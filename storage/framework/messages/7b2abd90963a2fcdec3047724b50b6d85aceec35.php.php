<ul class="list-group">
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a class="list-group-item <?php echo e((Request::is(ltrim($link, '/')))?'active':''); ?>" href="<?php echo e($link); ?>"><?php echo e($name); ?></a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>

