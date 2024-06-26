const defaultTheme = require('tailwindcss/defaultTheme');
const plugin = require("tailwindcss/plugin");

/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./storage/framework/views/*.php',
		'./resources/views/**/*.blade.php',
		'./app/Http/Controllers/**/*.php',
	],

	theme: {
		aspectRatio: {
      auto: 'auto',
      square: '1 / 1',
      video: '16 / 9',
      1: '1',
      2: '2',
      3: '3',
      4: '4',
      5: '5',
      6: '6',
      7: '7',
      8: '8',
      9: '9',
      10: '10',
      11: '11',
      12: '12',
      13: '13',
      14: '14',
      15: '15',
      16: '16',
    },
		extend: {
			fontFamily: {
				sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
			},
		},
	},

	plugins: [
		require('@tailwindcss/forms'),
		require('@tailwindcss/aspect-ratio'),
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
