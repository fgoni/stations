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

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/modal.js', 'public/js')
   .js('resources/js/layout.js', 'public/js')
   .js('resources/js/dropdown.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
   ])
   .options({
        processCssUrls: false,
        postCss: {
            plugins: [
                require('tailwindcss'),
                require('autoprefixer'),
            ]
        }
    })
    .webpackConfig({
        watchOptions: {
            ignored: /node_modules/,
            aggregateTimeout: 300,
            poll: 1000
        }
    });

if (mix.inProduction()) {
    mix.version();
}
