const defaultTheme = require('tailwindcss/defaultTheme');
const plugin = require("tailwindcss/plugin");

/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./storage/framework/views/*.php',
		'./resources/views/**/*.blade.php',
	],

	theme: {
		extend: {
			fontFamily: {
				sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
			},
		},
	},

	plugins: [
		require('@tailwindcss/forms'),
		plugin(function ({ addComponents, addUtilities }) {
			addUtilities({
				'.degradado': {
					background: 'rgb(0,217,253)',
					background: 'linear-gradient(90deg, rgba(0,217,253,1) 0%, rgba(41,183,252,1) 17%, rgba(88,144,250,1) 33%, rgba(136,104,248,1) 50%, rgba(198,53,246,1) 69%, rgba(219,35,245,1) 86%, rgba(250,9,244,1) 100%)',
				},
			});
		}),
	],
};
