import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';

const host = 'arcaddy.dev';

export default defineConfig({
	server: {
		hmr: { host },
		host,
		https: {
			key: fs.readFileSync('C:/Users/admin/AppData/Local/Programs/PhpWebStudy-Data/server/CA/1744908169101/CA-1744908169101.key'),
			cert: fs.readFileSync('C:/Users/admin/AppData/Local/Programs/PhpWebStudy-Data/server/CA/1744908169101/CA-1744908169101.crt')
		}
	},
	plugins: [
		laravel({
			input: [
				'resources/css/app.css',
				'resources/js/app.js'
			],
			refresh: true
		})
	],
	resolve: {
		alias: {
			'@': '/resources/js',
			'@assets': '/public'
		}
	},
	build: {
		rollupOptions: {
			output: {
				manualChunks(id) {
					if (id.includes('node_modules')) {
						return id.toString().split('node_modules/')[1].split('/')[0].toString();
					}
				}
			}
		}
	}
});
