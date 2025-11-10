<?php

describe('Editor Component', function () {
    test('renders with default props', function () {
        expectComponent($this, 'editor')
            ->toHaveDataAttribute('strata-editor')
            ->toHaveDataAttribute('strata-field-type', 'editor')
            ->toHaveDataAttribute('strata-editor-content')
            ->toHaveDataAttribute('strata-editor-input');
    });

    test('renders hidden input for Livewire binding', function () {
        expectComponent($this, 'editor')
            ->toContain('type="hidden"')
            ->toContain('data-strata-editor-input');
    });

    test('renders with wire:ignore directive', function () {
        expectComponent($this, 'editor')
            ->toContain('wire:ignore');
    });

    test('renders all sizes', function () {
        expectComponent($this, 'editor', ['size' => 'sm'])
            ->toHaveClasses('min-h-32', 'text-sm');

        expectComponent($this, 'editor', ['size' => 'md'])
            ->toHaveClasses('min-h-60', 'text-base');

        expectComponent($this, 'editor', ['size' => 'lg'])
            ->toHaveClasses('min-h-96', 'text-lg');
    });

    test('renders all validation states', function () {
        expectComponent($this, 'editor', ['state' => 'default'])
            ->toHaveClasses('border-border')
            ->toContain('focus-within:ring-ring');

        expectComponent($this, 'editor', ['state' => 'success'])
            ->toHaveClasses('border-success')
            ->toContain('focus-within:ring-success/20');

        expectComponent($this, 'editor', ['state' => 'error'])
            ->toHaveClasses('border-destructive')
            ->toContain('focus-within:ring-destructive/20');

        expectComponent($this, 'editor', ['state' => 'warning'])
            ->toHaveClasses('border-warning')
            ->toContain('focus-within:ring-warning/20');
    });

    test('wrapper has base classes', function () {
        expectComponent($this, 'editor')
            ->toHaveClasses('rounded-lg', 'border', 'bg-background', 'transition-colors');
    });

    test('wrapper has focus-within ring', function () {
        expectComponent($this, 'editor', ['state' => 'default'])
            ->toContain('focus-within:ring-2')
            ->toContain('focus-within:ring-ring')
            ->toContain('focus-within:ring-offset-2');
    });

    test('merges custom classes on wrapper', function () {
        expectComponent($this, 'editor', ['class' => 'custom-editor'])
            ->toHaveClasses('custom-editor', 'rounded-lg', 'border');
    });

    test('generates unique ID when not provided', function () {
        expectComponent($this, 'editor')
            ->toContain('editor-')
            ->toContain('id="editor-');
    });

    test('uses provided ID', function () {
        expectComponent($this, 'editor', ['id' => 'my-editor'])
            ->toContain('id="my-editor"');
    });

    test('includes toolbar component', function () {
        expectComponent($this, 'editor')
            ->toContain('data-strata-editor-toolbar');
    });

    test('toolbar has all formatting buttons', function () {
        expectComponent($this, 'editor')
            ->toContain('@click="toggleBold()"')
            ->toContain('@click="toggleItalic()"')
            ->toContain('@click="toggleStrike()"')
            ->toContain('@click="toggleCode()"');
    });

    test('toolbar has heading buttons', function () {
        expectComponent($this, 'editor')
            ->toContain('@click="toggleHeading(1)"')
            ->toContain('@click="toggleHeading(2)"')
            ->toContain('@click="toggleHeading(3)"');
    });

    test('toolbar has list buttons', function () {
        expectComponent($this, 'editor')
            ->toContain('@click="toggleBulletList()"')
            ->toContain('@click="toggleOrderedList()"');
    });

    test('toolbar has blockquote button', function () {
        expectComponent($this, 'editor')
            ->toContain('@click="toggleBlockquote()"');
    });

    test('toolbar has code block button', function () {
        expectComponent($this, 'editor')
            ->toContain('@click="toggleCodeBlock()"');
    });

    test('toolbar has link button', function () {
        expectComponent($this, 'editor')
            ->toContain('@click="setLink()"');
    });

    test('toolbar has image button', function () {
        expectComponent($this, 'editor')
            ->toContain('@click="addImage()"');
    });

    test('toolbar has text alignment buttons', function () {
        expectComponent($this, 'editor')
            ->toContain('@click="setTextAlign(\'left\')"')
            ->toContain('@click="setTextAlign(\'center\')"')
            ->toContain('@click="setTextAlign(\'right\')"')
            ->toContain('@click="setTextAlign(\'justify\')"');
    });

    test('toolbar has undo and redo buttons', function () {
        expectComponent($this, 'editor')
            ->toContain('@click="undo()"')
            ->toContain('@click="redo()"');
    });

    test('toolbar buttons have aria-labels', function () {
        expectComponent($this, 'editor')
            ->toContain('aria-label="Toggle bold"')
            ->toContain('aria-label="Toggle italic"')
            ->toContain('aria-label="Add link"')
            ->toContain('aria-label="Add image"');
    });

    test('toolbar buttons show active state', function () {
        expectComponent($this, 'editor')
            ->toContain(':class="{ \'bg-primary/20 text-primary\': isActive(\'bold\') }"')
            ->toContain(':class="{ \'bg-primary/20 text-primary\': isActive(\'italic\') }"');
    });

    test('toolbar has separators between button groups', function () {
        expectComponent($this, 'editor')
            ->toContain('data-strata-editor-separator');
    });

    test('initializes Alpine component with strataEditor', function () {
        expectComponent($this, 'editor')
            ->toContain('x-data="strataEditor(');
    });

    test('passes initial value to Alpine component', function () {
        expectComponent($this, 'editor')
            ->toContain('x-data="strataEditor(')
            ->toContain('null)');
    });

    test('editor content div has correct x-ref', function () {
        expectComponent($this, 'editor')
            ->toContain('x-ref="editor"');
    });

    test('passes wire:model to hidden input', function () {
        expectComponent($this, 'editor')
            ->toContain('type="hidden"');
    });

    test('undo button is disabled when no history', function () {
        expectComponent($this, 'editor')
            ->toContain(':disabled="!canUndo()"');
    });

    test('redo button is disabled when no future history', function () {
        expectComponent($this, 'editor')
            ->toContain(':disabled="!canRedo()"');
    });

    test('renders with name attribute', function () {
        expectComponent($this, 'editor', ['name' => 'content'])
            ->toContain('name="content"');
    });

    test('default size is medium', function () {
        expectComponent($this, 'editor')
            ->toHaveClasses('min-h-60', 'text-base');
    });

    test('default state is default', function () {
        expectComponent($this, 'editor')
            ->toHaveClasses('border-border')
            ->toContain('focus-within:ring-ring');
    });

    test('falls back to default size for invalid size', function () {
        expectComponent($this, 'editor', ['size' => 'invalid'])
            ->toHaveClasses('min-h-60', 'text-base');
    });

    test('falls back to default state for invalid state', function () {
        expectComponent($this, 'editor', ['state' => 'invalid'])
            ->toHaveClasses('border-border')
            ->toContain('focus-within:ring-ring');
    });

    test('toolbar buttons have tooltips', function () {
        expectComponent($this, 'editor')
            ->toContain('title="Bold (Ctrl+B)"')
            ->toContain('title="Italic (Ctrl+I)"')
            ->toContain('title="Strikethrough"')
            ->toContain('title="Inline code"');
    });

    test('toolbar buttons have hover states', function () {
        expectComponent($this, 'editor')
            ->toContain('hover:bg-muted')
            ->toContain('hover:text-foreground');
    });

    test('toolbar has proper spacing', function () {
        expectComponent($this, 'editor')
            ->toContain('gap-1')
            ->toContain('p-2');
    });

    test('editor content area has proper styling', function () {
        expectComponent($this, 'editor')
            ->toContain('data-strata-editor-content')
            ->toHaveClasses('text-foreground');
    });

    test('hidden input only receives specific attributes', function () {
        expectComponent($this, 'editor', [
            'wire:model' => 'content',
            'name' => 'editor_content',
            'class' => 'custom-class',
            'data-custom' => 'value',
        ])
            ->toContain('wire:model')
            ->toContain('name="editor_content"');
    });

    test('component is properly scoped with data attributes', function () {
        expectComponent($this, 'editor')
            ->toHaveDataAttribute('strata-editor')
            ->toHaveDataAttribute('strata-field-type', 'editor')
            ->toHaveDataAttribute('strata-editor-content')
            ->toHaveDataAttribute('strata-editor-input')
            ->toHaveDataAttribute('strata-editor-toolbar');
    });

    test('all states have ring-offset-2', function () {
        expectComponent($this, 'editor', ['state' => 'default'])
            ->toContain('focus-within:ring-offset-2');

        expectComponent($this, 'editor', ['state' => 'success'])
            ->toContain('focus-within:ring-offset-2');

        expectComponent($this, 'editor', ['state' => 'error'])
            ->toContain('focus-within:ring-offset-2');

        expectComponent($this, 'editor', ['state' => 'warning'])
            ->toContain('focus-within:ring-offset-2');
    });

    test('toolbar button SVG icons have correct size', function () {
        expectComponent($this, 'editor')
            ->toContain('w-4 h-4')
            ->toContain('class="w-4 h-4"');
    });

    test('toolbar separator has correct styling', function () {
        expectComponent($this, 'editor')
            ->toContain('w-px')
            ->toContain('bg-border')
            ->toContain('mx-1');
    });
});
