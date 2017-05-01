var elixir = require('laravel-elixir');

elixir(function (mix) {

    // Copy all files to the public directory
    mix.copy('resources/assets/css', 'public/css');
    mix.copy('resources/assets/adminLTE', 'public/adminLTE');
    mix.copy('resources/assets/fonts', 'public/fonts');
    mix.less(['utilities.less', 'mod.less', 'custom.less', 'forum.less'], 'resources/assets/css/compiled.css');

    // First mix all required styles and put them in the resources/css directory (overwriting previous compiled file)
    mix.styles([
        'dist/animate.css',
        'dist/bootstrap-jquery-ui.css',
        'dist/bootstrap.min.css',
        'compiled.css'
    ], 'resources/assets/css/compiled.css');

    // Then mix the theme styles and copy to public directory as core.css
    mix.styles([
        'fonts/source-sans-pro/font.css',
        'css/compiled.css',
        'adminLTE/css/adminLTE.css',
    ], 'public/css/core.css', 'resources/assets');

    // Mix all scripts
    mix.scripts([
        'dist/jquery.js',
        'dist/jquery-ui.js',
        'dist/jquery-cropit.js',
        'dist/bootstrap.min.js',
        'global.js',
        'tabs.js',
        'custom.js',
        'are_you_sure.js',
        'forum/mod.js',
        'forum/checkall.js',
        'forum/report.js',
        'core.js',
        'ban-user.js',
    ], 'public/js/scripts.js');

    mix.copy('resources/assets/js/dist', 'public/js');
    mix.copy('resources/assets/js/bbcode', 'public/js/bbcode');

});
