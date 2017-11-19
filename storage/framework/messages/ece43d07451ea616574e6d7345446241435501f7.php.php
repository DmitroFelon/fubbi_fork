<?php $__env->startSection('content'); ?>
    <?php echo Form::model($project, ['files' => true, 'method' => 'PUT', 'role'=>'form', 'id' => 'project-form', 'action' => ['ProjectController@update', 'id' => $project->id]]); ?>

    <?php echo $__env->make('pages.client.projects.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo Form::submit('Save', ['class' => 'btn btn-success form-control']); ?>

    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>