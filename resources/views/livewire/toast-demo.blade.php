<div class="space-y-8">
    <div>
        <h2 class="text-2xl font-bold mb-4">Toast Notifications Demo</h2>
        <p class="text-muted-foreground mb-6">
            Test toast notifications with different variants and behaviors.
        </p>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Livewire Toasts (from PHP)</h3>
        <div class="flex flex-wrap gap-3">
            <x-strata::button wire:click="showSuccessToast" variant="success">
                Show Success
            </x-strata::button>

            <x-strata::button wire:click="showErrorToast" variant="danger">
                Show Error
            </x-strata::button>

            <x-strata::button wire:click="showWarningToast" variant="warning">
                Show Warning
            </x-strata::button>

            <x-strata::button wire:click="showInfoToast">
                Show Info
            </x-strata::button>

            <x-strata::button wire:click="showPersistentToast" variant="secondary">
                Show Persistent (no auto-dismiss)
            </x-strata::button>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">JavaScript Toasts (from Browser)</h3>
        <div class="flex flex-wrap gap-3">
            <x-strata::button onclick="toast.success('Success!', 'Operation completed successfully.')" variant="success">
                JS Success
            </x-strata::button>

            <x-strata::button onclick="toast.error('Error!', 'Something went wrong.')" variant="danger">
                JS Error
            </x-strata::button>

            <x-strata::button onclick="toast.warning('Warning!', 'Please review your changes.')" variant="warning">
                JS Warning
            </x-strata::button>

            <x-strata::button onclick="toast.info('Info', 'This is informational.')">
                JS Info
            </x-strata::button>

            <x-strata::button onclick="toast('Simple message without title')" variant="secondary">
                JS Simple
            </x-strata::button>

            <x-strata::button onclick="toast({ variant: 'success', title: 'Custom', description: 'With custom options', duration: 10000 })" variant="secondary">
                JS Custom Duration (10s)
            </x-strata::button>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Toast Positions</h3>
        <p class="text-sm text-muted-foreground mb-3">
            Add <code class="px-2 py-1 bg-muted rounded text-xs">position="..."</code> prop to the toast component:
        </p>
        <ul class="text-sm text-muted-foreground space-y-1 list-disc list-inside">
            <li><code>bottom-right</code> (default)</li>
            <li><code>bottom-left</code></li>
            <li><code>bottom-center</code></li>
            <li><code>top-right</code></li>
            <li><code>top-left</code></li>
            <li><code>top-center</code></li>
        </ul>
    </div>

    <div class="p-4 bg-muted/50 rounded-lg">
        <h3 class="text-lg font-semibold mb-2">Usage Examples</h3>

        <div class="space-y-4 text-sm">
            <div>
                <p class="font-medium mb-2">1. Add toast container to layout:</p>
                <pre class="bg-card p-3 rounded border overflow-x-auto"><code>&lt;x-strata::toast /&gt;</code></pre>
            </div>

            <div>
                <p class="font-medium mb-2">2. From JavaScript:</p>
                <pre class="bg-card p-3 rounded border overflow-x-auto"><code>toast.success('Title', 'Description');
toast.error('Error', 'Message');
toast('Simple message');</code></pre>
            </div>

            <div>
                <p class="font-medium mb-2">3. From Livewire/PHP:</p>
                <pre class="bg-card p-3 rounded border overflow-x-auto"><code>use Stratos\StrataUI\Strata;

Strata::toast()->success('Saved!', 'Changes saved');
Strata::toast()->error('Failed', 'Please try again');</code></pre>
            </div>
        </div>
    </div>
</div>
