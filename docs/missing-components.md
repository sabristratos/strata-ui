# Missing Components Checklist

This document tracks components that are missing from Strata UI compared to comprehensive UI libraries.

## Form Components

### Input Variants
- [ ] Date Picker
- [x] Time Picker
- [ ] Date Range Picker
- [ ] Color Picker
- [ ] Range Slider (dual handles)
- [ ] Switch (if different from Toggle)
- [ ] Pin Input / OTP Input
- [ ] Combobox
- [ ] Multi-Select (if not in Select)
- [ ] Autocomplete
- [ ] Search Input (with clear/search icons)
- [ ] Password Input (with visibility toggle)
- [ ] Number Input (with increment/decrement)
- [ ] Phone Input (with country codes)

## Layout Components

- [ ] Grid
- [ ] Stack
- [ ] Container
- [ ] Spacer
- [ ] Divider (check if Separator covers this)
- [ ] Aspect Ratio

## Navigation Components

- [ ] Tabs
- [ ] Pagination
- [ ] Stepper / Steps
- [ ] Menu (check if Dropdown covers this)
- [ ] Command Palette
- [ ] Navigation Menu
- [ ] Link

## Overlay Components

- [ ] Dialog (check if Modal covers this)
- [ ] Drawer / Sheet
- [ ] Popconfirm
- [ ] Context Menu

## Feedback Components

- [ ] Progress Bar
- [ ] Spinner / Loading
- [ ] Skeleton
- [ ] Empty State
- [ ] Error Boundary

## Data Display Components

- [ ] Accordion
- [ ] Collapsible
- [ ] Stat / Metric Card
- [ ] Timeline
- [ ] Tree View
- [ ] Data List / Description List
- [ ] Code Block
- [ ] Blockquote (check if in Prose)

## Media Components

- [ ] Video Player
- [ ] Audio Player
- [ ] Carousel (check if Slider covers this)
- [ ] Gallery

## Advanced Components

- [ ] Chart (may be out of scope)
- [ ] Map (may be out of scope)
- [ ] Full Calendar (check current calendar features)
- [ ] Gantt Chart (likely out of scope)
- [ ] Kanban Board (likely out of scope)

## Utility Components

- [ ] Portal / Teleport
- [ ] Focus Trap
- [ ] Scroll Area
- [ ] Resizable
- [ ] Sortable
- [ ] Draggable
- [ ] Virtual Scroller

## Missing Implementation (Documented)

- [ ] Repeater (documented but not implemented)

---

## Priority Levels

### High Priority (Common in most UI libraries)
Components that should be implemented first:

- [ ] Date Picker
- [x] Time Picker
- [ ] Date Range Picker
- [ ] Tabs
- [ ] Accordion
- [ ] Pagination
- [ ] Stepper
- [ ] Progress Bar
- [ ] Spinner / Loading
- [ ] Drawer / Sheet
- [ ] Search Input
- [ ] Password Input

### Medium Priority (Nice to have)
Components to implement after high priority:

- [ ] Color Picker
- [ ] Pin Input / OTP Input
- [ ] Command Palette
- [ ] Context Menu
- [ ] Skeleton
- [ ] Empty State
- [ ] Collapsible
- [ ] Timeline
- [ ] Scroll Area
- [ ] Number Input
- [ ] Phone Input

### Low Priority (Advanced/Niche)
Components for future consideration:

- [ ] Charts
- [ ] Maps
- [ ] Kanban Board
- [ ] Virtual Scroller
- [ ] Sortable / Draggable
- [ ] Video / Audio Players
- [ ] Gantt Chart

---

## Notes

- Some components may already exist under different names (e.g., Switch vs Toggle, Dialog vs Modal)
- Check existing components before implementing to avoid duplication
- Follow the testing strategy: write tests first, then implement
- Use established patterns: Entangleable for state sync, Positionable for floating elements
- All components should have: implementation + tests + documentation
