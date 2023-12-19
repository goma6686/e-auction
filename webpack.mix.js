//import mix from 'laravel-mix';
const mix = require('laravel-mix');
// Example using dynamic import


mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/main.js', 'public/js')
   .vue()
   .babelConfig({
      presets: ['@babel/preset-env'],
      plugins: [],
   }).postCss('resources/css/app.css', 'public/css', [
    require('autoprefixer'),
]).sourceMaps();

mix.webpackConfig({
   resolve: {
       extensions: ['.js', '.json'],
   },
});
