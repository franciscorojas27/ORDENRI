import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/chartDashboard.js',
                'resources/js/coloredRows.js',
                'resources/js/modalShow.js',
                'resources/js/switchColor.js',
                'resources/js/modalDeleteOrders.js',
                'resources/js/dropFiles.js'
            ],
            refresh: true,
        }),
    ],
});
