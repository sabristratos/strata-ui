<div class="space-y-8">
    <div>
        <h3 class="text-lg font-semibold mb-4">Basic Single Select</h3>
        <div class="space-y-4">
            <x-strata::select wire:model.live="selectedCountry" placeholder="Select a country">
                @foreach($countries as $value => $label)
                    <x-strata::select.option :value="$value">
                        {{ $label }}
                    </x-strata::select.option>
                @endforeach
            </x-strata::select>

            <x-strata::select :value="$selectedFruit" wire:model.live="selectedFruit" placeholder="Select a fruit">
                @foreach($fruits as $value => $label)
                    <x-strata::select.option :value="$value">
                        {{ $label }}
                    </x-strata::select.option>
                @endforeach
            </x-strata::select>
        </div>
        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-2">Current State:</p>
            <p class="text-sm text-muted-foreground">Country: {{ $selectedCountry ?? 'None' }}</p>
            <p class="text-sm text-muted-foreground">Fruit: {{ $selectedFruit ?? 'None' }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Multiselect - Inline Chips</h3>
        <x-strata::select multiple :value="$selectedColors" wire:model.live="selectedColors" placeholder="Select colors" chips="inline">
            @foreach($colors as $value => $label)
                <x-strata::select.option :value="$value">
                    {{ $label }}
                </x-strata::select.option>
            @endforeach
        </x-strata::select>
        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-2">Selected Colors:</p>
            <p class="text-sm text-muted-foreground">{{ implode(', ', array_map(fn($v) => $colors[$v], $selectedColors)) ?: 'None' }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Multiselect - Below Chips</h3>
        <x-strata::select multiple :value="$selectedFrameworks" wire:model.live="selectedFrameworks" placeholder="Select frameworks" chips="below">
            @foreach($frameworks as $value => $label)
                <x-strata::select.option :value="$value">
                    {{ $label }}
                </x-strata::select.option>
            @endforeach
        </x-strata::select>
        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-2">Selected Frameworks:</p>
            <p class="text-sm text-muted-foreground">{{ implode(', ', array_map(fn($v) => $frameworks[$v], $selectedFrameworks)) ?: 'None' }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Multiselect - Summary</h3>
        <x-strata::select multiple :value="$selectedTags" wire:model.live="selectedTags" placeholder="Select tags" chips="summary">
            @foreach($tags as $value => $label)
                <x-strata::select.option :value="$value">
                    {{ $label }}
                </x-strata::select.option>
            @endforeach
        </x-strata::select>
        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-2">Selected Tags:</p>
            <p class="text-sm text-muted-foreground">{{ implode(', ', array_map(fn($v) => $tags[$v], $selectedTags)) ?: 'None' }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Sizes</h3>
        <div class="space-y-4">
            <x-strata::select size="sm" placeholder="Small select">
                <x-strata::select.option value="1">Option 1</x-strata::select.option>
                <x-strata::select.option value="2">Option 2</x-strata::select.option>
            </x-strata::select>

            <x-strata::select size="md" placeholder="Medium select (default)">
                <x-strata::select.option value="1">Option 1</x-strata::select.option>
                <x-strata::select.option value="2">Option 2</x-strata::select.option>
            </x-strata::select>

            <x-strata::select size="lg" placeholder="Large select">
                <x-strata::select.option value="1">Option 1</x-strata::select.option>
                <x-strata::select.option value="2">Option 2</x-strata::select.option>
            </x-strata::select>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Validation States</h3>
        <div class="space-y-4">
            <x-strata::select state="default" placeholder="Default state" value="1">
                <x-strata::select.option value="1">Selected Option</x-strata::select.option>
                <x-strata::select.option value="2">Option 2</x-strata::select.option>
            </x-strata::select>

            <x-strata::select state="success" placeholder="Success state" value="1">
                <x-strata::select.option value="1">Valid Selection</x-strata::select.option>
                <x-strata::select.option value="2">Option 2</x-strata::select.option>
            </x-strata::select>

            <x-strata::select state="error" placeholder="Error state" value="1">
                <x-strata::select.option value="1">Invalid Selection</x-strata::select.option>
                <x-strata::select.option value="2">Option 2</x-strata::select.option>
            </x-strata::select>

            <x-strata::select state="warning" placeholder="Warning state" value="1">
                <x-strata::select.option value="1">Caution Required</x-strata::select.option>
                <x-strata::select.option value="2">Option 2</x-strata::select.option>
            </x-strata::select>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Options with Icons and Descriptions</h3>
        <x-strata::select placeholder="Select a framework">
            <x-strata::select.option value="laravel">
                <x-slot:icon>
                    <div class="w-6 h-6 bg-red-500 rounded flex items-center justify-center text-white text-xs font-bold">L</div>
                </x-slot:icon>
                <x-slot:label>Laravel</x-slot:label>
                <x-slot:description>The PHP framework for web artisans</x-slot:description>
            </x-strata::select.option>

            <x-strata::select.option value="vue">
                <x-slot:icon>
                    <div class="w-6 h-6 bg-green-500 rounded flex items-center justify-center text-white text-xs font-bold">V</div>
                </x-slot:icon>
                <x-slot:label>Vue.js</x-slot:label>
                <x-slot:description>The progressive JavaScript framework</x-slot:description>
            </x-strata::select.option>

            <x-strata::select.option value="react">
                <x-slot:icon>
                    <div class="w-6 h-6 bg-blue-500 rounded flex items-center justify-center text-white text-xs font-bold">R</div>
                </x-slot:icon>
                <x-slot:label>React</x-slot:label>
                <x-slot:description>A JavaScript library for building UIs</x-slot:description>
            </x-strata::select.option>
        </x-strata::select>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Disabled State</h3>
        <div class="space-y-4">
            <x-strata::select disabled placeholder="Disabled select">
                <x-strata::select.option value="1">Option 1</x-strata::select.option>
                <x-strata::select.option value="2">Option 2</x-strata::select.option>
            </x-strata::select>

            <x-strata::select placeholder="Select with disabled option">
                <x-strata::select.option value="1">Available Option</x-strata::select.option>
                <x-strata::select.option value="2" disabled>Disabled Option</x-strata::select.option>
                <x-strata::select.option value="3">Another Available Option</x-strata::select.option>
            </x-strata::select>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Searchable Select</h3>
        <div class="space-y-4">
            <x-strata::select
                searchable
                :min-items-for-search="5"
                wire:model.live="selectedCountry"
                placeholder="Search countries..."
                search-placeholder="Type to search..."
            >
                @foreach($countries as $value => $label)
                    <x-strata::select.option :value="$value">
                        {{ $label }}
                    </x-strata::select.option>
                @endforeach
            </x-strata::select>
        </div>
        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-2">Selected Country:</p>
            <p class="text-sm text-muted-foreground">{{ $selectedCountry ?? 'None' }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Clearable Select</h3>
        <div class="space-y-4">
            <x-strata::select
                clearable
                wire:model.live="selectedFruit"
                placeholder="Select a fruit (clearable)"
            >
                @foreach($fruits as $value => $label)
                    <x-strata::select.option :value="$value">
                        {{ $label }}
                    </x-strata::select.option>
                @endforeach
            </x-strata::select>

            <x-strata::select
                multiple
                clearable
                wire:model.live="selectedColors"
                placeholder="Select colors (clearable multiselect)"
            >
                @foreach($colors as $value => $label)
                    <x-strata::select.option :value="$value">
                        {{ $label }}
                    </x-strata::select.option>
                @endforeach
            </x-strata::select>
        </div>
        <div class="mt-4 p-4 bg-muted rounded-lg">
            <p class="text-sm font-medium mb-2">Current State:</p>
            <p class="text-sm text-muted-foreground">Fruit: {{ $selectedFruit ?? 'None' }}</p>
            <p class="text-sm text-muted-foreground">Colors: {{ implode(', ', array_map(fn($v) => $colors[$v], $selectedColors)) ?: 'None' }}</p>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Grouped Options</h3>
        <x-strata::select placeholder="Select a location">
            <x-strata::select.group label="North America">
                <x-strata::select.option value="us">United States</x-strata::select.option>
                <x-strata::select.option value="ca">Canada</x-strata::select.option>
                <x-strata::select.option value="mx">Mexico</x-strata::select.option>
            </x-strata::select.group>

            <x-strata::select.group label="Europe">
                <x-strata::select.option value="uk">United Kingdom</x-strata::select.option>
                <x-strata::select.option value="fr">France</x-strata::select.option>
                <x-strata::select.option value="de">Germany</x-strata::select.option>
                <x-strata::select.option value="es">Spain</x-strata::select.option>
            </x-strata::select.group>

            <x-strata::select.group label="Asia">
                <x-strata::select.option value="jp">Japan</x-strata::select.option>
                <x-strata::select.option value="cn">China</x-strata::select.option>
                <x-strata::select.option value="kr">South Korea</x-strata::select.option>
            </x-strata::select.group>
        </x-strata::select>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Searchable with Groups</h3>
        <x-strata::select
            searchable
            placeholder="Search programming languages..."
        >
            <x-strata::select.group label="Frontend">
                <x-strata::select.option value="js">JavaScript</x-strata::select.option>
                <x-strata::select.option value="ts">TypeScript</x-strata::select.option>
                <x-strata::select.option value="html">HTML</x-strata::select.option>
                <x-strata::select.option value="css">CSS</x-strata::select.option>
            </x-strata::select.group>

            <x-strata::select.group label="Backend">
                <x-strata::select.option value="php">PHP</x-strata::select.option>
                <x-strata::select.option value="python">Python</x-strata::select.option>
                <x-strata::select.option value="ruby">Ruby</x-strata::select.option>
                <x-strata::select.option value="java">Java</x-strata::select.option>
            </x-strata::select.group>

            <x-strata::select.group label="Database">
                <x-strata::select.option value="sql">SQL</x-strata::select.option>
                <x-strata::select.option value="nosql">NoSQL</x-strata::select.option>
            </x-strata::select.group>
        </x-strata::select>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Empty States</h3>
        <div class="space-y-4">
            <x-strata::select
                placeholder="No options available"
                empty-message="There are no items to display"
            >
            </x-strata::select>

            <x-strata::select
                searchable
                placeholder="Search (will show no results)"
                no-results-message="No matching items found"
            >
                <x-strata::select.option value="1">Option 1</x-strata::select.option>
                <x-strata::select.option value="2">Option 2</x-strata::select.option>
            </x-strata::select>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold mb-4">Form Submission</h3>
        <div class="space-y-4">
            <x-strata::select wire:model="selectedCountry" placeholder="Select your country">
                @foreach($countries as $value => $label)
                    <x-strata::select.option :value="$value">
                        {{ $label }}
                    </x-strata::select.option>
                @endforeach
            </x-strata::select>

            <x-strata::button wire:click="submit" variant="primary">
                Submit Form
            </x-strata::button>

            @if($message)
                <div class="p-4 bg-success/10 text-success rounded-lg">
                    {{ $message }}
                </div>
            @endif
        </div>
    </div>
</div>
