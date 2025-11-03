import { describe, it, expect, beforeEach, vi } from 'vitest';
import Positionable from '../../resources/js/positionable.js';

vi.mock('@floating-ui/dom', () => ({
    computePosition: vi.fn(() => Promise.resolve({ x: 100, y: 200, placement: 'bottom-start', middlewareData: {} })),
    autoUpdate: vi.fn((ref, float, update, options) => {
        const cleanup = vi.fn();
        return cleanup;
    }),
    offset: vi.fn((value) => ({ name: 'offset', fn: () => ({}) })),
    flip: vi.fn((options) => ({ name: 'flip', fn: () => ({}) })),
    shift: vi.fn((options) => ({ name: 'shift', fn: () => ({}) })),
    size: vi.fn((options) => ({ name: 'size', fn: () => ({}) })),
    arrow: vi.fn((options) => ({ name: 'arrow', fn: () => ({}) })),
    hide: vi.fn((options) => ({ name: 'hide', fn: () => ({}) })),
    autoPlacement: vi.fn((options) => ({ name: 'autoPlacement', fn: () => ({}) })),
    inline: vi.fn((options) => ({ name: 'inline', fn: () => ({}) })),
    limitShift: vi.fn(() => ({ name: 'limitShift', fn: () => ({}) }))
}));

describe('Positionable', () => {
    let positionable;
    let mockComponent;
    let mockReference;
    let mockFloating;

    beforeEach(() => {
        Positionable.instances.clear();

        mockComponent = {
            $el: document.createElement('div'),
            $nextTick: vi.fn((cb) => cb()),
            $watch: vi.fn()
        };

        mockReference = document.createElement('button');
        mockFloating = document.createElement('div');

        global.window = global.window || {};
        global.window.innerWidth = 1024;

        positionable = new Positionable();
    });

    describe('constructor', () => {
        it('initializes with default config', () => {
            expect(positionable.config.placement).toBe('bottom-start');
            expect(positionable.config.offset).toBe(8);
            expect(positionable.config.strategy).toBe('absolute');
            expect(positionable.config.padding).toBe(5);
        });

        it('accepts custom placement config', () => {
            const p = new Positionable({ placement: 'top-end' });
            expect(p.config.placement).toBe('top-end');
        });

        it('accepts custom offset config', () => {
            const p = new Positionable({ offset: 16 });
            expect(p.config.offset).toBe(16);
        });

        it('accepts 0 as valid offset', () => {
            const p = new Positionable({ offset: 0 });
            expect(p.config.offset).toBe(0);
        });

        it('accepts custom strategy config', () => {
            const p = new Positionable({ strategy: 'fixed' });
            expect(p.config.strategy).toBe('fixed');
        });

        it('initializes size middleware options disabled by default', () => {
            expect(positionable.config.enableSize).toBe(false);
            expect(positionable.config.matchReferenceWidth).toBe(false);
            expect(positionable.config.maxHeight).toBe(false);
            expect(positionable.config.sizeApply).toBeNull();
        });

        it('accepts size middleware config', () => {
            const p = new Positionable({
                enableSize: true,
                matchReferenceWidth: true,
                maxHeight: true
            });
            expect(p.config.enableSize).toBe(true);
            expect(p.config.matchReferenceWidth).toBe(true);
            expect(p.config.maxHeight).toBe(true);
        });

        it('initializes arrow middleware options disabled by default', () => {
            expect(positionable.config.arrowElement).toBeNull();
            expect(positionable.config.arrowPadding).toBe(5);
        });

        it('accepts arrow middleware config', () => {
            const arrowEl = document.createElement('div');
            const p = new Positionable({
                arrowElement: arrowEl,
                arrowPadding: 10
            });
            expect(p.config.arrowElement).toBe(arrowEl);
            expect(p.config.arrowPadding).toBe(10);
        });

        it('accepts 0 as valid arrow padding', () => {
            const p = new Positionable({ arrowPadding: 0 });
            expect(p.config.arrowPadding).toBe(0);
        });

        it('initializes hide middleware options disabled by default', () => {
            expect(positionable.config.enableHide).toBe(false);
            expect(positionable.config.hideStrategy).toBe('referenceHidden');
        });

        it('accepts hide middleware config', () => {
            const p = new Positionable({
                enableHide: true,
                hideStrategy: 'escaped'
            });
            expect(p.config.enableHide).toBe(true);
            expect(p.config.hideStrategy).toBe('escaped');
        });

        it('initializes advanced options with defaults', () => {
            expect(positionable.config.boundary).toBeUndefined();
            expect(positionable.config.useAutoPlacement).toBe(false);
            expect(positionable.config.enableInline).toBe(false);
            expect(positionable.config.limitShiftEnabled).toBe(false);
            expect(positionable.config.customMiddleware).toEqual([]);
        });

        it('accepts advanced config options', () => {
            const boundary = document.createElement('div');
            const customMw = [{ name: 'custom' }];
            const p = new Positionable({
                boundary: boundary,
                useAutoPlacement: true,
                enableInline: true,
                limitShiftEnabled: true,
                customMiddleware: customMw
            });
            expect(p.config.boundary).toBe(boundary);
            expect(p.config.useAutoPlacement).toBe(true);
            expect(p.config.enableInline).toBe(true);
            expect(p.config.limitShiftEnabled).toBe(true);
            expect(p.config.customMiddleware).toBe(customMw);
        });

        it('initializes autoUpdateOptions with defaults', () => {
            expect(positionable.config.autoUpdateOptions).toEqual({
                ancestorScroll: true,
                ancestorResize: true,
                elementResize: true,
                layoutShift: true,
                animationFrame: false
            });
        });

        it('accepts custom autoUpdateOptions', () => {
            const p = new Positionable({
                autoUpdateOptions: {
                    ancestorScroll: false,
                    animationFrame: true
                }
            });
            expect(p.config.autoUpdateOptions.ancestorScroll).toBe(false);
            expect(p.config.autoUpdateOptions.animationFrame).toBe(true);
        });

        it('initializes instance properties', () => {
            expect(positionable.cleanup).toBeNull();
            expect(positionable.reference).toBeNull();
            expect(positionable.floating).toBeNull();
            expect(positionable.component).toBeNull();
            expect(positionable.state).toBe(false);
            expect(positionable.styles).toEqual({});
            expect(positionable.wrapperElement).toBeNull();
            expect(positionable.middlewareData).toEqual({});
        });
    });

    describe('start', () => {
        it('registers component, reference, and floating elements', () => {
            positionable.start(mockComponent, mockReference, mockFloating);

            expect(positionable.component).toBe(mockComponent);
            expect(positionable.reference).toBe(mockReference);
            expect(positionable.floating).toBe(mockFloating);
            expect(positionable.wrapperElement).toBe(mockComponent.$el);
        });

        it('adds instance to global instances set', () => {
            expect(Positionable.instances.size).toBe(0);
            positionable.start(mockComponent, mockReference, mockFloating);
            expect(Positionable.instances.size).toBe(1);
            expect(Positionable.instances.has(positionable)).toBe(true);
        });

        it('sets up state watcher', () => {
            const spy = vi.spyOn(positionable, 'watch');
            positionable.start(mockComponent, mockReference, mockFloating);
            expect(spy).toHaveBeenCalled();
        });

        it('returns this for method chaining', () => {
            const result = positionable.start(mockComponent, mockReference, mockFloating);
            expect(result).toBe(positionable);
        });

        it('calls compute on initialization', () => {
            const computeSpy = vi.spyOn(positionable, 'compute');
            positionable.start(mockComponent, mockReference, mockFloating);
            expect(computeSpy).toHaveBeenCalled();
        });
    });

    describe('watch', () => {
        beforeEach(() => {
            positionable.start(mockComponent, mockReference, mockFloating);
        });

        it('registers callback to watch state changes', async () => {
            const callback = vi.fn();
            positionable.watch(callback);

            await new Promise(resolve => queueMicrotask(resolve));
            expect(mockComponent.$watch).toHaveBeenCalled();
        });

        it('returns this for method chaining', () => {
            const callback = vi.fn();
            const result = positionable.watch(callback);
            expect(result).toBe(positionable);
        });
    });

    describe('syncPosition', () => {
        beforeEach(() => {
            positionable.start(mockComponent, mockReference, mockFloating);
        });

        it('does not sync on mobile (<640px)', () => {
            global.window.innerWidth = 639;
            positionable.syncPosition();
            expect(positionable.cleanup).toBeNull();
        });

        it('syncs position on desktop (>=640px)', async () => {
            const { autoUpdate } = await import('@floating-ui/dom');
            global.window.innerWidth = 640;
            positionable.syncPosition();
            expect(autoUpdate).toHaveBeenCalledWith(
                mockReference,
                mockFloating,
                expect.any(Function),
                positionable.config.autoUpdateOptions
            );
        });

        it('stores cleanup function', async () => {
            global.window.innerWidth = 1024;
            positionable.syncPosition();
            expect(positionable.cleanup).not.toBeNull();
            expect(typeof positionable.cleanup).toBe('function');
        });

        it('passes autoUpdateOptions to autoUpdate', async () => {
            const { autoUpdate } = await import('@floating-ui/dom');
            const customOptions = {
                ancestorScroll: false,
                animationFrame: true
            };
            const p = new Positionable({ autoUpdateOptions: customOptions });
            p.start(mockComponent, mockReference, mockFloating);

            global.window.innerWidth = 1024;
            p.syncPosition();

            expect(autoUpdate).toHaveBeenCalledWith(
                mockReference,
                mockFloating,
                expect.any(Function),
                customOptions
            );
        });
    });

    describe('compute', () => {
        beforeEach(() => {
            positionable.start(mockComponent, mockReference, mockFloating);
        });

        it('does nothing when reference is null', async () => {
            const { computePosition } = await import('@floating-ui/dom');
            const callCount = computePosition.mock.calls.length;
            positionable.reference = null;
            positionable.compute();
            expect(computePosition.mock.calls.length).toBe(callCount);
        });

        it('does nothing when floating is null', async () => {
            const { computePosition } = await import('@floating-ui/dom');
            const callCount = computePosition.mock.calls.length;
            positionable.floating = null;
            positionable.compute();
            expect(computePosition.mock.calls.length).toBe(callCount);
        });

        it('calls computePosition with basic middleware by default', async () => {
            const { computePosition, offset, flip, shift } = await import('@floating-ui/dom');

            await positionable.compute();

            expect(computePosition).toHaveBeenCalled();
            expect(offset).toHaveBeenCalledWith(8);
            expect(flip).toHaveBeenCalledWith({
                padding: 5,
                boundary: undefined
            });
            expect(shift).toHaveBeenCalled();
        });

        it('includes size middleware when enabled', async () => {
            const { size } = await import('@floating-ui/dom');
            const p = new Positionable({
                enableSize: true,
                matchReferenceWidth: true,
                maxHeight: true
            });
            p.start(mockComponent, mockReference, mockFloating);

            await p.compute();

            expect(size).toHaveBeenCalled();
        });

        it('includes arrow middleware when arrowElement provided', async () => {
            const { arrow: arrowMw } = await import('@floating-ui/dom');
            const arrowEl = document.createElement('div');
            const p = new Positionable({
                arrowElement: arrowEl,
                arrowPadding: 10
            });
            p.start(mockComponent, mockReference, mockFloating);

            await p.compute();

            expect(arrowMw).toHaveBeenCalledWith({
                element: arrowEl,
                padding: 10
            });
        });

        it('includes hide middleware when enabled', async () => {
            const { hide } = await import('@floating-ui/dom');
            const p = new Positionable({
                enableHide: true,
                hideStrategy: 'escaped'
            });
            p.start(mockComponent, mockReference, mockFloating);

            await p.compute();

            expect(hide).toHaveBeenCalledWith({
                strategy: 'escaped'
            });
        });

        it('uses autoPlacement instead of flip when enabled', async () => {
            const { autoPlacement, flip } = await import('@floating-ui/dom');
            const flipCallsBefore = flip.mock.calls.length;

            const p = new Positionable({
                useAutoPlacement: true
            });
            p.start(mockComponent, mockReference, mockFloating);

            await p.compute();

            expect(autoPlacement).toHaveBeenCalled();
            expect(flip.mock.calls.length).toBe(flipCallsBefore);
        });

        it('includes inline middleware when enabled', async () => {
            const { inline } = await import('@floating-ui/dom');
            const p = new Positionable({
                enableInline: true,
                inlineX: 100,
                inlineY: 200
            });
            p.start(mockComponent, mockReference, mockFloating);

            await p.compute();

            expect(inline).toHaveBeenCalledWith({
                x: 100,
                y: 200,
                padding: 2
            });
        });

        it('uses limitShift when enabled', async () => {
            const { shift, limitShift } = await import('@floating-ui/dom');
            const p = new Positionable({
                limitShiftEnabled: true
            });
            p.start(mockComponent, mockReference, mockFloating);

            await p.compute();

            expect(limitShift).toHaveBeenCalled();
            expect(shift).toHaveBeenCalled();
        });

        it('appends custom middleware', async () => {
            const { computePosition } = await import('@floating-ui/dom');
            const customMw = [
                { name: 'custom1', fn: () => ({}) },
                { name: 'custom2', fn: () => ({}) }
            ];
            const p = new Positionable({
                customMiddleware: customMw
            });
            p.start(mockComponent, mockReference, mockFloating);

            await p.compute();

            expect(computePosition).toHaveBeenCalled();
        });

        it('updates styles after compute', async () => {
            await positionable.compute();

            expect(positionable.styles).toEqual({
                position: 'absolute',
                left: '100px',
                top: '200px'
            });
        });

        it('stores middlewareData', async () => {
            await positionable.compute();

            expect(positionable.middlewareData).toBeDefined();
        });

        it('calls applyArrowPosition when arrow data present', async () => {
            const { computePosition } = await import('@floating-ui/dom');
            computePosition.mockResolvedValueOnce({
                x: 100,
                y: 200,
                placement: 'top',
                middlewareData: {
                    arrow: { x: 50, y: null, centerOffset: 0 }
                }
            });

            const arrowEl = document.createElement('div');
            const p = new Positionable({ arrowElement: arrowEl });
            p.start(mockComponent, mockReference, mockFloating);

            const spy = vi.spyOn(p, 'applyArrowPosition');
            await p.compute();

            expect(spy).toHaveBeenCalledWith('top', { x: 50, y: null, centerOffset: 0 });
        });

        it('calls applyHideVisibility when hide data present', async () => {
            const { computePosition } = await import('@floating-ui/dom');
            computePosition.mockResolvedValueOnce({
                x: 100,
                y: 200,
                placement: 'bottom',
                middlewareData: {
                    hide: { referenceHidden: true, escaped: false }
                }
            });

            const p = new Positionable({ enableHide: true });
            p.start(mockComponent, mockReference, mockFloating);

            const spy = vi.spyOn(p, 'applyHideVisibility');
            await p.compute();

            expect(spy).toHaveBeenCalledWith({ referenceHidden: true, escaped: false });
        });

        it('respects custom boundary option', async () => {
            const { flip, shift } = await import('@floating-ui/dom');
            const boundary = document.createElement('div');
            const p = new Positionable({ boundary });
            p.start(mockComponent, mockReference, mockFloating);

            await p.compute();

            expect(flip).toHaveBeenCalledWith({
                padding: 5,
                boundary
            });
            expect(shift).toHaveBeenCalledWith(expect.objectContaining({
                boundary
            }));
        });
    });

    describe('applyArrowPosition', () => {
        let arrowElement;

        beforeEach(() => {
            arrowElement = document.createElement('div');
            positionable.config.arrowElement = arrowElement;
        });

        it('positions arrow for top placement', () => {
            positionable.applyArrowPosition('top', { x: 50, y: null, centerOffset: 0 });

            expect(arrowElement.style.left).toBe('50px');
            expect(arrowElement.style.top).toBe('');
            expect(arrowElement.style.bottom).toBe('-4px');
        });

        it('positions arrow for bottom placement', () => {
            positionable.applyArrowPosition('bottom', { x: 50, y: null, centerOffset: 0 });

            expect(arrowElement.style.left).toBe('50px');
            expect(arrowElement.style.top).toBe('-4px');
        });

        it('positions arrow for left placement', () => {
            positionable.applyArrowPosition('left', { x: null, y: 50, centerOffset: 0 });

            expect(arrowElement.style.top).toBe('50px');
            expect(arrowElement.style.left).toBe('');
            expect(arrowElement.style.right).toBe('-4px');
        });

        it('positions arrow for right placement', () => {
            positionable.applyArrowPosition('right', { x: null, y: 50, centerOffset: 0 });

            expect(arrowElement.style.top).toBe('50px');
            expect(arrowElement.style.left).toBe('-4px');
        });

        it('handles compound placements (bottom-start)', () => {
            positionable.applyArrowPosition('bottom-start', { x: 20, y: null, centerOffset: 0 });

            expect(arrowElement.style.left).toBe('20px');
            expect(arrowElement.style.top).toBe('-4px');
        });

        it('uses loose equality for null check', () => {
            positionable.applyArrowPosition('bottom', { x: 0, y: undefined, centerOffset: 0 });

            expect(arrowElement.style.left).toBe('0px');
        });

        it('does nothing when arrowElement is null', () => {
            positionable.config.arrowElement = null;
            expect(() => {
                positionable.applyArrowPosition('top', { x: 50, y: null });
            }).not.toThrow();
        });
    });

    describe('applyHideVisibility', () => {
        beforeEach(() => {
            positionable.start(mockComponent, mockReference, mockFloating);
        });

        it('hides floating when referenceHidden is true', () => {
            positionable.applyHideVisibility({ referenceHidden: true, escaped: false });
            expect(mockFloating.style.visibility).toBe('hidden');
        });

        it('hides floating when escaped is true', () => {
            positionable.applyHideVisibility({ referenceHidden: false, escaped: true });
            expect(mockFloating.style.visibility).toBe('hidden');
        });

        it('hides floating when both are true', () => {
            positionable.applyHideVisibility({ referenceHidden: true, escaped: true });
            expect(mockFloating.style.visibility).toBe('hidden');
        });

        it('shows floating when both are false', () => {
            mockFloating.style.visibility = 'hidden';
            positionable.applyHideVisibility({ referenceHidden: false, escaped: false });
            expect(mockFloating.style.visibility).toBe('visible');
        });

        it('does nothing when floating is null', () => {
            positionable.floating = null;
            expect(() => {
                positionable.applyHideVisibility({ referenceHidden: true });
            }).not.toThrow();
        });
    });

    describe('open', () => {
        beforeEach(() => {
            positionable.start(mockComponent, mockReference, mockFloating);
        });

        it('closes conflicting instances', () => {
            const spy = vi.spyOn(positionable, 'closeConflictingInstances');
            positionable.open();
            expect(spy).toHaveBeenCalled();
        });

        it('computes position', () => {
            const spy = vi.spyOn(positionable, 'compute');
            positionable.open();
            expect(spy).toHaveBeenCalled();
        });

        it('sets state to true', () => {
            positionable.open();
            expect(positionable.state).toBe(true);
        });
    });

    describe('openIfClosed', () => {
        beforeEach(() => {
            positionable.start(mockComponent, mockReference, mockFloating);
        });

        it('opens when state is false', () => {
            positionable.state = false;
            const spy = vi.spyOn(positionable, 'open');
            positionable.openIfClosed();
            expect(spy).toHaveBeenCalled();
        });

        it('does not open when state is true', () => {
            positionable.state = true;
            const spy = vi.spyOn(positionable, 'open');
            positionable.openIfClosed();
            expect(spy).not.toHaveBeenCalled();
        });
    });

    describe('close', () => {
        beforeEach(() => {
            positionable.start(mockComponent, mockReference, mockFloating);
        });

        it('sets state to false', () => {
            positionable.state = true;
            positionable.close();
            expect(positionable.state).toBe(false);
        });
    });

    describe('toggle', () => {
        beforeEach(() => {
            positionable.start(mockComponent, mockReference, mockFloating);
        });

        it('closes when open', () => {
            positionable.state = true;
            const spy = vi.spyOn(positionable, 'close');
            positionable.toggle();
            expect(spy).toHaveBeenCalled();
        });

        it('opens when closed', () => {
            positionable.state = false;
            const spy = vi.spyOn(positionable, 'open');
            positionable.toggle();
            expect(spy).toHaveBeenCalled();
        });
    });

    describe('closeConflictingInstances', () => {
        let sibling, ancestor, descendant;

        beforeEach(() => {
            const ancestorEl = document.createElement('div');
            const currentEl = document.createElement('div');
            const descendantEl = document.createElement('div');
            const siblingEl = document.createElement('div');

            ancestorEl.appendChild(currentEl);
            currentEl.appendChild(descendantEl);

            mockComponent.$el = currentEl;
            positionable.start(mockComponent, mockReference, mockFloating);
            positionable.state = true;

            sibling = new Positionable();
            sibling.start(
                { $el: siblingEl, $nextTick: vi.fn((cb) => cb()), $watch: vi.fn() },
                document.createElement('button'),
                document.createElement('div')
            );
            sibling.state = true;

            ancestor = new Positionable();
            ancestor.start(
                { $el: ancestorEl, $nextTick: vi.fn((cb) => cb()), $watch: vi.fn() },
                document.createElement('button'),
                document.createElement('div')
            );
            ancestor.state = true;

            descendant = new Positionable();
            descendant.start(
                { $el: descendantEl, $nextTick: vi.fn((cb) => cb()), $watch: vi.fn() },
                document.createElement('button'),
                document.createElement('div')
            );
            descendant.state = true;
        });

        it('closes sibling instances', () => {
            positionable.closeConflictingInstances();
            expect(sibling.state).toBe(false);
        });

        it('keeps ancestor instances open', () => {
            positionable.closeConflictingInstances();
            expect(ancestor.state).toBe(true);
        });

        it('keeps descendant instances open', () => {
            positionable.closeConflictingInstances();
            expect(descendant.state).toBe(true);
        });

        it('does not close self', () => {
            positionable.closeConflictingInstances();
            expect(positionable.state).toBe(true);
        });

        it('does not attempt to close already closed instances', () => {
            sibling.state = false;
            const spy = vi.spyOn(sibling, 'close');
            positionable.closeConflictingInstances();
            expect(spy).not.toHaveBeenCalled();
        });
    });

    describe('destroy', () => {
        beforeEach(() => {
            positionable.start(mockComponent, mockReference, mockFloating);
        });

        it('calls cleanup function if exists', () => {
            const cleanupFn = vi.fn();
            positionable.cleanup = cleanupFn;
            positionable.destroy();
            expect(cleanupFn).toHaveBeenCalled();
        });

        it('sets cleanup to null', () => {
            positionable.cleanup = vi.fn();
            positionable.destroy();
            expect(positionable.cleanup).toBeNull();
        });

        it('removes instance from global instances', () => {
            expect(Positionable.instances.has(positionable)).toBe(true);
            positionable.destroy();
            expect(Positionable.instances.has(positionable)).toBe(false);
        });

        it('handles null cleanup gracefully', () => {
            positionable.cleanup = null;
            expect(() => positionable.destroy()).not.toThrow();
        });
    });

    describe('integration scenarios', () => {
        it('handles complete lifecycle', () => {
            const p = new Positionable({
                placement: 'top',
                offset: 12
            });

            p.start(mockComponent, mockReference, mockFloating);
            expect(Positionable.instances.size).toBe(1);

            p.open();
            expect(p.state).toBe(true);

            p.close();
            expect(p.state).toBe(false);

            p.destroy();
            expect(Positionable.instances.size).toBe(0);
        });

        it('handles select dropdown use case', async () => {
            const select = new Positionable({
                placement: 'bottom-start',
                enableSize: true,
                matchReferenceWidth: true,
                maxHeight: true
            });

            select.start(mockComponent, mockReference, mockFloating);
            await select.compute();

            expect(select.config.enableSize).toBe(true);
            expect(select.config.matchReferenceWidth).toBe(true);
        });

        it('handles tooltip with arrow use case', async () => {
            const arrowEl = document.createElement('div');
            const tooltip = new Positionable({
                placement: 'top',
                offset: 8,
                arrowElement: arrowEl,
                enableHide: true
            });

            tooltip.start(mockComponent, mockReference, mockFloating);
            await tooltip.compute();

            expect(tooltip.config.arrowElement).toBe(arrowEl);
            expect(tooltip.config.enableHide).toBe(true);
        });

        it('handles nested dropdowns', () => {
            const parent = new Positionable();
            const child = new Positionable();

            const parentEl = document.createElement('div');
            const childEl = document.createElement('div');
            parentEl.appendChild(childEl);

            parent.start(
                { $el: parentEl, $nextTick: vi.fn((cb) => cb()), $watch: vi.fn() },
                document.createElement('button'),
                document.createElement('div')
            );

            child.start(
                { $el: childEl, $nextTick: vi.fn((cb) => cb()), $watch: vi.fn() },
                document.createElement('button'),
                document.createElement('div')
            );

            parent.state = true;
            child.state = true;

            parent.closeConflictingInstances();

            expect(child.state).toBe(true);
        });

        it('handles multiple sibling dropdowns', () => {
            const dropdown1 = new Positionable();
            const dropdown2 = new Positionable();

            dropdown1.start(
                { $el: document.createElement('div'), $nextTick: vi.fn((cb) => cb()), $watch: vi.fn() },
                document.createElement('button'),
                document.createElement('div')
            );

            dropdown2.start(
                { $el: document.createElement('div'), $nextTick: vi.fn((cb) => cb()), $watch: vi.fn() },
                document.createElement('button'),
                document.createElement('div')
            );

            dropdown1.state = true;
            dropdown2.state = true;

            dropdown1.closeConflictingInstances();

            expect(dropdown2.state).toBe(false);
        });
    });
});
