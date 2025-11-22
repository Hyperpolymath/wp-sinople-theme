{
  description = "Sinople WordPress Theme - RSR-compliant semantic web theme";

  inputs = {
    nixpkgs.url = "github:NixOS/nixpkgs/nixos-unstable";
    rust-overlay.url = "github:oxalica/rust-overlay";
    flake-utils.url = "github:numtide/flake-utils";
  };

  outputs = { self, nixpkgs, rust-overlay, flake-utils }:
    flake-utils.lib.eachDefaultSystem (system:
      let
        overlays = [ (import rust-overlay) ];
        pkgs = import nixpkgs {
          inherit system overlays;
        };

        rustToolchain = pkgs.rust-bin.stable.latest.default.override {
          extensions = [ "rust-src" "rust-analyzer" ];
          targets = [ "wasm32-unknown-unknown" ];
        };

      in
      {
        devShells.default = pkgs.mkShell {
          buildInputs = with pkgs; [
            # Rust toolchain
            rustToolchain
            wasm-pack
            cargo-audit
            cargo-outdated

            # Node.js ecosystem (for ReScript)
            nodejs_20
            nodePackages.npm

            # Deno
            deno

            # Build tools
            just
            git

            # Optional tools
            nixpkgs-fmt  # Format Nix files
          ];

          shellHook = ''
            echo "🌿 Sinople WordPress Theme Development Environment"
            echo "=================================================="
            echo ""
            echo "Available commands:"
            echo "  just --list    Show all build recipes"
            echo "  just build     Build all components"
            echo "  just test      Run all tests"
            echo "  just dev       Start development mode"
            echo ""
            echo "Rust: $(rustc --version)"
            echo "Node: $(node --version)"
            echo "Deno: $(deno --version | head -1)"
            echo ""
          '';
        };

        # Package outputs
        packages.wasm = pkgs.stdenv.mkDerivation {
          name = "sinople-wasm";
          version = "1.0.0";
          src = ./wasm/semantic_processor;

          buildInputs = [ rustToolchain wasm-pack ];

          buildPhase = ''
            wasm-pack build --target web --out-dir pkg
          '';

          installPhase = ''
            mkdir -p $out
            cp -r pkg/* $out/
          '';
        };

        packages.rescript = pkgs.stdenv.mkDerivation {
          name = "sinople-rescript";
          version = "1.0.0";
          src = ./rescript;

          buildInputs = [ pkgs.nodejs_20 pkgs.nodePackages.npm ];

          buildPhase = ''
            npm install
            npx rescript build
          '';

          installPhase = ''
            mkdir -p $out
            find src -name "*.res.js" -exec cp {} $out/ \;
          '';
        };

        # Default package
        packages.default = pkgs.stdenv.mkDerivation {
          name = "sinople-theme";
          version = "1.0.0";
          src = ./.;

          buildInputs = [
            rustToolchain
            wasm-pack
            pkgs.nodejs_20
            pkgs.nodePackages.npm
            just
          ];

          buildPhase = ''
            just build
          '';

          installPhase = ''
            mkdir -p $out
            cp -r wordpress/* $out/
          '';

          meta = with pkgs.lib; {
            description = "Sinople WordPress Theme - Semantic web theme with WASM";
            homepage = "https://github.com/Hyperpolymath/wp-sinople-theme";
            license = licenses.mit; # Dual MIT/Palimpsest
            platforms = platforms.unix;
          };
        };

        # Apps
        apps.build = {
          type = "app";
          program = "${pkgs.just}/bin/just";
          args = [ "build" ];
        };

        apps.test = {
          type = "app";
          program = "${pkgs.just}/bin/just";
          args = [ "test" ];
        };

        apps.dev = {
          type = "app";
          program = "${pkgs.just}/bin/just";
          args = [ "dev" ];
        };

        # Checks (for nix flake check)
        checks = {
          build = self.packages.${system}.default;

          lint-rust = pkgs.runCommand "lint-rust" {
            buildInputs = [ rustToolchain ];
          } ''
            cd ${./.}/wasm/semantic_processor
            cargo fmt --check
            cargo clippy -- -D warnings
            touch $out
          '';
        };
      }
    );
}
