<?php

if (! function_exists('expectComponent')) {
    function expectComponent(mixed $testOrComponent, mixed $componentOrAttributes = null, mixed $attributesOrSlot = [], string $slot = ''): \Pest\Expectation
    {
        // Support both signatures: expectComponent('button', [...]) and expectComponent($this, 'button', [...])
        if (is_string($testOrComponent) && (is_array($componentOrAttributes) || is_string($componentOrAttributes) || $componentOrAttributes === null)) {
            // New signature: expectComponent('button', $attributes, $slot)
            $test = test();
            $componentName = $testOrComponent;
            $attributes = is_array($componentOrAttributes) ? $componentOrAttributes : [];
            $actualSlot = is_string($componentOrAttributes) ? $componentOrAttributes : (is_string($attributesOrSlot) ? $attributesOrSlot : '');
            if (is_array($componentOrAttributes) && ! empty($attributesOrSlot)) {
                $actualSlot = is_string($attributesOrSlot) ? $attributesOrSlot : $slot;
            }
        } else {
            // Old signature: expectComponent($this, 'button', $attributes, $slot)
            $test = $testOrComponent;
            $componentName = $componentOrAttributes;
            $attributes = is_array($attributesOrSlot) ? $attributesOrSlot : [];
            $actualSlot = $slot;
        }

        $rendered = $test->renderComponent($componentName, $attributes, $actualSlot);

        return expect($rendered);
    }
}
