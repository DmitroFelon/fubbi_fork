let mix = require('laravel-mix');


mix.sass('resources/assets/sass/app.scss', 'public/css')
    .copy('resources/assets/vendor/bootstrap/fonts', 'public/fonts')
    .copy('resources/assets/vendor/font-awesome/fonts', 'public/fonts')
    .styles(
        [
            'resources/assets/vendor/bootstrap/css/bootstrap.css',
            'resources/assets/js/plugins/jquery-ui/jquery-ui.min.css',
            'resources/assets/vendor/animate/animate.css',
            'resources/assets/vendor/font-awesome/css/font-awesome.css',
            'resources/assets/sass/plugins/steps/jquery.steps.css',
        ],
        'public/css/vendor.css')
    .scripts(
        [
            'resources/assets/js/bootstap.js',
            'resources/assets/vendor/jquery/jquery-3.1.1.min.js',
            'resources/assets/js/plugins/jquery-ui/jquery-ui.min.js',
            'resources/assets/vendor/bootstrap/js/bootstrap.js',
            'resources/assets/vendor/metisMenu/jquery.metisMenu.js',
            'resources/assets/vendor/slimscroll/jquery.slimscroll.min.js',
            'resources/assets/vendor/pace/pace.min.js',
            'resources/assets/js/plugins/jasny/jasny-bootstrap.min.js',
            'resources/assets/js/plugins/steps/jquery.steps.min.js',
            'resources/assets/js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js',
            'resources/assets/js/app.js'
        ],
        'public/js/app.js')
    .sourceMaps();
