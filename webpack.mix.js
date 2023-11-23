//import mix from 'laravel-mix';
const mix = require('laravel-mix');
// Example using dynamic import
mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
       //
]);