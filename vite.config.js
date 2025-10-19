import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/ecommerce.css', // Tailwind CSS
                'resources/js/app.js',        // Vanilla JS
            ],
            refresh: true,
        }),
    ],
});
