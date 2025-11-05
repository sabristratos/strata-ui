<div class="min-h-screen bg-background p-8">
    <div class="max-w-6xl mx-auto space-y-12">
        <div>
            <h1 class="text-4xl font-bold text-foreground mb-2">Color Picker Component</h1>
            <p class="text-lg text-muted-foreground">Interactive color selection with HSL/RGB picker, presets, and multiple formats</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-semibold text-foreground mb-4">Basic Examples</h2>

                    <div class="space-y-4 bg-card border border-border rounded-lg p-6">
                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Primary Color (HEX)</label>
                            <x-strata::color-picker
                                wire:model.live="primaryColor"
                                format="hex"
                                placeholder="Select primary color"
                            />
                            <p class="mt-2 text-sm text-muted-foreground">Value: <code class="px-2 py-1 bg-muted rounded">{{ $primaryColor }}</code></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Secondary Color (HEX)</label>
                            <x-strata::color-picker
                                wire:model.live="secondaryColor"
                                format="hex"
                                size="md"
                            />
                            <p class="mt-2 text-sm text-muted-foreground">Value: <code class="px-2 py-1 bg-muted rounded">{{ $secondaryColor }}</code></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Accent Color (HSL Format)</label>
                            <x-strata::color-picker
                                wire:model.live="hslColor"
                                format="hsl"
                            />
                            <p class="mt-2 text-sm text-muted-foreground">Value: <code class="px-2 py-1 bg-muted rounded">{{ $hslColor }}</code></p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-semibold text-foreground mb-4">Alpha Channel</h2>

                    <div class="space-y-4 bg-card border border-border rounded-lg p-6">
                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Color with Transparency</label>
                            <x-strata::color-picker
                                wire:model.live="alphaColor"
                                format="hex"
                                :allow-alpha="true"
                            />
                            <p class="mt-2 text-sm text-muted-foreground">Value: <code class="px-2 py-1 bg-muted rounded">{{ $alphaColor }}</code></p>
                        </div>

                        <div class="relative h-32 rounded-lg border border-border overflow-hidden">
                            <div class="absolute inset-0" style="background-image: linear-gradient(45deg, #e5e7eb 25%, transparent 25%), linear-gradient(-45deg, #e5e7eb 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #e5e7eb 75%), linear-gradient(-45deg, transparent 75%, #e5e7eb 75%); background-size: 16px 16px; background-position: 0 0, 0 8px, 8px -8px, -8px 0px;"></div>
                            <div class="absolute inset-0 flex items-center justify-center text-white font-bold text-2xl" style="background-color: {{ $alphaColor }}">
                                Preview
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-semibold text-foreground mb-4">Size Variants</h2>

                    <div class="space-y-4 bg-card border border-border rounded-lg p-6">
                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Small</label>
                            <x-strata::color-picker
                                wire:model="primaryColor"
                                size="sm"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Medium (Default)</label>
                            <x-strata::color-picker
                                wire:model="primaryColor"
                                size="md"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Large</label>
                            <x-strata::color-picker
                                wire:model="primaryColor"
                                size="lg"
                            />
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-semibold text-foreground mb-4">Validation States</h2>

                    <div class="space-y-4 bg-card border border-border rounded-lg p-6">
                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Default</label>
                            <x-strata::color-picker
                                wire:model="primaryColor"
                                state="default"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-success mb-2">Success</label>
                            <x-strata::color-picker
                                wire:model="accentColor"
                                state="success"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-destructive mb-2">Error</label>
                            <x-strata::color-picker
                                wire:model="primaryColor"
                                state="error"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-warning mb-2">Warning</label>
                            <x-strata::color-picker
                                wire:model="primaryColor"
                                state="warning"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-semibold text-foreground mb-4">Options</h2>

                    <div class="space-y-4 bg-card border border-border rounded-lg p-6">
                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Not Clearable</label>
                            <x-strata::color-picker
                                wire:model="primaryColor"
                                :clearable="false"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">No Presets</label>
                            <x-strata::color-picker
                                wire:model="primaryColor"
                                :show-presets="false"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Disabled</label>
                            <x-strata::color-picker
                                wire:model="primaryColor"
                                :disabled="true"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Custom Presets</label>
                            <x-strata::color-picker
                                wire:model="primaryColor"
                                :presets="[
                                    '#ef4444' => 'Red',
                                    '#f59e0b' => 'Amber',
                                    '#10b981' => 'Green',
                                    '#3b82f6' => 'Blue',
                                    '#8b5cf6' => 'Purple',
                                    '#ec4899' => 'Pink',
                                    '#06b6d4' => 'Cyan',
                                    '#f43f5e' => 'Rose',
                                ]"
                            />
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-semibold text-foreground mb-4">Live Preview</h2>

                    <div class="bg-card border border-border rounded-lg p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Background Color</label>
                            <x-strata::color-picker
                                wire:model.live="backgroundColor"
                                format="hex"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-foreground mb-2">Text Color</label>
                            <x-strata::color-picker
                                wire:model.live="textColor"
                                format="hex"
                            />
                        </div>

                        <div
                            class="mt-6 p-8 rounded-lg border-2 border-border transition-all duration-300"
                            style="background-color: {{ $backgroundColor }}; color: {{ $textColor }};"
                        >
                            <h3 class="text-2xl font-bold mb-2">Live Preview Card</h3>
                            <p class="text-lg">This card's background and text color change in real-time as you select colors above.</p>
                            <p class="mt-4 text-sm opacity-75">Background: {{ $backgroundColor }}</p>
                            <p class="text-sm opacity-75">Text: {{ $textColor }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-semibold text-foreground mb-4">Color Palette Builder</h2>

                    <div class="bg-card border border-border rounded-lg p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-muted-foreground mb-2">Primary</label>
                                <x-strata::color-picker
                                    wire:model.live="primaryColor"
                                    size="sm"
                                />
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-muted-foreground mb-2">Secondary</label>
                                <x-strata::color-picker
                                    wire:model.live="secondaryColor"
                                    size="sm"
                                />
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-muted-foreground mb-2">Accent</label>
                                <x-strata::color-picker
                                    wire:model.live="accentColor"
                                    size="sm"
                                />
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-muted-foreground mb-2">Background</label>
                                <x-strata::color-picker
                                    wire:model.live="backgroundColor"
                                    size="sm"
                                />
                            </div>
                        </div>

                        <div class="pt-4 border-t border-border">
                            <h4 class="text-sm font-medium text-foreground mb-3">Color Swatches</h4>
                            <div class="grid grid-cols-4 gap-3">
                                <div class="space-y-2">
                                    <div class="h-16 rounded-lg border border-border" style="background-color: {{ $primaryColor }}"></div>
                                    <p class="text-xs text-center text-muted-foreground">Primary</p>
                                </div>
                                <div class="space-y-2">
                                    <div class="h-16 rounded-lg border border-border" style="background-color: {{ $secondaryColor }}"></div>
                                    <p class="text-xs text-center text-muted-foreground">Secondary</p>
                                </div>
                                <div class="space-y-2">
                                    <div class="h-16 rounded-lg border border-border" style="background-color: {{ $accentColor }}"></div>
                                    <p class="text-xs text-center text-muted-foreground">Accent</p>
                                </div>
                                <div class="space-y-2">
                                    <div class="h-16 rounded-lg border border-border" style="background-color: {{ $backgroundColor }}"></div>
                                    <p class="text-xs text-center text-muted-foreground">Background</p>
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
                <li>✓ Interactive HSL/RGB color picker</li>
                <li>✓ Saturation/Lightness area with drag</li>
                <li>✓ Hue slider (360° color wheel)</li>
                <li>✓ Optional alpha/transparency control</li>
                <li>✓ HEX and HSL format support</li>
                <li>✓ Automatic format conversion</li>
                <li>✓ Preset color palette (Tailwind)</li>
                <li>✓ Custom presets support</li>
                <li>✓ Manual input fields</li>
                <li>✓ Real-time color preview</li>
                <li>✓ Size variants (sm, md, lg)</li>
                <li>✓ Validation states</li>
                <li>✓ Clearable option</li>
                <li>✓ Full Livewire integration</li>
                <li>✓ Keyboard accessible</li>
                <li>✓ ARIA compliant</li>
            </ul>
        </div>
    </div>
</div>
