const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js")
    .sass("resources/sass/chat/analist.scss", "public/css/chat")
    .sass("resources/sass/chat/client.scss", "public/css/chat")
    .sass("resources/sass/app.scss", "public/css");

mix.js("resources/js/peerAnalist.js", "public/js");
mix.js("resources/js/peerClient.js", "public/js");
mix.js("resources/js/forum.js", "public/js");
