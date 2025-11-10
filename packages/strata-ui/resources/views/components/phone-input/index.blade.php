{{--
/**
 * Phone Input Component
 *
 * International phone number input with country selector, auto-formatting, validation, and country detection.
 * Combines select and input components with flag icons and libphonenumber-js for phone number handling.
 *
 * @props
 * @prop array $countries - Required array of country data with structure: [{code: 'US', name: 'United States', dialCode: '+1', flag: 'us'}]
 * @prop string|null $value - Phone number in E.164 format (e.g., '+15551234567') (default: null)
 * @prop string|null $defaultCountry - Default country code to pre-select (e.g., 'US') (default: null)
 * @prop string|null $id - Unique component ID (default: auto-generated)
 * @prop string|null $name - Form input name (default: null)
 * @prop string $size - Component size: 'xs'|'sm'|'md'|'lg'|'xl' (default: 'md')
 * @prop string $state - Validation state: 'default'|'success'|'error'|'warning' (default: 'default')
 * @prop bool $disabled - Disable the phone input (default: false)
 * @prop bool $required - Mark as required field (default: false)
 * @prop bool $readonly - Make phone input read-only (default: false)
 * @prop string $placeholder - Placeholder text (default: 'Enter phone number')
 * @prop int $offset - Offset for country dropdown in pixels (default: 8)
 * @prop bool $returnObject - Return object with comprehensive data instead of E.164 string (default: false)
 *
 * @slots
 * @slot default - Not used, component generates its own content
 *
 * @example Basic usage
 * <x-strata::phone-input
 *     wire:model="phone"
 *     :countries="$countries"
 * />
 *
 * @example With default country
 * <x-strata::phone-input
 *     wire:model="contactPhone"
 *     :countries="$countries"
 *     default-country="US"
 *     placeholder="Enter your phone number"
 * />
 *
 * @example Required field with validation
 * <x-strata::phone-input
 *     wire:model="customerPhone"
 *     :countries="$countries"
 *     :required="true"
 *     state="error"
 *     default-country="GB"
 * />
 *
 * @example Different sizes
 * <x-strata::phone-input wire:model="phone" :countries="$countries" size="sm" />
 * <x-strata::phone-input wire:model="phone" :countries="$countries" size="lg" />
 *
 * @example Return object with comprehensive data
 * <x-strata::phone-input
 *     wire:model="phoneData"
 *     :countries="$countries"
 *     :return-object="true"
 * />
 *
 * Returned object structure:
 * {
 *     e164: '+12133734253',
 *     country: 'US',
 *     countryCallingCode: '1',
 *     nationalNumber: '2133734253',
 *     national: '(213) 373-4253',
 *     international: '+1 213 373 4253',
 *     uri: 'tel:+12133734253',
 *     isValid: true,
 *     isPossible: true
 * }
 */
--}}

@props([
    'countries' => [],
    'value' => null,
    'defaultCountry' => null,
    'id' => null,
    'name' => null,
    'size' => 'md',
    'state' => 'default',
    'disabled' => false,
    'required' => false,
    'readonly' => false,
    'placeholder' => 'Enter phone number',
    'offset' => 8,
    'returnObject' => false,
])

@php
use Stratos\StrataUI\Support\ComponentHelpers;
use Stratos\StrataUI\Support\PositioningHelper;

$componentId = ComponentHelpers::generateId('phone-input', $id, $attributes);

$countryOptions = collect($countries)->map(function ($country) {
    return [
        'value' => $country['code'],
        'label' => $country['name'],
        'dialCode' => $country['dialCode'],
        'flag' => $country['flag'] ?? strtolower($country['code']),
    ];
})->toArray();

$initialCountry = $defaultCountry ?? ($countries[0]['code'] ?? null);

$positioning = PositioningHelper::getAnchorPositioning('bottom-start', $offset);
$positioningStyle = $positioning['style'];

$animationClasses = '[&[popover]]:[transition:opacity_150ms,transform_150ms,overlay_150ms_allow-discrete,display_150ms_allow-discrete] ease-out will-change-[transform,opacity] opacity-100 scale-100 starting:opacity-0 starting:scale-95';

$disabledClasses = $disabled || $readonly ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer';
@endphp

<div
    x-data="window.strataPhoneInput({
        countries: {{ json_encode($countryOptions) }},
        initialValue: {{ json_encode($value) }},
        initialCountry: {{ json_encode($initialCountry) }},
        placeholder: {{ json_encode($placeholder) }},
        disabled: {{ $disabled ? 'true' : 'false' }},
        readonly: {{ $readonly ? 'true' : 'false' }},
        required: {{ $required ? 'true' : 'false' }},
        returnObject: {{ $returnObject ? 'true' : 'false' }},
    })"
    x-id="['phone-input', 'country-dropdown']"
    data-strata-phone-input
    data-strata-field-type="tel"
    data-disabled="{{ $disabled ? 'true' : 'false' }}"
    {{ $attributes->whereDoesntStartWith('wire:model')->merge(['class' => 'relative overflow-visible']) }}
>
    <div class="hidden" hidden>
        <input
            type="hidden"
            id="{{ $componentId }}"
            name="{{ $name ?? '' }}"
            x-ref="hiddenInput"
            x-bind:value="entangleable.value"
            data-strata-phone-input-value
            {{ $attributes->whereStartsWith('wire:model') }}
        />
    </div>

    <x-strata::input
        x-ref="phoneNumberInput"
        x-model="displayNumber"
        @input="handleNumberInput"
        @keydown="handleKeydown"
        type="tel"
        :size="$size"
        :state="$state"
        :disabled="$disabled"
        :readonly="$readonly"
        :required="$required"
        x-bind:placeholder="currentPlaceholder"
        data-strata-phone-number-input
    >
        <x-slot:prefixSlot>
            <div
                class="relative border-r border-border/50 pr-2 mr-2"
                x-ref="flagTriggerWrapper"
                :style="`anchor-name: --country-${$id('country-dropdown')};`"
            >
                <button
                    type="button"
                    x-ref="flagTrigger"
                    :disabled="isDisabled()"
                    :tabindex="isDisabled() ? -1 : 0"
                    aria-haspopup="listbox"
                    :aria-expanded="countryDropdownOpen"
                    class="flex items-center gap-1 transition-all duration-150 {{ $disabledClasses }}"
                    data-strata-phone-flag-button
                >
                    <span
                        class="fi fis inline-block"
                        x-bind:class="`fi-${selectedFlag}`"
                        style="width: 20px; height: 15px;"
                    ></span>
                    <template x-if="dialCode">
                        <span class="text-sm text-muted-foreground select-none" x-text="dialCode"></span>
                    </template>
                    <x-strata::icon.chevron-down class="w-3 h-3 text-muted-foreground transition-transform duration-150 ease-out" ::class="{ 'rotate-180': countryDropdownOpen }" />
                </button>
            </div>
        </x-slot:prefixSlot>
    </x-strata::input>

    <div
        :id="$id('country-dropdown')"
        x-ref="countryDropdown"
        popover="auto"
        @toggle="countryDropdownOpen = $event.newState === 'open'"
        @keydown="handleDropdownKeydown"
        :style="`{{ $positioningStyle }} position-anchor: --country-${$id('country-dropdown')};`"
        x-trap.nofocus="countryDropdownOpen"
        class="w-80 bg-popover border border-border rounded-lg shadow-xl p-0 overflow-hidden {{ $animationClasses }}"
        role="listbox"
        data-strata-phone-country-dropdown
        x-cloak
    >
        <div class="sticky top-0 z-10 bg-popover border-b border-border p-2">
            <input
                type="text"
                x-model="countrySearch"
                @keydown.escape="closeCountryDropdown()"
                @keydown="handleDropdownKeydown"
                :placeholder="$__('Search countries...')"
                role="searchbox"
                :aria-label="$__('Search countries')"
                class="w-full px-3 py-2 text-sm bg-input border border-border rounded-md transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                data-strata-phone-country-search
            />
        </div>

        <div class="max-h-64 overflow-y-auto p-1">
            <template x-for="(country, index) in filteredCountries" :key="country.value">
                <button
                    type="button"
                    @click="selectCountry(country)"
                    @mouseenter="highlightedIndex = index"
                    :class="{
                        'bg-primary/10 text-primary': selectedCountry === country.value,
                        'bg-muted': highlightedIndex === index && selectedCountry !== country.value
                    }"
                    class="w-full flex items-center gap-3 px-3 py-2 rounded-md hover:bg-muted transition-all duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-inset text-left"
                    role="option"
                    :aria-selected="selectedCountry === country.value ? 'true' : 'false'"
                    data-strata-phone-country-option
                >
                    <span
                        class="fi fis inline-block"
                        x-bind:class="`fi-${country.flag}`"
                        style="width: 20px; height: 15px;"
                    ></span>
                    <span class="flex-1 text-sm" x-text="`${country.dialCode} ${country.label}`"></span>
                    <x-strata::icon.check x-show="selectedCountry === country.value" class="w-4 h-4 text-primary flex-shrink-0" />
                </button>
            </template>
        </div>
    </div>

    <template x-if="validationMessage">
        <p
            class="mt-1.5 text-sm"
            x-bind:class="isValid ? 'text-success' : 'text-destructive'"
            x-text="validationMessage"
        ></p>
    </template>
</div>
