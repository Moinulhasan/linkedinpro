import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/home.css',
                'resources/css/audits.css',
                'resources/js/app.js',
                'resources/js/home.js',
                'resources/js/audits.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '127.0.0.1',
    },
});
