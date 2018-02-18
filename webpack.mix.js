let mix = require('laravel-mix');

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

// Needed to use process.env in this context.
require('dotenv').config();

mix
    // JS compilation
    .js('resources/assets/js/app.js', 'public/js')
        .sourceMaps() // we add sourcemaps to ease debug
        // .browserSync('localhost:8000') // we allow for automatic browser refresh
    // CSS compilation
    .sass('resources/assets/sass/app.scss', 'public/css', {
        // Theme colors are read from the .env file, in a «slack» fashion.
        'data': "$mix-theme-colors: '" + process.env.MIX_THEME_COLORS + "';"
    });