# File Input

A flexible file upload component with drag-and-drop support, file previews, upload progress tracking, client-side validation, and full Livewire integration.

## Features

- Single and multiple file uploads
- Drag-and-drop functionality with visual feedback
- **Upload progress indicator** with percentage display
- **Client-side validation** (file size, type, max files)
- **Built-in error display** for validation feedback
- Image thumbnail previews
- **Color-coded file extension badges**
- File type restrictions via accept attribute
- File size display
- Three size variants (sm, md, lg)
- Validation states (default, success, error, warning)
- **Custom icon support**
- **Loading state** during file processing
- **Clear all functionality** for file lists
- Disabled state
- Full Livewire wire:model integration

## Basic Usage

### Single File Upload

```blade
<x-strata::file-input
    wire:model.live="file"
    label="Upload a file"
    hint="Drag and drop or click to select"
/>
```

### Multiple File Upload

```blade
<x-strata::file-input
    wire:model.live="files"
    multiple
    label="Upload files"
    hint="Select multiple files"
/>
```

## New Features

### Upload Progress Indicator

Progress bar automatically appears when using wire:model with file uploads:

```blade
<x-strata::file-input
    wire:model="files"
    multiple
    label="Upload with progress tracking"
/>
```

The component automatically:
- Shows a progress bar during upload
- Displays upload percentage
- Shows loading overlay on drop zone
- Prevents interaction during upload

### Client-Side File Size Validation

Validate file sizes before upload to provide instant feedback:

```blade
<x-strata::file-input
    wire:model.live="files"
    :maxSize="1024 * 1024 * 5"
    label="Upload files (max 5MB each)"
    hint="Files larger than 5MB will be rejected"
/>
```

The `maxSize` prop accepts bytes. Files exceeding this size will be rejected with an error message before upload.

### Max Files Limit

Limit the number of files that can be selected:

```blade
<x-strata::file-input
    wire:model.live="files"
    multiple
    :maxFiles="3"
    label="Upload up to 3 files"
    hint="Maximum 3 files allowed"
/>
```

When users try to select more files than allowed, an instant error message appears.

### Built-In Error Display

Display validation errors directly in the component:

```blade
<x-strata::file-input
    wire:model.live="files"
    accept=".pdf"
    :maxSize="1024 * 1024"
    :error="$validationError"
    label="Upload PDF (max 1MB)"
/>
```

The error prop displays a formatted error message below the component.

### Custom Icon

Change the upload icon to any available Strata icon:

```blade
<x-strata::file-input
    icon="paperclip"
    label="Attach files"
/>

<x-strata::file-input
    icon="file-plus"
    label="Add documents"
/>
```

Default icon is `upload-cloud`.

### File Extension Badges

File items automatically display color-coded extension badges:

```blade
<x-strata::file-input.item
    fileName="document.pdf"
    fileSize="2.5 MB"
/>
```

Badge colors by file type:
- **PDF** - Red
- **DOC/DOCX** - Blue
- **XLS/XLSX** - Green
- **PPT/PPTX** - Orange
- **Images** - Pink
- **Videos** - Indigo
- **Audio** - Teal
- **Archives** - Purple

Disable badges with `:showBadge="false"`.

### Clear All Functionality

Add a "Clear All" button to file lists:

```blade
<x-strata::file-input.list
    clearable
    title="Selected Files"
    onClear="clearAllFiles"
>
    @foreach($files as $index => $file)
        <x-strata::file-input.item ... />
    @endforeach
</x-strata::file-input.list>
```

## Props Reference

### Main Component (file-input)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `multiple` | boolean | `false` | Allow multiple file selection |
| `accept` | string | `null` | File type restrictions (e.g., "image/*", ".pdf,.doc") |
| `maxSize` | integer | `null` | Maximum file size in bytes (validated client-side) |
| `maxFiles` | integer | `null` | Maximum number of files allowed (validated client-side) |
| `size` | string | `'md'` | Component size: `'sm'`, `'md'`, `'lg'` |
| `state` | string | `'default'` | Validation state: `'default'`, `'success'`, `'error'`, `'warning'` |
| `disabled` | boolean | `false` | Disable file selection |
| `label` | string | `null` | Main label text |
| `hint` | string | `null` | Helper text below label |
| `error` | string | `null` | Error message to display below component |
| `icon` | string | `'upload-cloud'` | Icon to display (any Strata icon name) |

### File Item Component (file-input.item)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `fileName` | string | `null` | Display name of the file |
| `fileSize` | string | `null` | Formatted file size string |
| `fileType` | string | `null` | MIME type of the file |
| `preview` | string | `null` | Preview image URL (for images) |
| `onRemove` | string | `null` | Livewire method to call on remove |
| `showBadge` | boolean | `true` | Show file extension badge |

### File List Component (file-input.list)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `empty` | string | `'No files selected'` | Text to show when list is empty |
| `clearable` | boolean | `false` | Show "Clear All" button |
| `onClear` | string | `null` | Livewire method to call on clear all |
| `title` | string | `null` | Optional title above file list |

## Livewire Integration

The file input component is built to work seamlessly with Livewire's file upload features.

### Component Setup

```php
use Livewire\Component;
use Livewire\WithFileUploads;

class FileUploadForm extends Component
{
    use WithFileUploads;

    public $avatar;
    public $documents = [];

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => 'image|max:2048',
        ]);
    }

    public function clearAllDocuments()
    {
        $this->documents = [];
    }

    public function render()
    {
        return view('livewire.file-upload-form');
    }
}
```

### View with All Features

```blade
<div>
    <x-strata::file-input
        wire:model.live="documents"
        multiple
        accept=".pdf,.doc,.docx"
        :maxSize="1024 * 1024 * 5"
        :maxFiles="5"
        label="Upload documents"
        hint="PDF, DOC, DOCX up to 5MB, max 5 files"
    />

    @if(count($documents) > 0)
        <x-strata::file-input.list
            clearable
            title="Selected Documents"
            onClear="clearAllDocuments"
        >
            @foreach($documents as $index => $doc)
                <x-strata::file-input.item
                    :fileName="$doc->getClientOriginalName()"
                    :fileSize="number_format($doc->getSize() / 1024, 2) . ' KB'"
                    :onRemove="'removeDocument(' . $index . ')'"
                />
            @endforeach
        </x-strata::file-input.list>
    @endif
</div>
```

## Size Variants

```blade
<x-strata::file-input size="sm" label="Small upload" />
<x-strata::file-input size="md" label="Medium upload" />
<x-strata::file-input size="lg" label="Large upload" />
```

## Validation States

```blade
<x-strata::file-input
    state="success"
    label="Upload successful"
/>

<x-strata::file-input
    state="error"
    label="Upload failed"
    hint="Please try again"
    error="File type not supported"
/>

<x-strata::file-input
    state="warning"
    label="File size warning"
    hint="File exceeds recommended size"
/>
```

## File Type Restrictions

### Images Only

```blade
<x-strata::file-input
    accept="image/*"
    label="Upload images"
    hint="PNG, JPG, GIF"
/>
```

### Documents Only

```blade
<x-strata::file-input
    accept=".pdf,.doc,.docx"
    label="Upload documents"
    hint="PDF, DOC, DOCX"
/>
```

### Multiple Specific Types

```blade
<x-strata::file-input
    accept=".csv,.xlsx,.xls"
    label="Upload spreadsheets"
    hint="CSV or Excel files"
/>
```

## Combined Validation Example

Use multiple validation props together for comprehensive client-side validation:

```blade
<x-strata::file-input
    wire:model.live="files"
    multiple
    accept="image/*"
    :maxSize="1024 * 1024 * 2"
    :maxFiles="10"
    label="Upload images"
    hint="Up to 10 images, 2MB each, PNG/JPG only"
/>
```

This will validate:
- Only image files accepted
- Maximum 2MB per file
- Maximum 10 files total
- All validation happens instantly before upload

## Form Submission Example

```blade
<form wire:submit="submit">
    <x-strata::file-input
        wire:model="documents"
        multiple
        accept=".pdf,.doc,.docx"
        :maxSize="1024 * 1024 * 5"
        :maxFiles="5"
        label="Upload required documents"
    />

    @error('documents.*')
        <p class="text-sm text-destructive mt-2">{{ $message }}</p>
    @enderror

    <x-strata::button type="submit" class="mt-4">
        Submit
    </x-strata::button>
</form>
```

```php
public function submit(): void
{
    $this->validate([
        'documents.*' => 'required|mimes:pdf,doc,docx|max:5120',
    ]);

    foreach ($this->documents as $document) {
        $document->store('documents');
    }

    session()->flash('message', 'Documents uploaded successfully!');
}
```

## Disabled State

```blade
<x-strata::file-input
    disabled
    label="Upload disabled"
    hint="File uploads are currently unavailable"
/>
```

## Custom Slot Content

You can use the default slot for custom hint content:

```blade
<x-strata::file-input label="Upload file">
    <span class="text-primary">Click to browse</span> or drag files here
</x-strata::file-input>
```

## Styling & Customization

The file input component uses Strata UI's theming system. You can customize colors by overriding CSS custom properties:

```css
@theme {
    --color-input-border: oklch(0.8 0.02 250);
    --color-primary: oklch(0.5 0.2 250);
    --color-destructive: oklch(0.6 0.2 10);
}
```

## Accessibility

The component includes proper accessibility features:
- Keyboard navigation support
- ARIA labels for screen readers
- Visual feedback for drag-and-drop
- Focus states for keyboard users
- Progress announcements for screen readers

## Browser Support

All features work in modern browsers:
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)

Client-side validation uses modern JavaScript APIs available in all current browsers.

## Notes

- Files are temporarily stored by Livewire until explicitly saved
- Client-side validation provides instant feedback before server upload
- Upload progress requires wire:model (not wire:model.live) for proper tracking
- Image previews use temporary URLs generated by Livewire
- Remove functionality requires Livewire methods
- Drag-and-drop area responds to hover and drag states
- File extension badges are automatically color-coded
- Clear All button only appears when clearable prop is true and files exist
