import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(() => {
    return {
        // Emit relative URLs inside built assets (e.g. Font Awesome @font-face
        // src in app.css). This keeps icon fonts resolvable regardless of how
        // the app is served — `php artisan serve` at "/" or XAMPP under
        // "/adsvopen/" — instead of baking an absolute APP_URL subpath in.
        base: './',
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
        ],
    };
});
