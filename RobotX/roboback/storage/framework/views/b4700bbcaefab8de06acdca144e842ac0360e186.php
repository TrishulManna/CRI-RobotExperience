<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Request</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="<?php echo e(route('requestform_submit')); ?>">
                        <?php echo e(csrf_field()); ?>


                        <label class="col-md-9 control-label">Step 1: Enter your Contact Information</label></br></br>

                        <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" required autofocus>

                                <?php if($errors->has('name')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('phonenumber') ? ' has-error' : ''); ?>">
                            <label for="phonenumber" class="col-md-4 control-label">Phone number</label>

                            <div class="col-md-6">
                                <input id="phonenumber" type="text" class="form-control" name="phonenumber" value="<?php echo e(old('phonenumber')); ?>" required>

                                <?php if($errors->has('phonenumber')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('phonenumber')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required>

                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <label class="col-md-9 control-label">Step 2: Enter your Company Information</label></br></br>

                        <div class="form-group<?php echo e($errors->has('company') ? ' has-error' : ''); ?>">
                            <label for="company" class="col-md-4 control-label">Company</label>

                            <div class="col-md-6">
                                <input id="company" type="text" class="form-control" name="company" value="<?php echo e(old('company')); ?>" required>

                                <?php if($errors->has('company')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('company')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('address') ? ' has-error' : ''); ?>">
                            <label for="address" class="col-md-4 control-label">Address</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="<?php echo e(old('address')); ?>" required>

                                <?php if($errors->has('address')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('address')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>


                        <div class="form-group<?php echo e($errors->has('postalcode') ? ' has-error' : ''); ?>">
                            <label for="postalcode" class="col-md-4 control-label">Postal code</label>

                            <div class="col-md-6">
                                <input id="Postal" type="text" class="form-control" name="postalcode" value="<?php echo e(old('postalcode')); ?>" required>

                                <?php if($errors->has('postalcode')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('postalcode')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Request
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>