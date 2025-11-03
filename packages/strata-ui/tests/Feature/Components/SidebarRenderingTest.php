<?php

describe('Sidebar Component', function () {
    test('renders with default props', function () {
        expectComponent($this, 'sidebar', slot: '<nav>Content</nav>')
            ->toHaveTag('aside')
            ->toContain('role="navigation"')
            ->toContain('aria-label="Main navigation"')
            ->toContain('data-strata-sidebar')
            ->toHaveClasses('fixed', 'inset-y-0', 'z-40', 'bg-sidebar', 'text-sidebar-foreground')
            ->toRenderSlot('<nav>Content</nav>');
    });

    test('renders with persistent variant', function () {
        expectComponent($this, 'sidebar', ['variant' => 'persistent'], 'Content')
            ->toContain('variant: "persistent"');
    });

    test('renders with mini variant', function () {
        expectComponent($this, 'sidebar', ['variant' => 'mini'], 'Content')
            ->toContain('variant: "mini"');
    });

    test('renders all width sizes', function () {
        expectComponent($this, 'sidebar', ['width' => 'sm'], 'Content')
            ->toHaveClasses('w-60');

        expectComponent($this, 'sidebar', ['width' => 'md'], 'Content')
            ->toHaveClasses('w-70');

        expectComponent($this, 'sidebar', ['width' => 'lg'], 'Content')
            ->toHaveClasses('w-80');
    });

    test('renders all collapsed width sizes', function () {
        expectComponent($this, 'sidebar', ['collapsedWidth' => 'sm'], 'Content')
            ->toHaveClasses('w-12');

        expectComponent($this, 'sidebar', ['collapsedWidth' => 'md'], 'Content')
            ->toHaveClasses('w-16');
    });

    test('renders with left position', function () {
        expectComponent($this, 'sidebar', ['position' => 'left'], 'Content')
            ->toHaveClasses('left-0', 'border-e')
            ->toContain('position: "left"');
    });

    test('renders with right position', function () {
        expectComponent($this, 'sidebar', ['position' => 'right'], 'Content')
            ->toHaveClasses('right-0', 'border-s')
            ->toContain('position: "right"');
    });

    test('renders with custom ID', function () {
        expectComponent($this, 'sidebar', ['id' => 'custom-sidebar'], 'Content')
            ->toContain('id="custom-sidebar"')
            ->toContain('data-sidebar-id="custom-sidebar"');
    });

    test('renders with auto-generated ID', function () {
        expectComponent($this, 'sidebar', [], 'Content')
            ->toContain('data-sidebar-id="sidebar-');
    });

    test('renders with defaultOpen state', function () {
        expectComponent($this, 'sidebar', ['defaultOpen' => true], 'Content')
            ->toContain('defaultOpen: true');

        expectComponent($this, 'sidebar', ['defaultOpen' => false], 'Content')
            ->toContain('defaultOpen: false');
    });

    test('renders with defaultCollapsed state', function () {
        expectComponent($this, 'sidebar', ['defaultCollapsed' => true], 'Content')
            ->toContain('defaultCollapsed: true');

        expectComponent($this, 'sidebar', ['defaultCollapsed' => false], 'Content')
            ->toContain('defaultCollapsed: false');
    });

    test('renders with overlay backdrop', function () {
        expectComponent($this, 'sidebar', ['overlay' => true], 'Content')
            ->toContain('backdrop-blur-sm');
    });

    test('renders without overlay when disabled', function () {
        $result = expectComponent($this, 'sidebar', ['overlay' => false], 'Content');

        expect($result->html)->not->toContain('backdrop-blur-sm');
    });

    test('has alpine.js integration', function () {
        expectComponent($this, 'sidebar', [], 'Content')
            ->toContain('x-data="strataSidebar')
            ->toContain('Alpine.data(\'strataSidebar\'');
    });

    test('has proper ARIA attributes', function () {
        expectComponent($this, 'sidebar', [], 'Content')
            ->toContain('role="navigation"')
            ->toContain('aria-label="Main navigation"')
            ->toContain(':aria-expanded')
            ->toContain(':aria-hidden');
    });

    test('merges custom classes correctly', function () {
        expectComponent($this, 'sidebar', ['class' => 'custom-class'], 'Content')
            ->toHaveClasses('custom-class', 'fixed', 'inset-y-0');
    });

    test('includes transition and animation classes', function () {
        expectComponent($this, 'sidebar', [], 'Content')
            ->toHaveClasses('transition-all', 'duration-300', 'ease-out', 'will-change-transform');
    });

    test('overlay uses CSS starting-style animation', function () {
        expectComponent($this, 'sidebar', ['overlay' => true], 'Content')
            ->toContain('transition-discrete')
            ->toContain('starting:opacity-0');
    });
});

describe('Sidebar.Nav Component', function () {
    test('renders with default props', function () {
        expectComponent($this, 'sidebar.nav', slot: '<a href="/">Link</a>')
            ->toHaveTag('nav')
            ->toContain('data-strata-sidebar-nav')
            ->toContain('aria-label="Sidebar navigation"')
            ->toHaveClasses('flex-1', 'overflow-y-auto', 'px-3', 'py-4')
            ->toRenderSlot('<a href="/">Link</a>');
    });

    test('merges custom classes correctly', function () {
        expectComponent($this, 'sidebar.nav', ['class' => 'custom-nav'], 'Content')
            ->toHaveClasses('custom-nav', 'flex-1');
    });
});

describe('Sidebar.Item Component', function () {
    test('renders as link with href', function () {
        expectComponent($this, 'sidebar.item', ['href' => '/dashboard'], 'Dashboard')
            ->toHaveTag('a')
            ->toContain('href="/dashboard"')
            ->toContain('data-strata-sidebar-item')
            ->toRenderSlot('Dashboard');
    });

    test('renders as button without href', function () {
        expectComponent($this, 'sidebar.item', slot: 'Button Item')
            ->toHaveTag('button')
            ->not->toContain('href=')
            ->toRenderSlot('Button Item');
    });

    test('renders active state', function () {
        expectComponent($this, 'sidebar.item', ['active' => true], 'Active')
            ->toContain('aria-current="page"')
            ->toHaveClasses('bg-sidebar-active', 'text-sidebar-active-foreground');
    });

    test('renders inactive state', function () {
        expectComponent($this, 'sidebar.item', ['active' => false], 'Inactive')
            ->toHaveClasses('text-sidebar-foreground', 'hover:bg-sidebar-hover')
            ->not->toContain('aria-current');
    });

    test('renders with icon', function () {
        expectComponent($this, 'sidebar.item', ['icon' => 'home'], 'Home')
            ->toContain('data-strata-sidebar-item-icon')
            ->toContain('<x-strata::icon :name="home"');
    });

    test('renders with badge', function () {
        expectComponent($this, 'sidebar.item', ['badge' => '5'], 'Messages')
            ->toContain('data-strata-sidebar-item-badge')
            ->toContain('<x-strata::badge');
    });

    test('renders with badge variant', function () {
        expectComponent($this, 'sidebar.item', ['badge' => '3', 'badgeVariant' => 'destructive'], 'Alerts')
            ->toContain(':variant="destructive"');
    });

    test('renders with target attribute', function () {
        expectComponent($this, 'sidebar.item', ['href' => 'https://example.com', 'target' => '_blank'], 'External')
            ->toContain('target="_blank"');
    });

    test('has proper base classes', function () {
        expectComponent($this, 'sidebar.item', slot: 'Item')
            ->toHaveClasses('flex', 'items-center', 'gap-3', 'w-full', 'px-3', 'py-2', 'text-sm', 'rounded-md')
            ->toHaveClasses('transition-all', 'duration-150');
    });

    test('has focus-visible styles', function () {
        expectComponent($this, 'sidebar.item', slot: 'Item')
            ->toContain('focus-visible:outline-none')
            ->toContain('focus-visible:ring-2');
    });

    test('uses CSS starting-style animation', function () {
        expectComponent($this, 'sidebar.item', slot: 'Item')
            ->toContain('transition-discrete')
            ->toContain('starting:opacity-0');
    });

    test('has search filtering integration', function () {
        expectComponent($this, 'sidebar.item', slot: 'Dashboard')
            ->toContain('x-show="filterItems(');
    });
});

describe('Sidebar.Group Component', function () {
    test('renders as details element', function () {
        expectComponent($this, 'sidebar.group', ['title' => 'Settings'], '<a>Link</a>')
            ->toHaveTag('details')
            ->toContain('data-strata-sidebar-group')
            ->toRenderSlot('<a>Link</a>');
    });

    test('renders summary with title', function () {
        expectComponent($this, 'sidebar.group', ['title' => 'Settings'], 'Content')
            ->toHaveTag('summary')
            ->toContain('data-strata-sidebar-group-trigger')
            ->toContain('Settings');
    });

    test('renders with icon', function () {
        expectComponent($this, 'sidebar.group', ['title' => 'Settings', 'icon' => 'settings'], 'Content')
            ->toContain('data-strata-sidebar-group-icon')
            ->toContain('<svg');
    });

    test('renders with badge', function () {
        expectComponent($this, 'sidebar.group', ['title' => 'Notifications', 'badge' => '10'], 'Content')
            ->toContain('<span')
            ->toContain('10');
    });

    test('renders with badge variant', function () {
        expectComponent($this, 'sidebar.group', ['title' => 'Notifications', 'badge' => '5', 'badgeVariant' => 'info'], 'Content')
            ->toContain('5');
    });

    test('renders with defaultExpanded state', function () {
        expectComponent($this, 'sidebar.group', ['title' => 'Group', 'defaultExpanded' => true], 'Content')
            ->toContain('|| true');
    });

    test('renders with custom ID', function () {
        expectComponent($this, 'sidebar.group', ['id' => 'custom-group'], 'Content')
            ->toContain('data-group-id="custom-group"')
            ->toContain("groupId: 'custom-group'");
    });

    test('renders with auto-generated ID', function () {
        expectComponent($this, 'sidebar.group', ['title' => 'Group'], 'Content')
            ->toContain('data-group-id="sidebar-group-');
    });

    test('has native details functionality', function () {
        expectComponent($this, 'sidebar.group', ['title' => 'Group'], 'Content')
            ->toContain('x-on:toggle="handleToggle')
            ->toContain('aria-controls');
    });

    test('has localStorage integration', function () {
        expectComponent($this, 'sidebar.group', ['title' => 'Group'], 'Content')
            ->toContain('localStorage.getItem')
            ->toContain('localStorage.setItem');
    });

    test('has chevron icon for expansion', function () {
        expectComponent($this, 'sidebar.group', ['title' => 'Group'], 'Content')
            ->toContain('data-strata-sidebar-group-chevron')
            ->toContain('<x-strata::icon.chevron-right');
    });

    test('has content wrapper with conditional padding', function () {
        expectComponent($this, 'sidebar.group', ['title' => 'Group'], 'Content')
            ->toContain('data-strata-sidebar-group-content')
            ->toContain(':class="collapsed ? \'\' : \'pl-6\'"');
    });

    test('has aria-expanded attribute', function () {
        expectComponent($this, 'sidebar.group', ['title' => 'Group'], 'Content')
            ->toContain(':aria-expanded="isOpen.toString()"');
    });

    test('uses CSS starting-style animation', function () {
        expectComponent($this, 'sidebar.group', ['title' => 'Group'], 'Content')
            ->toContain('transition-discrete')
            ->toContain('starting:opacity-0');
    });

    test('has search filtering integration', function () {
        expectComponent($this, 'sidebar.group', ['title' => 'Group'], 'Content')
            ->toContain('hasVisibleChildren')
            ->toContain('x-show="hasVisibleChildren"');
    });
});

describe('Sidebar.Section Component', function () {
    test('renders with title', function () {
        expectComponent($this, 'sidebar.section', ['title' => 'Administration'], 'Content')
            ->toContain('data-strata-sidebar-section')
            ->toContain('data-strata-sidebar-section-header')
            ->toContain('Administration')
            ->toRenderSlot('Content');
    });

    test('renders without title', function () {
        $result = expectComponent($this, 'sidebar.section', [], 'Content');

        expect($result->html)->not->toContain('data-strata-sidebar-section-header');
    });

    test('renders with divider', function () {
        expectComponent($this, 'sidebar.section', ['divider' => true], 'Content')
            ->toContain('<x-strata::separator');
    });

    test('renders without divider by default', function () {
        $result = expectComponent($this, 'sidebar.section', [], 'Content');

        expect($result->html)->not->toContain('<x-strata::separator');
    });

    test('has proper spacing', function () {
        expectComponent($this, 'sidebar.section', [], 'Content')
            ->toHaveClasses('space-y-1');
    });
});

describe('Sidebar.Header Component', function () {
    test('renders with default props', function () {
        expectComponent($this, 'sidebar.header', slot: '<div>Logo</div>')
            ->toContain('data-strata-sidebar-header')
            ->toHaveClasses('flex-shrink-0', 'border-b', 'px-3', 'py-4')
            ->toRenderSlot('<div>Logo</div>');
    });

    test('renders with search', function () {
        expectComponent($this, 'sidebar.header', ['search' => true], 'Logo')
            ->toContain('data-strata-sidebar-search')
            ->toContain('<x-strata::input')
            ->toContain('type="search"')
            ->toContain('x-model="searchQuery"')
            ->toContain('role="search"');
    });

    test('renders with custom search placeholder', function () {
        expectComponent($this, 'sidebar.header', ['search' => true, 'searchPlaceholder' => 'Find items...'], 'Logo')
            ->toContain(':placeholder="Find items..."');
    });

    test('renders with close button by default', function () {
        expectComponent($this, 'sidebar.header', [], 'Logo')
            ->toContain('data-strata-sidebar-close')
            ->toContain('aria-label="Close sidebar"');
    });

    test('hides close button when disabled', function () {
        $result = expectComponent($this, 'sidebar.header', ['close' => false], 'Logo');

        expect($result->html)->not->toContain('data-strata-sidebar-close');
    });

    test('uses CSS starting-style animation for collapsible elements', function () {
        expectComponent($this, 'sidebar.header', ['search' => true], 'Logo')
            ->toContain('transition-discrete')
            ->toContain('starting:opacity-0');
    });
});

describe('Sidebar.Footer Component', function () {
    test('renders with default props', function () {
        expectComponent($this, 'sidebar.footer', slot: '<div>Profile</div>')
            ->toContain('data-strata-sidebar-footer')
            ->toHaveClasses('flex-shrink-0', 'border-t', 'px-3', 'py-4')
            ->toRenderSlot('<div>Profile</div>');
    });

    test('merges custom classes correctly', function () {
        expectComponent($this, 'sidebar.footer', ['class' => 'custom-footer'], 'Content')
            ->toHaveClasses('custom-footer', 'flex-shrink-0');
    });

    test('uses CSS starting-style animation', function () {
        expectComponent($this, 'sidebar.footer', slot: 'Content')
            ->toContain('transition-discrete')
            ->toContain('starting:opacity-0');
    });
});

describe('Sidebar.Toggle Component', function () {
    test('renders with default props', function () {
        expectComponent($this, 'sidebar.toggle')
            ->toHaveTag('button')
            ->toContain('data-strata-sidebar-toggle')
            ->toContain('type="button"')
            ->toContain(':aria-label');
    });

    test('renders with target sidebar ID', function () {
        expectComponent($this, 'sidebar.toggle', ['target' => 'main-sidebar'])
            ->toContain('data-sidebar-id=\'main-sidebar\'');
    });

    test('renders hamburger variant', function () {
        expectComponent($this, 'sidebar.toggle', ['variant' => 'hamburger'])
            ->toContain('variant) === \'hamburger\'');
    });

    test('renders collapse variant', function () {
        expectComponent($this, 'sidebar.toggle', ['variant' => 'collapse'])
            ->toContain('variant) === \'collapse\'');
    });

    test('renders auto variant', function () {
        expectComponent($this, 'sidebar.toggle', ['variant' => 'auto'])
            ->toContain('variant) === \'auto\'');
    });

    test('has proper button classes', function () {
        expectComponent($this, 'sidebar.toggle')
            ->toHaveClasses('p-2', 'rounded-md', 'hover:bg-sidebar-hover')
            ->toContain('focus-visible:outline-none');
    });

    test('renders custom slot content', function () {
        expectComponent($this, 'sidebar.toggle', slot: '<span>Menu</span>')
            ->toRenderSlot('<span>Menu</span>');
    });

    test('uses icon components instead of inline SVG', function () {
        expectComponent($this, 'sidebar.toggle')
            ->toContain('<x-strata::icon.menu')
            ->toContain('<x-strata::icon.chevrons-left');
    });
});
