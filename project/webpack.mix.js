const mix = require('laravel-mix');

mix.webpackConfig(webpack => {
  return {
    plugins: [
      new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
      }),
    ],
  };
});
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

mix.copyDirectory('resources/fonts', 'public/fonts');

mix.styles('resources/css/font-awesome.min.css', 'public/css/font-awesome.css');

mix.js('resources/js/app.js', 'public/js')
  .js('resources/js/material-dashboard.js', 'public/js/material-dashboard.js')
  .sass('resources/sass/app.scss', 'public/css');
