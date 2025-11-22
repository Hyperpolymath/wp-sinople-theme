# Contributing to Sinople WordPress Theme

Thank you for your interest in contributing! Sinople follows the **Tri-Perimeter Contribution Framework (TPCF)** to ensure safe, inclusive, and effective collaboration.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Tri-Perimeter Contribution Framework](#tri-perimeter-contribution-framework)
- [Getting Started](#getting-started)
- [Development Workflow](#development-workflow)
- [Coding Standards](#coding-standards)
- [Testing Requirements](#testing-requirements)
- [Submitting Changes](#submitting-changes)
- [Security Vulnerabilities](#security-vulnerabilities)

## Code of Conduct

This project adheres to the [Contributor Covenant Code of Conduct](CODE_OF_CONDUCT.md). By participating, you are expected to uphold this code. Please report unacceptable behavior to conduct@sinople.org.

## Tri-Perimeter Contribution Framework (TPCF)

Sinople uses **graduated trust** with three contribution perimeters. See [TPCF.md](TPCF.md) for full details.

### Perimeter 3: Community Sandbox (🌐 Open Access)

**Most contributors start here!**

- ✅ **Anyone can contribute** without special permissions
- ✅ Submit issues, discussions, documentation fixes
- ✅ Propose features and improvements
- ✅ Review code and provide feedback
- ⚠️ **Cannot**: Directly commit to main branches

**Contribution Paths from Perimeter 3:**
1. **Documentation**: Fix typos, improve README, add examples
2. **Issues**: Report bugs, request features, discuss improvements
3. **Pull Requests**: Submit code for review by Perimeter 2/1
4. **Testing**: Try new features, report results
5. **Community**: Help others, answer questions, share knowledge

### Perimeter 2: Verified Contributors (🛡️ Write Access)

- ✅ Merge access to non-critical branches
- ✅ Triage issues and discussions
- ✅ Review and approve community PRs
- ⚠️ **Cannot**: Merge to `main` or create releases

**How to Graduate from Perimeter 3 → Perimeter 2:**
1. Make **5+ high-quality contributions** (merged PRs)
2. Demonstrate understanding of project architecture
3. Show commitment over **3+ months**
4. Adhere to Code of Conduct and coding standards
5. Nominate yourself or be nominated by a Perimeter 1 maintainer

### Perimeter 1: Core Maintainers (🔐 Full Access)

- ✅ Merge to `main` branch
- ✅ Create releases and tags
- ✅ Manage project governance
- ✅ Security vulnerability triage

**How to Graduate from Perimeter 2 → Perimeter 1:**
- By invitation only, based on sustained high-quality contributions and alignment with project values

## Getting Started

### Prerequisites

- **Rust** (stable) - for WASM module
- **Node.js** 18+ - for ReScript
- **Deno** 1.40+ - for Fresh framework
- **WordPress** 6.0+ - for testing
- **Git** - for version control

### Initial Setup

1. **Fork the repository**:
   ```bash
   # On GitHub/GitLab, click "Fork"
   git clone https://github.com/YOUR_USERNAME/wp-sinople-theme.git
   cd wp-sinople-theme
   ```

2. **Add upstream remote**:
   ```bash
   git remote add upstream https://github.com/Hyperpolymath/wp-sinople-theme.git
   ```

3. **Install dependencies**:
   ```bash
   # Rust tools
   cargo install wasm-pack

   # ReScript
   cd rescript && npm install && cd ..

   # Deno (if not installed)
   curl -fsSL https://deno.land/install.sh | sh
   ```

4. **Build the project**:
   ```bash
   ./build.sh
   ```

5. **Run tests** (when available):
   ```bash
   cargo test --manifest-path=wasm/semantic_processor/Cargo.toml
   cd rescript && npm test && cd ..
   cd deno && deno test && cd ..
   ```

## Development Workflow

### Branching Strategy

We use **GitHub Flow** (simplified):

1. `main` - production-ready code (protected)
2. `feature/ISSUE-description` - feature branches
3. `fix/ISSUE-description` - bug fix branches
4. `docs/description` - documentation changes
5. `chore/description` - maintenance tasks

### Creating a Feature Branch

```bash
# Update main
git checkout main
git pull upstream main

# Create feature branch
git checkout -b feature/123-semantic-graph-zoom

# Make changes, commit frequently
git add .
git commit -m "feat: add zoom controls to semantic graph"

# Push to your fork
git push origin feature/123-semantic-graph-zoom
```

### Commit Message Format

We follow **Conventional Commits**:

```
<type>(<scope>): <subject>

<body>

<footer>
```

**Types**:
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation only
- `style`: Formatting, missing semicolons, etc.
- `refactor`: Code change that neither fixes a bug nor adds a feature
- `perf`: Performance improvement
- `test`: Adding or updating tests
- `chore`: Build process, dependencies, etc.

**Examples**:
```
feat(wasm): add SPARQL-like query support

Implement a subset of SPARQL for querying RDF graphs:
- SELECT queries for constructs
- FILTER expressions for type matching
- LIMIT and OFFSET for pagination

Closes #123

---

fix(php): escape construct titles in archive view

XSS vulnerability when displaying construct titles.
All titles now properly escaped with esc_html().

Fixes #456
```

## Coding Standards

### Rust (WASM Module)

- **Style**: `rustfmt` (run `cargo fmt`)
- **Lints**: `clippy` (run `cargo clippy`)
- **No `unsafe` blocks** (unless absolutely necessary with clear justification)
- **Error handling**: Use `Result` types, not `panic!()`
- **Documentation**: Public functions need doc comments (`///`)
- **Tests**: Unit tests for all public functions

### ReScript

- **Style**: Follow ReScript conventions
- **Type annotations**: Prefer explicit types for clarity
- **Pattern matching**: Use exhaustive pattern matching
- **Error handling**: Use `Result.t` types
- **No `Js.log` in production code** (use conditional debugging)

### PHP (WordPress)

- **WordPress Coding Standards**: https://developer.wordpress.org/coding-standards/
- **Escaping**: Always escape output (`esc_html()`, `esc_attr()`, `esc_url()`)
- **Sanitization**: Always sanitize input (`sanitize_text_field()`, etc.)
- **Nonces**: Use for all forms (`wp_nonce_field()`, `wp_verify_nonce()`)
- **Capabilities**: Check user permissions (`current_user_can()`)
- **Prepared statements**: Use `$wpdb->prepare()` for SQL
- **Prefix**: All functions/variables with `sinople_`

### JavaScript

- **ES6+**: Use modern JavaScript features
- **No `eval()`**: Never use dynamic code execution
- **No `innerHTML`**: Use `textContent` or DOM APIs
- **Accessibility**: ARIA labels, keyboard navigation, focus management
- **Comments**: JSDoc for all functions

### CSS

- **BEM-inspired naming**: `.component__element--modifier`
- **Custom properties**: Use CSS variables for theming
- **Mobile-first**: Design for smallest screen first
- **Accessibility**: WCAG 2.3 AAA compliance (7:1 contrast)

## Testing Requirements

### Unit Tests (Required)

All new Rust functions must have unit tests:

```rust
#[cfg(test)]
mod tests {
    use super::*;

    #[test]
    fn test_parse_turtle() {
        let processor = SemanticProcessor::new();
        let ttl = "@prefix sn: <http://sinople.org/ontology#> .";
        assert!(processor.load_turtle(ttl).is_ok());
    }
}
```

### Integration Tests (Recommended)

Test interactions between components:

```typescript
// deno/tests/integration/semantic.test.ts
Deno.test("WASM processor integrates with ReScript", async () => {
  const processor = await initWithOntology(sampleTTL);
  const constructs = await processor.queryConstructs();
  assert(constructs.length > 0);
});
```

### Accessibility Tests (Required for UI changes)

Test keyboard navigation, screen reader support:

```javascript
// Test keyboard navigation
const button = document.querySelector('.graph-node');
button.dispatchEvent(new KeyboardEvent('keypress', { key: 'Enter' }));
assert(graphOpened);
```

## Submitting Changes

### Pull Request Process

1. **Update documentation** if needed (README, USAGE, etc.)
2. **Add tests** for new functionality
3. **Run all tests** and ensure they pass
4. **Run linters**: `cargo fmt`, `cargo clippy`, etc.
5. **Update CHANGELOG.md** (unreleased section)
6. **Push to your fork**
7. **Create Pull Request** on GitHub/GitLab

### Pull Request Template

```markdown
## Description

Brief description of changes.

Fixes #ISSUE_NUMBER

## Type of Change

- [ ] Bug fix (non-breaking change fixing an issue)
- [ ] New feature (non-breaking change adding functionality)
- [ ] Breaking change (fix or feature causing existing functionality to not work as expected)
- [ ] Documentation update

## Testing

Describe the tests you ran:

- [ ] Unit tests pass (`cargo test`, `npm test`)
- [ ] Integration tests pass (if applicable)
- [ ] Manual testing completed (describe steps)
- [ ] Accessibility tested (keyboard, screen reader)

## Checklist

- [ ] Code follows project style guidelines
- [ ] Self-review of code completed
- [ ] Comments added to complex code
- [ ] Documentation updated (if needed)
- [ ] No new warnings generated
- [ ] Tests added that prove fix/feature works
- [ ] Dependent changes merged and published

## Screenshots (if applicable)

Add screenshots for UI changes.
```

### Review Process

1. **Automated checks** run (CI/CD)
2. **Perimeter 2 reviewer** provides feedback
3. **Address feedback** with additional commits
4. **Approval** from at least one Perimeter 2/1 maintainer
5. **Merge** by Perimeter 1 maintainer (or Perimeter 2 for non-main branches)

## Security Vulnerabilities

**DO NOT** submit security vulnerabilities as public issues or pull requests.

See [SECURITY.md](SECURITY.md) for responsible disclosure process.

## Questions?

- **Discussions**: https://github.com/Hyperpolymath/wp-sinople-theme/discussions
- **Chat**: [Link to Discord/Matrix if available]
- **Email**: contrib@sinople.org

## Attribution

All contributors are listed in [MAINTAINERS.md](MAINTAINERS.md). By contributing, you agree to have your name (or pseudonym) listed unless you request otherwise.

## License

By contributing, you agree that your contributions will be licensed under the dual MIT/Palimpsest v0.8 license. See [LICENSE.txt](LICENSE.txt).

---

**Thank you for contributing to Sinople!** 🌿
