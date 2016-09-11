const elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

/**
 *  Script list
 */
var scripts = [
    'api/google-maps.js',
    'api/whatstation.js',
    'api/wikipedia.js',

    'controllers/home.js',
    'controllers/locate.js',
    'controllers/regions.js',
    'controllers/station.js',
    'controllers/stations.js',

    'app.js'
];

elixir(mix => {
    // Scripts
    mix.scripts(scripts, 'public/js/app.js').version('js/app.js')

    // Styles
    mix.sass('app.css').version('css/app.css');

    // Views
    mix.copy('resources/views/app', 'public/views');
});
