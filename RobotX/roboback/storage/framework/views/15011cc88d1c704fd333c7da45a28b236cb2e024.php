<?php $__env->startSection('content'); ?>
    <?php if( isset($user) ): ?>
        <?php echo Form::model($user, [
            'method' => 'PATCH',
            'id' => 'edit-database',
            'route' => ['users.update', $user->id]
        ]); ?>

    <?php else: ?>
        <?php echo Form::open([
            'method' => 'POST',
            'id' => 'edit-database',
            'route' => 'users.store'
        ]); ?>

    <?php endif; ?>

    <div class="container">

        <div id="form-errors" style="color: red; font-weight: bold; padding-bottom: 5px;"></div>

        <div class="form-group">
            <?php echo Form::label('name', 'name user:', ['class' => 'control-label']); ?>

            <?php echo Form::text('name', null, ['class' => 'form-control']); ?>

        </div>

        <div class="form-group">
            <?php echo Form::label('email', 'E-mail:', ['class' => 'control-label']); ?>

            <?php echo Form::text('email', null, ['class' => 'form-control']); ?>

        </div>

      

        <?php echo Form::submit('Save Users', ['class' => 'btn btn-primary btn-block']); ?>


        <?php echo Form::close(); ?>


    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
        $("#edit-database").ajaxform( { form: 'user', index: "<?php echo e(route('users.index')); ?>" } );

        $(document).ready(function() {
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>