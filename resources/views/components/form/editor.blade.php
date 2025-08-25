@php
    $editorId = $id ?: 'editor-' . Str::random(8);
@endphp

<div
    x-data="{
        /**
         * Rich text editor component state
         * @property {string} content - HTML content of the editor
         */
        content: '{{ $value }}',
        
        /**
         * Initialize the editor component
         * Sets initial content and attaches form submission handler
         */
        init() {
            this.$refs.editor.innerHTML = this.content;
            this.$el.closest('form')?.addEventListener('submit', () => {
                this.update();
            });
        },
        
        /**
         * Update the hidden input with current editor content
         * Called on input events and form submission
         */
        update() {
            this.content = this.$refs.editor.innerHTML;
        },
        
        /**
         * Apply formatting command to selected text
         * @param {string} command - The execCommand to execute (bold, italic, etc.)
         * @param {?string} param - Optional parameter for the command
         */
        format(command, param = null) {
            this.$refs.editor.focus();
            const selection = window.getSelection();
            
            if (selection.rangeCount > 0) {
                try {
                    document.execCommand(command, false, param);
                } catch (e) {
                    console.error('Format command failed:', e);
                }
            }
        }
    }"
    x-init="init()"
    class="w-full"
>
    <div class="border border-muted rounded-md overflow-hidden bg-white dark:bg-gray-900">
        <div class="flex items-center gap-1 p-2 border-b border-muted bg-gray-50 dark:bg-gray-800">
            <x-strata::button 
                variant="ghost" 
                size="sm"
                type="button"
                @click="format('bold')"
                :disabled="$disabled ?? false"
                class="!w-8 !h-8 !p-0 flex-shrink-0"
            >
                <strong class="font-bold">B</strong>
            </x-strata::button>
            
            <x-strata::button 
                variant="ghost" 
                size="sm"
                type="button"
                @click="format('italic')"
                :disabled="$disabled ?? false"
                class="!w-8 !h-8 !p-0 flex-shrink-0"
            >
                <em class="italic">I</em>
            </x-strata::button>
            
            <x-strata::button 
                variant="ghost" 
                size="sm"
                type="button"
                @click="format('underline')"
                :disabled="$disabled ?? false"
                class="!w-8 !h-8 !p-0 flex-shrink-0"
            >
                <span class="underline">U</span>
            </x-strata::button>
            
            <div class="w-px h-6 bg-muted mx-1"></div>
            
            <x-strata::button 
                variant="ghost" 
                size="sm"
                type="button"
                @click="format('insertUnorderedList')"
                :disabled="$disabled ?? false"
                icon="heroicon-o-list-bullet"
                class="!w-8 !h-8 flex-shrink-0"
            />
            
            <x-strata::button 
                variant="ghost" 
                size="sm"
                type="button"
                @click="format('insertOrderedList')"
                :disabled="$disabled ?? false"
                icon="heroicon-o-numbered-list"
                class="!w-8 !h-8 flex-shrink-0"
            />
        </div>
        <div
            @if($id) id="{{ $id }}" @endif
            x-ref="editor"
            @if($disabled ?? false) @else contenteditable="true" @endif
            class="block w-full p-4 text-primary focus:outline-none focus:ring-0 bg-white dark:bg-gray-900 prose prose-sm max-w-none [&_ul]:list-disc [&_ul]:ml-6 [&_ol]:list-decimal [&_ol]:ml-6"
            style="min-height: {{ $minHeight }}px; {{ $maxHeight ? 'max-height: ' . $maxHeight . 'px; overflow-y: auto;' : '' }}"
            @input="update"
            @if($placeholder) data-placeholder="{{ $placeholder }}" @endif
            {{ $attributes }}
        ></div>
    </div>
    <input type="hidden" @if($name) name="{{ $name }}" @endif x-model="content">
    
    <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 border border-muted rounded-md">
        <div class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Generated HTML:</div>
        <pre class="text-xs text-gray-600 dark:text-gray-400 whitespace-pre-wrap" x-text="content"></pre>
    </div>
</div>