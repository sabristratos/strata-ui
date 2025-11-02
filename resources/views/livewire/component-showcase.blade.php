<div class="space-y-12" x-data="{ darkMode: $persist(false).as('darkMode'), selectedFeatures: [], sortOrder: 'newest' }">
    {{-- Navigation --}}
    <div class="sticky top-0 z-10 bg-body/80 backdrop-blur-sm border-b border-border p-6 -mx-8 px-8">
        <h1 class="text-3xl font-bold mb-4">Strata UI Component Showcase</h1>
        <nav class="flex flex-wrap gap-2">
            <a href="#form-inputs" class="text-sm px-3 py-1 bg-muted hover:bg-muted/80 rounded-full transition">Form Inputs</a>
            <a href="#buttons" class="text-sm px-3 py-1 bg-muted hover:bg-muted/80 rounded-full transition">Buttons & Actions</a>
            <a href="#layout" class="text-sm px-3 py-1 bg-muted hover:bg-muted/80 rounded-full transition">Layout & Structure</a>
            <a href="#feedback" class="text-sm px-3 py-1 bg-muted hover:bg-muted/80 rounded-full transition">Feedback & Overlays</a>
            <a href="#display" class="text-sm px-3 py-1 bg-muted hover:bg-muted/80 rounded-full transition">Display</a>
        </nav>
    </div>

    {{-- Form Inputs --}}
    <section id="form-inputs" class="space-y-8">
        <h2 class="text-2xl font-bold">Form Inputs</h2>

        {{-- Input --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Input</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Basic Inputs</h4>
                        <div class="space-y-4">
                            <x-strata::input wire:model.live="textInput" placeholder="Enter text" />
                            <x-strata::input wire:model="emailInput" type="email" placeholder="Enter email" />
                            <x-strata::input type="password" placeholder="Enter password" />
                            <x-strata::input type="search" placeholder="Search..." />
                        </div>
                        <div class="mt-4 p-4 bg-muted rounded-lg">
                            <p class="text-sm text-muted-foreground">Text Input: {{ $textInput ?: 'Empty' }}</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Input Sizes</h4>
                        <div class="space-y-4">
                            <x-strata::input size="sm" placeholder="Small input" />
                            <x-strata::input size="md" placeholder="Medium input (default)" />
                            <x-strata::input size="lg" placeholder="Large input" />
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Validation States</h4>
                        <div class="space-y-4">
                            <x-strata::input state="default" placeholder="Default state" />
                            <x-strata::input state="success" placeholder="Success state" value="Valid input" />
                            <x-strata::input state="error" placeholder="Error state" value="Invalid input" />
                            <x-strata::input state="warning" placeholder="Warning state" value="Check this" />
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Input with Clear</h4>
                        <x-strata::input wire:model.live="searchInput" placeholder="Search with clear button" />
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>

        {{-- Textarea --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Textarea</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Basic Textarea</h4>
                        <x-strata::textarea wire:model="textareaInput" placeholder="Enter your message..." rows="4" />
                        <div class="mt-4 p-4 bg-muted rounded-lg">
                            <p class="text-sm text-muted-foreground">Character count: {{ strlen($textareaInput) }}</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Textarea Sizes</h4>
                        <div class="space-y-4">
                            <x-strata::textarea size="sm" placeholder="Small textarea" rows="3" />
                            <x-strata::textarea size="md" placeholder="Medium textarea" rows="3" />
                            <x-strata::textarea size="lg" placeholder="Large textarea" rows="3" />
                        </div>
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>

        {{-- Select --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Select</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Single Select</h4>
                        <x-strata::select :value="$selectedFruit" wire:model.live="selectedFruit" placeholder="Select a fruit">
                            @foreach($fruits as $value => $label)
                                <x-strata::select.option :value="$value">{{ $label }}</x-strata::select.option>
                            @endforeach
                        </x-strata::select>
                        <div class="mt-4 p-4 bg-muted rounded-lg">
                            <p class="text-sm text-muted-foreground">Selected: {{ $selectedFruit ?? 'None' }}</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Multiselect - Inline Chips</h4>
                        <x-strata::select multiple :value="$selectedColors" wire:model.live="selectedColors" placeholder="Select colors" chips="inline">
                            @foreach($colors as $value => $label)
                                <x-strata::select.option :value="$value">{{ $label }}</x-strata::select.option>
                            @endforeach
                        </x-strata::select>
                        <div class="mt-4 p-4 bg-muted rounded-lg">
                            <p class="text-sm text-muted-foreground">Selected: {{ implode(', ', array_map(fn($v) => $colors[$v], $selectedColors)) ?: 'None' }}</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Searchable Select</h4>
                        <x-strata::select searchable wire:model.live="selectedCountry" placeholder="Search countries...">
                            @foreach($countries as $value => $label)
                                <x-strata::select.option :value="$value">{{ $label }}</x-strata::select.option>
                            @endforeach
                        </x-strata::select>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Select Sizes</h4>
                        <div class="space-y-4">
                            <x-strata::select size="sm" placeholder="Small select">
                                <x-strata::select.option value="1">Option 1</x-strata::select.option>
                                <x-strata::select.option value="2">Option 2</x-strata::select.option>
                            </x-strata::select>
                            <x-strata::select size="md" placeholder="Medium select">
                                <x-strata::select.option value="1">Option 1</x-strata::select.option>
                                <x-strata::select.option value="2">Option 2</x-strata::select.option>
                            </x-strata::select>
                            <x-strata::select size="lg" placeholder="Large select">
                                <x-strata::select.option value="1">Option 1</x-strata::select.option>
                                <x-strata::select.option value="2">Option 2</x-strata::select.option>
                            </x-strata::select>
                        </div>
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>

        {{-- Checkbox --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Checkbox</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Basic Checkbox</h4>
                        <div class="space-y-3">
                            <x-strata::checkbox wire:model.live="checkbox">I agree to the terms</x-strata::checkbox>
                            <x-strata::checkbox wire:model.live="checkboxNotifications">Enable notifications</x-strata::checkbox>
                            <x-strata::checkbox wire:model.live="checkboxNewsletter">Subscribe to newsletter</x-strata::checkbox>
                        </div>
                        <div class="mt-4 p-4 bg-muted rounded-lg">
                            <p class="text-sm text-muted-foreground">Agreed: {{ $checkbox ? 'Yes' : 'No' }}</p>
                            <p class="text-sm text-muted-foreground">Notifications: {{ $checkboxNotifications ? 'On' : 'Off' }}</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Checkbox Group</h4>
                        <div class="space-y-3">
                            <x-strata::checkbox wire:model.live="selectAll">Select All</x-strata::checkbox>
                            @foreach($availableOptions as $value => $label)
                                <x-strata::checkbox wire:model.live="selectedOptions" value="{{ $value }}">{{ $label }}</x-strata::checkbox>
                            @endforeach
                        </div>
                        <div class="mt-4 p-4 bg-muted rounded-lg">
                            <p class="text-sm text-muted-foreground">Selected: {{ implode(', ', array_map(fn($v) => $availableOptions[$v], $selectedOptions)) ?: 'None' }}</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Checkbox Sizes</h4>
                        <div class="space-y-3">
                            <x-strata::checkbox size="sm">Small checkbox</x-strata::checkbox>
                            <x-strata::checkbox size="md">Medium checkbox (default)</x-strata::checkbox>
                            <x-strata::checkbox size="lg">Large checkbox</x-strata::checkbox>
                        </div>
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>

        {{-- Radio --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Radio</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Basic Radio Group</h4>
                        <div class="space-y-3">
                            <x-strata::radio wire:model.live="radio" value="option1">Option 1</x-strata::radio>
                            <x-strata::radio wire:model.live="radio" value="option2">Option 2</x-strata::radio>
                            <x-strata::radio wire:model.live="radio" value="option3">Option 3</x-strata::radio>
                        </div>
                        <div class="mt-4 p-4 bg-muted rounded-lg">
                            <p class="text-sm text-muted-foreground">Selected: {{ $radio }}</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Radio Sizes</h4>
                        <div class="space-y-3">
                            <x-strata::radio size="sm" name="size-demo" value="sm">Small radio</x-strata::radio>
                            <x-strata::radio size="md" name="size-demo" value="md">Medium radio (default)</x-strata::radio>
                            <x-strata::radio size="lg" name="size-demo" value="lg">Large radio</x-strata::radio>
                        </div>
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>

        {{-- Toggle --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Toggle</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Basic Toggle</h4>
                        <div class="space-y-4">
                            <x-strata::toggle wire:model.live="toggle">Enable feature</x-strata::toggle>
                            <x-strata::toggle wire:model.live="toggleNotifications">Push notifications</x-strata::toggle>
                        </div>
                        <div class="mt-4 p-4 bg-muted rounded-lg">
                            <p class="text-sm text-muted-foreground">Feature: {{ $toggle ? 'Enabled' : 'Disabled' }}</p>
                            <p class="text-sm text-muted-foreground">Notifications: {{ $toggleNotifications ? 'On' : 'Off' }}</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Toggle Sizes</h4>
                        <div class="space-y-4">
                            <x-strata::toggle size="sm">Small toggle</x-strata::toggle>
                            <x-strata::toggle size="md">Medium toggle (default)</x-strata::toggle>
                            <x-strata::toggle size="lg">Large toggle</x-strata::toggle>
                        </div>
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>

        {{-- File Input --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">File Input</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Single File Upload</h4>
                        <x-strata::file-input
                            wire:model="uploadedFile"
                            label="Choose a file"
                            hint="Click or drag and drop to upload"
                        />
                        @if($uploadedFile)
                            <div class="mt-4 p-4 bg-muted rounded-lg">
                                <p class="text-sm text-muted-foreground">File selected: {{ $uploadedFile->getClientOriginalName() }}</p>
                            </div>
                        @endif
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Multiple Files Upload</h4>
                        <x-strata::file-input
                            wire:model="uploadedFiles"
                            multiple
                            label="Choose multiple files"
                            hint="You can select and upload multiple files at once"
                        />
                        @if($uploadedFiles && count($uploadedFiles) > 0)
                            <div class="mt-4 p-4 bg-muted rounded-lg">
                                <p class="text-sm font-medium mb-2">{{ count($uploadedFiles) }} file(s) selected:</p>
                                <ul class="text-sm text-muted-foreground list-disc list-inside">
                                    @foreach($uploadedFiles as $file)
                                        <li>{{ $file->getClientOriginalName() }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">File Input Sizes</h4>
                        <div class="space-y-4">
                            <x-strata::file-input size="sm" label="Small size upload" />
                            <x-strata::file-input size="md" label="Medium size upload (default)" />
                            <x-strata::file-input size="lg" label="Large size upload" />
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">With File Type Restrictions</h4>
                        <x-strata::file-input
                            label="Upload images only"
                            hint="Accepts JPG, PNG, GIF files"
                            accept="image/*"
                        />
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">With Custom Content</h4>
                        <x-strata::file-input label="Upload document">
                            <span class="font-medium">Drag files here</span>
                            <span class="block mt-1">or click to browse</span>
                            <span class="block mt-2 text-xs">Supports: PDF, DOC, DOCX</span>
                        </x-strata::file-input>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">With Preview List</h4>
                        <x-strata::file-input
                            label="Upload files with preview"
                            hint="Selected files will appear in a list below"
                        />

                        <div class="mt-4">
                            <x-strata::file-input.list title="Uploaded Files (Demo)" clearable onClear="clearAllFiles">
                                <x-strata::file-input.item
                                    fileName="project-proposal.pdf"
                                    fileSize="2.5 MB"
                                    fileType="application/pdf"
                                    onRemove="removeFile(1)"
                                />
                                <x-strata::file-input.item
                                    fileName="presentation-slides.pptx"
                                    fileSize="5.8 MB"
                                    fileType="application/vnd.ms-powerpoint"
                                    onRemove="removeFile(2)"
                                />
                                <x-strata::file-input.item
                                    fileName="screenshot.jpg"
                                    fileSize="1.2 MB"
                                    fileType="image/jpeg"
                                    preview="https://picsum.photos/200/200?random=1"
                                    onRemove="removeFile(3)"
                                />
                                <x-strata::file-input.item
                                    fileName="vacation-photo.png"
                                    fileSize="3.4 MB"
                                    fileType="image/png"
                                    preview="https://picsum.photos/200/200?random=2"
                                    onRemove="removeFile(4)"
                                />
                            </x-strata::file-input.list>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Empty State</h4>
                        <x-strata::file-input.list empty="No documents uploaded yet. Upload files to see them here." />
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Individual File Items</h4>
                        <div class="space-y-3">
                            <x-strata::file-input.item
                                fileName="document.docx"
                                fileSize="450 KB"
                                fileType="application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            />
                            <x-strata::file-input.item
                                fileName="spreadsheet.xlsx"
                                fileSize="1.8 MB"
                                fileType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                            />
                            <x-strata::file-input.item
                                fileName="archive.zip"
                                fileSize="12.5 MB"
                                fileType="application/zip"
                            />
                        </div>
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>

        {{-- Calendar --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Calendar</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Single Date Selection</h4>
                        <x-strata::calendar mode="single" />
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Range Selection</h4>
                        <x-strata::calendar mode="range" />
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Multiple Dates</h4>
                        <x-strata::calendar mode="multiple" />
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>

        {{-- Date Picker --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Date Picker</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Single Date Picker</h4>
                        <x-strata::date-picker mode="single" placeholder="Select a date" />
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Date Range Picker</h4>
                        <x-strata::date-picker mode="range" placeholder="Select date range" />
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Multiple Dates Picker</h4>
                        <x-strata::date-picker mode="multiple" placeholder="Select multiple dates" />
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Date Picker Sizes</h4>
                        <div class="space-y-4">
                            <x-strata::date-picker size="sm" placeholder="Small date picker" />
                            <x-strata::date-picker size="md" placeholder="Medium date picker" />
                            <x-strata::date-picker size="lg" placeholder="Large date picker" />
                        </div>
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>
    </section>

    {{-- Buttons & Actions --}}
    <section id="buttons" class="space-y-8">
        <h2 class="text-2xl font-bold">Buttons & Actions</h2>

        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Button</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Button Variants</h4>
                        <div class="flex flex-wrap gap-3">
                            <x-strata::button variant="default">Default</x-strata::button>
                            <x-strata::button variant="primary">Primary</x-strata::button>
                            <x-strata::button variant="secondary">Secondary</x-strata::button>
                            <x-strata::button variant="destructive">Destructive</x-strata::button>
                            <x-strata::button variant="ghost">Ghost</x-strata::button>
                            <x-strata::button variant="text">Text</x-strata::button>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Button Sizes</h4>
                        <div class="flex items-center gap-3">
                            <x-strata::button size="sm">Small</x-strata::button>
                            <x-strata::button size="md">Medium</x-strata::button>
                            <x-strata::button size="lg">Large</x-strata::button>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Button with Icons</h4>
                        <div class="flex flex-wrap gap-3">
                            <x-strata::button variant="primary">
                                <x-strata::icon.plus class="w-4 h-4 mr-2" />
                                Create New
                            </x-strata::button>
                            <x-strata::button variant="default">
                                <x-strata::icon.save class="w-4 h-4 mr-2" />
                                Save
                            </x-strata::button>
                            <x-strata::button variant="destructive">
                                <x-strata::icon.trash class="w-4 h-4 mr-2" />
                                Delete
                            </x-strata::button>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Icon Buttons</h4>
                        <div class="flex gap-3">
                            <x-strata::button.icon variant="primary" icon="settings" aria-label="Settings" />
                            <x-strata::button.icon variant="secondary" icon="edit" aria-label="Edit" />
                            <x-strata::button.icon variant="secondary" appearance="ghost" icon="more-horizontal" aria-label="More" />
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Disabled State</h4>
                        <div class="flex gap-3">
                            <x-strata::button variant="primary" disabled>Disabled Primary</x-strata::button>
                            <x-strata::button variant="default" disabled>Disabled Default</x-strata::button>
                        </div>
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>
    </section>

    {{-- Layout & Structure --}}
    <section id="layout" class="space-y-8">
        <h2 class="text-2xl font-bold">Layout & Structure</h2>

        {{-- Card --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Card</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Card Styles</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <x-strata::card style="flat">
                                <x-strata::card.body>
                                    <h5 class="font-semibold mb-2">Flat Card</h5>
                                    <p class="text-sm text-muted-foreground">A simple flat card with minimal styling.</p>
                                </x-strata::card.body>
                            </x-strata::card>
                            <x-strata::card style="outlined">
                                <x-strata::card.body>
                                    <h5 class="font-semibold mb-2">Outlined Card</h5>
                                    <p class="text-sm text-muted-foreground">Card with a visible border.</p>
                                </x-strata::card.body>
                            </x-strata::card>
                            <x-strata::card style="elevated">
                                <x-strata::card.body>
                                    <h5 class="font-semibold mb-2">Elevated Card</h5>
                                    <p class="text-sm text-muted-foreground">Card with shadow elevation.</p>
                                </x-strata::card.body>
                            </x-strata::card>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Card with Header and Footer</h4>
                        <x-strata::card style="elevated">
                            <x-strata::card.header>
                                <h5 class="font-semibold">Card Header</h5>
                                <p class="text-sm text-muted-foreground">Optional subtitle</p>
                            </x-strata::card.header>
                            <x-strata::card.body>
                                <p>This is the main content of the card. You can put any content here.</p>
                            </x-strata::card.body>
                            <x-strata::card.footer>
                                <div class="flex justify-end gap-2">
                                    <x-strata::button variant="ghost" size="sm">Cancel</x-strata::button>
                                    <x-strata::button variant="primary" size="sm">Save</x-strata::button>
                                </div>
                            </x-strata::card.footer>
                        </x-strata::card>
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>

        {{-- Table --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Table</h3>
                <x-strata::table>
                    <x-strata::table.header>
                        <x-strata::table.row>
                            <x-strata::table.head-cell>Name</x-strata::table.head-cell>
                            <x-strata::table.head-cell>Email</x-strata::table.head-cell>
                            <x-strata::table.head-cell>Role</x-strata::table.head-cell>
                            <x-strata::table.head-cell>Status</x-strata::table.head-cell>
                        </x-strata::table.row>
                    </x-strata::table.header>

                    <x-strata::table.body>
                        @foreach($tableData as $row)
                            <x-strata::table.row>
                                <x-strata::table.cell>{{ $row['name'] }}</x-strata::table.cell>
                                <x-strata::table.cell>{{ $row['email'] }}</x-strata::table.cell>
                                <x-strata::table.cell>{{ $row['role'] }}</x-strata::table.cell>
                                <x-strata::table.cell>
                                    <x-strata::badge :variant="$row['status'] === 'active' ? 'success' : 'default'">
                                        {{ ucfirst($row['status']) }}
                                    </x-strata::badge>
                                </x-strata::table.cell>
                            </x-strata::table.row>
                        @endforeach
                    </x-strata::table.body>
                </x-strata::table>
            </x-strata::card.body>
        </x-strata::card>

        {{-- Accordion --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Accordion</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Single Selection Accordion</h4>
                        <x-strata::accordion type="single" wire:model.live="selectedAccordionItem">
                            @foreach($faqData as $faq)
                                <x-strata::accordion.item value="{{ $faq['id'] }}">
                                    <x-slot:trigger>{{ $faq['question'] }}</x-slot:trigger>
                                    <x-slot:content>{{ $faq['answer'] }}</x-slot:content>
                                </x-strata::accordion.item>
                            @endforeach
                        </x-strata::accordion>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Multiple Selection Accordion</h4>
                        <x-strata::accordion type="multiple" wire:model.live="multipleSelectedItems">
                            @foreach($faqData as $faq)
                                <x-strata::accordion.item value="{{ $faq['id'] }}">
                                    <x-slot:trigger>{{ $faq['question'] }}</x-slot:trigger>
                                    <x-slot:content>{{ $faq['answer'] }}</x-slot:content>
                                </x-strata::accordion.item>
                            @endforeach
                        </x-strata::accordion>
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>
    </section>

    {{-- Feedback & Overlays --}}
    <section id="feedback" class="space-y-8">
        <h2 class="text-2xl font-bold">Feedback & Overlays</h2>

        {{-- Alert --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Alert</h3>
                <div class="space-y-4">
                    <x-strata::alert variant="neutral" title="Default Alert">
                        This is a default alert message.
                    </x-strata::alert>

                    <x-strata::alert variant="success" title="Success!">
                        Your changes have been saved successfully.
                    </x-strata::alert>

                    <x-strata::alert variant="warning" title="Warning">
                        Please review the information before proceeding.
                    </x-strata::alert>

                    <x-strata::alert variant="error" title="Error">
                        An error occurred while processing your request.
                    </x-strata::alert>

                    <x-strata::alert variant="info" title="Information">
                        Here's some helpful information you should know.
                    </x-strata::alert>
                </div>
            </x-strata::card.body>
        </x-strata::card>

        {{-- Modal --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Modal</h3>
                <div class="space-y-4">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Basic Modal</h4>
                        <x-strata::button wire:click="openModal" variant="primary">Open Modal</x-strata::button>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Modal Sizes</h4>
                        <div class="flex gap-3">
                            <x-strata::button wire:click="$set('showSmallModal', true)" size="sm">Small Modal</x-strata::button>
                            <x-strata::button wire:click="$set('showModal', true)">Default Modal</x-strata::button>
                            <x-strata::button wire:click="$set('showLargeModal', true)" size="lg">Large Modal</x-strata::button>
                        </div>
                    </div>
                </div>

                <x-strata::modal wire:model="showModal">
                    <x-strata::modal.header>
                        <h4 class="text-lg font-semibold">Modal Title</h4>
                    </x-strata::modal.header>
                    <x-strata::modal.body>
                        <p class="text-muted-foreground">This is the modal content. You can put any content here.</p>
                    </x-strata::modal.body>
                    <x-strata::modal.footer>
                        <x-strata::button wire:click="closeModal" variant="ghost">Cancel</x-strata::button>
                        <x-strata::button wire:click="closeModal" variant="primary">Confirm</x-strata::button>
                    </x-strata::modal.footer>
                </x-strata::modal>

                <x-strata::modal wire:model="showSmallModal" size="sm">
                    <x-strata::modal.header>
                        <h4 class="text-lg font-semibold">Small Modal</h4>
                    </x-strata::modal.header>
                    <x-strata::modal.body>
                        <p class="text-muted-foreground">This is a small modal.</p>
                    </x-strata::modal.body>
                </x-strata::modal>

                <x-strata::modal wire:model="showLargeModal" size="lg">
                    <x-strata::modal.header>
                        <h4 class="text-lg font-semibold">Large Modal</h4>
                    </x-strata::modal.header>
                    <x-strata::modal.body>
                        <p class="text-muted-foreground">This is a large modal with more space for content.</p>
                    </x-strata::modal.body>
                </x-strata::modal>
            </x-strata::card.body>
        </x-strata::card>

        {{-- Popover --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Popover</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Basic Popover</h4>
                        <x-strata::popover id="basic-popover">
                            <x-strata::popover.trigger target="basic-popover" variant="default">
                                Show Popover
                            </x-strata::popover.trigger>
                            <x-strata::popover.content>
                                <div class="p-4">
                                    <h5 class="font-semibold mb-2">Popover Title</h5>
                                    <p class="text-sm text-muted-foreground">This is popover content. You can put any information here.</p>
                                </div>
                            </x-strata::popover.content>
                        </x-strata::popover>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Popover Placements</h4>
                        <div class="flex gap-3">
                            <x-strata::popover id="popover-top" placement="top">
                                <x-strata::popover.trigger target="popover-top">Top</x-strata::popover.trigger>
                                <x-strata::popover.content>
                                    <div class="p-3">
                                        <p class="text-sm">Popover on top</p>
                                    </div>
                                </x-strata::popover.content>
                            </x-strata::popover>

                            <x-strata::popover id="popover-bottom" placement="bottom">
                                <x-strata::popover.trigger target="popover-bottom">Bottom</x-strata::popover.trigger>
                                <x-strata::popover.content>
                                    <div class="p-3">
                                        <p class="text-sm">Popover on bottom</p>
                                    </div>
                                </x-strata::popover.content>
                            </x-strata::popover>

                            <x-strata::popover id="popover-left" placement="left">
                                <x-strata::popover.trigger target="popover-left">Left</x-strata::popover.trigger>
                                <x-strata::popover.content>
                                    <div class="p-3">
                                        <p class="text-sm">Popover on left</p>
                                    </div>
                                </x-strata::popover.content>
                            </x-strata::popover>

                            <x-strata::popover id="popover-right" placement="right">
                                <x-strata::popover.trigger target="popover-right">Right</x-strata::popover.trigger>
                                <x-strata::popover.content>
                                    <div class="p-3">
                                        <p class="text-sm">Popover on right</p>
                                    </div>
                                </x-strata::popover.content>
                            </x-strata::popover>
                        </div>
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>

        {{-- Dropdown --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Dropdown</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Basic Action Menu</h4>
                        <x-strata::dropdown id="actions-1">
                            <x-strata::dropdown.trigger data-dropdown-trigger="actions-1" variant="default">
                                Actions
                                <x-strata::icon.chevron-down class="w-4 h-4" />
                            </x-strata::dropdown.trigger>
                            <x-strata::dropdown.content>
                                <x-strata::dropdown.item icon="edit">Edit</x-strata::dropdown.item>
                                <x-strata::dropdown.item icon="copy">Duplicate</x-strata::dropdown.item>
                                <x-strata::dropdown.item icon="refresh-cw">Refresh</x-strata::dropdown.item>
                                <x-strata::dropdown.divider />
                                <x-strata::dropdown.item icon="trash" destructive>Delete</x-strata::dropdown.item>
                            </x-strata::dropdown.content>
                        </x-strata::dropdown>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Trigger Variants</h4>
                        <div class="flex gap-4">
                            <x-strata::dropdown id="variant-default">
                                <x-strata::dropdown.trigger data-dropdown-trigger="variant-default" variant="default">Default</x-strata::dropdown.trigger>
                                <x-strata::dropdown.content>
                                    <x-strata::dropdown.item icon="save">Save</x-strata::dropdown.item>
                                    <x-strata::dropdown.item icon="download">Download</x-strata::dropdown.item>
                                </x-strata::dropdown.content>
                            </x-strata::dropdown>

                            <x-strata::dropdown id="variant-primary">
                                <x-strata::dropdown.trigger data-dropdown-trigger="variant-primary" variant="primary">Primary</x-strata::dropdown.trigger>
                                <x-strata::dropdown.content>
                                    <x-strata::dropdown.item icon="save">Save</x-strata::dropdown.item>
                                    <x-strata::dropdown.item icon="download">Download</x-strata::dropdown.item>
                                </x-strata::dropdown.content>
                            </x-strata::dropdown>

                            <x-strata::dropdown id="variant-ghost">
                                <x-strata::dropdown.trigger data-dropdown-trigger="variant-ghost" variant="ghost">Ghost</x-strata::dropdown.trigger>
                                <x-strata::dropdown.content>
                                    <x-strata::dropdown.item icon="save">Save</x-strata::dropdown.item>
                                    <x-strata::dropdown.item icon="download">Download</x-strata::dropdown.item>
                                </x-strata::dropdown.content>
                            </x-strata::dropdown>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">With Sections & Icons</h4>
                        <x-strata::dropdown id="sections-1">
                            <x-strata::dropdown.trigger data-dropdown-trigger="sections-1">Menu</x-strata::dropdown.trigger>
                            <x-strata::dropdown.content>
                                <x-strata::dropdown.label>Account</x-strata::dropdown.label>
                                <x-strata::dropdown.item icon="user">Profile</x-strata::dropdown.item>
                                <x-strata::dropdown.item icon="settings">Settings</x-strata::dropdown.item>
                                <x-strata::dropdown.divider />
                                <x-strata::dropdown.label>Actions</x-strata::dropdown.label>
                                <x-strata::dropdown.item icon="refresh-cw">Refresh</x-strata::dropdown.item>
                                <x-strata::dropdown.item icon="download">Export</x-strata::dropdown.item>
                                <x-strata::dropdown.divider />
                                <x-strata::dropdown.item icon="log-out" destructive>Sign Out</x-strata::dropdown.item>
                            </x-strata::dropdown.content>
                        </x-strata::dropdown>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Checkbox Items (Alpine State)</h4>
                        <div class="flex gap-4 items-center">
                            <x-strata::dropdown id="features-1">
                                <x-strata::dropdown.trigger data-dropdown-trigger="features-1">
                                    Features
                                    <x-strata::icon.chevron-down class="w-4 h-4" />
                                </x-strata::dropdown.trigger>
                                <x-strata::dropdown.content>
                                    <x-strata::dropdown.label>Enable Features</x-strata::dropdown.label>
                                    <x-strata::dropdown.checkbox-item value="notifications" name="selectedFeatures" x-model="selectedFeatures">
                                        Enable Notifications
                                    </x-strata::dropdown.checkbox-item>
                                    <x-strata::dropdown.checkbox-item value="auto-save" name="selectedFeatures" x-model="selectedFeatures">
                                        Auto Save
                                    </x-strata::dropdown.checkbox-item>
                                    <x-strata::dropdown.checkbox-item value="dark-mode" name="selectedFeatures" x-model="selectedFeatures">
                                        Dark Mode
                                    </x-strata::dropdown.checkbox-item>
                                </x-strata::dropdown.content>
                            </x-strata::dropdown>
                            <div class="text-sm text-muted-foreground">
                                Selected: <span x-text="selectedFeatures.join(', ') || 'None'"></span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Radio Items (Alpine State)</h4>
                        <div class="flex gap-4 items-center">
                            <x-strata::dropdown id="sort-1">
                                <x-strata::dropdown.trigger data-dropdown-trigger="sort-1">
                                    Sort By: <span x-text="sortOrder"></span>
                                    <x-strata::icon.chevron-down class="w-4 h-4" />
                                </x-strata::dropdown.trigger>
                                <x-strata::dropdown.content>
                                    <x-strata::dropdown.label>Sort Order</x-strata::dropdown.label>
                                    <x-strata::dropdown.radio-item value="newest" name="sortOrder" x-model="sortOrder">
                                        Newest First
                                    </x-strata::dropdown.radio-item>
                                    <x-strata::dropdown.radio-item value="oldest" name="sortOrder" x-model="sortOrder">
                                        Oldest First
                                    </x-strata::dropdown.radio-item>
                                    <x-strata::dropdown.radio-item value="alphabetical" name="sortOrder" x-model="sortOrder">
                                        Alphabetical
                                    </x-strata::dropdown.radio-item>
                                </x-strata::dropdown.content>
                            </x-strata::dropdown>
                            <div class="text-sm text-muted-foreground">
                                Current: <span x-text="sortOrder"></span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Nested Submenus</h4>
                        <x-strata::dropdown id="nested-1">
                            <x-strata::dropdown.trigger data-dropdown-trigger="nested-1">
                                File
                                <x-strata::icon.chevron-down class="w-4 h-4" />
                            </x-strata::dropdown.trigger>
                            <x-strata::dropdown.content>
                                <x-strata::dropdown.item icon="file">New File</x-strata::dropdown.item>
                                <x-strata::dropdown.item icon="folder">New Folder</x-strata::dropdown.item>
                                <x-strata::dropdown.divider />
                                <x-strata::dropdown.submenu label="Export" icon="download" trigger="hover">
                                    <x-strata::dropdown.item icon="file">Export as PDF</x-strata::dropdown.item>
                                    <x-strata::dropdown.item icon="file">Export as CSV</x-strata::dropdown.item>
                                    <x-strata::dropdown.item icon="file">Export as JSON</x-strata::dropdown.item>
                                </x-strata::dropdown.submenu>
                                <x-strata::dropdown.divider />
                                <x-strata::dropdown.item icon="save">Save</x-strata::dropdown.item>
                            </x-strata::dropdown.content>
                        </x-strata::dropdown>
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>
    </section>

    {{-- Display --}}
    <section id="display" class="space-y-8">
        <h2 class="text-2xl font-bold">Display</h2>

        {{-- Avatar --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Avatar</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Avatar Sizes</h4>
                        <div class="flex items-center gap-4">
                            <x-strata::avatar size="sm" src="https://i.pravatar.cc/100?img=1" />
                            <x-strata::avatar size="md" src="https://i.pravatar.cc/100?img=2" />
                            <x-strata::avatar size="lg" src="https://i.pravatar.cc/100?img=3" />
                            <x-strata::avatar size="xl" src="https://i.pravatar.cc/100?img=4" />
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Avatar Fallbacks</h4>
                        <div class="flex items-center gap-4">
                            <x-strata::avatar fallback="JD" />
                            <x-strata::avatar fallback="AB" />
                            <x-strata::avatar fallback="XY" />
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Avatar Group</h4>
                        <x-strata::avatar.group>
                            <x-strata::avatar src="https://i.pravatar.cc/100?img=5" />
                            <x-strata::avatar src="https://i.pravatar.cc/100?img=6" />
                            <x-strata::avatar src="https://i.pravatar.cc/100?img=7" />
                            <x-strata::avatar fallback="+3" />
                        </x-strata::avatar.group>
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>

        {{-- Badge --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Badge</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Badge Variants</h4>
                        <div class="flex flex-wrap gap-3">
                            <x-strata::badge variant="default">Default</x-strata::badge>
                            <x-strata::badge variant="primary">Primary</x-strata::badge>
                            <x-strata::badge variant="secondary">Secondary</x-strata::badge>
                            <x-strata::badge variant="success">Success</x-strata::badge>
                            <x-strata::badge variant="warning">Warning</x-strata::badge>
                            <x-strata::badge variant="error">Error</x-strata::badge>
                            <x-strata::badge variant="info">Info</x-strata::badge>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Badge Sizes</h4>
                        <div class="flex items-center gap-3">
                            <x-strata::badge size="sm">Small</x-strata::badge>
                            <x-strata::badge size="md">Medium</x-strata::badge>
                            <x-strata::badge size="lg">Large</x-strata::badge>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Removable Badges</h4>
                        <div class="flex flex-wrap gap-3">
                            <x-strata::badge.removable variant="primary">Removable</x-strata::badge.removable>
                            <x-strata::badge.removable variant="success">Success</x-strata::badge.removable>
                            <x-strata::badge.removable variant="warning">Warning</x-strata::badge.removable>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Badge Container</h4>
                        <x-strata::badge.container>
                            <x-strata::badge variant="primary">Tag 1</x-strata::badge>
                            <x-strata::badge variant="secondary">Tag 2</x-strata::badge>
                            <x-strata::badge variant="success">Tag 3</x-strata::badge>
                            <x-strata::badge variant="warning">Tag 4</x-strata::badge>
                        </x-strata::badge.container>
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>

        {{-- Kbd --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Kbd (Keyboard)</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Basic Keyboard Keys</h4>
                        <div class="flex flex-wrap gap-3">
                            <x-strata::kbd>⌘</x-strata::kbd>
                            <x-strata::kbd>Ctrl</x-strata::kbd>
                            <x-strata::kbd>Shift</x-strata::kbd>
                            <x-strata::kbd>Alt</x-strata::kbd>
                            <x-strata::kbd>Enter</x-strata::kbd>
                            <x-strata::kbd>Esc</x-strata::kbd>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Keyboard Shortcuts</h4>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="flex gap-1">
                                    <x-strata::kbd>⌘</x-strata::kbd>
                                    <x-strata::kbd>K</x-strata::kbd>
                                </div>
                                <span class="text-sm text-muted-foreground">Open command palette</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="flex gap-1">
                                    <x-strata::kbd>Ctrl</x-strata::kbd>
                                    <x-strata::kbd>S</x-strata::kbd>
                                </div>
                                <span class="text-sm text-muted-foreground">Save file</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="flex gap-1">
                                    <x-strata::kbd>Shift</x-strata::kbd>
                                    <x-strata::kbd>Alt</x-strata::kbd>
                                    <x-strata::kbd>F</x-strata::kbd>
                                </div>
                                <span class="text-sm text-muted-foreground">Format document</span>
                            </div>
                        </div>
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>

        {{-- Rating --}}
        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Rating</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium mb-3">Basic Rating</h4>
                        <x-strata::rating variant="input" wire:model.live="rating" />
                        <div class="mt-4 p-4 bg-muted rounded-lg">
                            <p class="text-sm text-muted-foreground">Current Rating: {{ $rating }} stars</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Pre-filled Rating</h4>
                        <x-strata::rating variant="input" wire:model.live="rating2" />
                        <div class="mt-4 p-4 bg-muted rounded-lg">
                            <p class="text-sm text-muted-foreground">Current Rating: {{ $rating2 }} stars</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Rating Sizes</h4>
                        <div class="space-y-4">
                            <x-strata::rating size="sm" value="4" />
                            <x-strata::rating size="md" value="4" />
                            <x-strata::rating size="lg" value="4" />
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-medium mb-3">Read-only Rating</h4>
                        <x-strata::rating readonly value="4" />
                    </div>
                </div>
            </x-strata::card.body>
        </x-strata::card>
    </section>

    {{-- Form Submission Example --}}
    <section class="space-y-8">
        <h2 class="text-2xl font-bold">Form Example</h2>

        <x-strata::card style="elevated">
            <x-strata::card.body padding="lg">
                <h3 class="text-xl font-semibold mb-4">Complete Form Demo</h3>
                <div class="space-y-4">
                    <x-strata::input wire:model="emailInput" type="email" placeholder="Enter your email" />
                    <x-strata::select wire:model="selectedCountry" placeholder="Select your country">
                        @foreach($countries as $value => $label)
                            <x-strata::select.option :value="$value">{{ $label }}</x-strata::select.option>
                        @endforeach
                    </x-strata::select>
                    <x-strata::textarea wire:model="textareaInput" placeholder="Enter your message..." rows="4" />
                    <x-strata::checkbox wire:model="checkbox">I agree to the terms and conditions</x-strata::checkbox>
                    <x-strata::button wire:click="submit" variant="primary">Submit Form</x-strata::button>

                    @if($message)
                        <div class="p-4 bg-success/10 text-success rounded-lg">
                            {{ $message }}
                        </div>
                    @endif
                </div>
            </x-strata::card.body>
        </x-strata::card>
    </section>
</div>
