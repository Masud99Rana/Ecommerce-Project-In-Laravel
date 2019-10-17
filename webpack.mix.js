const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('resources/sass/app.scss', 'public/css')
    .styles([
        'resources/css/custom.css',
    ], 'public/css/all.css')
    .js([
        'resources/js/app.js',
        'resources/js/custom.js',
    ], 'public/js/all.js')
    .version();
