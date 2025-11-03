<div
    data-strata-editor-toolbar
    class="flex items-center gap-1 p-2 border-b border-border bg-muted/30 rounded-t-lg flex-wrap"
>
    <div class="flex items-center gap-0.5">
        <x-strata::editor.button
            @click="toggleBold()"
            :active="isActive('bold')"
            aria-label="Toggle bold"
            title="Bold (Ctrl+B)"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z"/>
            </svg>
        </x-strata::editor.button>

        <x-strata::editor.button
            @click="toggleItalic()"
            :active="isActive('italic')"
            aria-label="Toggle italic"
            title="Italic (Ctrl+I)"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 4h4M14 4l-4 16M6 20h4"/>
            </svg>
        </x-strata::editor.button>

        <x-strata::editor.button
            @click="toggleStrike()"
            :active="isActive('strike')"
            aria-label="Toggle strikethrough"
            title="Strikethrough"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M9 5h6a3 3 0 013 3M9 19h6a3 3 0 003-3"/>
            </svg>
        </x-strata::editor.button>

        <x-strata::editor.button
            @click="toggleCode()"
            :active="isActive('code')"
            aria-label="Toggle code"
            title="Inline code"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
            </svg>
        </x-strata::editor.button>
    </div>

    <x-strata::editor.separator />

    <div class="flex items-center gap-0.5">
        <x-strata::editor.button
            @click="toggleHeading(1)"
            :active="isActive('heading', { level: 1 })"
            aria-label="Toggle heading 1"
            title="Heading 1"
        >
            H1
        </x-strata::editor.button>

        <x-strata::editor.button
            @click="toggleHeading(2)"
            :active="isActive('heading', { level: 2 })"
            aria-label="Toggle heading 2"
            title="Heading 2"
        >
            H2
        </x-strata::editor.button>

        <x-strata::editor.button
            @click="toggleHeading(3)"
            :active="isActive('heading', { level: 3 })"
            aria-label="Toggle heading 3"
            title="Heading 3"
        >
            H3
        </x-strata::editor.button>
    </div>

    <x-strata::editor.separator />

    <div class="flex items-center gap-0.5">
        <x-strata::editor.button
            @click="toggleBulletList()"
            :active="isActive('bulletList')"
            aria-label="Toggle bullet list"
            title="Bullet list"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
            </svg>
        </x-strata::editor.button>

        <x-strata::editor.button
            @click="toggleOrderedList()"
            :active="isActive('orderedList')"
            aria-label="Toggle ordered list"
            title="Numbered list"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 6h10M7 12h10M7 18h10M3 6h.01M3 12h.01M3 18h.01"/>
            </svg>
        </x-strata::editor.button>

        <x-strata::editor.button
            @click="toggleBlockquote()"
            :active="isActive('blockquote')"
            aria-label="Toggle blockquote"
            title="Blockquote"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
        </x-strata::editor.button>

        <x-strata::editor.button
            @click="toggleCodeBlock()"
            :active="isActive('codeBlock')"
            aria-label="Toggle code block"
            title="Code block"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </x-strata::editor.button>
    </div>

    <x-strata::editor.separator />

    <div class="flex items-center gap-0.5">
        <x-strata::editor.button
            @click="setTextAlign('left')"
            :active="isActive({ textAlign: 'left' })"
            aria-label="Align left"
            title="Align left"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h16"/>
            </svg>
        </x-strata::editor.button>

        <x-strata::editor.button
            @click="setTextAlign('center')"
            :active="isActive({ textAlign: 'center' })"
            aria-label="Align center"
            title="Align center"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M7 12h10M4 18h16"/>
            </svg>
        </x-strata::editor.button>

        <x-strata::editor.button
            @click="setTextAlign('right')"
            :active="isActive({ textAlign: 'right' })"
            aria-label="Align right"
            title="Align right"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M10 12h10M4 18h16"/>
            </svg>
        </x-strata::editor.button>

        <x-strata::editor.button
            @click="setTextAlign('justify')"
            :active="isActive({ textAlign: 'justify' })"
            aria-label="Justify"
            title="Justify"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </x-strata::editor.button>
    </div>

    <x-strata::editor.separator />

    <div class="flex items-center gap-0.5">
        <x-strata::editor.button
            @click="setLink()"
            :active="isActive('link')"
            aria-label="Add link"
            title="Link"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
            </svg>
        </x-strata::editor.button>

        <x-strata::editor.button
            @click="addImage()"
            aria-label="Add image"
            title="Image"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </x-strata::editor.button>
    </div>

    <x-strata::editor.separator />

    <div class="flex items-center gap-0.5">
        <x-strata::editor.button
            @click="undo()"
            :disabled="!canUndo()"
            aria-label="Undo"
            title="Undo (Ctrl+Z)"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
            </svg>
        </x-strata::editor.button>

        <x-strata::editor.button
            @click="redo()"
            :disabled="!canRedo()"
            aria-label="Redo"
            title="Redo (Ctrl+Shift+Z)"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10h-10a8 8 0 00-8 8v2M21 10l-6 6m6-6l-6-6"/>
            </svg>
        </x-strata::editor.button>
    </div>
</div>
