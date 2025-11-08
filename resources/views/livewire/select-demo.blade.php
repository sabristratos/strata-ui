<div class="min-h-screen bg-background py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-12">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-foreground mb-4">Select Component Showcase</h1>
            <p class="text-lg text-muted-foreground max-w-3xl mx-auto">
                A comprehensive demonstration of the Strata UI Select component featuring single/multi-select, searchable options, cascading selects, form integration, and common use cases.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-card border border-border rounded-lg p-6 space-y-4">
                <h3 class="text-lg font-semibold text-card-foreground">Single Select</h3>
                <x-strata::select
                    wire:model.live="singleValue"
                    placeholder="Choose an option">
                    <x-strata::select.option value="option1" label="Option 1" />
                    <x-strata::select.option value="option2" label="Option 2" />
                    <x-strata::select.option value="option3" label="Option 3" />
                </x-strata::select>
                <p class="text-sm text-muted-foreground">Selected: <span class="font-mono">{{ $singleValue ?? 'null' }}</span></p>
            </div>

            <div class="bg-card border border-border rounded-lg p-6 space-y-4">
                <h3 class="text-lg font-semibold text-card-foreground">Multi-Select</h3>
                <x-strata::select
                    wire:model.live="multipleValues"
                    :multiple="true"
                    placeholder="Choose technologies">
                    @foreach($this->getTechnologies() as $tech)
                        <x-strata::select.option :value="$tech['value']" :label="$tech['label']" />
                    @endforeach
                </x-strata::select>
                <p class="text-sm text-muted-foreground">Selected: <span class="font-mono">{{ count($multipleValues) }} items</span></p>
            </div>

            <div class="bg-card border border-border rounded-lg p-6 space-y-4">
                <h3 class="text-lg font-semibold text-card-foreground">Searchable</h3>
                <x-strata::select
                    wire:model.live="searchableValue"
                    :searchable="true"
                    :minItemsForSearch="0"
                    placeholder="Search technologies">
                    @foreach($this->getTechnologies() as $tech)
                        <x-strata::select.option :value="$tech['value']" :label="$tech['label']" />
                    @endforeach
                </x-strata::select>
                <p class="text-sm text-muted-foreground">Selected: <span class="font-mono">{{ $searchableValue ?? 'null' }}</span></p>
            </div>
        </div>

        <div class="bg-card border border-border rounded-lg p-6 space-y-6">
            <h2 class="text-2xl font-bold text-card-foreground">Size Variants</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Small</label>
                    <x-strata::select wire:model="sizeSmall" size="sm" placeholder="Small size">
                        <x-strata::select.option value="1" label="Option 1" />
                        <x-strata::select.option value="2" label="Option 2" />
                    </x-strata::select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Medium (Default)</label>
                    <x-strata::select wire:model="sizeMedium" size="md" placeholder="Medium size">
                        <x-strata::select.option value="1" label="Option 1" />
                        <x-strata::select.option value="2" label="Option 2" />
                    </x-strata::select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Large</label>
                    <x-strata::select wire:model="sizeLarge" size="lg" placeholder="Large size">
                        <x-strata::select.option value="1" label="Option 1" />
                        <x-strata::select.option value="2" label="Option 2" />
                    </x-strata::select>
                </div>
            </div>
        </div>

        <div class="bg-card border border-border rounded-lg p-6 space-y-6">
            <h2 class="text-2xl font-bold text-card-foreground">Validation States</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Default</label>
                    <x-strata::select wire:model="stateDefault" state="default" placeholder="Default state">
                        <x-strata::select.option value="1" label="Option 1" />
                        <x-strata::select.option value="2" label="Option 2" />
                    </x-strata::select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Success</label>
                    <x-strata::select wire:model="stateSuccess" state="success" placeholder="Success state">
                        <x-strata::select.option value="success" label="Valid Option" />
                        <x-strata::select.option value="other" label="Other Option" />
                    </x-strata::select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Error</label>
                    <x-strata::select wire:model="stateError" state="error" placeholder="Error state">
                        <x-strata::select.option value="1" label="Option 1" />
                        <x-strata::select.option value="2" label="Option 2" />
                    </x-strata::select>
                    @error('stateError') <p class="text-sm text-destructive">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Warning</label>
                    <x-strata::select wire:model="stateWarning" state="warning" placeholder="Warning state">
                        <x-strata::select.option value="1" label="Option 1" />
                        <x-strata::select.option value="2" label="Option 2" />
                    </x-strata::select>
                </div>
            </div>
        </div>

        <div class="bg-card border border-border rounded-lg p-6 space-y-6">
            <h2 class="text-2xl font-bold text-card-foreground">Options with Icons</h2>
            <p class="text-muted-foreground">Enhance your select options with icons for better visual recognition</p>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="space-y-4 p-4 border border-border rounded-lg">
                    <h3 class="text-lg font-semibold text-card-foreground">Single Select with Icons</h3>
                    <p class="text-sm text-muted-foreground">Choose your preferred notification method</p>
                    <x-strata::select
                        wire:model.live="iconSingleValue"
                        placeholder="Select notification type">
                        @foreach($this->getNotificationOptions() as $option)
                            <x-strata::select.option :value="$option['value']" :label="$option['label']">
                                <x-slot:icon>
                                    <x-dynamic-component :component="'strata::icon.' . $option['icon']" class="w-5 h-5 text-muted-foreground" />
                                </x-slot:icon>
                            </x-strata::select.option>
                        @endforeach
                    </x-strata::select>
                    <p class="text-sm text-muted-foreground">Selected: <span class="font-mono">{{ $iconSingleValue ?? 'null' }}</span></p>
                </div>

                <div class="space-y-4 p-4 border border-border rounded-lg">
                    <h3 class="text-lg font-semibold text-card-foreground">Multi-Select with Icons</h3>
                    <p class="text-sm text-muted-foreground">Select multiple file types</p>
                    <x-strata::select
                        wire:model.live="iconMultipleValue"
                        :multiple="true"
                        :chips="true"
                        placeholder="Choose file types">
                        @foreach($this->getFileTypeOptions() as $option)
                            <x-strata::select.option :value="$option['value']" :label="$option['label']">
                                <x-slot:icon>
                                    <x-dynamic-component :component="'strata::icon.' . $option['icon']" class="w-5 h-5 text-muted-foreground" />
                                </x-slot:icon>
                            </x-strata::select.option>
                        @endforeach
                    </x-strata::select>
                    <p class="text-sm text-muted-foreground">Selected: <span class="font-mono">{{ count($iconMultipleValue) }} types</span></p>
                </div>

                <div class="space-y-4 p-4 border border-border rounded-lg">
                    <h3 class="text-lg font-semibold text-card-foreground">Icons with Descriptions</h3>
                    <p class="text-sm text-muted-foreground">Options with icons and helpful descriptions</p>
                    <x-strata::select
                        wire:model.live="iconSearchableValue"
                        :searchable="true"
                        :minItemsForSearch="0"
                        placeholder="Select status">
                        @foreach($this->getStatusOptions() as $option)
                            <x-strata::select.option
                                :value="$option['value']"
                                :label="$option['label']"
                                :description="$option['description']">
                                <x-slot:icon>
                                    <x-dynamic-component :component="'strata::icon.' . $option['icon']" class="w-5 h-5 text-muted-foreground" />
                                </x-slot:icon>
                            </x-strata::select.option>
                        @endforeach
                    </x-strata::select>
                    <p class="text-sm text-muted-foreground">Selected: <span class="font-mono">{{ $iconSearchableValue ?? 'null' }}</span></p>
                </div>
            </div>
        </div>

        <div class="bg-card border border-border rounded-lg p-6 space-y-6">
            <h2 class="text-2xl font-bold text-card-foreground">Cascading Selects - Real-World Examples</h2>
            <p class="text-muted-foreground">Demonstrates how one select can dynamically update another using Livewire</p>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="space-y-4 p-4 border border-border rounded-lg">
                    <h3 class="text-lg font-semibold text-card-foreground">Country → State</h3>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-foreground">Select Country</label>
                        <x-strata::select wire:model.live="country" placeholder="Choose a country">
                            @foreach($this->getCountries() as $c)
                                <x-strata::select.option :value="$c['value']" :label="$c['label']" />
                            @endforeach
                        </x-strata::select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-foreground">Select State/Province</label>
                        <x-strata::select
                            wire:model.live="state"
                            :disabled="!$country"
                            placeholder="{{ $country ? 'Choose a state' : 'Select country first' }}">
                            @foreach($availableStates as $s)
                                <x-strata::select.option :value="$s['value']" :label="$s['label']" />
                            @endforeach
                        </x-strata::select>
                    </div>
                    <div class="text-sm text-muted-foreground space-y-1">
                        <p>Country: <span class="font-mono">{{ $country ?? 'null' }}</span></p>
                        <p>State: <span class="font-mono">{{ $state ?? 'null' }}</span></p>
                    </div>
                </div>

                <div class="space-y-4 p-4 border border-border rounded-lg">
                    <h3 class="text-lg font-semibold text-card-foreground">Category → Subcategory</h3>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-foreground">Select Category</label>
                        <x-strata::select wire:model.live="category" placeholder="Choose a category">
                            @foreach($this->getCategories() as $cat)
                                <x-strata::select.option :value="$cat['value']" :label="$cat['label']" />
                            @endforeach
                        </x-strata::select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-foreground">Select Subcategory</label>
                        <x-strata::select
                            wire:model.live="subcategory"
                            :disabled="!$category"
                            placeholder="{{ $category ? 'Choose a subcategory' : 'Select category first' }}">
                            @foreach($availableSubcategories as $sub)
                                <x-strata::select.option :value="$sub['value']" :label="$sub['label']" />
                            @endforeach
                        </x-strata::select>
                    </div>
                    <div class="text-sm text-muted-foreground space-y-1">
                        <p>Category: <span class="font-mono">{{ $category ?? 'null' }}</span></p>
                        <p>Subcategory: <span class="font-mono">{{ $subcategory ?? 'null' }}</span></p>
                    </div>
                </div>

                <div class="space-y-4 p-4 border border-border rounded-lg">
                    <h3 class="text-lg font-semibold text-card-foreground">Department → Employee</h3>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-foreground">Select Department</label>
                        <x-strata::select wire:model.live="department" placeholder="Choose a department">
                            @foreach($this->getDepartments() as $dept)
                                <x-strata::select.option :value="$dept['value']" :label="$dept['label']" />
                            @endforeach
                        </x-strata::select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-foreground">Select Employee</label>
                        <x-strata::select
                            wire:model.live="employee"
                            :disabled="!$department"
                            :searchable="true"
                            placeholder="{{ $department ? 'Choose an employee' : 'Select department first' }}">
                            @foreach($availableEmployees as $emp)
                                <x-strata::select.option :value="$emp['value']" :label="$emp['label']" />
                            @endforeach
                        </x-strata::select>
                    </div>
                    <div class="text-sm text-muted-foreground space-y-1">
                        <p>Department: <span class="font-mono">{{ $department ?? 'null' }}</span></p>
                        <p>Employee: <span class="font-mono">{{ $employee ?? 'null' }}</span></p>
                    </div>
                </div>
            </div>

            <div class="flex justify-center">
                <x-strata::button wire:click="resetCascading" variant="secondary">
                    Reset All Cascading Selects
                </x-strata::button>
            </div>
        </div>

        <div class="bg-card border border-border rounded-lg p-6 space-y-6">
            <h2 class="text-2xl font-bold text-card-foreground">Form Reset Demo</h2>
            <p class="text-muted-foreground">Test Livewire's $this->reset() functionality with multiple selects</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Product</label>
                    <x-strata::select wire:model.live="formProduct" placeholder="Choose product">
                        @foreach($this->getProducts() as $product)
                            <x-strata::select.option :value="$product['value']" :label="$product['label']" />
                        @endforeach
                    </x-strata::select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Tags (Multi-select)</label>
                    <x-strata::select
                        wire:model.live="formTags"
                        :multiple="true"
                        :chips="true"
                        placeholder="Choose tags">
                        @foreach($this->getTags() as $tag)
                            <x-strata::select.option :value="$tag['value']" :label="$tag['label']" />
                        @endforeach
                    </x-strata::select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Priority</label>
                    <x-strata::select wire:model.live="formPriority" placeholder="Choose priority">
                        @foreach($this->getPriorities() as $priority)
                            <x-strata::select.option :value="$priority['value']" :label="$priority['label']" />
                        @endforeach
                    </x-strata::select>
                </div>
            </div>

            <div class="p-4 bg-muted rounded-lg space-y-2">
                <h4 class="font-semibold text-sm text-foreground">Current Values:</h4>
                <div class="text-sm text-muted-foreground space-y-1">
                    <p>Product: <span class="font-mono">{{ $formProduct ?? 'null' }}</span></p>
                    <p>Tags: <span class="font-mono">{{ json_encode($formTags) }}</span></p>
                    <p>Priority: <span class="font-mono">{{ $formPriority ?? 'null' }}</span></p>
                </div>
            </div>

            <div class="flex justify-center">
                <x-strata::button wire:click="resetForm" variant="destructive">
                    Reset Form (using $this->reset())
                </x-strata::button>
            </div>
        </div>

        <div class="bg-card border border-border rounded-lg p-6 space-y-6">
            <h2 class="text-2xl font-bold text-card-foreground">Common Features & Edge Cases</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4 p-4 border border-border rounded-lg">
                    <h3 class="text-lg font-semibold text-card-foreground">Clearable Select</h3>
                    <p class="text-sm text-muted-foreground">Shows clear button when value is selected</p>
                    <x-strata::select
                        wire:model.live="clearableValue"
                        :clearable="true"
                        placeholder="Clearable select">
                        <x-strata::select.option value="option1" label="Option 1" />
                        <x-strata::select.option value="option2" label="Option 2" />
                        <x-strata::select.option value="option3" label="Option 3" />
                    </x-strata::select>
                    <p class="text-sm text-muted-foreground">Value: <span class="font-mono">{{ $clearableValue ?? 'null' }}</span></p>
                </div>

                <div class="space-y-4 p-4 border border-border rounded-lg">
                    <h3 class="text-lg font-semibold text-card-foreground">Disabled Select</h3>
                    <p class="text-sm text-muted-foreground">Select is completely disabled</p>
                    <x-strata::select
                        wire:model="disabledValue"
                        :disabled="true"
                        placeholder="Cannot interact">
                        <x-strata::select.option value="option1" label="Option 1" />
                        <x-strata::select.option value="option2" label="Option 2" />
                    </x-strata::select>
                    <p class="text-sm text-muted-foreground">Value: <span class="font-mono">{{ $disabledValue ?? 'null' }}</span></p>
                </div>

                <div class="space-y-4 p-4 border border-border rounded-lg">
                    <h3 class="text-lg font-semibold text-card-foreground">Multi-select with Chips</h3>
                    <p class="text-sm text-muted-foreground">Displays selections as chips inline</p>
                    <x-strata::select
                        wire:model.live="chipsValue"
                        :multiple="true"
                        :chips="true"
                        placeholder="Multi-select with chips">
                        @foreach($this->getTags() as $tag)
                            <x-strata::select.option :value="$tag['value']" :label="$tag['label']" />
                        @endforeach
                    </x-strata::select>
                    <p class="text-sm text-muted-foreground">Selected: <span class="font-mono">{{ count($chipsValue) }} items</span></p>
                </div>

                <div class="space-y-4 p-4 border border-border rounded-lg">
                    <h3 class="text-lg font-semibold text-card-foreground">Max Selected Limit</h3>
                    <p class="text-sm text-muted-foreground">Limit selection to 3 items max</p>
                    <x-strata::select
                        wire:model.live="maxSelectedValue"
                        :multiple="true"
                        :maxSelected="3"
                        :chips="true"
                        :clearable="true"
                        placeholder="Select up to 3 technologies">
                        @foreach($this->getTechnologies() as $tech)
                            <x-strata::select.option :value="$tech['value']" :label="$tech['label']" />
                        @endforeach
                    </x-strata::select>
                    <p class="text-sm text-muted-foreground">
                        Selected: <span class="font-mono">{{ count($maxSelectedValue) }}/3 items</span>
                        @if(count($maxSelectedValue) >= 3)
                            <span class="text-warning"> - Max reached!</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-card border border-border rounded-lg p-6 space-y-6">
            <h2 class="text-2xl font-bold text-card-foreground">Real-World Form Example with Validation</h2>
            <p class="text-muted-foreground">Complete form submission with Laravel validation</p>

            @if($projectMessage)
                <div class="p-4 bg-success/10 border border-success rounded-lg">
                    <p class="text-success font-medium">{{ $projectMessage }}</p>
                </div>
            @endif

            <form wire:submit.prevent="submitProject" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-foreground">Project Name *</label>
                        <x-strata::input
                            wire:model="projectName"
                            placeholder="Enter project name"
                            :state="$errors->has('projectName') ? 'error' : 'default'"
                        />
                        @error('projectName') <p class="text-sm text-destructive">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-foreground">Category *</label>
                        <x-strata::select
                            wire:model="projectCategory"
                            placeholder="Choose category"
                            :state="$errors->has('projectCategory') ? 'error' : 'default'">
                            @foreach($this->getCategories() as $cat)
                                <x-strata::select.option :value="$cat['value']" :label="$cat['label']" />
                            @endforeach
                        </x-strata::select>
                        @error('projectCategory') <p class="text-sm text-destructive">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Technologies * (Multi-select)</label>
                    <x-strata::select
                        wire:model="projectTags"
                        :multiple="true"
                        :searchable="true"
                        :chips="true"
                        placeholder="Choose at least one technology"
                        :state="$errors->has('projectTags') ? 'error' : 'default'">
                        @foreach($this->getTechnologies() as $tech)
                            <x-strata::select.option :value="$tech['value']" :label="$tech['label']" />
                        @endforeach
                    </x-strata::select>
                    @error('projectTags') <p class="text-sm text-destructive">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-foreground">Status *</label>
                    <x-strata::select
                        wire:model="projectStatus"
                        placeholder="Choose project status"
                        :state="$errors->has('projectStatus') ? 'error' : 'default'">
                        @foreach($this->getStatuses() as $status)
                            <x-strata::select.option :value="$status['value']" :label="$status['label']" />
                        @endforeach
                    </x-strata::select>
                    @error('projectStatus') <p class="text-sm text-destructive">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end">
                    <x-strata::button type="submit">
                        Create Project
                    </x-strata::button>
                </div>
            </form>
        </div>

        <div class="bg-card border border-border rounded-lg p-6">
            <h2 class="text-2xl font-bold text-card-foreground mb-4">Features Demonstrated</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="flex items-start gap-2">
                    <div class="mt-1 text-success">✓</div>
                    <div>
                        <h4 class="font-semibold text-sm text-foreground">Single & Multi-Select</h4>
                        <p class="text-sm text-muted-foreground">Both selection modes with array sync</p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <div class="mt-1 text-success">✓</div>
                    <div>
                        <h4 class="font-semibold text-sm text-foreground">Searchable Options</h4>
                        <p class="text-sm text-muted-foreground">Real-time filtering of options</p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <div class="mt-1 text-success">✓</div>
                    <div>
                        <h4 class="font-semibold text-sm text-foreground">Cascading Selects</h4>
                        <p class="text-sm text-muted-foreground">Three real-world cascading patterns</p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <div class="mt-1 text-success">✓</div>
                    <div>
                        <h4 class="font-semibold text-sm text-foreground">Form Reset</h4>
                        <p class="text-sm text-muted-foreground">Livewire $this->reset() integration</p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <div class="mt-1 text-success">✓</div>
                    <div>
                        <h4 class="font-semibold text-sm text-foreground">Validation States</h4>
                        <p class="text-sm text-muted-foreground">Success, error, warning states</p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <div class="mt-1 text-success">✓</div>
                    <div>
                        <h4 class="font-semibold text-sm text-foreground">Size Variants</h4>
                        <p class="text-sm text-muted-foreground">Small, medium, large sizes</p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <div class="mt-1 text-success">✓</div>
                    <div>
                        <h4 class="font-semibold text-sm text-foreground">Clearable</h4>
                        <p class="text-sm text-muted-foreground">Clear button for resetting</p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <div class="mt-1 text-success">✓</div>
                    <div>
                        <h4 class="font-semibold text-sm text-foreground">Disabled States</h4>
                        <p class="text-sm text-muted-foreground">Disabled selects and options</p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <div class="mt-1 text-success">✓</div>
                    <div>
                        <h4 class="font-semibold text-sm text-foreground">Chips Display</h4>
                        <p class="text-sm text-muted-foreground">Visual chips for multi-select</p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <div class="mt-1 text-success">✓</div>
                    <div>
                        <h4 class="font-semibold text-sm text-foreground">Max Selected</h4>
                        <p class="text-sm text-muted-foreground">Limit selection count in multi-select</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
