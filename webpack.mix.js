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

mix.webpackConfig(require('./webpack.config'))
//.copyDirectory('resources/ckeditor5_custom_build/build', 'node_modules/@ckeditor/ckeditor5-build-decoupled-document/build')
//     .copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
//     .copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
    .js('resources/assets/js/app.js', 'public/js/app.min.js')
    .vue()
    .sass('resources/assets/sass/app.scss', 'public/css/app.min.css')
    .sass('resources/assets/sass/theme1.scss', 'public/css/theme1.min.css')
    .sass('resources/assets/sass/theme2.scss', 'public/css/theme2.min.css')
    .sass('resources/assets/sass/cms.scss', 'public/css/cms.min.css')
    .options({
        postCss: [
            require('postcss-import'),
            require('tailwindcss'),
        ]
    });

if (mix.inProduction()) {
    mix.version();
}



