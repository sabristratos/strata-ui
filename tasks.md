# Strata UI Improvement Tasks

A comprehensive checklist of improvements to make the package maintainable, flexible, and consistent while avoiding over-engineering.

---

## P0 - Critical Bugs (Fix Immediately)

### JavaScript Module Bugs
- [x] **Fix Popover positioning strategy** - Change from 'fixed' to 'absolute' per CLAUDE.md guidelines
  `packages/strata-ui/resources/views/components/popover/index.blade.php:36`

- [x] **Fix Entangleable watcher bug** - Capture old value before updating to pass correct values to watchers
  `packages/strata-ui/resources/js/entangleable.js:68`
  Current: `this.value = value; this.notifyWatchers(value, this.value);` (both are same!)
  Should: `const oldValue = this.value; this.value = value; this.notifyWatchers(value, oldValue);`

- [x] **Fix Entangleable to allow false/0 values** - Current check blocks legitimate false/0 values from Livewire
  `packages/strata-ui/resources/js/entangleable.js:42`
  Current: `if (serverValue !== undefined && serverValue !== null)`
  Should: `if (serverValue !== undefined)`

---

## P1 - Code Quality & Compliance (High Priority)

### Remove Comments (Violates CLAUDE.md Rules)
- [x] **Remove console.log from strata.js**
  `packages/strata-ui/resources/js/strata.js:12`

- [x] **Remove Blade comments from file-input component**
  `packages/strata-ui/resources/views/components/file-input/index.blade.php`
  - Line 211: `{{-- Gallery layout for images --}}`
  - Line 222: `{{-- Overlay with file info on hover --}}`
  - Line 235: `{{-- Action buttons --}}`
  - Line 264: `{{-- List layout for documents --}}`

### Consistency Fixes
- [x] **Add data-strata-field-type to remaining form components**
  Currently missing in:
  - `packages/strata-ui/resources/views/components/calendar/index.blade.php`
  - `packages/strata-ui/resources/views/components/date-picker/index.blade.php`
  - `packages/strata-ui/resources/views/components/file-input/index.blade.php`

---

## P2 - Consistency & Architecture (Medium Priority)

### Animation Standardization
- [x] **Standardize animation timing across all positioned components**
  Use consistent values: `duration-150`, `ease-out` for all dropdowns, selects, popovers, modals, etc.
  Check components: dropdown, select, date-picker, popover, modal

### Lifecycle Management
- [x] **Add destroy() method to Entangleable**
  Properly clean up watchers and Livewire listeners when components unmount
  `packages/strata-ui/resources/js/entangleable.js`

- [x] **Add destroy() method to Positionable**
  Clean up Floating UI instances and event listeners
  `packages/strata-ui/resources/js/positionable.js`
  **Note:** Already implemented correctly (lines 136-142)

### Code Cleanup
- [x] **Review unused Positionable methods**
  Either remove unused methods OR document as public API:
  - `openIfClosed()` (line 95) - only used in Select - **KEPT**
  - `isOpen()` / `isClosed()` (lines 113-119) - never used - **REMOVED**

  `packages/strata-ui/resources/js/positionable.js`

### Documentation Improvements
- [x] **Update CLAUDE.md with data-strata-\* conventions**
  Document the standard: `data-strata-{component}`, `data-strata-{component}-wrapper`, `data-strata-field-type`

- [x] **Add decision matrix to CLAUDE.md**
  When to use Entangleable vs direct wire:model:
  - Simple single-value = direct wire:model (checkbox, radio, toggle, input, textarea)
  - Complex state/multi-select = Entangleable (select, calendar, date-picker, rating)

---

## P3 - Nice to Have (Low Priority)

### Build Optimization
- [ ] **Add cache busting to Vite config for production** (DEFERRED)
  Consider using `[name].[hash].js` instead of `[name].js` for better cache invalidation
  `packages/strata-ui/vite.config.js`
  **Status:** Deferred - requires manifest reading implementation and testing. Can be tackled separately if needed for production.

### Code Review
- [x] **Review CSS anchor positioning styles**
  Lines 20-227 in `packages/strata-ui/resources/css/strata.css` might be redundant with JS polyfill
  Confirm if both are needed or if JS polyfill handles everything
  **Result:** Confirmed NOT needed. All components use Floating UI instead. Removed:
  - `@oddbird/css-anchor-positioning` npm package
  - Polyfill import and call from strata.js
  - 208 lines of unused CSS anchor positioning styles
  - Bundle reduced by ~15KB

---

## Future Enhancements (Optional - For Reference)

Common UI components not yet implemented (if needed for your marketing sites/apps):

**Navigation & Layout:**
- [ ] Tabs / Tab List
- [ ] Breadcrumbs
- [ ] Pagination
- [ ] Stepper / Multi-step Form

**Feedback & Overlays:**
- [ ] Toast / Notification
- [ ] Tooltip
- [ ] Progress Bar / Spinner
- [ ] Skeleton Loader

**Advanced Inputs:**
- [ ] Slider / Range Input
- [ ] Combobox (Autocomplete)
- [ ] Command Palette
- [ ] Color Picker
- [ ] Date Range Picker (if calendar doesn't cover it)

**Data Display:**
- [ ] Data Table with sorting/filtering/pagination
- [ ] Tree View
- [ ] Timeline

**Interactions:**
- [ ] Context Menu
- [ ] Drag & Drop utilities

---

## Notes

- **Total Core Tasks**: 14 actionable items across P0-P3
- **Philosophy**: Maintain simplicity, avoid over-engineering, prioritize maintainability
- **Testing Strategy**: Test Livewire integration via demo components on welcome page
- **Before Committing**: Always run `vendor/bin/pint` for code style compliance