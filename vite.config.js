import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');
    const appPath = new URL(env.APP_URL || 'http://localhost').pathname.replace(/\/$/, '');

    return {
        base: `${appPath === '/' ? '' : appPath}/build/`,
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
        ],
    };
});
