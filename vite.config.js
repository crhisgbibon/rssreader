import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/vh.js',

                // RSSReader
                'resources/js/RSSReader/profile.js',
                'resources/js/RSSReader/reader.js',
                'resources/js/RSSReader/sources.js',
            ],
            refresh: true,
        }),
    ],
});
