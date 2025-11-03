# Prose

Wrapper component for rich content and markdown rendering with beautiful typography.

## Security Warning

⚠️ **Important:** When rendering user-generated or markdown content, always sanitize the HTML to prevent XSS attacks.

```blade
{{-- ❌ UNSAFE - Never use unescaped output with untrusted content --}}
<x-strata::prose>
    {!! $userContent !!}
</x-strata::prose>

{{-- ✅ SAFE - Use a markdown parser with HTML purification --}}
<x-strata::prose>
    {!! Str::markdown($trustedMarkdown) !!}
</x-strata::prose>

{{-- ✅ SAFE - Use escaped output for plain text --}}
<x-strata::prose>
    {{ $plainText }}
</x-strata::prose>
```

**Recommendation:** Use a library like `league/commonmark` with HTML Purifier for parsing user-submitted markdown safely.

## Basic Usage

```blade
<x-strata::prose>
    <h1>Article Title</h1>
    <p>This is a paragraph with <strong>bold</strong> and <em>italic</em> text.</p>
    <ul>
        <li>List item one</li>
        <li>List item two</li>
    </ul>
</x-strata::prose>
```

## Sizes

The prose component supports multiple size variants:

```blade
{{-- Small --}}
<x-strata::prose size="sm">
    <p>Smaller text for sidebars or compact layouts.</p>
</x-strata::prose>

{{-- Base (default) --}}
<x-strata::prose size="base">
    <p>Standard readable text for most content.</p>
</x-strata::prose>

{{-- Large --}}
<x-strata::prose size="lg">
    <p>Larger text for feature articles.</p>
</x-strata::prose>

{{-- Extra Large --}}
<x-strata::prose size="xl">
    <p>Extra large text for hero content.</p>
</x-strata::prose>

{{-- 2XL --}}
<x-strata::prose size="2xl">
    <p>Maximum size for special content.</p>
</x-strata::prose>
```

## Custom Element

Change the wrapping element:

```blade
<x-strata::prose as="article">
    <h1>Article Content</h1>
    <p>Content goes here...</p>
</x-strata::prose>

<x-strata::prose as="section">
    <h2>Section Content</h2>
    <p>Content goes here...</p>
</x-strata::prose>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `as` | `string` | `div` | HTML element to render |
| `size` | `string` | `base` | Typography size: `sm`, `base`, `lg`, `xl`, `2xl` |

## Styled Elements

The prose component automatically styles:

### Headings

```blade
<x-strata::prose>
    <h1>Heading 1</h1>
    <h2>Heading 2</h2>
    <h3>Heading 3</h3>
    <h4>Heading 4</h4>
    <h5>Heading 5</h5>
    <h6>Heading 6</h6>
</x-strata::prose>
```

### Paragraphs and Text

```blade
<x-strata::prose>
    <p>Regular paragraph text.</p>
    <p class="lead">Lead paragraph with larger text.</p>
    <p><strong>Bold text</strong> and <em>italic text</em>.</p>
    <p><a href="#">Links are styled</a> with hover effects.</p>
</x-strata::prose>
```

### Lists

```blade
<x-strata::prose>
    <ul>
        <li>Unordered list item</li>
        <li>Another item
            <ul>
                <li>Nested item</li>
            </ul>
        </li>
    </ul>

    <ol>
        <li>Ordered list item</li>
        <li>Another item</li>
    </ol>
</x-strata::prose>
```

### Blockquotes

```blade
<x-strata::prose>
    <blockquote>
        <p>This is a blockquote with beautiful styling and proper spacing.</p>
    </blockquote>
</x-strata::prose>
```

### Code

```blade
<x-strata::prose>
    <p>Inline code: <code>const x = 10;</code></p>

    <pre><code>// Code block
function greet(name) {
    return `Hello, ${name}!`;
}</code></pre>
</x-strata::prose>
```

### Tables

```blade
<x-strata::prose>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Role</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Alice</td>
                <td>Developer</td>
                <td>Active</td>
            </tr>
            <tr>
                <td>Bob</td>
                <td>Designer</td>
                <td>Active</td>
            </tr>
        </tbody>
    </table>
</x-strata::prose>
```

### Horizontal Rules

```blade
<x-strata::prose>
    <p>Content above</p>
    <hr>
    <p>Content below</p>
</x-strata::prose>
```

### Images and Figures

```blade
<x-strata::prose>
    <figure>
        <img src="/path/to/image.jpg" alt="Description">
        <figcaption>Image caption with proper styling</figcaption>
    </figure>
</x-strata::prose>
```

## Examples

### Blog Post

```blade
<article class="max-w-4xl mx-auto py-12">
    <x-strata::heading level="1" class="mb-4">
        Building Scalable Laravel Applications
    </x-strata::heading>

    <x-strata::text variant="muted" class="mb-8">
        Published on January 15, 2025 by John Doe
    </x-strata::text>

    <x-strata::prose size="lg">
        <p class="lead">
            Laravel has become the go-to framework for building modern web applications.
            In this guide, we'll explore best practices for scaling your Laravel apps.
        </p>

        <h2>Architecture Patterns</h2>

        <p>
            When building large-scale applications, architecture becomes crucial.
            Here are some key patterns to consider:
        </p>

        <ul>
            <li>Repository pattern for data abstraction</li>
            <li>Service layer for business logic</li>
            <li>Event-driven architecture for decoupling</li>
        </ul>

        <h3>Repository Pattern</h3>

        <p>
            The repository pattern provides a clean abstraction layer between
            your business logic and data access:
        </p>

        <pre><code>class UserRepository
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}</code></pre>

        <blockquote>
            <p>
                "The repository pattern has transformed how we structure our Laravel
                applications, making them more testable and maintainable."
            </p>
        </blockquote>

        <h2>Performance Optimization</h2>

        <p>
            Performance is critical for user experience. Consider these strategies:
        </p>

        <ol>
            <li>Use database indexing strategically</li>
            <li>Implement query result caching</li>
            <li>Optimize eager loading with <code>with()</code></li>
        </ol>

        <hr>

        <p>
            For more information, check out the
            <a href="https://laravel.com/docs">official Laravel documentation</a>.
        </p>
    </x-strata::prose>
</article>
```

### Documentation Page

```blade
<div class="max-w-5xl mx-auto">
    <x-strata::prose>
        <h1>API Reference</h1>

        <h2>Authentication</h2>

        <p>
            All API requests require authentication via Bearer token:
        </p>

        <pre><code>Authorization: Bearer {token}</code></pre>

        <h3>Endpoints</h3>

        <table>
            <thead>
                <tr>
                    <th>Method</th>
                    <th>Endpoint</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>GET</code></td>
                    <td><code>/api/users</code></td>
                    <td>List all users</td>
                </tr>
                <tr>
                    <td><code>POST</code></td>
                    <td><code>/api/users</code></td>
                    <td>Create a user</td>
                </tr>
            </tbody>
        </table>

        <h2>Error Handling</h2>

        <p>
            The API returns standard HTTP status codes:
        </p>

        <ul>
            <li><code>200</code> - Success</li>
            <li><code>401</code> - Unauthorized</li>
            <li><code>404</code> - Not Found</li>
            <li><code>500</code> - Server Error</li>
        </ul>
    </x-strata::prose>
</div>
```

### Markdown Content

```blade
<x-strata::prose>
    {!! $markdownContent !!}
</x-strata::prose>
```

## Theme Integration

The prose component automatically integrates with Strata's theme system:

- **Light/Dark Mode**: All colors adapt automatically
- **Color Tokens**: Uses `--color-foreground`, `--color-primary`, etc.
- **Spacing**: Consistent with Strata's design system
- **Borders**: Uses `--color-border` and `--radius` variables

## Customization

You can add custom classes to override or extend default styling:

```blade
<x-strata::prose class="custom-prose-styling">
    <p>Content with custom styling...</p>
</x-strata::prose>
```

Add a maximum width if needed (component has no max-width by default):

```blade
<x-strata::prose class="max-w-4xl mx-auto">
    <p>Centered prose content with readable line length...</p>
</x-strata::prose>
```

## Supported Elements

The prose component styles the following HTML elements:

**Fully Supported:**
- Headings (`h1` - `h6`)
- Paragraphs (`p`), strong, emphasis
- Links (`a`) with hover states
- Lists (`ul`, `ol`, `li`) with custom markers
- Code blocks (`pre`, `code`) with syntax highlighting support
- Blockquotes with border accent
- Tables (`table`, `thead`, `tbody`, `tr`, `th`, `td`)
- Horizontal rules (`hr`)
- Figures and captions (`figure`, `figcaption`)
- Definition lists (`dl`, `dt`, `dd`)
- Keyboard input (`kbd`)
- Marked/highlighted text (`mark`)
- Deletions and insertions (`del`, `ins`)
- Abbreviations (`abbr`)
- Citations (`cite`)

**Note:** Nested code elements (code in lists, tables, blockquotes) are specially styled for consistency.

## Accessibility

- Semantic HTML elements
- Proper heading hierarchy
- Sufficient color contrast
- Table headers for screen readers
- Alt text support for images
- Keyboard-accessible links
