let mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public').setPublicPath('public').vue().version();