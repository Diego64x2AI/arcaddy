import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
// import basicSsl from '@vitejs/plugin-basic-ssl'
import fs from 'fs'

const host = 'arcaddy.dev'

export default defineConfig({
	server: {
		hmr: { host },
		host,
		https: {
      key: fs.readFileSync('C:/laragon/etc/ssl/laragon.key'),
      cert: fs.readFileSync('C:/laragon/etc/ssl/laragon.crt'),
    },
	},
	plugins: [
		// basicSsl(),
		laravel({
			input: [
				'resources/css/app.css',
				'resources/js/app.js',
			],
			refresh: true,
		}),
	],
	resolve: {
		alias: {
			'@': '/resources/js',
			'@assets': '/public',
		},
	},
});
