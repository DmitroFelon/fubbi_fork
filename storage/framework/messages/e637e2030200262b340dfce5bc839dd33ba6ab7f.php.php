<div class="project-card col-xs-3 col-sm-3 col-md-3 col-lg-3">
    <div>
        <div class="project-name">
            <a href="<?php echo e(action('ProjectController@show', ['id' => $project->id])); ?>"><?php echo e($project->id); ?></a>
        </div>
        <div class="project-edit">
            <a class="text-muted" href="<?php echo e(action('ProjectController@edit', ['id' => $project->id])); ?>">Edit</a>
        </div>
        <div class="project-name">
            <span><?php echo e($project->state); ?></span>
        </div>
        <div class="project-workers">
            <?php $__currentLoopData = $project->workers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $worker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('partials.client.projects.worker', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>