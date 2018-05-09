<?php $__env->startSection('content'); ?>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-body">

            <div class="panel-body">
              <p class="list-header">
                <span class="user-header">Users</span>
                <a href="<?php echo e(route('users.create')); ?>" class="btn btn-default align-right">
                    <i class="fa fa-plus action-icon" title="New User"></i>
                </a>
              </p>

              <div class="form-group">

            <table class="table table-striped">
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>E-mail</th>
                  <th>Created at</th>
                  </tr>
                <?php if(!$users->count()): ?>
                  <tr>
                    <td colspan="4">No Users added yet.</td>
                  </tr>
                <?php endif; ?>

                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <tr>
                    <td class="robot-actions">
                        <a href="<?php echo e(route('users.edit', $user->id)); ?>">
                            <i class="fa fa-pencil pull-left list-icon"></i>
                        </a>
                        <a href="<?php echo e(route('users.destroy', $user->id)); ?>" class="remove-confirm">
                            <i class="fa fa-trash pull-right list-icon"></i>
                        </a>
                        <a href="edit.blade.php"></a>
                    </td>
                    <td><?php echo e($user->name); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td><?php echo e($user->created_at); ?></td>
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