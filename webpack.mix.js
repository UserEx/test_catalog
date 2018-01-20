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

mix.js(['resources/assets/js/app.js', 'node_modules/webpack-bootstrap-treeview/public/js/bootstrap-treeview.js'], 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .styles('node_modules/webpack-bootstrap-treeview/public/css/bootstrap-treeview.css', 'public/css/bootstrap-treeview.css');
