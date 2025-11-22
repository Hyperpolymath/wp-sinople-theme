# Sinople WordPress Theme

A modern, semantically-aware WordPress theme powered by **ReScript**, **Deno**, and **WASM**. Sinople (from the heraldic term for green) combines traditional WordPress theming with cutting-edge semantic web technologies for character relationships, glosses, and knowledge graphs.

## Features

- 🧠 **Semantic Web Processing**: RDF/OWL processing via Rust WASM for construct relationships
- 🌐 **IndieWeb Level 4**: Full Webmention and Micropub support
- ♿ **WCAG 2.3 AAA**: Maximum accessibility compliance
- 🔒 **Type Safety**: ReScript-only architecture (NO TypeScript)
- ⚡ **Performance**: Rust-powered WASM semantic processor
- 🎨 **Modern Stack**: Deno + Fresh framework for server-side rendering

## Quick Start

### Prerequisites

- WordPress 6.0+
- PHP 7.4+
- Rust (for building WASM)
- Deno 1.40+
- Node.js 18+ (for ReScript)

### Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/Hyperpolymath/wp-sinople-theme.git
   cd wp-sinople-theme
   ```

2. **Build WASM module**:
   ```bash
   cd wasm/semantic_processor
   cargo install wasm-pack
   ./build.sh
   cd ../..
   ```

3. **Compile ReScript**:
   ```bash
   cd rescript
   npm install
   npm run build
   cd ..
   ```

4. **Set up WordPress**:
   ```bash
   # Copy wordpress/ directory to your WordPress themes folder
   cp -r wordpress /path/to/wordpress/wp-content/themes/sinople
   ```

5. **Activate theme** in WordPress admin

### Development

```bash
# Build everything
./build.sh

# Development mode (watch files)
./dev.sh

# Run tests
cd tests
deno test integration/
```

## Project Structure

```
wp-sinople-theme/
├── wasm/               # Rust WASM semantic processor
├── rescript/           # ReScript source code
├── deno/               # Deno + Fresh application
├── wordpress/          # WordPress theme files
├── ontology/           # RDF ontologies (Turtle format)
├── tests/              # Integration tests
└── docs/               # Documentation
```

## Custom Post Types

### Constructs
Abstract concepts, entities, or ideas (e.g., "Time", "Consciousness", "Justice")

### Entanglements
Relationships between constructs (e.g., "Time → Space", "Consciousness → Free Will")

## IndieWeb Features

- **Webmention**: `/wp-json/sinople/v1/webmention`
- **Micropub**: `/wp-json/sinople/v1/micropub`
- **Microformats2**: All posts include h-entry markup

## Semantic Web APIs

- **Semantic Graph**: `/wp-json/sinople/v1/semantic-graph`
- **RDF Export**: `/wp-json/sinople/v1/constructs/{id}/rdf`
- **Full Ontology**: `/wp-json/sinople/v1/ontology`

## Accessibility

Sinople meets **WCAG 2.3 AAA** standards:

- 7:1 contrast ratio for normal text
- Full keyboard navigation support
- Screen reader optimized
- Respects `prefers-reduced-motion`
- Skip links to main content
- Semantic HTML5 markup

## Browser Support

- Chrome/Edge 90+
- Firefox 88+
- Safari 14+

## Contributing

We welcome contributions! See [CONTRIBUTING.md](CONTRIBUTING.md) for:
- Development guidelines
- Tri-Perimeter Contribution Framework (TPCF)
- Code style and commit conventions
- Pull request process

Please also review our [CODE_OF_CONDUCT.md](CODE_OF_CONDUCT.md).

## Documentation

### User Documentation
- **[USAGE.md](USAGE.md)**: Developer usage guide
- **[ROADMAP.md](ROADMAP.md)**: Development roadmap
- **[STACK.md](STACK.md)**: Technical stack details
- **[CHANGELOG.md](CHANGELOG.md)**: Version history and release notes

### Project Governance
- **[CONTRIBUTING.md](CONTRIBUTING.md)**: Contribution guidelines and TPCF
- **[CODE_OF_CONDUCT.md](CODE_OF_CONDUCT.md)**: Community standards
- **[SECURITY.md](SECURITY.md)**: Security policy and vulnerability reporting
- **[MAINTAINERS.md](MAINTAINERS.md)**: Project maintainers and governance
- **[TPCF.md](TPCF.md)**: Tri-Perimeter Contribution Framework details

### Development
- **[CLAUDE.md](CLAUDE.md)**: AI assistant guidelines and architecture
- **[RSR_AUDIT.md](RSR_AUDIT.md)**: Rhodium Standard Repository compliance audit

## Security

Security vulnerabilities can be reported via:
- Email: security@sinople.org
- Security policy: [SECURITY.md](SECURITY.md)
- Security.txt: [/.well-known/security.txt](.well-known/security.txt)

We follow coordinated disclosure practices with 24-hour acknowledgment and 7-day patch timelines.

## License

**Dual Licensed** - Choose either:

- **MIT License** (OSI-approved, permissive)
- **Palimpsest License v0.8** (political autonomy focus)

See [LICENSE.txt](LICENSE.txt) for full terms.

**SPDX-License-Identifier**: `MIT OR Palimpsest-0.8`

## Standards Compliance

- ✅ **RSR Bronze Level**: ~75% Rhodium Standard Repository compliance
- ✅ **WCAG 2.3 AAA**: Maximum web accessibility
- ✅ **IndieWeb Level 4**: Webmention + Micropub
- ✅ **Semantic Versioning 2.0.0**: Version management
- ✅ **Conventional Commits**: Commit message format
- ✅ **RFC 9116**: security.txt implementation

## Credits

**Development**: Claude Code (Anthropic) + Human collaboration
**License**: MIT OR Palimpsest-0.8
**Humans**: See [.well-known/humans.txt](.well-known/humans.txt)
**AI Policy**: See [.well-known/ai.txt](.well-known/ai.txt)
