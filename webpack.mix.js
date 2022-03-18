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
const WebpackShellPluginNext = require('webpack-shell-plugin-next');
mix.webpackConfig({
    plugins:
        [
            // new WebpackShellPluginNext({onBuildStart:{scripts: ['php artisan lang:js resources/js/vue-translations.js --no-lib --quiet']}, onBuildEnd:{scripts: []}})
            new WebpackShellPluginNext({onBuildStart:{scripts: ['php artisan lang:js resources/js/vue-translations.json --json --quiet']}, onBuildEnd:{scripts: []}})
        ]
});

mix.copyDirectory('resources/assets/icons', 'public/images/icons');
mix.copyDirectory('resources/assets/img', 'public/assets');
mix.copyDirectory('resources/assets/landing-img', 'public/assets/landing-img');
mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/base.js', 'public/js/base.js')
    .js('resources/js/landing/landing.js', 'public/js/landing.js')
    .js('resources/js/splide.min.js', 'public/js/splide.min.js')
    .js('resources/js/carousel.js', 'public/js/carousel.js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/landingStyles/landing-app.scss', 'public/css');
