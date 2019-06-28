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

// Uncomment to activate bundle analyzer.
// const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

const webpack = require('webpack');

mix
// JS compilation
    .js([
        // we append the localization lib to the sources
        'vendor/andywer/js-localization/resources/js/localization.js',
        'public/vendor/js-localization/messages.js',
        // standard entry point
        'resources/assets/js/app.js',
    ], 'public/js/app.js')
    .sourceMaps() // we add sourcemaps to ease debug
    // .browserSync('localhost:8000') // we allow for automatic browser refresh
    .extract([
        'jquery', 'moment',
        'bootstrap','bootstrap-datepicker', 'bootstrap-select',
        'textcomplete', 'dropzone', 'jstree', 'autosize', 'popper.js'
    ])
    // CSS compilation
    .sass('resources/assets/sass/app.scss', 'public/css', {
        // Theme colors are read from the .env file, in a «slack» fashion.
        'data': "$mix-theme-colors: '" + process.env.MIX_THEME_COLORS + "';"
    })
    // Copy generated icons to their destination
    .copyDirectory('resources/assets/img/generated', 'public/icons')
    .webpackConfig({ // not in use right now but we might need it at some point
        resolve: {
            alias: {
                // './fonts/titillium': path.resolve(__dirname, 'public/fonts/vendor/jstree-bootstrap-theme/dist/themes/proton/titillium')
            }
        },
        plugins: [
            // Uncomment to activate bundle analyzer.
            // new BundleAnalyzerPlugin(),

            // We don't want ALL locales for moment.js to be compiled in the
            // vendor file, it's too big !
            //
            // Note : When adding support for other languages it
            // should be possible to do this to load other locales :
            // require('moment/locale/fr.js');
            new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)
        ]
    });