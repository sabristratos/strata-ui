import { defineConfig } from 'vitest/config';
import path from 'path';

export default defineConfig({
  test: {
    globals: true,
    environment: 'happy-dom',
    setupFiles: ['./tests/JavaScript/setup.js'],
    include: ['tests/JavaScript/**/*.test.js'],
    coverage: {
      provider: 'v8',
      reporter: ['text', 'json', 'html'],
      include: ['resources/js/**/*.js'],
      exclude: ['resources/js/strata.js']
    }
  },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/js')
    }
  }
});
