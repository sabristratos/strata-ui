<div class="min-h-screen bg-body text-foreground">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-16">

        <div class="text-center space-y-4">
            <h1 class="text-4xl font-bold">Input & Textarea Components</h1>
            <p class="text-lg text-muted-foreground max-w-3xl mx-auto">
                Comprehensive demonstration of Strata UI Input and Textarea components featuring size variants, validation states, icons, prefixes, suffixes, and real-world use cases with Livewire integration.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-3 flex justify-end">
                <x-strata::button
                    wire:click="resetAll"
                    variant="secondary"
                    size="sm"
                    iconLeft="refresh-cw"
                >
                    Reset All Demos
                </x-strata::button>
            </div>
        </div>

        <section class="space-y-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">Basic Input Examples</h2>
                <p class="text-muted-foreground">Common HTML input types with default styling</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="space-y-3">
                    <div>
                        <h3 class="font-semibold mb-1">Text Input</h3>
                        <p class="text-sm text-muted-foreground">type="text"</p>
                    </div>
                    <x-strata::input
                        wire:model.live="basicInput"
                        type="text"
                        placeholder="Enter text"
                    />
                    <span class="text-xs text-muted-foreground font-mono">Value: {{ $basicInput ?: '(empty)' }}</span>
                </div>

                <div class="space-y-3">
                    <div>
                        <h3 class="font-semibold mb-1">Email Input</h3>
                        <p class="text-sm text-muted-foreground">type="email"</p>
                    </div>
                    <x-strata::input
                        wire:model.live="emailInput"
                        type="email"
                        placeholder="your@email.com"
                    />
                    <span class="text-xs text-muted-foreground font-mono">Value: {{ $emailInput ?: '(empty)' }}</span>
                </div>

                <div class="space-y-3">
                    <div>
                        <h3 class="font-semibold mb-1">Password Input</h3>
                        <p class="text-sm text-muted-foreground">type="password"</p>
                    </div>
                    <x-strata::input
                        wire:model.live="passwordInput"
                        type="password"
                        placeholder="••••••••"
                    />
                    <span class="text-xs text-muted-foreground font-mono">Value: {{ $passwordInput ? str_repeat('•', strlen($passwordInput)) : '(empty)' }}</span>
                </div>

                <div class="space-y-3">
                    <div>
                        <h3 class="font-semibold mb-1">Search Input</h3>
                        <p class="text-sm text-muted-foreground">type="search"</p>
                    </div>
                    <x-strata::input
                        wire:model.live="searchInput"
                        type="search"
                        placeholder="Search..."
                    />
                    <span class="text-xs text-muted-foreground font-mono">Value: {{ $searchInput ?: '(empty)' }}</span>
                </div>

                <div class="space-y-3">
                    <div>
                        <h3 class="font-semibold mb-1">Number Input</h3>
                        <p class="text-sm text-muted-foreground">type="number"</p>
                    </div>
                    <x-strata::input
                        wire:model.live="numberInput"
                        type="number"
                        placeholder="123"
                    />
                    <span class="text-xs text-muted-foreground font-mono">Value: {{ $numberInput ?: '(empty)' }}</span>
                </div>

                <div class="space-y-3">
                    <div>
                        <h3 class="font-semibold mb-1">Tel Input</h3>
                        <p class="text-sm text-muted-foreground">type="tel"</p>
                    </div>
                    <x-strata::input
                        wire:model.live="telInput"
                        type="tel"
                        placeholder="+1 (555) 000-0000"
                    />
                    <span class="text-xs text-muted-foreground font-mono">Value: {{ $telInput ?: '(empty)' }}</span>
                </div>

                <div class="space-y-3">
                    <div>
                        <h3 class="font-semibold mb-1">URL Input</h3>
                        <p class="text-sm text-muted-foreground">type="url"</p>
                    </div>
                    <x-strata::input
                        wire:model.live="urlInput"
                        type="url"
                        placeholder="https://example.com"
                    />
                    <span class="text-xs text-muted-foreground font-mono">Value: {{ $urlInput ?: '(empty)' }}</span>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">Size Variants</h2>
                <p class="text-muted-foreground">Small, medium, and large input sizes</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-3">
                    <h3 class="font-semibold">Small (sm)</h3>
                    <x-strata::input
                        wire:model.live="inputSm"
                        size="sm"
                        placeholder="Small input"
                    />
                    <span class="text-xs text-muted-foreground">h-9 px-3 text-sm</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Medium (md) - Default</h3>
                    <x-strata::input
                        wire:model.live="inputMd"
                        size="md"
                        placeholder="Medium input"
                    />
                    <span class="text-xs text-muted-foreground">h-10 px-3 text-base</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Large (lg)</h3>
                    <x-strata::input
                        wire:model.live="inputLg"
                        size="lg"
                        placeholder="Large input"
                    />
                    <span class="text-xs text-muted-foreground">h-11 px-4 text-lg</span>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">Validation States</h2>
                <p class="text-muted-foreground">Default, success, error, and warning states with automatic icons</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <h3 class="font-semibold">Default</h3>
                    <x-strata::input
                        wire:model.live="inputDefault"
                        state="default"
                        placeholder="No validation"
                    />
                    <span class="text-xs text-muted-foreground">border-border with ring on focus</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Success</h3>
                    <x-strata::input
                        wire:model.live="inputSuccess"
                        state="success"
                        placeholder="Valid input"
                    />
                    <span class="text-xs text-success">✓ Check circle icon appears automatically</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Error</h3>
                    <x-strata::input
                        wire:model.live="inputError"
                        state="error"
                        placeholder="Invalid input"
                    />
                    <span class="text-xs text-destructive">✗ Alert circle icon appears automatically</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Warning</h3>
                    <x-strata::input
                        wire:model.live="inputWarning"
                        state="warning"
                        placeholder="Warning input"
                    />
                    <span class="text-xs text-warning">⚠ Alert triangle icon appears automatically</span>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">Icon Support</h2>
                <p class="text-muted-foreground">Left icons, right icons, or both simultaneously</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-3">
                    <h3 class="font-semibold">Left Icon</h3>
                    <x-strata::input
                        wire:model.live="iconLeftInput"
                        iconLeft="mail"
                        placeholder="Email address"
                    />
                    <span class="text-xs text-muted-foreground">iconLeft="mail"</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Right Icon</h3>
                    <x-strata::input
                        wire:model.live="iconRightInput"
                        iconRight="search"
                        placeholder="Search..."
                    />
                    <span class="text-xs text-muted-foreground">iconRight="search"</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Both Icons</h3>
                    <x-strata::input
                        wire:model.live="iconBothInput"
                        iconLeft="user"
                        iconRight="check"
                        placeholder="Username"
                    />
                    <span class="text-xs text-muted-foreground">iconLeft + iconRight</span>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">Prefix & Suffix</h2>
                <p class="text-muted-foreground">Real-world examples with text decorations</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="space-y-3">
                    <h3 class="font-semibold">Currency</h3>
                    <x-strata::input
                        wire:model.live="currencyInput"
                        type="number"
                        prefix="$"
                        placeholder="0.00"
                    />
                    <span class="text-xs text-muted-foreground">prefix="$"</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">URL Prefix</h3>
                    <x-strata::input
                        wire:model.live="urlPrefixInput"
                        type="text"
                        prefix="https://"
                        placeholder="example.com"
                    />
                    <span class="text-xs text-muted-foreground">prefix="https://"</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Domain</h3>
                    <x-strata::input
                        wire:model.live="domainInput"
                        type="text"
                        suffix=".com"
                        placeholder="yoursite"
                    />
                    <span class="text-xs text-muted-foreground">suffix=".com"</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Measurement</h3>
                    <x-strata::input
                        wire:model.live="measurementInput"
                        type="number"
                        suffix="kg"
                        placeholder="0"
                    />
                    <span class="text-xs text-muted-foreground">suffix="kg"</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Percentage</h3>
                    <x-strata::input
                        wire:model.live="percentageInput"
                        type="number"
                        suffix="%"
                        placeholder="0"
                    />
                    <span class="text-xs text-muted-foreground">suffix="%"</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Combined (Budget)</h3>
                    <x-strata::input
                        wire:model.live="currencyInput"
                        type="number"
                        iconLeft="dollar-sign"
                        prefix="$"
                        suffix="USD"
                        placeholder="0.00"
                    />
                    <span class="text-xs text-muted-foreground">icon + prefix + suffix</span>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">Clearable & Disabled</h2>
                <p class="text-muted-foreground">Interactive clearing and disabled states</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <h3 class="font-semibold">Clearable Input</h3>
                    <x-strata::input
                        wire:model.live="clearableInput"
                        iconLeft="search"
                        placeholder="Search with clear button"
                    >
                        <x-strata::input.clear />
                    </x-strata::input>
                    <span class="text-xs text-muted-foreground">Uses slot with &lt;x-strata::input.clear /&gt;</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Disabled State</h3>
                    <x-strata::input
                        wire:model.live="disabledInput"
                        :disabled="true"
                        placeholder="Cannot edit"
                    />
                    <span class="text-xs text-muted-foreground">disabled="true" - opacity-50</span>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">All Features Combined</h2>
                <p class="text-muted-foreground">Input with every decoration option simultaneously</p>
            </div>

            <div class="max-w-2xl">
                <x-strata::input
                    wire:model.live="allFeaturesInput"
                    size="lg"
                    state="success"
                    iconLeft="gift"
                    prefix="$"
                    suffix="USD"
                    placeholder="Enter amount"
                >
                    <x-strata::input.clear />
                </x-strata::input>
                <p class="text-sm text-muted-foreground mt-3">
                    size="lg" | state="success" | iconLeft="gift" | prefix="$" | suffix="USD" | clearable
                </p>
            </div>
        </section>

        <section class="space-y-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">Textarea: Basic Examples</h2>
                <p class="text-muted-foreground">Multi-line text input for various use cases</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <h3 class="font-semibold">Basic Textarea</h3>
                    <x-strata::textarea
                        wire:model.live="basicTextarea"
                        placeholder="Enter your text here..."
                        rows="4"
                    />
                    <span class="text-xs text-muted-foreground">Default 4 rows</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Comment Box</h3>
                    <x-strata::textarea
                        wire:model.live="commentTextarea"
                        placeholder="Leave a comment..."
                        rows="4"
                    />
                    <span class="text-xs text-muted-foreground">Comments, feedback, notes</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Description</h3>
                    <x-strata::textarea
                        wire:model.live="descriptionTextarea"
                        placeholder="Describe your project in detail..."
                        rows="6"
                    />
                    <span class="text-xs text-muted-foreground">Longer content, 6 rows</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Message</h3>
                    <x-strata::textarea
                        wire:model.live="messageTextarea"
                        placeholder="Write your message..."
                        rows="6"
                    />
                    <span class="text-xs text-muted-foreground">Contact forms, messages</span>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">Textarea: Size Variants</h2>
                <p class="text-muted-foreground">Small, medium, and large textarea sizes</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-3">
                    <h3 class="font-semibold">Small (sm)</h3>
                    <x-strata::textarea
                        wire:model.live="textareaSm"
                        size="sm"
                        placeholder="Small textarea"
                        rows="4"
                    />
                    <span class="text-xs text-muted-foreground">px-3 py-2 text-sm</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Medium (md) - Default</h3>
                    <x-strata::textarea
                        wire:model.live="textareaMd"
                        size="md"
                        placeholder="Medium textarea"
                        rows="4"
                    />
                    <span class="text-xs text-muted-foreground">px-3 py-2.5 text-base</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Large (lg)</h3>
                    <x-strata::textarea
                        wire:model.live="textareaLg"
                        size="lg"
                        placeholder="Large textarea"
                        rows="4"
                    />
                    <span class="text-xs text-muted-foreground">px-4 py-3 text-lg</span>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">Textarea: Validation States</h2>
                <p class="text-muted-foreground">States with automatic icon indicators</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <h3 class="font-semibold">Default</h3>
                    <x-strata::textarea
                        wire:model.live="textareaDefault"
                        state="default"
                        placeholder="No validation"
                        rows="3"
                    />
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Success</h3>
                    <x-strata::textarea
                        wire:model.live="textareaSuccess"
                        state="success"
                        rows="3"
                    />
                    <span class="text-xs text-success">✓ Green border with check icon</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Error</h3>
                    <x-strata::textarea
                        wire:model.live="textareaError"
                        state="error"
                        placeholder="Required field"
                        rows="3"
                    />
                    <span class="text-xs text-destructive">✗ Red border with alert icon</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Warning</h3>
                    <x-strata::textarea
                        wire:model.live="textareaWarning"
                        state="warning"
                        rows="3"
                    />
                    <span class="text-xs text-warning">⚠ Yellow border with warning icon</span>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">Textarea: Resize Options</h2>
                <p class="text-muted-foreground">Control how users can resize the textarea</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <h3 class="font-semibold">None (Fixed Size)</h3>
                    <x-strata::textarea
                        wire:model.live="resizeNone"
                        resize="none"
                        placeholder="Cannot resize (fixed)"
                        rows="3"
                    />
                    <span class="text-xs text-muted-foreground">resize="none"</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Vertical (Default)</h3>
                    <x-strata::textarea
                        wire:model.live="resizeVertical"
                        resize="vertical"
                        placeholder="Resize vertically only"
                        rows="3"
                    />
                    <span class="text-xs text-muted-foreground">resize="vertical"</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Horizontal</h3>
                    <x-strata::textarea
                        wire:model.live="resizeHorizontal"
                        resize="horizontal"
                        placeholder="Resize horizontally only"
                        rows="3"
                    />
                    <span class="text-xs text-muted-foreground">resize="horizontal"</span>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold">Both Directions</h3>
                    <x-strata::textarea
                        wire:model.live="resizeBoth"
                        resize="both"
                        placeholder="Resize in any direction"
                        rows="3"
                    />
                    <span class="text-xs text-muted-foreground">resize="both"</span>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">Textarea: Character Count</h2>
                <p class="text-muted-foreground">Using slot for character counter and helper text</p>
            </div>

            <div class="max-w-2xl">
                <x-strata::textarea
                    wire:model.live="charCountTextarea"
                    placeholder="Type something (max 200 characters)..."
                    rows="5"
                    :state="strlen($charCountTextarea) > 200 ? 'error' : (strlen($charCountTextarea) > 180 ? 'warning' : 'default')"
                >
                    <span class="text-xs {{ strlen($charCountTextarea) > 200 ? 'text-destructive' : 'text-muted-foreground' }}">
                        {{ strlen($charCountTextarea) }} / 200 characters
                    </span>
                </x-strata::textarea>
                <p class="text-sm text-muted-foreground mt-3">
                    Character counter in slot with dynamic state based on length
                </p>
            </div>
        </section>

        <section class="space-y-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">Real-World Example: Contact Form</h2>
                <p class="text-muted-foreground">Complete form with validation, error handling, and submission</p>
            </div>

            <div class="max-w-3xl mx-auto border border-border rounded-lg p-8 bg-card">
                @if($formSubmitted)
                    <div class="mb-6 p-4 bg-success/10 border border-success rounded-lg text-success">
                        {{ $formSubmitted }}
                    </div>
                @endif

                <form wire:submit="submitForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="formName" class="block text-sm font-medium">
                                Name <span class="text-destructive">*</span>
                            </label>
                            <x-strata::input
                                id="formName"
                                wire:model="formName"
                                iconLeft="user"
                                placeholder="John Doe"
                                :state="$errors->has('formName') ? 'error' : ($formName && strlen($formName) >= 3 ? 'success' : 'default')"
                            />
                            @error('formName')
                                <span class="text-xs text-destructive">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="formEmail" class="block text-sm font-medium">
                                Email <span class="text-destructive">*</span>
                            </label>
                            <x-strata::input
                                id="formEmail"
                                wire:model="formEmail"
                                type="email"
                                iconLeft="mail"
                                placeholder="john@example.com"
                                :state="$errors->has('formEmail') ? 'error' : ($formEmail && filter_var($formEmail, FILTER_VALIDATE_EMAIL) ? 'success' : 'default')"
                            />
                            @error('formEmail')
                                <span class="text-xs text-destructive">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="formPhone" class="block text-sm font-medium">
                                Phone <span class="text-destructive">*</span>
                            </label>
                            <x-strata::input
                                id="formPhone"
                                wire:model="formPhone"
                                type="tel"
                                iconLeft="phone"
                                placeholder="+1 (555) 000-0000"
                                :state="$errors->has('formPhone') ? 'error' : ($formPhone ? 'success' : 'default')"
                            />
                            @error('formPhone')
                                <span class="text-xs text-destructive">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="formWebsite" class="block text-sm font-medium">
                                Website
                            </label>
                            <x-strata::input
                                id="formWebsite"
                                wire:model="formWebsite"
                                type="url"
                                prefix="https://"
                                placeholder="example.com"
                                :state="$errors->has('formWebsite') ? 'error' : 'default'"
                            />
                            @error('formWebsite')
                                <span class="text-xs text-destructive">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="formBudget" class="block text-sm font-medium">
                                Budget
                            </label>
                            <x-strata::input
                                id="formBudget"
                                wire:model="formBudget"
                                type="number"
                                prefix="$"
                                suffix="USD"
                                placeholder="0.00"
                                :state="$errors->has('formBudget') ? 'error' : 'default'"
                            />
                            @error('formBudget')
                                <span class="text-xs text-destructive">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="formMessage" class="block text-sm font-medium">
                            Message <span class="text-destructive">*</span>
                        </label>
                        <x-strata::textarea
                            id="formMessage"
                            wire:model="formMessage"
                            placeholder="Tell us about your project..."
                            rows="5"
                            :state="$errors->has('formMessage') ? 'error' : ($formMessage && strlen($formMessage) >= 10 ? 'success' : 'default')"
                        >
                            <span class="text-xs {{ strlen($formMessage) > 500 ? 'text-destructive' : 'text-muted-foreground' }}">
                                {{ strlen($formMessage) }} / 500 characters
                            </span>
                        </x-strata::textarea>
                        @error('formMessage')
                            <span class="text-xs text-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <x-strata::button type="submit" iconLeft="send">
                            Submit Form
                        </x-strata::button>
                        <x-strata::button
                            type="button"
                            wire:click="resetForm"
                            variant="secondary"
                            iconLeft="x"
                        >
                            Reset Form
                        </x-strata::button>
                    </div>
                </form>
            </div>
        </section>

        <section class="space-y-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">Features Demonstrated</h2>
                <p class="text-muted-foreground">Complete feature checklist</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="flex items-start gap-3 p-4 border border-border rounded-lg">
                    <div class="w-6 h-6 rounded-full bg-success/20 text-success flex items-center justify-center flex-shrink-0 mt-0.5">✓</div>
                    <div>
                        <h4 class="font-semibold">All Input Types</h4>
                        <p class="text-sm text-muted-foreground">text, email, password, search, number, tel, url</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 border border-border rounded-lg">
                    <div class="w-6 h-6 rounded-full bg-success/20 text-success flex items-center justify-center flex-shrink-0 mt-0.5">✓</div>
                    <div>
                        <h4 class="font-semibold">3 Size Variants</h4>
                        <p class="text-sm text-muted-foreground">Small, medium, large for both components</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 border border-border rounded-lg">
                    <div class="w-6 h-6 rounded-full bg-success/20 text-success flex items-center justify-center flex-shrink-0 mt-0.5">✓</div>
                    <div>
                        <h4 class="font-semibold">4 Validation States</h4>
                        <p class="text-sm text-muted-foreground">Default, success, error, warning with auto-icons</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 border border-border rounded-lg">
                    <div class="w-6 h-6 rounded-full bg-success/20 text-success flex items-center justify-center flex-shrink-0 mt-0.5">✓</div>
                    <div>
                        <h4 class="font-semibold">Icon Support</h4>
                        <p class="text-sm text-muted-foreground">Left, right, or both icons simultaneously</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 border border-border rounded-lg">
                    <div class="w-6 h-6 rounded-full bg-success/20 text-success flex items-center justify-center flex-shrink-0 mt-0.5">✓</div>
                    <div>
                        <h4 class="font-semibold">Prefix & Suffix</h4>
                        <p class="text-sm text-muted-foreground">Currency, URLs, measurements, percentages</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 border border-border rounded-lg">
                    <div class="w-6 h-6 rounded-full bg-success/20 text-success flex items-center justify-center flex-shrink-0 mt-0.5">✓</div>
                    <div>
                        <h4 class="font-semibold">Clearable Functionality</h4>
                        <p class="text-sm text-muted-foreground">Clear button using slot pattern</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 border border-border rounded-lg">
                    <div class="w-6 h-6 rounded-full bg-success/20 text-success flex items-center justify-center flex-shrink-0 mt-0.5">✓</div>
                    <div>
                        <h4 class="font-semibold">Disabled State</h4>
                        <p class="text-sm text-muted-foreground">Visual disabled state with reduced opacity</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 border border-border rounded-lg">
                    <div class="w-6 h-6 rounded-full bg-success/20 text-success flex items-center justify-center flex-shrink-0 mt-0.5">✓</div>
                    <div>
                        <h4 class="font-semibold">Textarea Resize Options</h4>
                        <p class="text-sm text-muted-foreground">None, vertical, horizontal, both directions</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 border border-border rounded-lg">
                    <div class="w-6 h-6 rounded-full bg-success/20 text-success flex items-center justify-center flex-shrink-0 mt-0.5">✓</div>
                    <div>
                        <h4 class="font-semibold">Character Counter</h4>
                        <p class="text-sm text-muted-foreground">Using slot for dynamic character counting</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 border border-border rounded-lg">
                    <div class="w-6 h-6 rounded-full bg-success/20 text-success flex items-center justify-center flex-shrink-0 mt-0.5">✓</div>
                    <div>
                        <h4 class="font-semibold">Livewire Integration</h4>
                        <p class="text-sm text-muted-foreground">wire:model, validation, real-time updates</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 border border-border rounded-lg">
                    <div class="w-6 h-6 rounded-full bg-success/20 text-success flex items-center justify-center flex-shrink-0 mt-0.5">✓</div>
                    <div>
                        <h4 class="font-semibold">Form Validation</h4>
                        <p class="text-sm text-muted-foreground">Complete form with error handling</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 border border-border rounded-lg">
                    <div class="w-6 h-6 rounded-full bg-success/20 text-success flex items-center justify-center flex-shrink-0 mt-0.5">✓</div>
                    <div>
                        <h4 class="font-semibold">Inset Shadow Depth</h4>
                        <p class="text-sm text-muted-foreground">Subtle tactile depth for interactive feel</p>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
