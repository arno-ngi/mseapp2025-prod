const mix = require('laravel-mix');

mix
    .combine([
        'resources/assets/css/jquery-jvectormap-1.2.2.css',
        'resources/assets/css/preloader.css',
        'resources/assets/css/bootstrap.min.css',
        'resources/assets/css/icons.css',
        'resources/assets/css/alertify.min.css',
        'resources/assets/css/treeview.css',
        'resources/assets/css/app.css',
    ], 'public/css/law.css').version()
    .combine([
        'resources/assets/js/jquery.min.js',
        'resources/assets/js/bootstrap.bundle.min.js',
        'resources/assets/js/metisMenu.min.js',
        'resources/assets/js/simplebar.min.js',
        'resources/assets/js/waves.min.js',
        'resources/assets/js/feather.min.js',
        'resources/assets/js/pace.min.js',
        'resources/assets/js/dashboard.init.js',
        'resources/assets/js/apexcharts.min.js',
        'resources/assets/js/alertify.min.js',
        'resources/assets/js/typehead.js',
        'resources/assets/js/treeview.js',
        'resources/assets/js/app.js',
    ], 'public/js/law.js').version();
