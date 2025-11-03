import { describe, it, expect, beforeEach, vi } from 'vitest';
import Entangleable from '../../resources/js/entangleable.js';

describe('Entangleable', () => {
    let entangleable;

    beforeEach(() => {
        entangleable = new Entangleable();
    });

    describe('constructor', () => {
        it('initializes with null value when no argument provided', () => {
            expect(entangleable.value).toBeNull();
            expect(entangleable.watchers).toEqual([]);
            expect(entangleable.component).toBeNull();
        });

        it('initializes with provided value', () => {
            const customValue = ['option1', 'option2'];
            const e = new Entangleable(customValue);
            expect(e.value).toEqual(customValue);
        });

        it('accepts various data types as initial value', () => {
            expect(new Entangleable('string').value).toBe('string');
            expect(new Entangleable(42).value).toBe(42);
            expect(new Entangleable(true).value).toBe(true);
            expect(new Entangleable([1, 2, 3]).value).toEqual([1, 2, 3]);
            expect(new Entangleable({ key: 'value' }).value).toEqual({ key: 'value' });
        });
    });

    describe('watch', () => {
        it('registers a watcher callback', () => {
            const callback = vi.fn();
            entangleable.watch(callback);
            expect(entangleable.watchers).toHaveLength(1);
            expect(entangleable.watchers[0]).toBe(callback);
        });

        it('allows multiple watchers', () => {
            const callback1 = vi.fn();
            const callback2 = vi.fn();
            const callback3 = vi.fn();

            entangleable.watch(callback1);
            entangleable.watch(callback2);
            entangleable.watch(callback3);

            expect(entangleable.watchers).toHaveLength(3);
        });

        it('returns this for method chaining', () => {
            const callback = vi.fn();
            const result = entangleable.watch(callback);
            expect(result).toBe(entangleable);
        });
    });

    describe('get', () => {
        it('returns the current value', () => {
            entangleable.value = 'test value';
            expect(entangleable.get()).toBe('test value');
        });

        it('returns null when value is not set', () => {
            expect(entangleable.get()).toBeNull();
        });
    });

    describe('set', () => {
        it('updates the value', () => {
            entangleable.set('new value');
            expect(entangleable.value).toBe('new value');
        });

        it('notifies watchers when value changes', () => {
            const callback = vi.fn();
            entangleable.watch(callback);
            entangleable.set('new value');

            expect(callback).toHaveBeenCalledWith('new value', null);
        });

        it('notifies all watchers', () => {
            const callback1 = vi.fn();
            const callback2 = vi.fn();

            entangleable.watch(callback1);
            entangleable.watch(callback2);
            entangleable.set('test');

            expect(callback1).toHaveBeenCalled();
            expect(callback2).toHaveBeenCalled();
        });

        it('does not notify watchers when value is the same', () => {
            const callback = vi.fn();
            entangleable.set('initial');
            entangleable.watch(callback);
            entangleable.set('initial');

            expect(callback).not.toHaveBeenCalled();
        });

        it('uses JSON.stringify for deep equality check', () => {
            const callback = vi.fn();
            entangleable.set([1, 2, 3]);
            entangleable.watch(callback);
            entangleable.set([1, 2, 3]); // Same content, different array

            expect(callback).not.toHaveBeenCalled();
        });

        it('detects changes in nested objects', () => {
            const callback = vi.fn();
            entangleable.set({ a: 1, b: { c: 2 } });
            entangleable.watch(callback);
            entangleable.set({ a: 1, b: { c: 3 } });

            expect(callback).toHaveBeenCalled();
        });

        it('passes old and new values to watchers', () => {
            const callback = vi.fn();
            entangleable.set('old');
            entangleable.watch(callback);
            entangleable.set('new');

            expect(callback).toHaveBeenCalledWith('new', 'old');
        });
    });

    describe('notifyWatchers', () => {
        it('calls all watcher callbacks with correct arguments', () => {
            const callback1 = vi.fn();
            const callback2 = vi.fn();

            entangleable.watch(callback1);
            entangleable.watch(callback2);
            entangleable.notifyWatchers('new', 'old');

            expect(callback1).toHaveBeenCalledWith('new', 'old');
            expect(callback2).toHaveBeenCalledWith('new', 'old');
        });

        it('handles empty watchers array gracefully', () => {
            expect(() => entangleable.notifyWatchers('new', 'old')).not.toThrow();
        });
    });

    describe('syncToLivewire', () => {
        it('syncs value to Livewire when $wire exists', () => {
            const mockSet = vi.fn();
            const mockComponent = {
                $wire: {
                    set: mockSet,
                    get: vi.fn()
                }
            };

            entangleable.component = mockComponent;
            entangleable.wireModelProperty = 'testProperty';
            entangleable.value = 'sync value';

            entangleable.syncToLivewire();

            expect(mockSet).toHaveBeenCalledWith('testProperty', 'sync value');
        });

        it('does nothing when $wire is not available', () => {
            const mockComponent = {};
            entangleable.component = mockComponent;
            entangleable.wireModelProperty = 'testProperty';

            expect(() => entangleable.syncToLivewire()).not.toThrow();
        });

        it('does nothing when wireModelProperty is not set', () => {
            const mockSet = vi.fn();
            const mockComponent = {
                $wire: { set: mockSet }
            };

            entangleable.component = mockComponent;

            entangleable.syncToLivewire();

            expect(mockSet).not.toHaveBeenCalled();
        });
    });

    describe('syncFromLivewire', () => {
        it('syncs value from Livewire to local state', () => {
            const callback = vi.fn();
            const mockGet = vi.fn(() => 'livewire value');
            const mockComponent = {
                $wire: {
                    get: mockGet,
                    set: vi.fn()
                }
            };

            entangleable.component = mockComponent;
            entangleable.wireModelProperty = 'testProperty';
            entangleable.watch(callback);

            entangleable.syncFromLivewire();

            expect(mockGet).toHaveBeenCalledWith('testProperty');
            expect(entangleable.value).toBe('livewire value');
            expect(callback).toHaveBeenCalledWith('livewire value', null);
        });

        it('handles undefined Livewire values gracefully', () => {
            const mockGet = vi.fn(() => undefined);
            const mockComponent = {
                $wire: {
                    get: mockGet
                }
            };

            entangleable.component = mockComponent;
            entangleable.wireModelProperty = 'testProperty';
            const oldValue = entangleable.value;

            entangleable.syncFromLivewire();

            expect(entangleable.value).toBe(oldValue);
        });
    });

    describe('setupLivewire', () => {
        it('extracts wire:model property from input element', () => {
            const mockInput = {
                getAttributeNames: () => ['wire:model.live', 'type', 'name'],
                getAttribute: vi.fn((attr) => {
                    if (attr === 'wire:model.live') return 'selectedItems';
                    return null;
                })
            };

            const mockComponent = {
                $wire: {
                    get: vi.fn(() => ['initial']),
                    set: vi.fn(),
                    $watch: vi.fn()
                }
            };

            entangleable.setupLivewire(mockComponent, mockInput);

            expect(entangleable.wireModelProperty).toBe('selectedItems');
            expect(entangleable.component).toBe(mockComponent);
        });

        it('sets up Livewire watcher', () => {
            const mockWatch = vi.fn();
            const mockInput = {
                getAttributeNames: () => ['wire:model'],
                getAttribute: vi.fn(() => 'testProp')
            };

            const mockComponent = {
                $wire: {
                    get: vi.fn(() => 'initial'),
                    set: vi.fn(),
                    $watch: mockWatch
                }
            };

            entangleable.setupLivewire(mockComponent, mockInput);

            expect(mockWatch).toHaveBeenCalledWith('testProp', expect.any(Function));
        });

        it('does nothing when inputElement is null', () => {
            const mockComponent = { $wire: {} };
            expect(() => entangleable.setupLivewire(mockComponent, null)).not.toThrow();
            expect(entangleable.component).toBeNull();
        });

        it('does nothing when no wire:model attribute found', () => {
            const mockInput = {
                getAttributeNames: () => ['type', 'name'],
                getAttribute: vi.fn()
            };

            const mockComponent = { $wire: {} };
            entangleable.setupLivewire(mockComponent, mockInput);

            expect(entangleable.wireModelProperty).toBeNull();
        });

        it('handles wire:model variations', () => {
            const variations = [
                'wire:model',
                'wire:model.live',
                'wire:model.lazy',
                'wire:model.debounce',
                'wire:model.defer'
            ];

            variations.forEach(variation => {
                const e = new Entangleable();
                const mockInput = {
                    getAttributeNames: () => [variation],
                    getAttribute: vi.fn(() => 'prop')
                };

                const mockComponent = {
                    $wire: {
                        get: vi.fn(() => null),
                        set: vi.fn(),
                        $watch: vi.fn()
                    }
                };

                e.setupLivewire(mockComponent, mockInput);
                expect(e.wireModelProperty).toBe('prop');
            });
        });
    });

    describe('setupAlpine', () => {
        it('syncs with Alpine component property', () => {
            const mockComponent = {
                selectedItems: ['item1', 'item2']
            };

            entangleable.setupAlpine(mockComponent, 'selectedItems');

            expect(entangleable.value).toEqual(['item1', 'item2']);
            expect(entangleable.alpineModelProperty).toBe('selectedItems');
        });

        it('updates Alpine property when value changes', () => {
            const mockComponent = {
                selectedItems: []
            };

            entangleable.setupAlpine(mockComponent, 'selectedItems');
            entangleable.set(['new', 'items']);

            expect(mockComponent.selectedItems).toEqual(['new', 'items']);
        });

        it('handles undefined Alpine property', () => {
            const mockComponent = {};
            expect(() => entangleable.setupAlpine(mockComponent, 'nonExistent')).not.toThrow();
        });
    });

    describe('destroy', () => {
        it('clears all watchers', () => {
            entangleable.watch(vi.fn());
            entangleable.watch(vi.fn());
            entangleable.destroy();

            expect(entangleable.watchers).toEqual([]);
        });

        it('clears all references', () => {
            entangleable.component = { mock: 'component' };
            entangleable.wireModelProperty = 'prop';
            entangleable.alpineModelProperty = 'alphaProp';
            entangleable.value = 'value';

            entangleable.destroy();

            expect(entangleable.component).toBeNull();
            expect(entangleable.wireModelProperty).toBeNull();
            expect(entangleable.alpineModelProperty).toBeNull();
            expect(entangleable.value).toBeNull();
        });

        it('prevents memory leaks', () => {
            const callback = vi.fn();
            entangleable.watch(callback);
            entangleable.destroy();
            entangleable.notifyWatchers('new', 'old');

            expect(callback).not.toHaveBeenCalled();
        });
    });

    describe('integration scenarios', () => {
        it('handles multi-select use case', () => {
            const callback = vi.fn();
            const multiSelect = new Entangleable([]);

            multiSelect.watch((newValue) => {
                callback(newValue);
            });

            multiSelect.set(['item1']);
            multiSelect.set(['item1', 'item2']);
            multiSelect.set(['item1', 'item2', 'item3']);

            expect(callback).toHaveBeenCalledTimes(3);
            expect(callback).toHaveBeenLastCalledWith(['item1', 'item2', 'item3']);
        });

        it('handles calendar date selection', () => {
            const calendar = new Entangleable(null);
            const dates = [];

            calendar.watch((newValue) => {
                dates.push(newValue);
            });

            calendar.set(new Date('2024-01-01'));
            calendar.set([new Date('2024-01-01'), new Date('2024-01-15')]);

            expect(dates).toHaveLength(2);
        });

        it('maintains reactivity chain', () => {
            const results = [];

            entangleable.watch((newValue) => results.push(`watcher1: ${newValue}`));
            entangleable.watch((newValue) => results.push(`watcher2: ${newValue}`));

            entangleable.set('first');
            entangleable.set('second');

            expect(results).toEqual([
                'watcher1: first',
                'watcher2: first',
                'watcher1: second',
                'watcher2: second'
            ]);
        });
    });
});
