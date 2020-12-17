const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js');

mix.scripts([
        'resources/js/products/index.js',
	],
	'public/js/main.js'
);

mix.less('resources/less/global.less', '../resources/css')
	.less('resources/less/homepage/index.less', '../resources/css/homepage')
	.less('resources/less/products/index.less', '../resources/css/products')
	.combine([
		'resources/css/global.css',
		'resources/css/homepage/index.css',
		'resources/css/products/index.css',
	],
	'public/css/main.css'
);