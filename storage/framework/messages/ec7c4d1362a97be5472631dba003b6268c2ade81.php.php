<ul class="nav nav-tabs">
    <?php for($i=1;$i<9;$i++): ?>
        <li class="<?php echo e(($i==1)?'active':''); ?>">
            <a href="#keyword-<?php echo e($i); ?>" data-toggle="tab">Overview <?php echo e($i); ?></a>
        </li>
    <?php endfor; ?>
</ul>
<div class="tab-content clearfix">
    <?php for($i=1;$i<9;$i++): ?>
        <div class="tab tab-pane <?php echo e(($i==1)?'active':''); ?>" id="keyword-<?php echo e($i); ?>">
            <?php $__currentLoopData = array_chunk($keywords, 10)[$i]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyword): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <label>
                        <input name="keywords[]" type="checkbox" value="<?php echo e($keyword["text"]); ?>">
                        <?php echo e(ucfirst($keyword["text"])); ?>

                    </label>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endfor; ?>
</div>
