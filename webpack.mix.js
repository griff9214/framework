let mix = require("laravel-mix");
mix
    .setPublicPath('public')
    .js('resources/assets/js/app.js', 'js')
    .sass('resources/assets/sass/app.sass', 'css');
