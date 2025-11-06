# Select

Flexible select component with single/multi-select, searchable options, chips display, and seamless Livewire integration. Perfect for forms, filters, and cascading selections.

## Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `multiple` | boolean | `false` | `true`, `false` | Enable multi-select mode |
| `size` | string | `md` | `sm`, `md`, `lg` | Component size |
| `state` | string | `default` | `default`, `success`, `error`, `warning` | Validation state |
| `placeholder` | string | `'Select an option'` | Any string | Placeholder text |
| `disabled` | boolean | `false` | `true`, `false` | Disable the select |
| `value` | mixed | `null` | String/int or array | Selected value(s) |
| `chips` | boolean | `false` | `true`, `false` | Show selections as chips (multi-select only) |
| `searchable` | boolean | `false` | `true`, `false` | Enable search filtering |
| `minItemsForSearch` | int | `0` | Any integer | Minimum options before search shows |
| `searchPlaceholder` | string | `'Search...'` | Any string | Search input placeholder |
| `clearable` | boolean | `false` | `true`, `false` | Show clear button |
| `name` | string | `null` | Any string | Form input name |
| `noResultsMessage` | string | `'No results found'` | Any string | Message when search has no results |
| `emptyMessage` | string | `'No options available'` | Any string | Message when no options |

## Example

```blade
{{-- Basic single select --}}
<x-strata::select wire:model="category" placeholder="Select category">
    <x-strata::select.option value="1" label="Electronics" />
    <x-strata::select.option value="2" label="Clothing" />
    <x-strata::select.option value="3" label="Books" />
</x-strata::select>

{{-- Multi-select with chips and search --}}
<x-strata::select
    wire:model="tags"
    :multiple="true"
    :chips="true"
    :searchable="true"
    :minItemsForSearch="5"
    placeholder="Select tags"
>
    <x-strata::select.option value="laravel" label="Laravel" />
    <x-strata::select.option value="php" label="PHP" />
    <x-strata::select.option value="vue" label="Vue.js" />
    <x-strata::select.option value="react" label="React" />
</x-strata::select>

{{-- With validation state and clearable --}}
<x-strata::select
    wire:model="priority"
    state="error"
    :clearable="true"
    placeholder="Select priority"
>
    <x-strata::select.option value="low" label="Low" />
    <x-strata::select.option value="medium" label="Medium" />
    <x-strata::select.option value="high" label="High" />
</x-strata::select>
```

## Livewire Integration

### Cascading Selects

Update one select based on another's value using Livewire's reactive properties:

```blade
{{-- Component: app/Livewire/LocationSelector.php --}}
public $country = null;
public $state = null;
public $availableStates = [];

public function updatedCountry($value)
{
    $this->state = null;
    $this->availableStates = $this->getStatesForCountry($value);
}
```

```blade
{{-- View: resources/views/livewire/location-selector.blade.php --}}
<x-strata::select
    wire:model.live="country"
    placeholder="Choose a country"
>
    <x-strata::select.option value="us" label="United States" />
    <x-strata::select.option value="ca" label="Canada" />
    <x-strata::select.option value="uk" label="United Kingdom" />
</x-strata::select>

<x-strata::select
    wire:model.live="state"
    :disabled="!$country"
    placeholder="{{ $country ? 'Choose a state' : 'Select country first' }}"
>
    @foreach($availableStates as $state)
        <x-strata::select.option :value="$state['value']" :label="$state['label']" />
    @endforeach
</x-strata::select>
```

### Form Reset

Reset multiple selects using Livewire's `$this->reset()`:

```php
public function resetFilters()
{
    $this->reset(['category', 'tags', 'priority']);
}
```

## Keyboard Navigation

Full keyboard support for accessibility and typeahead search:

| Key | Action |
|-----|--------|
| `Enter` / `Space` / `↓` | Open dropdown |
| `↑` `↓` | Navigate options |
| `Home` / `End` | Jump to first/last option |
| `Enter` / `Space` | Select highlighted option |
| `Esc` / `Tab` | Close dropdown |
| `a-z` / `0-9` | Typeahead search - type to jump to options |

### Typeahead Search

When the dropdown is open, typing any character instantly highlights the first option starting with that letter. Continue typing to refine your search:

- Type "p" to jump to "PHP"
- Type "ph" to narrow to options starting with "ph"
- Type "pyt" to jump to "Python"
- 500ms delay resets the search buffer

Typeahead works alongside the manual search filter - use typeahead for quick keyboard navigation, use the search input for filtering long lists.

## Notes

- **Chips wrap:** When `chips=true`, the trigger button uses `min-height` and allows chips to wrap to multiple lines
- **Search threshold:** Use `minItemsForSearch` to only show search when needed (e.g., 5+ options)
- **Disabled cascading:** Use `:disabled="!$dependency"` for cascading selects that depend on parent selection
- **Clearable:** Clear button appears only when a value is selected
- **Multi-select display:** Without chips, shows "X selections" summary; with chips, displays each selection
- **Validation states:** Use `state` prop to show success/error/warning styling
- **Focus management:** Search input auto-focuses when dropdown opens (if searchable)
- **Livewire sync:** Uses Entangleable for bidirectional state synchronization
