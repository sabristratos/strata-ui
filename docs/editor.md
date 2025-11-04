# Editor

Rich text editor component powered by [Tiptap](https://tiptap.dev/) with a comprehensive formatting toolbar. Perfect for blog posts, comments, descriptions, or any content that needs rich formatting.

## Features

- **Text Formatting**: Bold, Italic, Strike, Code
- **Headings**: H1, H2, H3
- **Lists**: Bullet lists and ordered lists
- **Blocks**: Blockquotes and code blocks
- **Rich Content**: Links and images
- **Text Alignment**: Left, center, right, justify
- **History**: Undo and redo with keyboard shortcuts
- **Active States**: Visual feedback showing active formatting
- **Keyboard Shortcuts**: Full Tiptap keyboard support
- **Livewire Integration**: Seamless two-way data binding
- **JSON Storage**: Content stored in Tiptap's structured JSON format

## Basic Usage

```blade
<x-strata::editor wire:model="content" />
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `size` | `string` | `'md'` | Component size: `'sm'`, `'md'`, or `'lg'` |
| `state` | `string` | `'default'` | Validation state: `'default'`, `'success'`, `'error'`, or `'warning'` |
| `id` | `string\|null` | `null` | HTML id attribute (auto-generated if not provided) |

## Sizes

### Small

```blade
<x-strata::editor wire:model="content" size="sm" />
```

Minimum height: 128px (min-h-32), Text size: small

### Medium (Default)

```blade
<x-strata::editor wire:model="content" size="md" />
```

Minimum height: 240px (min-h-60), Text size: base

### Large

```blade
<x-strata::editor wire:model="content" size="lg" />
```

Minimum height: 384px (min-h-96), Text size: large

## Validation States

### Default

```blade
<x-strata::editor wire:model="content" />
```

Standard border and focus ring.

### Success

```blade
<x-strata::editor wire:model="content" state="success" />
```

Green border and focus ring to indicate valid content.

### Error

```blade
<x-strata::editor wire:model="content" state="error" />
```

Red border and focus ring to indicate validation errors.

### Warning

```blade
<x-strata::editor wire:model="content" state="warning" />
```

Yellow/amber border and focus ring for warnings.

## Livewire Integration

The editor automatically syncs with Livewire using `wire:model`:

```blade
<x-strata::editor wire:model="post.body" />
```

```php
use Livewire\Component;

class EditPost extends Component
{
    public $post;

    public function save()
    {
        $this->validate([
            'post.body' => 'required|json',
        ]);

        $this->post->save();
    }
}
```

## Content Format

**Important**: The editor stores content as JSON, not HTML. This is Tiptap's native format and provides better structure and reliability.

### Example JSON Structure

```json
{
  "type": "doc",
  "content": [
    {
      "type": "heading",
      "attrs": { "level": 2 },
      "content": [
        { "type": "text", "text": "Welcome" }
      ]
    },
    {
      "type": "paragraph",
      "content": [
        { "type": "text", "text": "This is " },
        { "type": "text", "marks": [{ "type": "bold" }], "text": "bold text" },
        { "type": "text", "text": " with a " },
        {
          "type": "text",
          "marks": [{ "type": "link", "attrs": { "href": "https://example.com" } }],
          "text": "link"
        }
      ]
    }
  ]
}
```

### Converting to HTML

If you need HTML output for display, you can convert the JSON in your Livewire component or model:

```php
use Tiptap\Editor;

class Post extends Model
{
    protected $casts = [
        'body' => 'array', // Cast JSON to array
    ];

    public function getBodyHtmlAttribute()
    {
        return (new Editor)
            ->setContent($this->body)
            ->getHTML();
    }
}
```

```blade
{!! $post->bodyHtml !!}
```

Or use a package like `ueberdosis/tiptap-php` for server-side rendering.

## Toolbar Features

### Text Formatting

- **Bold** - `Ctrl/Cmd + B`
- **Italic** - `Ctrl/Cmd + I`
- **Strike** - `Ctrl/Cmd + Shift + S`
- **Code** - `Ctrl/Cmd + E`

### Headings

- **Heading 1** - `Ctrl/Cmd + Alt + 1`
- **Heading 2** - `Ctrl/Cmd + Alt + 2`
- **Heading 3** - `Ctrl/Cmd + Alt + 3`

### Lists

- **Bullet List** - `Ctrl/Cmd + Shift + 8`
- **Ordered List** - `Ctrl/Cmd + Shift + 7`

### Blocks

- **Blockquote** - `Ctrl/Cmd + Shift + B`
- **Code Block** - `Ctrl/Cmd + Alt + C`

### Rich Content

- **Link** - Prompts for URL, then creates/removes link
- **Image** - Prompts for image URL, then inserts image

### Text Alignment

- **Align Left**
- **Align Center**
- **Align Right**
- **Justify**

### History

- **Undo** - `Ctrl/Cmd + Z`
- **Redo** - `Ctrl/Cmd + Shift + Z` or `Ctrl/Cmd + Y`

## Keyboard Shortcuts

All standard Tiptap keyboard shortcuts are supported:

| Action | Shortcut (Mac) | Shortcut (Windows) |
|--------|----------------|-------------------|
| Bold | `Cmd + B` | `Ctrl + B` |
| Italic | `Cmd + I` | `Ctrl + I` |
| Strike | `Cmd + Shift + S` | `Ctrl + Shift + S` |
| Code | `Cmd + E` | `Ctrl + E` |
| Heading 1 | `Cmd + Alt + 1` | `Ctrl + Alt + 1` |
| Heading 2 | `Cmd + Alt + 2` | `Ctrl + Alt + 2` |
| Heading 3 | `Cmd + Alt + 3` | `Ctrl + Alt + 3` |
| Bullet List | `Cmd + Shift + 8` | `Ctrl + Shift + 8` |
| Ordered List | `Cmd + Shift + 7` | `Ctrl + Shift + 7` |
| Blockquote | `Cmd + Shift + B` | `Ctrl + Shift + B` |
| Code Block | `Cmd + Alt + C` | `Ctrl + Alt + C` |
| Undo | `Cmd + Z` | `Ctrl + Z` |
| Redo | `Cmd + Shift + Z` | `Ctrl + Shift + Z` |
| Hard Break | `Shift + Enter` | `Shift + Enter` |

## Examples

### Blog Post Editor

```blade
<div>
    <x-strata::label for="title">Title</x-strata::label>
    <x-strata::input wire:model="title" id="title" />

    <x-strata::label for="body" class="mt-4">Body</x-strata::label>
    <x-strata::editor wire:model="body" size="lg" id="body" />

    <x-strata::button wire:click="save" class="mt-4">
        Publish
    </x-strata::button>
</div>
```

### Comment System

```blade
<div>
    <x-strata::editor
        wire:model="comment"
        size="sm"
        :state="$errors->has('comment') ? 'error' : 'default'"
    />

    @error('comment')
        <p class="text-destructive text-sm mt-1">{{ $message }}</p>
    @enderror

    <x-strata::button wire:click="submit" size="sm" class="mt-2">
        Post Comment
    </x-strata::button>
</div>
```

### Form with Validation

```blade
<form wire:submit="save">
    <div class="space-y-4">
        <div>
            <x-strata::label for="description">Description</x-strata::label>
            <x-strata::editor
                wire:model="description"
                id="description"
                :state="$errors->has('description') ? 'error' : 'default'"
            />
            @error('description')
                <p class="text-destructive text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <x-strata::button type="submit">Save</x-strata::button>
    </div>
</form>
```

## Tiptap Extensions

The editor includes the following Tiptap extensions:

### StarterKit

Includes: Document, Paragraph, Text, Bold, Italic, Strike, Code, Heading, Bullet List, Ordered List, List Item, Blockquote, Code Block, Horizontal Rule, Hard Break, Dropcursor, Gapcursor, History.

[StarterKit Documentation →](https://tiptap.dev/api/extensions/starter-kit)

### Link

Clickable links with configurable attributes.

Configuration:
- `openOnClick: false` - Links don't open automatically
- Custom classes: `text-primary underline cursor-pointer`

[Link Documentation →](https://tiptap.dev/api/marks/link)

### Image

Inline images with responsive sizing.

Configuration:
- Custom classes: `max-w-full h-auto rounded`

[Image Documentation →](https://tiptap.dev/api/nodes/image)

### TextAlign

Text alignment for headings and paragraphs.

Configuration:
- Applies to: `heading`, `paragraph`

[TextAlign Documentation →](https://tiptap.dev/api/extensions/text-align)

## Accessibility

- Toolbar buttons have `aria-label` attributes
- Toolbar buttons have `title` tooltips
- Active formatting states are visually indicated
- All keyboard shortcuts work for screen reader users
- Focus management within the editor

## Styling

The editor uses Tailwind's typography plugin classes for consistent, beautiful text styling:

- `prose` - Base prose styling
- `prose-sm` / `prose-lg` - Size variants
- `dark:prose-invert` - Dark mode support
- `max-w-none` - Allow full width content
- `focus:outline-none` - Custom focus styles

## Known Limitations

1. **Link and Image Insertion**: Currently uses `window.prompt()` which is not ideal UX. Future versions will include proper modal dialogs.

2. **No File Upload**: Images require a URL. To add file upload:
   - Use Livewire's file upload
   - Upload to temporary storage
   - Get public URL
   - Insert into editor

3. **No Toolbar Customization**: Toolbar shows all buttons. Future versions will support customization.

4. **JSON Format**: Content is JSON, not HTML. You'll need server-side conversion for HTML display.

## Future Enhancements

- Modal dialogs for link and image insertion
- File upload support for images
- Toolbar customization (show/hide buttons)
- Placeholder text support
- Character/word count
- Table support
- Mention support (@username)
- Collaboration/real-time editing
- Export to Markdown/HTML
- Import from HTML/Markdown

## Browser Support

Tiptap supports all modern browsers:
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)

## Troubleshooting

### Content Not Saving

Make sure your Livewire property accepts JSON/array:

```php
public $content; // Works

protected $casts = [
    'content' => 'array', // Even better
];
```

### Styling Issues

Ensure you have included the Strata UI assets:

```blade
<head>
    @strataStyles
</head>
<body>
    @strataScripts
</body>
```

### Alpine Not Initializing

The editor uses `wire:ignore` and requires the page to be fully loaded. If you're loading the editor dynamically, ensure Alpine reinitializes.

### Links Not Working

Links don't open on click by default (security). To open:
- Hold `Cmd/Ctrl` while clicking
- Right-click → "Open Link"
- Use the link button to edit/remove

## See Also

- [Tiptap Documentation](https://tiptap.dev/)
- [Tailwind Typography Plugin](https://tailwindcss.com/docs/typography-plugin)
- [Livewire Wire:model](https://laravel-livewire.com/docs/properties#data-binding)
