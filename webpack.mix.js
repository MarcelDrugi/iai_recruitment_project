const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js');

mix.scripts([
        'resources/js/products/index.js',
		'resources/js/invoice/index.js',
		'resources/js/invoice-list/index.js',
	],
	'public/js/main.js'
);

mix.less('resources/less/global.less', '../resources/css')
	.less('resources/less/homepage/index.less', '../resources/css/homepage')
	.less('resources/less/products/index.less', '../resources/css/products')
	.less('resources/less/invoice/index.less', '../resources/css/invoice')
	.less('resources/less/invoice-preview/index.less', '../resources/css/invoice-preview')
	.less('resources/less/invoice-list/index.less', '../resources/css/invoice-list')
	.combine([
		'resources/css/global.css',
		'resources/css/homepage/index.css',
		'resources/css/products/index.css',
		'resources/css/invoice/index.css',
		'resources/css/invoice-preview/index.css',
		'resources/css/invoice-list/index.css',
	],
	'public/css/main.css'
);
