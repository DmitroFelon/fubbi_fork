<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Fubbi</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="<?php echo e(URL::to('css/app.css')); ?>" rel="stylesheet">
    <script src="<?php echo e(URL::to('js/app.js')); ?>" rel="stylesheet"></script>
</head>
<header>
    <?php echo $__env->make('header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</header>
<body>

<main role="main" class="container-fluid">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        <?php echo $__env->make('partials.left-sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        <?php echo $__env->make('partials.right-sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
</main>

<footer class="footer">
    <?php echo $__env->yieldContent('script'); ?>

    <?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</footer>

</body>
</html>
