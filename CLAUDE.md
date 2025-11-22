# CLAUDE.md - Sinople WordPress Theme (Modern Stack)

## Project Overview

**Sinople** (from the heraldic term for green) is a modern, semantically-aware WordPress theme built with cutting-edge web technologies. It combines traditional WordPress theming with a modern ReScript + Deno + WASM stack for maximum type safety, performance, and semantic web capabilities.

### Core Mission
- **Semantic Web First**: RDF/OWL processing for character relationships, glosses, and entanglements
- **IndieWeb Level 4**: Full Webmention and Micropub support
- **Maximum Accessibility**: WCAG 2.3 AAA compliance mandatory
- **Type Safety**: ReScript-only (NO TypeScript) with WASM integration
- **Performance**: Rust-powered WASM for semantic processing

## Architecture Overview

```
┌─────────────────────────────────────────────────────────┐
│                    WordPress Theme                       │
│  (Traditional PHP Templates + Custom Post Types)        │
└────────────────┬────────────────────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────────────────────┐
│              Deno + Fresh Framework                      │
│  (Server-side rendering, API routes, Islands)           │
└────────────────┬────────────────────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────────────────────┐
│           ReScript Business Logic                        │
│  (Type-safe bindings, components, utilities)            │
└────────────────┬────────────────────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────────────────────┐
│        Rust WASM Semantic Processor                     │
│  (Sophia RDF, FastGraph, Turtle parsing)                │
└─────────────────────────────────────────────────────────┘
```

## Project Structure

```
wp-sinople-theme/
├── CLAUDE.md                      # This file
├── README.md                      # User-facing documentation
├── USAGE.md                       # Developer usage guide
├── ROADMAP.md                     # Development roadmap
├── STACK.md                       # Technical stack details
├── COMPREHENSIVE_ANALYSIS.md      # Architecture deep-dive
│
├── wordpress/                     # Traditional WordPress theme files
│   ├── style.css                  # Theme header + base styles
│   ├── functions.php              # Theme setup, hooks, integrations
│   ├── index.php                  # Main template
│   ├── header.php                 # Header template
│   ├── footer.php                 # Footer template
│   ├── sidebar.php                # Sidebar template
│   ├── single.php                 # Single post
│   ├── single-construct.php       # Custom: Construct CPT
│   ├── single-entanglement.php    # Custom: Entanglement CPT
│   ├── page.php                   # Page template
│   ├── archive.php                # Archive template
│   ├── search.php                 # Search results
│   ├── 404.php                    # 404 page
│   ├── comments.php               # Comments template
│   ├── screenshot.png             # Theme screenshot (1200x900)
│   ├── template-parts/            # Reusable template components
│   │   ├── content.php
│   │   ├── content-construct.php
│   │   ├── navigation.php
│   │   └── semantic-graph.php
│   ├── inc/                       # PHP functionality
│   │   ├── custom-post-types.php  # Constructs, Entanglements
│   │   ├── taxonomies.php         # Custom taxonomies
│   │   ├── widgets.php            # Custom widgets
│   │   ├── customizer.php         # Theme customizer
│   │   ├── indieweb.php           # IndieWeb integrations
│   │   ├── semantic.php           # Semantic web helpers
│   │   └── accessibility.php      # WCAG AAA utilities
│   ├── assets/
│   │   ├── css/
│   │   │   ├── base.css           # CSS custom properties
│   │   │   ├── layout.css         # Grid/flexbox layouts
│   │   │   ├── components.css     # UI components
│   │   │   ├── accessibility.css  # WCAG AAA overrides
│   │   │   └── print.css          # Print styles
│   │   ├── js/
│   │   │   ├── navigation.js      # Accessible navigation
│   │   │   ├── graph-viewer.js    # Semantic graph UI
│   │   │   └── annotations.js     # Gloss annotations
│   │   └── images/
│   │       ├── logo.svg
│   │       └── icons/
│   └── languages/                 # i18n translation files
│       └── sinople.pot
│
├── deno/                          # Deno + Fresh application
│   ├── deno.json                  # Deno configuration
│   ├── import_map.json            # Import maps
│   ├── dev.ts                     # Development server
│   ├── main.ts                    # Production server
│   ├── fresh.gen.ts               # Auto-generated Fresh manifest
│   ├── routes/                    # Fresh file-based routing
│   │   ├── index.tsx              # Home page (ReScript)
│   │   ├── api/
│   │   │   ├── webmention.ts      # Webmention endpoint
│   │   │   ├── micropub.ts        # Micropub endpoint
│   │   │   ├── semantic.ts        # Semantic query API
│   │   │   ├── wordpress.ts       # WP API proxy
│   │   │   └── void.ts            # VoID dataset description
│   │   ├── constructs/
│   │   │   └── [slug].tsx         # Dynamic construct pages
│   │   └── entanglements/
│   │       └── [slug].tsx         # Dynamic entanglement pages
│   ├── islands/                   # Interactive islands (ReScript)
│   │   ├── SemanticGraph.tsx      # RDF graph visualization
│   │   ├── GlossAnnotation.tsx    # Inline glosses
│   │   ├── CharacterNetwork.tsx   # Character relationship viewer
│   │   └── SearchFilter.tsx       # Accessible search/filter
│   ├── components/                # Shared components (ReScript)
│   │   ├── Layout.res
│   │   ├── Navigation.res
│   │   ├── Footer.res
│   │   └── Metadata.res
│   └── lib/                       # Utilities
│       ├── WordPress.ts           # WP API client
│       ├── RDF.res                # RDF utilities
│       ├── IndieWeb.res           # Webmention/Micropub
│       └── Cache.ts               # Caching layer
│
├── rescript/                      # ReScript source code
│   ├── bsconfig.json              # ReScript configuration
│   ├── src/
│   │   ├── bindings/              # External bindings
│   │   │   ├── SemanticProcessor.res  # WASM bindings
│   │   │   ├── WordPress.res      # WP REST API
│   │   │   └── Deno.res           # Deno runtime
│   │   ├── components/            # UI components
│   │   │   ├── Graph.res          # RDF graph viewer
│   │   │   ├── Gloss.res          # Annotation components
│   │   │   ├── Navigation.res     # Accessible nav
│   │   │   └── Card.res           # Content cards
│   │   ├── domain/                # Business logic
│   │   │   ├── Construct.res      # Construct domain model
│   │   │   ├── Entanglement.res   # Entanglement model
│   │   │   ├── Character.res      # Character model
│   │   │   └── Ontology.res       # Sinople ontology
│   │   ├── services/              # API services
│   │   │   ├── SemanticService.res
│   │   │   ├── WordPressService.res
│   │   │   └── IndieWebService.res
│   │   └── utils/
│   │       ├── Result.res         # Error handling
│   │       ├── Accessibility.res  # WCAG utilities
│   │       └── I18n.res           # Internationalization
│   └── examples/
│       └── example.res            # Usage examples
│
├── wasm/                          # Rust WASM modules
│   └── semantic_processor/
│       ├── Cargo.toml             # Rust dependencies
│       ├── build.sh               # WASM build script
│       ├── src/
│       │   ├── lib.rs             # Main WASM entry (390 lines)
│       │   ├── graph.rs           # FastGraph wrapper
│       │   ├── query.rs           # SPARQL-like queries
│       │   ├── ontology.rs        # Sinople ontology loader
│       │   └── utils.rs           # Utility functions
│       ├── pkg/                   # Built WASM artifacts
│       │   ├── semantic_processor_bg.wasm  (1.3MB)
│       │   ├── semantic_processor.js
│       │   └── semantic_processor.d.ts
│       └── tests/
│           └── integration.rs     # Browser-based tests
│
├── ontology/                      # RDF ontologies
│   ├── sinople.ttl                # Main Sinople ontology
│   ├── constructs.ttl             # Construct vocabulary
│   ├── entanglements.ttl          # Entanglement vocabulary
│   └── characters.ttl             # Character relationships
│
├── build/                         # Build outputs
│   ├── rescript/                  # Compiled ReScript
│   └── deno/                      # Deno bundles
│
├── tests/                         # Test suites
│   ├── integration/
│   │   ├── wasm-rescript.test.ts
│   │   ├── wordpress-api.test.ts
│   │   └── indieweb.test.ts
│   └── accessibility/
│       └── wcag-aaa.test.ts
│
├── build.sh                       # Master build script
├── dev.sh                         # Development mode
└── deploy.sh                      # Deployment script
```

## Technology Stack

### Core Technologies
- **WordPress**: 6.0+ (PHP 7.4+)
- **Rust**: Stable (WASM compilation)
- **ReScript**: 11+ (NO TypeScript!)
- **Deno**: 1.40+ with Fresh framework
- **Sophia RDF**: 0.8 (Rust RDF library)

### Key Libraries & Tools

#### Rust/WASM
```toml
[dependencies]
wasm-bindgen = "0.2"
sophia_api = "0.8"
sophia_inmem = "0.8"
sophia_turtle = "0.8"
serde = { version = "1.0", features = ["derive"] }
serde-wasm-bindgen = "0.6"

[profile.release]
wasm-opt = false  # Network restrictions
opt-level = "z"   # Size optimization
```

#### ReScript
```json
{
  "name": "sinople-theme",
  "sources": ["src"],
  "package-specs": {
    "module": "es6",
    "in-source": true
  },
  "suffix": ".res.js",
  "bs-dependencies": []
}
```

#### Deno
```json
{
  "imports": {
    "$fresh/": "https://deno.land/x/fresh@1.6.0/",
    "preact": "https://esm.sh/preact@10.19.2",
    "preact/": "https://esm.sh/preact@10.19.2/"
  },
  "compilerOptions": {
    "jsx": "react-jsx",
    "jsxImportSource": "preact"
  }
}
```

## WordPress Integration

### Custom Post Types

#### Constructs
Abstract concepts, entities, or ideas within the Sinople semantic universe.

```php
register_post_type('sinople_construct', [
    'public' => true,
    'has_archive' => true,
    'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
    'show_in_rest' => true,
    'rest_base' => 'constructs',
]);
```

#### Entanglements
Relationships, connections, or interactions between constructs.

```php
register_post_type('sinople_entanglement', [
    'public' => true,
    'has_archive' => true,
    'supports' => ['title', 'editor', 'custom-fields'],
    'show_in_rest' => true,
    'rest_base' => 'entanglements',
]);
```

### Custom Taxonomies
- `construct_type`: Categorize constructs
- `entanglement_type`: Categorize relationships
- `semantic_tag`: Tag entities for RDF processing

### REST API Extensions

```php
// Endpoint: /wp-json/sinople/v1/semantic-graph
register_rest_route('sinople/v1', '/semantic-graph', [
    'methods' => 'GET',
    'callback' => 'sinople_get_semantic_graph',
    'permission_callback' => '__return_true',
]);
```

## Semantic Web Features

### RDF/OWL Processing

The Rust WASM module processes RDF Turtle files using Sophia 0.8:

```rust
// Core functionality from lib.rs
pub struct SemanticProcessor {
    graph: FastGraph,
}

impl SemanticProcessor {
    pub fn new() -> Self;
    pub fn load_turtle(&mut self, ttl: &str) -> Result<(), JsValue>;
    pub fn query_constructs(&self) -> JsValue;
    pub fn query_entanglements(&self) -> JsValue;
    pub fn find_relationships(&self, construct_id: &str) -> JsValue;
}
```

### ReScript Bindings

```rescript
// SemanticProcessor.res
type t

@new @module("./pkg/semantic_processor.js")
external make: unit => t = "SemanticProcessor"

@send
external loadTurtle: (t, string) => promise<result<unit, string>> = "load_turtle"

@send
external queryConstructs: t => promise<array<construct>> = "query_constructs"
```

### Sinople Ontology

Core vocabularies defined in Turtle format:

```turtle
# sinople.ttl
@prefix sn: <http://sinople.org/ontology#> .
@prefix owl: <http://www.w3.org/2002/07/owl#> .

sn:Construct a owl:Class ;
    rdfs:label "Construct"@en ;
    rdfs:comment "An abstract entity or concept in the Sinople universe"@en .

sn:Entanglement a owl:Class ;
    rdfs:label "Entanglement"@en ;
    rdfs:comment "A relationship between two or more constructs"@en .

sn:hasGloss a owl:DatatypeProperty ;
    rdfs:domain sn:Construct ;
    rdfs:range xsd:string .
```

## IndieWeb Integration (Level 4 Compliance)

### Webmention Endpoint

```typescript
// deno/routes/api/webmention.ts
export const handler: Handlers = {
  async POST(req, ctx) {
    const form = await req.formData();
    const source = form.get('source');
    const target = form.get('target');

    // Verify source links to target
    // Store webmention
    // Send notification

    return new Response('Accepted', { status: 202 });
  }
};
```

### Micropub Endpoint

```typescript
// deno/routes/api/micropub.ts
export const handler: Handlers = {
  async POST(req, ctx) {
    // Authenticate request
    // Parse h-entry microformat
    // Create WordPress post via REST API

    return new Response(JSON.stringify({ url }), {
      status: 201,
      headers: { 'Location': url }
    });
  }
};
```

### Microformats

All templates include microformats2 classes:

```php
<article class="h-entry" id="post-<?php the_ID(); ?>">
  <h1 class="p-name"><?php the_title(); ?></h1>
  <div class="e-content"><?php the_content(); ?></div>
  <a class="u-url" href="<?php the_permalink(); ?>"></a>
  <time class="dt-published" datetime="<?php echo get_the_date('c'); ?>">
    <?php the_date(); ?>
  </time>
</article>
```

## Accessibility (WCAG 2.3 AAA)

### Mandatory Requirements

1. **Contrast Ratios**: 7:1 for normal text, 4.5:1 for large text
2. **Keyboard Navigation**: Full keyboard access, visible focus indicators
3. **Screen Reader Support**: ARIA labels, landmarks, live regions
4. **Motion**: Respect `prefers-reduced-motion`
5. **Color**: Never rely on color alone
6. **Forms**: Clear labels, error identification, suggestions
7. **Headings**: Logical hierarchy, no skipped levels
8. **Links**: Descriptive text, clear purpose from context

### CSS Custom Properties

```css
:root {
  /* WCAG AAA compliant color palette */
  --color-text: #000000;
  --color-bg: #FFFFFF;
  --color-primary: #006400;      /* Dark green (Sinople) */
  --color-secondary: #004d00;
  --color-link: #003300;
  --color-link-visited: #1a0033;
  --color-focus: #FFD700;         /* High contrast focus */

  /* Typography for readability */
  --font-base: 1.125rem;          /* 18px minimum */
  --line-height: 1.5;
  --measure: 70ch;                /* Optimal line length */
}

@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after {
    animation-duration: 0.01ms !important;
    transition-duration: 0.01ms !important;
  }
}
```

### Keyboard Navigation

```javascript
// Enhanced keyboard support
document.addEventListener('keydown', (e) => {
  // Skip to main content (Alt+1)
  if (e.altKey && e.key === '1') {
    document.getElementById('main').focus();
  }

  // Skip to navigation (Alt+2)
  if (e.altKey && e.key === '2') {
    document.getElementById('nav').focus();
  }
});
```

## Build System

### Master Build Script

```bash
#!/bin/bash
# build.sh

set -e

echo "🏗️  Building Sinople Theme..."

# 1. Build WASM module
echo "📦 Building Rust WASM..."
cd wasm/semantic_processor
cargo install wasm-pack  # Install via cargo (curl blocked)
wasm-pack build --target web --out-dir pkg
cd ../..

# 2. Compile ReScript
echo "🔧 Compiling ReScript..."
cd rescript
npm install  # or yarn
npx rescript build
cd ..

# 3. Bundle Deno application
echo "🦕 Bundling Deno..."
cd deno
deno task build
cd ..

# 4. Copy assets to WordPress theme
echo "📋 Copying assets..."
mkdir -p wordpress/assets/wasm
cp wasm/semantic_processor/pkg/* wordpress/assets/wasm/
cp -r build/rescript/* wordpress/assets/js/
cp -r build/deno/* wordpress/assets/js/

echo "✅ Build complete!"
```

### Development Mode

```bash
#!/bin/bash
# dev.sh

# Watch ReScript files
cd rescript && npx rescript build -w &

# Watch Deno Fresh
cd deno && deno task start &

# Watch Rust (requires manual rebuild)
echo "📝 Rust WASM requires manual rebuild: cd wasm/semantic_processor && ./build.sh"

wait
```

## Development Guidelines

### ReScript Coding Standards

```rescript
// Use descriptive names
type construct = {
  id: string,
  title: string,
  content: string,
  glosses: array<gloss>,
}

// Prefer pattern matching over conditionals
let renderConstruct = (construct: construct) =>
  switch construct.glosses {
  | [] => <div> {React.string(construct.content)} </div>
  | glosses => <GlossedContent content=construct.content glosses />
  }

// Use Result for error handling
type loadError = NetworkError | ParseError | NotFound

let loadConstruct = async (id: string): result<construct, loadError> => {
  // ...
}
```

### WordPress Security

```php
// Always escape output
echo esc_html($construct->title);
echo esc_url($construct->permalink);
echo esc_attr($construct->id);

// Sanitize input
$clean_id = sanitize_text_field($_POST['construct_id']);

// Check capabilities
if (!current_user_can('edit_posts')) {
    wp_die(__('Unauthorized', 'sinople'));
}

// Use nonces
wp_nonce_field('sinople_save_construct', 'sinople_nonce');
if (!wp_verify_nonce($_POST['sinople_nonce'], 'sinople_save_construct')) {
    wp_die(__('Security check failed', 'sinople'));
}
```

### Rust/WASM Gotchas

```rust
// SimpleTerm requires manual string conversion (no .value())
let subject = match triple.s() {
    SimpleTerm::Iri(iri) => iri.to_string(),
    SimpleTerm::LiteralDatatype(lit, _) => lit.to_string(),
    _ => String::new(),
};

// Return JS-compatible types
#[wasm_bindgen]
pub fn query_constructs(&self) -> JsValue {
    let constructs: Vec<Construct> = // ...
    serde_wasm_bindgen::to_value(&constructs).unwrap()
}

// Handle errors gracefully
pub fn load_turtle(&mut self, ttl: &str) -> Result<(), JsValue> {
    TurtleParser::new(ttl.as_bytes())
        .parse_all(&mut self.graph)
        .map_err(|e| JsValue::from_str(&format!("Parse error: {}", e)))
}
```

## Testing

### Integration Tests

```typescript
// tests/integration/wasm-rescript.test.ts
Deno.test("WASM semantic processor loads ontology", async () => {
  const processor = new SemanticProcessor();
  const ttl = await Deno.readTextFile("./ontology/sinople.ttl");

  await processor.load_turtle(ttl);
  const constructs = await processor.query_constructs();

  assert(constructs.length > 0);
});
```

### Accessibility Tests

```typescript
// tests/accessibility/wcag-aaa.test.ts
import { assertEquals } from "https://deno.land/std/assert/mod.ts";

Deno.test("All text meets AAA contrast ratio", async () => {
  // Use axe-core or pa11y
  const violations = await checkContrast();
  assertEquals(violations.length, 0);
});
```

### Skip WASM tests in CLI

```bash
# Tests require browser environment
cargo test --lib  # Skip WASM tests
```

## Internationalization

```php
// Load text domain
function sinople_load_textdomain() {
    load_theme_textdomain('sinople', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'sinople_load_textdomain');

// Use in templates
esc_html_e('View all constructs', 'sinople');
printf(
    esc_html__('Posted on %s', 'sinople'),
    get_the_date()
);
```

## Metadata & Feeds

### Dublin Core

```php
<meta name="DC.title" content="<?php echo esc_attr(get_the_title()); ?>">
<meta name="DC.creator" content="<?php echo esc_attr(get_the_author()); ?>">
<meta name="DC.date" content="<?php echo get_the_date('c'); ?>">
<meta name="DC.type" content="Text">
<meta name="DC.format" content="text/html">
```

### VoID Description

```turtle
# Served at /api/void
@prefix void: <http://rdfs.org/ns/void#> .
@prefix dcterms: <http://purl.org/dc/terms/> .

<http://sinople.org/dataset> a void:Dataset ;
    dcterms:title "Sinople Semantic Dataset" ;
    void:feature <http://www.w3.org/ns/formats/Turtle> ;
    void:sparqlEndpoint <http://sinople.org/api/semantic> ;
    void:exampleResource <http://sinople.org/constructs/example> .
```

## Git Workflow

### Branch Strategy
- **Development**: `claude/sinople-wordpress-theme-01WjY1Gf3VwVsBjRkNRKCN7a`
- **Documentation**: `claude/create-claude-md-01XMBAxFdTUTCqsvscUtvXqm`
- Merge to main when stable

### Commit Messages

```
feat: add Webmention endpoint for IndieWeb Level 4
fix: resolve WCAG AAA contrast issue in navigation
docs: update WASM build instructions
perf: optimize RDF graph queries in Rust
```

### Push with Retry

```bash
# Push with exponential backoff on network errors
for i in 1 2 3 4; do
    if git push -u origin claude/sinople-wordpress-theme-01WjY1Gf3VwVsBjRkNRKCN7a; then
        break
    fi
    sleep $((2**i))
done
```

## Performance Optimizations

1. **WASM Caching**: Load semantic processor once, reuse in-memory graph
2. **Lazy Islands**: Use Fresh islands only for interactive components
3. **Edge Caching**: Cache RDF queries at CDN level
4. **Asset Optimization**: Minify CSS/JS, optimize images
5. **Code Splitting**: Load WASM only when needed

## Known Limitations & Workarounds

### Sophia API Changes
Sophia 0.8 uses separate crates (`sophia_api`, `sophia_inmem`, `sophia_turtle`) instead of unified package.

### SimpleTerm Value Access
No `.value()` method; manually convert with `to_string()`:

```rust
let value = match term {
    SimpleTerm::LiteralDatatype(lit, _) => lit.to_string(),
    _ => String::new(),
};
```

### Network Restrictions
- Cannot use `curl` installer for wasm-pack → Use `cargo install wasm-pack`
- Cannot run `wasm-opt` → Set `wasm-opt = false` in Cargo.toml

### WASM Test Environment
Tests panic without browser `console` object → Always skip with `cargo test --lib` or in build.sh

## Resources

### WordPress
- [Theme Developer Handbook](https://developer.wordpress.org/themes/)
- [REST API Handbook](https://developer.wordpress.org/rest-api/)
- [Coding Standards](https://developer.wordpress.org/coding-standards/)

### ReScript
- [ReScript Documentation](https://rescript-lang.org/docs/manual/latest/introduction)
- [ReScript & React](https://rescript-lang.org/docs/react/latest/introduction)

### Deno & Fresh
- [Deno Manual](https://deno.land/manual)
- [Fresh Documentation](https://fresh.deno.dev/docs/introduction)

### Semantic Web
- [Sophia RDF](https://docs.rs/sophia/latest/sophia/)
- [RDF 1.1 Primer](https://www.w3.org/TR/rdf11-primer/)
- [Turtle Format](https://www.w3.org/TR/turtle/)

### IndieWeb
- [IndieWeb Standards](https://indieweb.org/standards)
- [Webmention Spec](https://www.w3.org/TR/webmention/)
- [Micropub Spec](https://micropub.spec.indieweb.org/)

### Accessibility
- [WCAG 2.3](https://www.w3.org/WAI/WCAG23/quickref/)
- [ARIA Authoring Practices](https://www.w3.org/WAI/ARIA/apg/)

## Critical Notes for Claude

1. **NO TypeScript**: This project uses ReScript exclusively
2. **WCAG 2.3 AAA**: Non-negotiable; always verify contrast, keyboard nav, screen readers
3. **Sophia 0.8**: Use separate crates, not unified package
4. **WASM Tests**: Always skip in CLI builds (need browser environment)
5. **Security**: Escape all WordPress output, sanitize all input
6. **IndieWeb**: Webmention + Micropub are core features, not optional
7. **Semantic First**: RDF/OWL processing is central to theme identity
8. **Build Gotchas**: Document all network restrictions and workarounds
9. **Type Safety**: Leverage ReScript's type system; use Result for errors
10. **Performance**: WASM is for semantic processing; keep bundle size reasonable

## Support & Community

- **Repository**: `Hyperpolymath/wp-sinople-theme`
- **Issues**: File issues on GitHub with `[WASM]`, `[ReScript]`, `[A11y]`, or `[IndieWeb]` tags
- **Discussions**: Use GitHub Discussions for architecture questions
- **Documentation**: Keep USAGE.md, ROADMAP.md, and STACK.md in sync

---

**Last Updated**: 2025-11-22
**Status**: Active Development
**License**: GNU GPL v2 or later
