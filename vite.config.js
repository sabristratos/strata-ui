import { defineConfig } from 'vite'
import { resolve } from 'path'

export default defineConfig({
  build: {
    outDir: 'resources/dist',
    lib: {
      entry: resolve(__dirname, 'resources/js/strata.js'),
      name: 'Strata',
      fileName: 'strata-ui',
      formats: ['iife']
    },
    rollupOptions: {
      output: {
        extend: true
      }
    },
    minify: true,
    sourcemap: true
  },
  define: {
    'process.env.NODE_ENV': '"production"'
  }
})