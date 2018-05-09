<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Request overview</div>

                <div class="panel-body">
                     <table class="table table-striped">
                            <tr>
                                <th>Name</th>
                                <th>Phone number</th>
                                <th>E-mail</th>
                                <th>Company</th>
                                <th>Address</th>
                                <th>Postal code</th>
                                
                            </tr>

                                    <?php $__currentLoopData = $request; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                          <tr class="bhv-row" id="data-info<?php echo e($data->id); ?>">
                                              <td class="data-name">
                                                <p><?php echo e($data->name); ?></p>
                                              </td>
                                              <td class="data-phonenumber">
                                                <p><?php echo e($data->phonenumber); ?></p>
                                              </td>
                                              <td class="data-email">
                                                <p><?php echo e($data->email); ?></p>
                                              </td>
                                              <td class="data-company">
                                                <p><?php echo e($data->company); ?></p>
                                              </td>
                                              <td class="data-address">
                                                <p><?php echo e($data->address); ?></p>
                                              </td>
                                              <td class="data-postalcode">
                                                <p><?php echo e($data->postalcode); ?></p>
                                              </td>



                                          </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>


                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>