const mix = require('laravel-mix');
const {version} = require("laravel-mix");

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

mix.js(['node_modules/bootstrap/dist/js/bootstrap.bundle.js', 'resources/js/app.js'], 'public/js/app.js')
    .sass('resources/scss/app.scss', 'public/css')
    .vue().version()
    .sourceMaps();
