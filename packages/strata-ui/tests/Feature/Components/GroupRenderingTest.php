<?php

describe('Group Component', function () {
    test('renders with horizontal orientation by default', function () {
        expectComponent($this, 'group', slot: '<button>One</button><button>Two</button>')
            ->toHaveTag('div')
            ->toHaveClasses('flex', 'flex-row')
            ->toRenderSlot('One')
            ->toRenderSlot('Two');
    });

    test('renders with vertical orientation', function () {
        expectComponent($this, 'group', ['orientation' => 'vertical'], '<button>One</button><button>Two</button>')
            ->toHaveClasses('flex', 'flex-col');
    });

    test('horizontal orientation removes right borders except last', function () {
        expectComponent($this, 'group', ['orientation' => 'horizontal'], '<button>One</button>')
            ->toContain('[&amp;&gt;*]:border-r-0')
            ->toContain('[&amp;&gt;*:last-child]:border-r-2');
    });

    test('horizontal orientation removes rounded corners for middle items', function () {
        expectComponent($this, 'group', ['orientation' => 'horizontal'], '<button>One</button>')
            ->toContain('[&amp;&gt;*:not(:first-child)]:rounded-l-none')
            ->toContain('[&amp;&gt;*:not(:last-child)]:rounded-r-none');
    });

    test('vertical orientation removes bottom borders except last', function () {
        expectComponent($this, 'group', ['orientation' => 'vertical'], '<button>One</button>')
            ->toContain('[&amp;&gt;*]:border-b-0')
            ->toContain('[&amp;&gt;*:last-child]:border-b-2');
    });

    test('vertical orientation removes rounded corners for middle items', function () {
        expectComponent($this, 'group', ['orientation' => 'vertical'], '<button>One</button>')
            ->toContain('[&amp;&gt;*:not(:first-child)]:rounded-t-none')
            ->toContain('[&amp;&gt;*:not(:last-child)]:rounded-b-none');
    });

    test('merges custom classes', function () {
        expectComponent($this, 'group', ['class' => 'custom-class'], '<button>Test</button>')
            ->toHaveClasses('custom-class', 'flex', 'flex-row');
    });

    test('renders multiple children', function () {
        expectComponent($this, 'group', slot: '<button>One</button><button>Two</button><button>Three</button>')
            ->toRenderSlot('One')
            ->toRenderSlot('Two')
            ->toRenderSlot('Three');
    });
});
