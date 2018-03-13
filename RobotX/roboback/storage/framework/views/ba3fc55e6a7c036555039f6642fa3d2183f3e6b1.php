<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <p class="list-header">
                            <span class="icon-header">Icons</span>
                            <a href="<?php echo e(route('icons.create')); ?>" class="btn btn-default align-right">
                                <i class="fa fa-plus action-icon" title="New Icon"></i>
                            </a>
                        </p>

                        <table class="table table-striped">
                            <tr>
                                <th></th>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Description</th>
                            </tr>
                            <?php if(!$icons->count()): ?>
                                <tr>
                                    <td colspan="4">No icons added yet.</td>
                                </tr>
                            <?php endif; ?>

                            <?php $__currentLoopData = $icons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icon): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>
                                    <td class="icon-actions">
                                        <a href="<?php echo e(route('icons.edit', $icon->id)); ?>">
                                            <i class="fa fa-pencil pull-left list-icon"></i>
                                        </a>
                                        <a href="<?php echo e(route('icons.destroy', $icon->id)); ?>" class="remove-confirm">
                                            <i class="fa fa-trash pull-right list-icon"></i>
                                        </a>
                                        <a href="edit.blade.php"></a>
                                    </td>
                                    <td><img class="pull-left list-icon icon-icon" src="<?php echo e('data:image/' . $icon->type . ';base64,' . $icon->icon); ?>"/></td>
                                    <td><?php echo e($icon->name); ?></td>
                                    <td><?php echo e($icon->description); ?></td>
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