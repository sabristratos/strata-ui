import { beforeEach, vi } from 'vitest';
import { createEntangleableMixin } from '../../resources/js/entangleable-mixin.js';
import { createPositionableMixin } from '../../resources/js/positionable-mixin.js';

beforeEach(() => {
  global.window = global.window || {};

  global.Alpine = {
    store: vi.fn(),
    data: vi.fn(),
    effect: vi.fn()
  };

  global.Livewire = {
    find: vi.fn(),
    hook: vi.fn()
  };

  global.window.Alpine = global.Alpine;
  global.window.Livewire = global.Livewire;
  global.window.createEntangleableMixin = createEntangleableMixin;
  global.window.createPositionableMixin = createPositionableMixin;
});
