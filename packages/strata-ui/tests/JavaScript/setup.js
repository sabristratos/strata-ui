import { beforeEach, vi } from 'vitest';

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
});
