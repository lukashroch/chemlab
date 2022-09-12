import vue from '@vitejs/plugin-vue2';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig(() => {
  return {
    resolve: {
      alias: {
        '@': '/resources/js/',
      },
    },
    plugins: [
      laravel({
        input: ['resources/js/main.js', 'resources/scss/app.scss'],
        refresh: true,
      }),
      vue({
        template: {
          transformAssetUrlsOptions: {
            includeAbsolute: false,
          },
        },
      }),
    ],
  };
});
