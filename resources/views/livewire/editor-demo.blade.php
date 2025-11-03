<div class="container mx-auto py-12 px-4 max-w-4xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Tiptap Editor Demo</h1>
        <p class="text-muted-foreground">Test the rich text editor component with all formatting options</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-success/10 border border-success rounded-lg text-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="space-y-6">
        <div>
            <label class="block text-sm font-medium mb-2">Editor</label>
            <x-strata::editor wire:model.live="content" />
        </div>

        <div class="flex gap-3">
            <button
                wire:click="save"
                class="px-4 py-2 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 transition-colors"
            >
                Save Content
            </button>
        </div>

        <div>
            <details class="border border-border rounded-lg">
                <summary class="px-4 py-3 cursor-pointer font-medium hover:bg-muted/50 transition-colors">
                    View JSON Content
                </summary>
                <div class="p-4 border-t border-border bg-muted/30">
                    <pre class="text-xs overflow-auto"><code>{{ json_encode($content, JSON_PRETTY_PRINT) }}</code></pre>
                </div>
            </details>
        </div>

        <div>
            <h3 class="text-lg font-semibold mb-3">Formatting Options</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="p-4 border border-border rounded-lg">
                    <h4 class="font-medium mb-2">Text Formatting</h4>
                    <ul class="space-y-1 text-muted-foreground">
                        <li>• Bold (Ctrl+B)</li>
                        <li>• Italic (Ctrl+I)</li>
                        <li>• Strikethrough</li>
                        <li>• Inline Code</li>
                    </ul>
                </div>
                <div class="p-4 border border-border rounded-lg">
                    <h4 class="font-medium mb-2">Headings</h4>
                    <ul class="space-y-1 text-muted-foreground">
                        <li>• Heading 1</li>
                        <li>• Heading 2</li>
                        <li>• Heading 3</li>
                    </ul>
                </div>
                <div class="p-4 border border-border rounded-lg">
                    <h4 class="font-medium mb-2">Lists & Blocks</h4>
                    <ul class="space-y-1 text-muted-foreground">
                        <li>• Bullet List</li>
                        <li>• Numbered List</li>
                        <li>• Blockquote</li>
                        <li>• Code Block</li>
                    </ul>
                </div>
                <div class="p-4 border border-border rounded-lg">
                    <h4 class="font-medium mb-2">Alignment & Media</h4>
                    <ul class="space-y-1 text-muted-foreground">
                        <li>• Text Alignment (Left/Center/Right/Justify)</li>
                        <li>• Links</li>
                        <li>• Images (URL)</li>
                        <li>• Undo/Redo (Ctrl+Z/Ctrl+Shift+Z)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
