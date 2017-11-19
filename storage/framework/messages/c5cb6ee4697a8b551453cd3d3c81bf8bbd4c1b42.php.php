<?php $__env->startSection('content'); ?>
    <?php echo Form::open(['files' => true, 'method' => 'POST', 'role'=>'form', 'id' => 'project-form', 'action' => ['ProjectController@store']]); ?>


    <?php echo $__env->make('pages.client.projects.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class='form-group'>
        <?php echo Form::submit('Save', ['class' => 'btn btn-success form-control']); ?>

    </div>
    <?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>



<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>