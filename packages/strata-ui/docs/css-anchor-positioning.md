# CSS Anchor Positioning Implementation Guide

This document captures critical lessons learned while implementing CSS anchor positioning with the `@oddbird/css-anchor-positioning` polyfill in Strata UI. Use this as a reference for implementing anchor positioning in popovers, tooltips, dropdowns, and other floating UI components.

## Table of Contents

- [Overview](#overview)
- [Polyfill Setup](#polyfill-setup)
- [Critical Requirements](#critical-requirements)
- [Common Pitfalls](#common-pitfalls)
- [Working Implementation](#working-implementation)
- [Troubleshooting](#troubleshooting)
- [Browser Support](#browser-support)

## Overview

CSS anchor positioning allows elements to position themselves relative to other elements (anchors) using modern CSS properties. Since browser support is limited (Chrome 125+), we use the `@oddbird/css-anchor-positioning` polyfill.

**Key Concepts:**
- **Anchor**: The reference element (e.g., a button trigger)
- **Positioned Element**: The floating element (e.g., a popover)
- **Fallback Positioning**: Automatic repositioning when overflow occurs

## Polyfill Setup

### Installation

```bash
npm install @oddbird/css-anchor-positioning
```

### Initialization

The polyfill is automatically loaded when the browser doesn't support CSS anchor positioning.

```javascript
// Auto-load polyfill for browsers without native support
if (!CSS.supports('anchor-name', '--test')) {
    import('@oddbird/css-anchor-positioning');
}
```

**Location**: `packages/strata-ui/resources/js/strata.js`

## Critical Requirements

### 1. Use `position-area` NOT `inset-area`

The CSS spec uses `position-area`, not `inset-area`.

```css
/* ❌ WRONG */
[popover] {
    inset-area: bottom;
}

/* ✅ CORRECT */
[popover] {
    position-area: bottom;
}
```

**However**: For fallback positioning with the polyfill, use `anchor()` functions instead of `position-area` (see below).

### 2. Fallbacks Require Named @position-try Rules

Direct `position-area` keywords do NOT work as fallback values with the polyfill.

```css
/* ❌ WRONG - polyfill doesn't support this */
[popover] {
    position-area: bottom;
    position-try-fallbacks: top, left, right;
}

/* ✅ CORRECT - reference named @position-try rules */
[popover] {
    top: anchor(bottom);
    left: anchor(left);
    position-try-fallbacks: --try-top, --try-left;
}

@position-try --try-top {
    bottom: anchor(top);
    left: anchor(left);
}
```

### 3. Use anchor() Functions for Positioning

The polyfill requires explicit `anchor()` function positioning, not `position-area`.

```css
/* ❌ WRONG - position-area doesn't work well with polyfill fallbacks */
[popover].popover-placement-bottom {
    position-area: bottom;
}

/* ✅ CORRECT - use anchor() functions */
[popover].popover-placement-bottom {
    top: anchor(bottom);
    left: anchor(left);
}
```

### 4. ALL Four Inset Properties MUST Be Explicit

**This is the most critical requirement.** The polyfill requires all four inset properties (top, bottom, left, right) to be explicitly defined in BOTH base rules AND @position-try rules.

```css
/* ❌ WRONG - missing explicit inset properties */
[popover].popover-placement-bottom {
    top: anchor(bottom);
    left: anchor(left);
    /* bottom and right are undefined - breaks fallbacks! */
}

@position-try --try-top {
    bottom: anchor(top);
    left: anchor(left);
    /* Missing top and right - loses anchor connection! */
}

/* ✅ CORRECT - all four inset properties explicit */
[popover].popover-placement-bottom {
    top: anchor(bottom);
    bottom: auto;         /* Explicit */
    left: anchor(left);
    right: auto;          /* Explicit */
    position-try-fallbacks: --try-top;
}

@position-try --try-top {
    top: auto;            /* Explicit */
    bottom: anchor(top);
    left: anchor(left);
    right: auto;          /* Explicit */
}
```

**Why this matters**: The polyfill tracks inset properties internally. If a property isn't explicitly defined, the polyfill can't properly manage it during fallback transitions, causing the element to lose its anchor connection and float to (0, 0).

### 5. Use `auto` Instead of `revert`

While `revert` is supported, `auto` is more explicit and reliable with the polyfill.

```css
/* ❌ WORKS BUT NOT IDEAL */
@position-try --try-top {
    bottom: anchor(top);
    top: revert;
}

/* ✅ BETTER - explicit auto */
@position-try --try-top {
    top: auto;
    bottom: anchor(top);
}
```

## Common Pitfalls

### Pitfall 1: Importing Without Invoking

```javascript
// ❌ Polyfill not applied
import '@oddbird/css-anchor-positioning/fn';
```

**Symptom**: Anchor positioning doesn't work at all.
**Solution**: Call `polyfill()` after importing.

### Pitfall 2: Using Direct Keywords in Fallbacks

```css
/* ❌ Doesn't work with polyfill */
position-try-fallbacks: top, bottom, left;
```

**Symptom**: Fallbacks don't trigger.
**Solution**: Use named `@position-try` rules.

### Pitfall 3: Missing Inset Properties

```css
/* ❌ Incomplete positioning */
[popover] {
    top: anchor(bottom);
    left: anchor(left);
}
```

**Symptom**: Element floats to top-left corner (0, 0) when fallback triggers.
**Solution**: Explicitly define all four inset properties.

### Pitfall 4: Conflicting Props

```css
/* ❌ Button component has 'style' prop that consumes HTML style attribute */
<x-strata::button style="anchor-name: --my-anchor;" />
```

**Symptom**: `anchor-name` doesn't get applied to DOM.
**Solution**: Rename component prop (we use `appearance` instead of `style`).

## Working Implementation

### Strata UI Approach

Strata UI uses a centralized approach with:
- **PositioningHelper** PHP class for consistent placement calculations
- **Global CSS fallbacks** via `data-placement` attribute
- **Dynamic anchor names** using Alpine's `x-id()` for unique instances

### HTML Structure (Popover Example)

```blade
{{-- Popover wrapper with Alpine x-id for unique identification --}}
<x-strata::popover placement="bottom-start">
    {{-- Trigger with dynamic anchor-name --}}
    <x-strata::popover.trigger>
        <x-strata::button>Open Menu</x-strata::button>
    </x-strata::popover.trigger>

    {{-- Content with position-anchor and placement attribute --}}
    <x-strata::popover.content>
        Popover content
    </x-strata::popover.content>
</x-strata::popover>
```

### Generated HTML

```html
<!-- Trigger sets unique anchor-name using Alpine $id() -->
<div
    x-popover-trigger="popover-1"
    style="anchor-name: --popover-popover-1;"
>
    <button>Open Menu</button>
</div>

<!-- Content anchors to trigger and uses data-placement for fallbacks -->
<div
    id="popover-1"
    popover="auto"
    data-placement="bottom-start"
    style="
        position: absolute;
        inset: auto;
        margin-top: 8px;
        top: anchor(bottom);
        left: anchor(left);
        position-anchor: --popover-popover-1;
    "
>
    Popover content
</div>
```

### PositioningHelper PHP Class

The `PositioningHelper` class centralizes all placement-to-CSS mapping logic:

```php
// packages/strata-ui/src/Support/PositioningHelper.php
namespace Stratos\StrataUI\Support;

class PositioningHelper
{
    public static function getAnchorPositioning(string $placement, int $offset = 8): array
    {
        [$insetProperty, $anchorSide, $alignProperty, $alignSide, $marginProperty] = match ($placement) {
            'bottom-start' => ['top', 'bottom', 'left', 'left', 'margin-top'],
            'bottom-end' => ['top', 'bottom', 'right', 'right', 'margin-top'],
            'bottom' => ['top', 'bottom', 'left', 'left', 'margin-top'],
            'top-start' => ['bottom', 'top', 'left', 'left', 'margin-bottom'],
            'top-end' => ['bottom', 'top', 'right', 'right', 'margin-bottom'],
            'top' => ['bottom', 'top', 'left', 'left', 'margin-bottom'],
            'right-start' => ['left', 'right', 'top', 'top', 'margin-left'],
            'right-end' => ['left', 'right', 'bottom', 'bottom', 'margin-left'],
            'right' => ['left', 'right', 'top', 'top', 'margin-left'],
            'left-start' => ['right', 'left', 'top', 'top', 'margin-right'],
            'left-end' => ['right', 'left', 'bottom', 'bottom', 'margin-right'],
            'left' => ['right', 'left', 'top', 'top', 'margin-right'],
            default => ['top', 'bottom', 'left', 'left', 'margin-top'],
        };

        $style = "position: absolute; inset: auto; {$marginProperty}: {$offset}px; {$insetProperty}: anchor({$anchorSide}); {$alignProperty}: anchor({$alignSide});";

        return [
            'style' => $style,
            'insetProperty' => $insetProperty,
            'anchorSide' => $anchorSide,
            'alignProperty' => $alignProperty,
            'alignSide' => $alignSide,
        ];
    }
}
```

### Global CSS Fallbacks

Global fallbacks defined in `anchor-positioning.css` apply to ANY element with `data-placement` attribute:

```css
/* File: packages/strata-ui/resources/css/anchor-positioning.css */

/* Bottom-start fallback sequence */
@position-try --fallback-bottom-start-1 {
    inset: auto;
    margin-bottom: 8px;
    bottom: anchor(top);
    left: anchor(left);
}

@position-try --fallback-bottom-start-2 {
    inset: auto;
    margin-left: 4px;
    left: anchor(right);
    top: anchor(top);
}

@position-try --fallback-bottom-start-3 {
    inset: auto;
    margin-right: 4px;
    right: anchor(left);
    top: anchor(top);
}

/* Global selector - works for dropdowns, popovers, tooltips, etc. */
[data-placement="bottom-start"] {
    position-try-fallbacks:
        --fallback-bottom-start-1,
        --fallback-bottom-start-2,
        --fallback-bottom-start-3;
}

/* All 12 placements defined with intelligent fallback sequences */
[data-placement="top"] { ... }
[data-placement="top-start"] { ... }
[data-placement="top-end"] { ... }
[data-placement="bottom"] { ... }
[data-placement="bottom-end"] { ... }
[data-placement="left"] { ... }
[data-placement="left-start"] { ... }
[data-placement="left-end"] { ... }
[data-placement="right"] { ... }
[data-placement="right-start"] { ... }
[data-placement="right-end"] { ... }
```

### Fallback Strategy

Each placement has 3 intelligent fallback positions:

1. **Flip on primary axis** - Bottom → Top (maintain alignment)
2. **Try adjacent placements** - Bottom → Right/Left (maintain axis when possible)
3. **Flip to perpendicular axis** - Bottom → Opposite side (last resort)

Example for `bottom-start`:
- Primary: Below trigger, left-aligned
- Fallback 1: Above trigger, left-aligned (flip vertical)
- Fallback 2: Right of trigger, top-aligned (try horizontal)
- Fallback 3: Left of trigger, top-aligned (opposite horizontal)

## Troubleshooting

### Issue: Anchor positioning doesn't work at all

**Check**:
1. Is the polyfill invoked? (`polyfill()` called after import)
2. Is `position: absolute` set on positioned element?
3. Are both `anchor-name` and `position-anchor` defined?
4. Do the anchor names match (including `--` prefix)?

### Issue: Base positioning works, but fallbacks don't trigger

**Check**:
1. Are you using named `@position-try` rules, not direct keywords?
2. Does `position-try-fallbacks` reference valid rule names?

### Issue: Fallback causes element to float to top-left (0,0)

**Root cause**: Missing explicit inset properties.

**Fix**:
1. Add explicit `auto` values for all undefined inset properties in base rule
2. Define ALL four inset properties in every `@position-try` rule

### Issue: Browser console shows "Unknown at rule: @position-try"

**This is expected**: The warning comes from the CSS parser (Vite/PostCSS) not recognizing modern CSS. The polyfill handles these at runtime. You can ignore these warnings.

### Issue: Style attribute not rendering on button

**Root cause**: Component prop name conflicts with HTML attribute.

**Fix**: Rename the component prop (e.g., `style` → `appearance`).

## Browser Support

### Native Support
- **Chrome/Edge 125+**: Partial support (basic anchor positioning)
- **Chrome/Edge 128+**: Added `position-try-fallbacks` (renamed from `position-try-order`)
- **Chrome/Edge 129+**: Added `position-area` property

### Polyfill Coverage
The `@oddbird/css-anchor-positioning` polyfill provides support for:
- ✅ `anchor-name` and `position-anchor` properties
- ✅ `anchor()` functions for positioning
- ✅ `@position-try` at-rules
- ✅ `position-try-fallbacks` property
- ⚠️ `position-area` property (with limitations - see below)

### Polyfill Limitations

1. **position-area wrapping**: The polyfill implements `position-area` by wrapping elements, which can break certain selectors
2. **Overflow alignment**: Not fully implemented - may not reposition exactly like native implementation
3. **Dynamic anchors**: Limited support for dynamically added/removed anchors
4. **Percentage anchor values**: Not supported in fallbacks

**Recommendation**: Use explicit `anchor()` functions instead of `position-area` for maximum polyfill compatibility.

## Alpine Magic Helpers

Strata UI provides global Alpine magic helpers for easy interaction with positioned elements:

```javascript
// packages/strata-ui/resources/js/alpine-helpers.js
document.addEventListener('alpine:init', () => {
    // Close nearest popover
    Alpine.magic('closePopover', (el) => {
        return () => {
            const popoverContent = el.closest('[data-strata-popover-content]');
            if (popoverContent) {
                popoverContent.hidePopover();
            }
        };
    });

    // Close nearest dropdown
    Alpine.magic('closeDropdown', (el) => {
        return () => {
            const dropdownContent = el.closest('[data-strata-dropdown-content]');
            if (dropdownContent) {
                dropdownContent.hidePopover();
            }
        };
    });

    // Close nearest modal/dialog
    Alpine.magic('closeModal', (el) => {
        return () => {
            const dialog = el.closest('dialog[open]');
            if (dialog) {
                dialog.close();
            }
        };
    });
});
```

### Usage

```blade
{{-- In popover content --}}
<button @click="$closePopover()">Close</button>
<button wire:click="delete" @click="$closePopover()">Delete</button>

{{-- In dropdown content --}}
<x-strata::dropdown.item @click="$closeDropdown()">Action</x-strata::dropdown.item>

{{-- In modal/dialog --}}
<button @click="$closeModal()">Cancel</button>
```

## Best Practices

1. **Use PositioningHelper** for all placement calculations to maintain consistency
2. **Add `data-placement` attribute** to enable global CSS fallbacks on any positioned element
3. **Use Alpine `x-id()`** for dynamic anchor names to ensure uniqueness across multiple instances
4. **Use directional margins** (`margin-top`, `margin-bottom`, etc.) instead of uniform `margin`
5. **Leverage magic helpers** (`$closePopover()`, `$closeDropdown()`, etc.) for clean component interactions
6. **Test fallback behavior** by resizing the viewport to trigger overflow
7. **Consider native support**: Once browser support is widespread (likely 2026+), we can remove the polyfill
8. **Avoid prop name conflicts**: Don't use common HTML attribute names as component props

## Future Considerations

### When Native Support is Sufficient

Once browser support reaches ~95% (estimated 2026-2027), consider:

1. Removing the polyfill dependency
2. Conditionally loading the polyfill only for older browsers
3. Potentially switching to `position-area` syntax (simpler than `anchor()` functions)
4. Removing explicit `auto` declarations (native implementation may not require them)

### Alternative Approaches

If the polyfill proves too limiting, alternatives include:

1. **JavaScript positioning libraries**: Floating UI (formerly Popper.js)
2. **CSS-only approaches**: Transform-based positioning (no anchor support)
3. **Hybrid approach**: CSS anchor positioning where supported, JS fallback for older browsers

## Related Documentation

- [Popover Component Documentation](./popover.md)
- [MDN: CSS Anchor Positioning](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_anchor_positioning)
- [@oddbird/css-anchor-positioning Polyfill](https://github.com/oddbird/css-anchor-positioning)
- [Popover API Specification](https://developer.mozilla.org/en-US/docs/Web/API/Popover_API)

## Changelog

### 2025-01-XX - Initial Implementation
- Implemented CSS anchor positioning with polyfill
- Discovered and documented critical requirements
- Established working patterns for fallback positioning
