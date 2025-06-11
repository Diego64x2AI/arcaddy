import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import fs from "fs";

const host = "arcaddy.dev";
const vhostPath = `C:\\Users\\admin\\AppData\\Local\\Programs\\PhpWebStudy-Data\\server\\vhost\\apache\\`;

// read the vhost file and extract the ssl certificate and key paths
const vhostContent = fs.readFileSync(`${vhostPath}${host}.conf`, "utf8");
const sslCertPath = vhostContent.match(/SSLCertificateFile\s+"([^"]+)"/)[1];
const sslKeyPath = vhostContent.match(/SSLCertificateKeyFile\s+"([^"]+)"/)[1];
console.log("SSL Certificate Path:", sslCertPath);
console.log("SSL Key Path:", sslKeyPath);

export default defineConfig({
	server: {
		hmr: { host },
		host,
		https: {
			key: fs.readFileSync(sslKeyPath),
			cert: fs.readFileSync(sslCertPath),
		},
		headers: {
			'Access-Control-Allow-Origin': '*',
		},
	},
	plugins: [
		laravel({
			input: ["resources/css/app.css", "resources/js/app.js"],
			refresh: true,
		}),
	],
	resolve: {
		alias: {
			"@": "/resources/js",
			"@assets": "/public",
		},
	},
	build: {
		rollupOptions: {
			output: {
				manualChunks(id) {
					if (id.includes("node_modules")) {
						return id
							.toString()
							.split("node_modules/")[1]
							.split("/")[0]
							.toString();
					}
				},
			},
		},
	},
});
