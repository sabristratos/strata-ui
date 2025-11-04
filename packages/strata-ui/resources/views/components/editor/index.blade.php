{{--
/**
 * Editor Component
 *
 * Rich text editor powered by Tiptap with full formatting toolbar.
 * Stores content as JSON (Tiptap's native format) and uses Entangleable for Livewire sync.
 * Includes StarterKit, Link, Image, and TextAlign extensions.
 *
 * @props
 * @prop string $size - Component size: 'sm'|'md'|'lg' (default: 'md')
 * @prop string $state - Validation state: 'default'|'success'|'error'|'warning' (default: 'default')
 * @prop string|null $id - HTML id attribute for the hidden input (default: auto-generated)
 *
 * @slots
 * @slot default - Not used (editor has fixed structure)
 *
 * @data-format
 * The editor stores content as JSON, not HTML. Example structure:
 * {
 *   "type": "doc",
 *   "content": [
 *     {
 *       "type": "paragraph",
 *       "content": [{ "type": "text", "text": "Hello world" }]
 *     }
 *   ]
 * }
 *
 * @features
 * - Text formatting: Bold, Italic, Strike, Code, Headings (1-3)
 * - Lists: Bullet and Ordered
 * - Blocks: Blockquote, Code Block
 * - Rich content: Links and Images
 * - Text alignment: Left, Center, Right, Justify
 * - History: Undo and Redo
 * - Active state highlighting for all toolbar buttons
 * - Keyboard shortcuts (Tiptap defaults)
 *
 * @example Basic usage
 * <x-strata::editor wire:model="content" />
 *
 * @example With size and state
 * <x-strata::editor
 *     wire:model="description"
 *     size="lg"
 *     state="error" />
 *
 * @example With custom ID
 * <x-strata::editor
 *     wire:model="post.body"
 *     id="post-editor" />
 *
 * @note This component uses wire:ignore and manages its own state through Alpine.js
 * @note Content is synced to Livewire via Entangleable on change (with debouncing)
 * @note Link and image insertion currently use window.prompt() (planned improvement)
 */
--}}

@props([
    'size' => 'md',
    'state' => 'default',
    'id' => null,
])

@php
    $sizes = [
        'sm' => 'min-h-32 text-sm',
        'md' => 'min-h-60 text-base',
        'lg' => 'min-h-96 text-lg',
    ];

    $states = [
        'default' => 'border-border focus-within:ring-2 focus-within:ring-ring focus-within:ring-offset-2',
        'success' => 'border-success focus-within:ring-2 focus-within:ring-success/20 focus-within:ring-offset-2',
        'error' => 'border-destructive focus-within:ring-2 focus-within:ring-destructive/20 focus-within:ring-offset-2',
        'warning' => 'border-warning focus-within:ring-2 focus-within:ring-warning/20 focus-within:ring-offset-2',
    ];

    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    $stateClasses = $states[$state] ?? $states['default'];

    $componentId = $id ?? $attributes->get('id') ?? 'editor-' . uniqid();

    $initialValue = null;
    if ($attributes->wire('model')->value() && isset($this)) {
        $initialValue = $this->{$attributes->wire('model')->value()};
    }
@endphp

<div
    wire:ignore
    x-data="strataEditor(@js($initialValue))"
    data-strata-editor
    data-strata-field-type="editor"
    {{ $attributes->merge(['class' => 'rounded-lg border bg-background transition-colors ' . $stateClasses]) }}
>
    <input
        type="hidden"
        data-strata-editor-input
        id="{{ $componentId }}"
        {{ $attributes->only(['wire:model', 'wire:model.live', 'name']) }}
    />

    <x-strata::editor.toolbar />

    <div
        x-ref="editor"
        data-strata-editor-content
        class="text-foreground {{ $sizeClasses }}"
    ></div>

    <input
        type="file"
        x-ref="imageInput"
        accept="image/*"
        class="hidden"
        data-strata-editor-image-input
        @change="handleImageSelect($event)"
    />
</div>
