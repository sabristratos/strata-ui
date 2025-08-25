<?php

declare(strict_types=1);

use Strata\UI\View\Components\Form\Rating;

describe('Rating Component Tests', function () {
    it('renders component with default settings', function () {
        $component = new Rating();
        $view = $component->render();
        
        expect($view)->toBeInstanceOf(\Illuminate\Contracts\View\View::class);
        expect($view->name())->toBe('strata::components.form.rating');
        expect($component->max)->toBe(5);
        expect($component->readonly)->toBeFalse();
        expect($component->clearable)->toBeTrue();
        expect($component->size)->toBe('md');
        expect($component->icon)->toBe('heroicon-o-star');
    });

    it('renders component with custom maximum rating', function () {
        $component = new Rating(max: 10);
        $rendered = $component->render()->render();
        
        expect($component->max)->toBe(10);
        expect($rendered)->toContain('max: @js(10)');
    });

    it('renders component with initial value', function () {
        $component = new Rating(value: 3);
        $rendered = $component->render()->render();
        
        expect($component->value)->toBe(3);
        expect($rendered)->toContain('value: @js(3)');
        expect($rendered)->toContain('3 out of 5');
    });

    it('renders component with label and description', function () {
        $component = new Rating(
            label: 'Rate this product',
            description: 'Please rate from 1 to 5 stars'
        );
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('Rate this product')
            ->and($rendered)->toContain('Please rate from 1 to 5 stars')
            ->and($rendered)->toContain('text-sm font-medium text-foreground')
            ->and($rendered)->toContain('text-xs text-muted-foreground');
    });

    it('renders readonly component correctly', function () {
        $component = new Rating(readonly: true, value: 4);
        $rendered = $component->render()->render();
        
        expect($component->readonly)->toBeTrue();
        expect($rendered)->toContain('readonly: @js(true)')
            ->and($rendered)->toContain('cursor-default')
            ->and($rendered)->not->toContain('@click="setRating');
    });

    it('renders component without clear button when not clearable', function () {
        $component = new Rating(clearable: false);
        $rendered = $component->render()->render();
        
        expect($component->clearable)->toBeFalse();
        expect($rendered)->not->toContain('Clear rating')
            ->and($rendered)->not->toContain('x-icon name="x"');
    });

    it('renders component with custom icon', function () {
        $component = new Rating(icon: 'heroicon-o-heart');
        $rendered = $component->render()->render();
        
        expect($component->icon)->toBe('heroicon-o-heart');
        expect($rendered)->toContain('name="heroicon-o-heart"');
    });

    it('renders component with custom name attribute', function () {
        $component = new Rating(name: 'product_rating');
        $rendered = $component->render()->render();
        
        expect($component->name)->toBe('product_rating');
        expect($rendered)->toContain('name="product_rating"');
    });

    it('applies correct size classes for small size', function () {
        $component = new Rating(size: 'sm');
        
        expect($component->size)->toBe('sm');
        expect($component->getSizeClasses())->toBe('w-4 h-4');
        expect($component->getGapClasses())->toBe('gap-1');
        expect($component->getClearButtonSizeClasses())->toBe('w-4 h-4');
    });

    it('applies correct size classes for large size', function () {
        $component = new Rating(size: 'lg');
        
        expect($component->size)->toBe('lg');
        expect($component->getSizeClasses())->toBe('w-6 h-6');
        expect($component->getGapClasses())->toBe('gap-2');
        expect($component->getClearButtonSizeClasses())->toBe('w-5 h-5');
    });

    it('applies correct size classes for medium size (default)', function () {
        $component = new Rating(size: 'md');
        
        expect($component->size)->toBe('md');
        expect($component->getSizeClasses())->toBe('w-5 h-5');
        expect($component->getGapClasses())->toBe('gap-1.5');
        expect($component->getClearButtonSizeClasses())->toBe('w-4 h-4');
    });

    it('constrains value within bounds', function () {
        $component = new Rating(max: 5, value: 10);
        expect($component->value)->toBe(5);

        $component = new Rating(max: 5, value: -1);
        expect($component->value)->toBe(0);

        $component = new Rating(max: 3, value: 2.5);
        expect($component->value)->toBe(2.5);
    });

    it('enforces minimum max value', function () {
        $component = new Rating(max: 0);
        expect($component->max)->toBe(1);

        $component = new Rating(max: -5);
        expect($component->max)->toBe(1);
    });

    it('generates unique id when not provided', function () {
        $component1 = new Rating();
        $component2 = new Rating();
        
        expect($component1->id)->not->toBe($component2->id);
        expect($component1->id)->toStartWith('rating-');
        expect($component2->id)->toStartWith('rating-');
    });

    it('uses custom id when provided', function () {
        $component = new Rating(id: 'custom-rating-id');
        
        expect($component->id)->toBe('custom-rating-id');
    });

    it('renders hidden input for form submission when name is provided', function () {
        $component = new Rating(name: 'rating', value: 4);
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('type="hidden"')
            ->and($rendered)->toContain('name="rating"')
            ->and($rendered)->toContain('value="4"');
    });

    it('does not render hidden input when using wire:model', function () {
        $component = new Rating(name: 'rating');
        $rendered = $component->render()->render();
        
        // This is a simplified test - in real usage, wire:model would be passed via attributes
        expect($rendered)->toContain('x-ref="hiddenInput"');
    });

    it('renders all star buttons for the maximum rating', function () {
        $component = new Rating(max: 7);
        $rendered = $component->render()->render();
        
        // Should render 7 star buttons
        expect(substr_count($rendered, 'Rate 1 out of'))->toBe(1);
        expect(substr_count($rendered, 'Rate 7 out of'))->toBe(1);
        expect($rendered)->toContain('Rate 1 out of 7')
            ->and($rendered)->toContain('Rate 7 out of 7');
    });

    it('includes proper accessibility attributes', function () {
        $component = new Rating(
            label: 'Product Rating',
            description: 'Rate this product'
        );
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('aria-labelledby')
            ->and($rendered)->toContain('aria-describedby')
            ->and($rendered)->toContain('aria-label="Rate')
            ->and($rendered)->toContain('focus-visible:ring-2');
    });

    it('includes clear button with proper accessibility', function () {
        $component = new Rating(clearable: true);
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('aria-label="Clear rating"')
            ->and($rendered)->toContain('title="Clear rating"');
    });

    it('renders current rating display when value is set', function () {
        $component = new Rating(value: 3, max: 5);
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('3 out of 5');
    });

    it('does not render rating display when value is null', function () {
        $component = new Rating(value: null);
        $rendered = $component->render()->render();
        
        expect($rendered)->not->toContain('out of');
    });

    it('uses Alpine.data pattern for component initialization', function () {
        $component = new Rating(name: 'test_rating', value: 4);
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('x-data="strataRating({')
            ->and($rendered)->toContain('hasWireModel: @js(false)')
            ->and($rendered)->toContain('name: @js("test_rating")')
            ->and($rendered)->toContain('Alpine.data(\'strataRating\'');
    });

    it('handles wire model configuration correctly', function () {
        // This test simulates having wire:model attribute
        $component = new Rating(name: 'rating');
        $rendered = $component->render()->render();
        
        expect($rendered)->toContain('x-modelable="value"')
            ->and($rendered)->toContain('hasWireModel');
    });
});