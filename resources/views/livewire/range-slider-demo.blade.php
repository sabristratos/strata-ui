<div class="min-h-screen bg-background p-8">
    <div class="max-w-6xl mx-auto space-y-12">
        <div>
            <h1 class="text-4xl font-bold text-foreground mb-2">Range Slider Component</h1>
            <p class="text-lg text-muted-foreground">Dual-handle range input for numeric value filtering</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-semibold text-foreground mb-4">E-commerce Examples</h2>

                    <div class="space-y-6 bg-card border border-border rounded-lg p-6">
                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Price Range</label>
                            <x-strata::range-slider
                                wire:model.live="priceRange"
                                :min="0"
                                :max="1000"
                                :step="10"
                                prefix="$"
                            />
                            <p class="mt-2 text-sm text-muted-foreground">
                                Selected: <code class="px-2 py-1 bg-muted rounded">${{ $priceRange['min'] }} - ${{ $priceRange['max'] }}</code>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Discount Range (%)</label>
                            <x-strata::range-slider
                                wire:model.live="discountRange"
                                :min="0"
                                :max="100"
                                :step="5"
                                suffix="%"
                            />
                            <p class="mt-2 text-sm text-muted-foreground">
                                Selected: <code class="px-2 py-1 bg-muted rounded">{{ $discountRange['min'] }}% - {{ $discountRange['max'] }}%</code>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Rating Range</label>
                            <x-strata::range-slider
                                wire:model.live="ratingRange"
                                :min="1"
                                :max="5"
                                :step="0.5"
                            />
                            <p class="mt-2 text-sm text-muted-foreground">
                                Selected: <code class="px-2 py-1 bg-muted rounded">{{ $ratingRange['min'] }} - {{ $ratingRange['max'] }} stars</code>
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-semibold text-foreground mb-4">Size Variants</h2>

                    <div class="space-y-4 bg-card border border-border rounded-lg p-6">
                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Small</label>
                            <x-strata::range-slider
                                wire:model="priceRange"
                                :min="0"
                                :max="1000"
                                size="sm"
                                prefix="$"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Medium (Default)</label>
                            <x-strata::range-slider
                                wire:model="priceRange"
                                :min="0"
                                :max="1000"
                                size="md"
                                prefix="$"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Large</label>
                            <x-strata::range-slider
                                wire:model="priceRange"
                                :min="0"
                                :max="1000"
                                size="lg"
                                prefix="$"
                            />
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-semibold text-foreground mb-4">Validation States</h2>

                    <div class="space-y-4 bg-card border border-border rounded-lg p-6">
                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Default</label>
                            <x-strata::range-slider
                                wire:model="priceRange"
                                :min="0"
                                :max="1000"
                                state="default"
                                prefix="$"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-success mb-2">Success</label>
                            <x-strata::range-slider
                                wire:model="ageRange"
                                :min="0"
                                :max="100"
                                state="success"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-destructive mb-2">Error</label>
                            <x-strata::range-slider
                                wire:model="priceRange"
                                :min="0"
                                :max="1000"
                                state="error"
                                prefix="$"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-warning mb-2">Warning</label>
                            <x-strata::range-slider
                                wire:model="priceRange"
                                :min="0"
                                :max="1000"
                                state="warning"
                                prefix="$"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-semibold text-foreground mb-4">Display Options</h2>

                    <div class="space-y-4 bg-card border border-border rounded-lg p-6">
                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">With Values (Default)</label>
                            <x-strata::range-slider
                                wire:model="priceRange"
                                :min="0"
                                :max="1000"
                                :show-values="true"
                                prefix="$"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Without Values</label>
                            <x-strata::range-slider
                                wire:model="priceRange"
                                :min="0"
                                :max="1000"
                                :show-values="false"
                                prefix="$"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Without Labels</label>
                            <x-strata::range-slider
                                wire:model="priceRange"
                                :min="0"
                                :max="1000"
                                :show-labels="false"
                                prefix="$"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Minimal (No Values/Labels)</label>
                            <x-strata::range-slider
                                wire:model="priceRange"
                                :min="0"
                                :max="1000"
                                :show-values="false"
                                :show-labels="false"
                                prefix="$"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Disabled</label>
                            <x-strata::range-slider
                                wire:model="priceRange"
                                :min="0"
                                :max="1000"
                                :disabled="true"
                                prefix="$"
                            />
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-semibold text-foreground mb-4">Other Use Cases</h2>

                    <div class="space-y-4 bg-card border border-border rounded-lg p-6">
                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Age Range</label>
                            <x-strata::range-slider
                                wire:model.live="ageRange"
                                :min="18"
                                :max="65"
                                :step="1"
                                suffix=" yrs"
                            />
                            <p class="mt-2 text-sm text-muted-foreground">
                                Selected: <code class="px-2 py-1 bg-muted rounded">{{ $ageRange['min'] }} - {{ $ageRange['max'] }} years</code>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Temperature Range (°C)</label>
                            <x-strata::range-slider
                                wire:model.live="temperatureRange"
                                :min="-20"
                                :max="50"
                                :step="1"
                                suffix="°C"
                            />
                            <p class="mt-2 text-sm text-muted-foreground">
                                Selected: <code class="px-2 py-1 bg-muted rounded">{{ $temperatureRange['min'] }}°C - {{ $temperatureRange['max'] }}°C</code>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Volume (%)</label>
                            <x-strata::range-slider
                                wire:model.live="volumeRange"
                                :min="0"
                                :max="100"
                                :step="1"
                                suffix="%"
                            />
                            <p class="mt-2 text-sm text-muted-foreground">
                                Selected: <code class="px-2 py-1 bg-muted rounded">{{ $volumeRange['min'] }}% - {{ $volumeRange['max'] }}%</code>
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-semibold text-foreground mb-4">Interactive Demo</h2>

                    <div class="bg-card border border-border rounded-lg p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Adjust Price Range</label>
                            <x-strata::range-slider
                                wire:model.live="priceRange"
                                :min="0"
                                :max="1000"
                                :step="10"
                                prefix="$"
                                size="lg"
                            />
                        </div>

                        <div class="mt-6 p-6 rounded-lg border-2 border-border bg-muted">
                            <h3 class="text-xl font-bold mb-4">Filter Results</h3>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-muted-foreground">Minimum Price:</span>
                                    <span class="font-bold ml-2">${{ $priceRange['min'] }}</span>
                                </div>
                                <div>
                                    <span class="text-muted-foreground">Maximum Price:</span>
                                    <span class="font-bold ml-2">${{ $priceRange['max'] }}</span>
                                </div>
                                <div class="col-span-2">
                                    <span class="text-muted-foreground">Price Range:</span>
                                    <span class="font-bold ml-2">${{ $priceRange['min'] }} - ${{ $priceRange['max'] }}</span>
                                </div>
                                <div class="col-span-2">
                                    <span class="text-muted-foreground">Range Width:</span>
                                    <span class="font-bold ml-2">${{ $priceRange['max'] - $priceRange['min'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 p-6 bg-muted rounded-lg">
            <h3 class="text-lg font-semibold text-foreground mb-2">Component Features</h3>
            <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-muted-foreground">
                <li>✓ Dual handles for min/max selection</li>
                <li>✓ Click track to move nearest handle</li>
                <li>✓ Drag handles smoothly</li>
                <li>✓ Keyboard navigation (arrow keys)</li>
                <li>✓ Page Up/Down for large jumps</li>
                <li>✓ Home/End keys to min/max</li>
                <li>✓ Handles cannot cross each other</li>
                <li>✓ Configurable min/max/step</li>
                <li>✓ Prefix/suffix support ($, %, °C)</li>
                <li>✓ Real-time value formatting</li>
                <li>✓ Size variants (sm, md, lg)</li>
                <li>✓ Validation states</li>
                <li>✓ Show/hide values and labels</li>
                <li>✓ Full Livewire integration</li>
                <li>✓ ARIA compliant</li>
                <li>✓ Keyboard accessible</li>
            </ul>
        </div>
    </div>
</div>
