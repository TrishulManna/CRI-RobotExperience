<?php $__env->startSection('content'); ?>

    <div class="container">
        <div id="row">
            <div class="col-md-12">
                <?php if(!Auth::guest()): ?>
                    <p class="project-header">
                        <a href="<?php echo e(route('projects.create')); ?>" class="btn btn-default align-right">
                            <i class="fa fa-plus list-icon" title=" Add project"></i>
                        </a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <div class="panel-group" id="accordion">
            <div id="row">
                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                            <?php if(!Auth::guest()): ?>
                                <a href="<?php echo e(route('projects.edit', $project->id)); ?>">
                                    <img src="<?php echo e($project->getImage()); ?>" class="project-image" alt="Project image" title="<?php echo e($project->name); ?>">
                                </a>
                            <?php else: ?>
                                <img src="<?php echo e($project->getImage()); ?>" class="project-image" alt="Project image" title="<?php echo e($project->name); ?>">
                            <?php endif; ?>
                            <div class="caption">
                                <h4><?php echo e($project->name); ?></h4>
                                <p><i class="fa fa-clock-o" class="project-date"></i> <?php echo e(date('d-m-Y H:i', strtotime($project->start_time))); ?></p>
                                <?php if(!Auth::guest()): ?>
                                    <p>
                                        <?php echo e(Form::open(['route' => ['projects.destroy', $project->id], 'method' => 'delete', 'style' => 'display: inline'])); ?>

                                            <a href="<?php echo e(route('projects.edit', $project->id)); ?>" class="btn btn-primary" role="button" title="Edit"><i class="fa fa-pencil project-action-icon"></i></a>
                                            <a href="<?php echo e(route('projects.copy', $project->id)); ?>" class="btn btn-default" role="button" title="Copy"><i class="fa fa-copy project-action-icon"></i></a>
                                            <button type="submit" class="btn btn-default" role="button" title="Delete"><i class="fa fa-trash project-action-icon"></i></button>
                                        <?php echo e(Form::close()); ?>

                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>