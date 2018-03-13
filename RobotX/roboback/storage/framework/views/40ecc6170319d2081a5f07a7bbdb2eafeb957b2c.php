<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <p class="list-header">
                            <span class="robot-header">Robots</span>
                            <a href="<?php echo e(route('robots.create')); ?>" class="btn btn-default align-right">
                                <i class="fa fa-plus action-icon" title="New Robot"></i>
                            </a>
                        </p>

                        <table class="table table-striped">
                            <tr>
                                <th></th>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>OS</th>
                                <th>Version</th>
                            </tr>
                            <?php if(!$robots->count()): ?>
                                <tr>
                                    <td colspan="4">No robots added yet.</td>
                                </tr>
                            <?php endif; ?>

                            <?php $__currentLoopData = $robots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $robot): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>
                                    <td class="robot-actions">
                                        <a href="<?php echo e(route('robots.edit', $robot->id)); ?>">
                                            <i class="fa fa-pencil pull-left list-icon"></i>
                                        </a>
                                        <a href="<?php echo e(route('robots.destroy', $robot->id)); ?>" class="remove-confirm">
                                            <i class="fa fa-trash pull-right list-icon"></i>
                                        </a>
                                        <a href="edit.blade.php"></a>
                                    </td>
                                    <td><?php echo e($robot->type); ?></td>
                                    <td><?php echo e($robot->name); ?></td>
                                    <td><?php echo e($robot->version); ?></td>
                                    <td><?php echo e($robot->ostype); ?></td>
                                    <td><?php echo e($robot->osversion); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>