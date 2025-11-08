# Phone Input

International phone number input with country selector, auto-formatting, validation, and country detection using libphonenumber-js.

## Features

- **Country Selector** - Searchable dropdown with flag icons and dial codes
- **Auto-Formatting** - Formats numbers as you type based on country
- **Validation** - Real-time validation using libphonenumber-js
- **Country Detection** - Auto-detects country when pasting international numbers
- **Keyboard Navigation** - Full keyboard support for country dropdown
- **E.164 Format** - Returns standardized international format
- **Object Mode** - Optional rich object return with comprehensive data
- **Accessible** - ARIA compliant with proper roles and labels

## Basic Usage

```blade
<x-strata::phone-input
    wire:model="phone"
    :countries="$countries"
/>
```

### Countries Array Format

```php
$countries = [
    [
        'code' => 'US',
        'name' => 'United States',
        'dialCode' => '+1',
        'flag' => 'us'
    ],
    [
        'code' => 'GB',
        'name' => 'United Kingdom',
        'dialCode' => '+44',
        'flag' => 'gb'
    ],
    // ...
];
```

## Return Modes

### String Mode (Default)

Returns E.164 formatted phone number:

```blade
<x-strata::phone-input
    wire:model="phone"
    :countries="$countries"
/>
```

```php
// Returns: '+12133734253'
public string $phone = '';
```

### Object Mode

Returns comprehensive phone data object:

```blade
<x-strata::phone-input
    wire:model="phoneData"
    :countries="$countries"
    :return-object="true"
/>
```

```php
// Returns object with all phone number data
public array $phoneData = [];

// Object structure:
// [
//     'e164' => '+12133734253',
//     'country' => 'US',
//     'countryCallingCode' => '1',
//     'nationalNumber' => '2133734253',
//     'national' => '(213) 373-4253',
//     'international' => '+1 213 373 4253',
//     'uri' => 'tel:+12133734253',
//     'isValid' => true,
//     'isPossible' => true
// ]
```

## Examples

### With Default Country

```blade
<x-strata::phone-input
    wire:model="contactPhone"
    :countries="$countries"
    default-country="US"
    placeholder="Enter your phone number"
/>
```

### Required Field with Validation

```blade
<x-strata::phone-input
    wire:model="customerPhone"
    :countries="$countries"
    :required="true"
    state="error"
    default-country="GB"
/>
```

### Different Sizes

```blade
<x-strata::phone-input wire:model="phone" :countries="$countries" size="sm" />
<x-strata::phone-input wire:model="phone" :countries="$countries" size="md" />
<x-strata::phone-input wire:model="phone" :countries="$countries" size="lg" />
```

### Disabled/Readonly

```blade
<x-strata::phone-input
    wire:model="phone"
    :countries="$countries"
    :disabled="true"
/>

<x-strata::phone-input
    wire:model="phone"
    :countries="$countries"
    :readonly="true"
/>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `countries` | `array` | `[]` | Required country data array |
| `value` | `string\|null` | `null` | Phone number in E.164 format |
| `default-country` | `string\|null` | `null` | Default country code (e.g., 'US') |
| `return-object` | `bool` | `false` | Return object with comprehensive data |
| `id` | `string\|null` | `null` | Component ID |
| `name` | `string\|null` | `null` | Form input name |
| `size` | `string` | `'md'` | Size: 'xs', 'sm', 'md', 'lg', 'xl' |
| `state` | `string` | `'default'` | State: 'default', 'success', 'error', 'warning' |
| `disabled` | `bool` | `false` | Disable input |
| `required` | `bool` | `false` | Mark as required |
| `readonly` | `bool` | `false` | Make read-only |
| `placeholder` | `string` | `'Enter phone number'` | Placeholder text |
| `offset` | `int` | `8` | Dropdown offset in pixels |

## Keyboard Navigation

### Country Dropdown

- **Arrow Down/Up** - Navigate through countries
- **Home/End** - Jump to first/last country
- **Enter/Space** - Select highlighted country
- **Escape** - Close dropdown
- **Type to search** - Filter countries by name/code

### Phone Input

- **Enter** - Submit if valid
- **Paste international number** - Auto-detects country

## Usage with Forms

```blade
<form wire:submit="saveContact">
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium mb-2">
                Phone Number
            </label>
            <x-strata::phone-input
                wire:model="contact.phone"
                :countries="$countries"
                :required="true"
                default-country="US"
            />
            @error('contact.phone')
                <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Save Contact</button>
    </div>
</form>
```

## Validation Example

```php
use Illuminate\Validation\Rule;
use Propaganistas\LaravelPhone\PhoneNumber;

// In your Livewire component or Form Request
public function rules()
{
    return [
        'phone' => [
            'required',
            'phone:AUTO,US',  // Using laravel-phone package
        ],
    ];
}

// Or manually validate
public function validatePhone()
{
    if (!empty($this->phone)) {
        try {
            $phoneNumber = PhoneNumber::make($this->phone);
            if (!$phoneNumber->isValid()) {
                $this->addError('phone', 'Invalid phone number');
            }
        } catch (\Exception $e) {
            $this->addError('phone', 'Invalid phone number format');
        }
    }
}
```

## Object Mode Use Cases

When `return-object` is enabled, you get access to additional data:

### Display Formatted Number

```blade
@if($phoneData)
    <p>National: {{ $phoneData['national'] }}</p>
    <p>International: {{ $phoneData['international'] }}</p>
@endif
```

### Create Phone Links

```blade
@if($phoneData && $phoneData['isValid'])
    <a href="{{ $phoneData['uri'] }}">
        Call {{ $phoneData['national'] }}
    </a>
@endif
```

### Store Separate Fields

```php
// Store different formats in database
DB::table('contacts')->insert([
    'phone_e164' => $phoneData['e164'],
    'phone_national' => $phoneData['national'],
    'phone_country' => $phoneData['country'],
    'phone_is_valid' => $phoneData['isValid'],
]);
```

## Accessibility

- **ARIA Roles** - Proper `listbox`, `option`, `searchbox` roles
- **Keyboard Support** - Full keyboard navigation
- **Screen Readers** - All interactive elements properly labeled
- **Focus Management** - Clear focus indicators and logical tab order
