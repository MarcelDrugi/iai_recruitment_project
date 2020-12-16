const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js');

mix.scripts([
        //'resources/js/order/index.js',
	],
	'public/js/main.js'
);

mix.less('resources/less/homepage/index.less', '../resources/css/homepage').combine([
		'resources/css/homepage/index.css',
	],
	'public/css/main.css'
);
