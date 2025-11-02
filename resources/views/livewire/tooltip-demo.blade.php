<div class="space-y-12">
    <div>
        <h2 class="text-2xl font-semibold mb-6">Tooltip Component</h2>
        <p class="text-muted-foreground mb-8">
            Interactive tooltips with hover and focus support. Supports both simple text and rich HTML content.
        </p>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Simple Text Tooltips</h3>
        <div class="flex flex-wrap gap-4">
            <x-strata::tooltip text="This is a simple tooltip">
                <x-strata::button>Hover me</x-strata::button>
            </x-strata::tooltip>

            <x-strata::tooltip text="Button with icon tooltip" placement="right">
                <x-strata::button.icon icon="circle-help" />
            </x-strata::tooltip>

            <x-strata::tooltip text="Secondary button tooltip" placement="bottom">
                <x-strata::button variant="secondary">Secondary</x-strata::button>
            </x-strata::tooltip>

            <x-strata::tooltip text="Destructive action warning" placement="left">
                <x-strata::button variant="destructive">Delete</x-strata::button>
            </x-strata::tooltip>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Placement Variants</h3>
        <div class="flex justify-center items-center gap-12 p-12">
            <x-strata::tooltip text="Top placement" placement="top">
                <x-strata::button>Top</x-strata::button>
            </x-strata::tooltip>

            <x-strata::tooltip text="Right placement" placement="right">
                <x-strata::button>Right</x-strata::button>
            </x-strata::tooltip>

            <x-strata::tooltip text="Bottom placement" placement="bottom">
                <x-strata::button>Bottom</x-strata::button>
            </x-strata::tooltip>

            <x-strata::tooltip text="Left placement" placement="left">
                <x-strata::button>Left</x-strata::button>
            </x-strata::tooltip>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Rich Content Tooltips</h3>
        <div class="flex flex-wrap gap-4">
            <x-strata::tooltip>
                <x-slot:content>
                    <div class="space-y-1">
                        <div class="font-semibold">Rich Content</div>
                        <div class="text-xs">This tooltip contains HTML</div>
                    </div>
                </x-slot:content>
                <x-strata::button>Rich HTML</x-strata::button>
            </x-strata::tooltip>

            <x-strata::tooltip placement="right">
                <x-slot:content>
                    <div class="space-y-1">
                        <div class="font-semibold">Interactive Tooltip</div>
                        <div class="text-xs">
                            <a href="https://github.com" target="_blank" class="underline hover:text-primary">
                                Click this link
                            </a>
                        </div>
                    </div>
                </x-slot:content>
                <x-strata::button.icon icon="circle-help" />
            </x-strata::tooltip>

            <x-strata::tooltip placement="bottom">
                <x-slot:content>
                    <div class="space-y-2">
                        <div class="font-semibold">Keyboard Shortcut</div>
                        <div class="flex gap-1">
                            <x-strata::kbd>Ctrl</x-strata::kbd>
                            <span>+</span>
                            <x-strata::kbd>S</x-strata::kbd>
                        </div>
                    </div>
                </x-slot:content>
                <x-strata::button>Save</x-strata::button>
            </x-strata::tooltip>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Custom Delays</h3>
        <div class="flex flex-wrap gap-4">
            <x-strata::tooltip text="No delay" :delay="0">
                <x-strata::button>Instant (0ms)</x-strata::button>
            </x-strata::tooltip>

            <x-strata::tooltip text="Fast delay" :delay="100">
                <x-strata::button>Fast (100ms)</x-strata::button>
            </x-strata::tooltip>

            <x-strata::tooltip text="Default delay">
                <x-strata::button>Default (200ms)</x-strata::button>
            </x-strata::tooltip>

            <x-strata::tooltip text="Slow delay" :delay="500">
                <x-strata::button>Slow (500ms)</x-strata::button>
            </x-strata::tooltip>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Tooltips on Various Elements</h3>
        <div class="flex flex-wrap items-center gap-4">
            <x-strata::tooltip text="Avatar tooltip">
                <x-strata::avatar src="https://github.com/shadcn.png" alt="Avatar" />
            </x-strata::tooltip>

            <x-strata::tooltip text="Badge tooltip">
                <x-strata::badge>Badge</x-strata::badge>
            </x-strata::tooltip>

            <x-strata::tooltip text="Keyboard shortcut">
                <x-strata::kbd>Esc</x-strata::kbd>
            </x-strata::tooltip>

            <x-strata::tooltip text="Alert with tooltip">
                <x-strata::alert variant="info" title="Info Alert" />
            </x-strata::tooltip>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Multiple Tooltips</h3>
        <p class="text-muted-foreground mb-4">
            Test that multiple tooltips work correctly on the same page.
        </p>
        <div class="grid grid-cols-4 gap-4">
            @for($i = 1; $i <= 12; $i++)
                <x-strata::tooltip text="Tooltip {{ $i }}" placement="{{ ['top', 'right', 'bottom', 'left'][($i - 1) % 4] }}">
                    <x-strata::button class="w-full">Button {{ $i }}</x-strata::button>
                </x-strata::tooltip>
            @endfor
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Accessibility</h3>
        <p class="text-muted-foreground mb-4">
            Tooltips are keyboard accessible. Use Tab to focus elements and the tooltip will show.
        </p>
        <div class="flex flex-wrap gap-4">
            <x-strata::tooltip text="Focus to show tooltip">
                <x-strata::button>Tab to focus</x-strata::button>
            </x-strata::tooltip>

            <x-strata::tooltip text="Works with icon buttons too">
                <x-strata::button.icon icon="circle-help" />
            </x-strata::tooltip>
        </div>
    </div>
</div>
