<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">


                <h2 style="margin: 0; ">Dashboard: <?php echo e($project->name); ?></h2>
                
                <a style="margin-bottom: 30px; margin-top: 10px;" href="<?php echo e(route('projects.change', $project->id)); ?>" class="btn btn-default" role="button" title="Edit"><i class="fa fa-pencil action-icon project-action-icon"></i></a>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Behaviors</h3>
                    </div>
                    <div class="panel-body">
                        <p style="text-align: right">
                            <a href="<?php echo e(route('behaviors.link', $project->id)); ?>" class="btn btn-default align-right" data-title="Add behaviors to Dashboard" data-toggle="lightbox"><i class="fa fa-external-link action-icon"></i> Link Behavior</a>
                        </p>

                        <table id="behaviors" class="table table-striped">
                            <tr>
                            <th colspan="1">Nr.</th> 
                            <th colspan="3">Behavior name</th>
                                <th style="text-align: right">Actions</th>
                            </tr>
                            <?php if(!$project->behaviors->count()): ?>
                                <tr>
                                    <td colspan="3">No behaviors added yet.</td>
                                </tr>
                            <?php endif; ?>
                     
                            <button id="myButton1" type="button" class="btn btn-info SeeMore2" data-toggle="collapse" data-target=".demo" style="width:100%">Show first 25</button>
                            
                            <?PHP 
                            $i=1;
                           
                            ?>
                            <?php $__currentLoopData = $project->behaviors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $behavior): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <?PHP 
                          
                            //echo $i;
                            if($i < 26) {$bg="#EEEECC"; $collapse="collapse";} else {$bg=""; $collapse="collapse in";}

                          //  if($i == 1) {echo "JA";}


                            ?>
 

                                <tr id="<?php echo e($behavior->id); ?>" class="demo <?=$collapse;?>">
                                <td><?=$i;?></td>
                                    <?php if(!$behavior->icondata): ?>
                                        <td class="project-list-icon" style="background-color: <?=$bg;?>;"><i class="fa fa-smile-o list-icon"></i></td>
                                    <?php else: ?>
                                    <td style="background-color: <?=$bg;?>;"><img class="pull-left list-icon icon-icon" src="<?php echo e('data:image/' . $behavior->icondata['type'] . ';base64,' . $behavior->icondata['icon']); ?>"/></td>
                                    <?php endif; ?>
                                    <td style="background-color: <?=$bg;?>;"><?php if(isset($behavior->sayanimation )): ?><i class="fa fa-child"></i><?php else: ?> &nbsp; <?php endif; ?></td>
                                    <td style="background-color: <?=$bg;?>;"><?php echo e($behavior->name); ?></td>
                                    <td style="background-color: <?=$bg;?>;">
                                        <a href="<?php echo e(route('projects.deletebehavior', [$behavior->id, $project->id])); ?>" class="remove-confirm"><i class="fa fa-times pull-right"></i></a>
                                    </td>
                                </tr>

                                <?PHP 
                            $i=$i+1;
                          //  if($i == 26) {echo "NEE";}
                            ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Texts</h3>
                    </div>
                    <div class="panel-body">
                        <p style="text-align: right">
                            <a href="<?php echo e(route('texts.link', $project->id)); ?>" class="btn btn-default align-right" data-title="Add texts to Dashboard" data-toggle="lightbox"><i class="fa fa-external-link action-icon"></i> Link Text</a>
                            
                        </p>

                        <table id="texts" class="table table-striped">
                            <tr>
                            <th colspan="1">Nr.</th>    
                            <th colspan="2">Text name</th>
                                <th style="text-align: right">Actions</th>
                            </tr>
                            <?php if(!$project->texts->count()): ?>
                                <tr>
                                    <td colspan="3">No texts added yet.</td>
                                </tr>
                            <?php endif; ?>

                            <button id="myButton2" type="button" class="btn btn-info SeeMore2" data-toggle="collapse" data-target=".demo2" style="width:100%">Show first 25</button>
                            
                            <?PHP 
                            $j=1;
                           
                            ?>

                            <?php $__currentLoopData = $project->texts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $text): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <?PHP 
                          
                            //echo $i;
                            if($j < 26) {$bg2="#EEEECC"; $collapse2="collapse";} else {$bg2=""; $collapse2="collapse in";}

                          //  if($i == 1) {echo "JA";}


                            ?>
                                <tr id="<?php echo e($text->id); ?>"  class="demo2 <?=$collapse2;?>">
                                <td style="background-color: <?=$bg2;?>;"><?=$j;?></td>
                                 <?php if(!$text->icondata): ?>
                                        <td class="project-list-icon"  style="background-color: <?=$bg2;?>;"><i class="fa fa-commenting-o list-icon"></i></td>
                                    <?php else: ?>
                                    <td style="background-color: <?=$bg2;?>;"><img class="pull-left list-icon icon-icon" src="<?php echo e('data:image/' . $text->icondata['type'] . ';base64,' . $text->icondata['icon']); ?>"/></td>
                                    <?php endif; ?>
                                    <td style="background-color: <?=$bg2;?>;"><?php echo e($text->name); ?></td>
                                    <td style="background-color: <?=$bg2;?>;">
                                        <a href="<?php echo e(route('projects.deletetext', [$text->id, $project->id])); ?>" class="remove-confirm"><i class="fa fa-times pull-right"></i></a>
                                    </td>
                                </tr>
                                <?PHP 
                            $j=$j+1;
                          //  if($i == 26) {echo "NEE";}
                            ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
        $(document).ready(function() {


            $('.SeeMore2').click(function(){
		var $this = $(this);
		$this.toggleClass('SeeMore2');
		if($this.hasClass('SeeMore2')){
            $this.text('It is not possible to collapse');
          			
		} else {
			$this.text('First 25 are shown');
		}
	});



            $("#behaviors").tableDnD(
                {
                    onDrop: function(table, row) {
                        $.ajax({
                            url: "<?php echo e(route('behaviors.reorder', [$project->id])); ?>",
                            data: $.tableDnD.serialize()
                        });
                    }
                }
            );
            $("#texts").tableDnD(
                {
                    onDrop: function(table, row) {
                        $.ajax({
                            url: "<?php echo e(route('texts.reorder', [$project->id])); ?>",
                            data: $.tableDnD.serialize()
                        });
                    }
                }
            );
        });
    </script>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>