import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vuePlugin from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vuePlugin({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false
                }
            }
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            '@components': path.resolve(__dirname, 'resources/js/vue/components'),
            '@pages': path.resolve(__dirname, 'resources/js/vue/pages'),
            '@stores': path.resolve(__dirname, 'resources/js/stores'),
            '@helpers': path.resolve(__dirname, 'resources/js/helpers'),
        },
    },
});
