<?php $__env->startSection('content'); ?>

    <?php if(isset($behavior)): ?>
        <?php echo Form::model($behavior, [
            'method' => 'PATCH',
            'id' => 'edit-database',
            'route' => ['behaviors.update', $behavior->id]
        ]); ?>

    <?php else: ?>
        <?php echo Form::open([
            'method' => 'POST',
            'id' => 'edit-database',
            'route' => 'behaviors.store'
        ]); ?>

    <?php endif; ?>

    <div class="container">

        <div id="form-errors" style="color: red; font-weight: bold; padding-bottom: 5px;"></div>

        <div class="form-group">
            <?php echo Form::label('name', 'Name of this behavior:', ['class' => 'control-label']); ?>

            <?php echo Form::text('name', null, ['class' => 'form-control']); ?>

        </div>

        <?php if(isset($behavior)): ?>
            <div class="form-group">
                <?php echo Form::label('id', 'ID / Created / Modified:', ['class' => 'control-label']); ?>

                <br />
                <?php echo Form::text('id', $behavior->id, ['class' => '', 'readonly' => 'readonly']); ?>

                <?php echo Form::text('created', $behavior->createdDate(), ['class' => '', 'readonly' => 'readonly']); ?>

                <?php echo Form::text('updated', $behavior->updatedDate(), ['class' => '', 'readonly' => 'readonly']); ?>

            </div>
        <?php endif; ?>

        <div class="form-group">
            <?php echo Form::label('icon', 'Icon:', ['class' => 'control-label']); ?>

            <div class="input-group">
                <?php if(isset($behavior->icondata)): ?>
                    <?php echo Form::hidden('icon', $behavior->icondata->id, ['id' => 'behavior-icon']); ?>

                    <img src="<?php echo e('data:image/' . $behavior->icondata->type . ';base64,' . $behavior->icondata->icon); ?>"/>
                <?php else: ?>
                    <?php echo Form::hidden('icon', 'fa-commenting-o', ['id' => 'behavior-icon']); ?>

                    <i class="fa fa-smile-o list-icon"></i>
                <?php endif; ?>
                <?php if(isset($behavior)): ?>
                    <?php echo Form::hidden('behavior_id', $behavior->id); ?>

                   <a id="add-icon-link" onclick="addIcon()" href="#" class="btn btn-default align-right text-icon-selector" data-title="Add icon to behavior" data-toggle="lightbox"><i class="fa fa-external-link action-icon"></i> Link Icon</a>
                <?php else: ?>
                    <?php echo Form::hidden('behavior_id', 'NEW'); ?>

                    <a id="add-icon-link" onclick="addIcon()" href="#" class="btn btn-default align-right text-icon-selector" data-title="Add icon to behavior" data-toggle="lightbox"><i class="fa fa-external-link action-icon"></i> Link Icon</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo Form::label('Video', 'Video:', ['class' => 'control-label']); ?>

            <?php echo e(Form::token()); ?>

            <?php echo Form::hidden('type', null, ['id' => 'type']); ?>

            <?php echo Form::hidden('vfile', null, ['id' => 'vfile']); ?>

            <div id="from-upload-video" class="dropzone drop-upload" style="margin-bottom: 20px;"></div>
        </div>
        <!--
        -->

        <div class="form-group">
            <?php echo Form::label('slug', 'Internal name:', ['class' => 'control-label']); ?>

            <?php echo Form::text('slug', null, ['class' => 'form-control']); ?>

        </div>

        <div class="form-group">
            <?php echo Form::label('behaviortype', 'Type Behavior:', ['class' => 'control-label']); ?>

            <?php echo Form::select('behaviortype', $behavior_types, null, ['class' => 'form-control', 'single' => 'single']); ?>

        </div>

        <div class="form-group">
            <?php echo Form::label('basemenu', 'Base Menu:', ['class' => 'control-label']); ?>

            <?php echo Form::select('basemenu', $base_menus, null, ['class' => 'form-control', 'single' => 'single']); ?>

        </div>

        <div class="form-group">
            <?php echo Form::label('languages', 'Language:', ['class' => 'control-label']); ?>

            <?php echo Form::select('languages[]', $languages, null, ['class' => 'form-control', 'multiple' => 'multiple']); ?>

        </div>

        <div class="form-group">
            <?php echo Form::label('voicecommands', 'Voice Commands:', ['class' => 'control-label']); ?>

            <?php echo Form::textarea('voicecommands', null, ['class' => 'form-control', 'rows' => '5']); ?>

        </div>

       <div class="form-group">
            <?php echo Form::label('sayanimation', 'Say Animation:', ['class' => 'control-label']); ?>

            <?php echo Form::checkbox('sayanimation', 'true', (Form::getValueAttribute('sayanimation') == 'true'?true:false), ['class' => 'project-animation-checkbox', 'id' => 'sayanimation']); ?>

       </div>

        <div class="form-group">
            <?php echo Form::label('description', 'Description:', ['class' => 'control-label']); ?>

            <?php echo Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5']); ?>

        </div>

        <div class="form-group">
            <?php echo Form::label('robots', 'Suitable For:', ['class' => 'control-label']); ?>

            <div id="robot_list" class="">
                <?php if(isset($behavior)): ?>
                   <?php $__currentLoopData = $behavior->robots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $robot): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <div class="robot-select" style="padding-bottom: 3px;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 50%;">
                                        <?php echo Form::select('robot_version[]', $robotnames, $robot->id, ['class' => 'form-control', 'single' => 'single', 'onchange' => 'changeRobotInfo(this)']); ?>

                                    </td>
                                    <td style="width: 10%; padding-left: 20px">
                                        <span style="font-weight: bold">OS:</span> <span class="robot-ostype-info" ><?php echo $robot->ostype; ?></span>
                                    </td>
                                    <td style="width: 10%; padding-left: 1px">
                                        <span style="font-weight: bold">Version:</span> <span class="robot-osversion-info"><?php echo $robot->osversion; ?></span>
                                    </td>
                                    <td style="width: 5px; padding-left: 1px">
                                        <a class="bhv-remove-robot" onclick="delRobot(this)">
                                            <i class="fa fa-trash pull-right list-icon"></i>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                <?php endif; ?>
            </div>
            <a class="btn btn-default align-right" onclick="addRobotSelect()">
                <i class="fa fa-plus action-icon robot-add-icon" title="New robot"></i>
            </a>
        </div>

        <?php if(isset($project_id) && $project_id): ?>
            <?php echo Form::hidden('project_id', $project_id); ?>

        <?php endif; ?>

        <?php echo Form::submit('Save Behavior', ['class' => 'btn btn-primary btn-block']); ?>


        <?php echo Form::close(); ?>


    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
        $("#edit-database").ajaxform( { form: 'Behavior', index: "<?php echo e(route('behaviors.index')); ?>" } );

        $(document).ready(function() {
            $("#from-upload-video").dropzone({
                url: "<?php echo e(route('behaviors.savevideo')); ?>",
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                method: 'post',
                maxFiles: 1,
                maxFilesize: 100000,
                uploadMultiple: false,
                paramName: 'uploadfile',
                acceptedFiles: 'video/*,image/*',
                dictDefaultMessage: "Click or drag to upload video <br />",
                // createImageThumbnails: true,
                // thumbnailHeight: 150,
                accept: function(file, done) {
                    console.log("accept.url=" + '<?php echo e(route('behaviors.savevideo')); ?>');
                    console.log("accept.file=" + JSON.stringify(file));
                    done();
                },
                sending: function(file, xhr, formData) {
                    console.log("sending.file=" + JSON.stringify(file));
                    console.log("sending.formData=" + JSON.stringify(formData));
                    // console.log("accept.sending=" + $('[name=_token]').val());
                    formData.append("_token", $('[name=_token').val());
                    formData.append("uploadfile", '/Users/geert/Desktop/RoboTest/test.mp4');
                },
                error: function(file, message) {
                    console.log("error.file=" + JSON.stringify(file));
                    console.log("error.message=" + message);
                    $("#form-errors").html("Upload video not successful!");
                    $("#form-upload-video").html("");
                    $("#vfile").val("");
                },
                success: function(file, response) {
                    console.log("success.file=" + JSON.stringify(file));
                    console.log("success.response=" + JSON.stringify(response));
                    $("#vfile").val(response.file);
                    $("#type").val(response.type);
                    $("#form-upload-video").html("");
                }
            });
        });

        function addIcon() {
            $("#add-icon-link").attr("href", "<?php echo e(route('behaviors.icons', 'ID')); ?>?" + $("#edit-database").serialize());
            return false;
        }

        function addRobotSelect() {
            var html = '<div class="robot-select" style="padding-bottom: 3px;"><table style="width: 100%;"><tr>' +
                       '<td style="width: 50%;"><?php echo Form::select('robot_version[]', $robotnames, null, ['class' => 'form-control', 'single' => 'single', 'onchange' => 'changeRobotInfo(this)']); ?></td>';
            <?php if(isset($robot)): ?>
                html = html + '<td style="width: 10%; padding-left: 20px"><span style="font-weight: bold">OS:</span> <span class="robot-ostype-info" ><?php echo $robot->ostype; ?></span></td>' +
                              '<td style="width: 10%; padding-left: 1px"><span style="font-weight: bold">Version:</span> <span class="robot-osversion-info"><?php echo $robot->osversion; ?></span></td>' +
                              '<td style="width: 5px; padding-left: 1px"><a class="bhv-remove-robot" onclick="delRobot(this)"><i class="fa fa-trash pull-right list-icon"></i></a></td>';
            <?php else: ?>
                html = html + '<td style="width: 10%; padding-left: 20px"><span style="font-weight: bold">OS:</span> <span class="robot-ostype-info" ></span></td>' +
                              '<td style="width: 10%; padding-left: 1px"><span style="font-weight: bold">Version:</span> <span class="robot-osversion-info"></span></td>' +
                              '<td style="width: 5px; padding-left: 1px"><a class="bhv-remove-robot" onclick="delRobot(this)"><i class="fa fa-trash pull-right list-icon"></i></a></td>';
            <?php endif; ?>
            html = html + '</tr></table></div>';
            $("#robot_list").append(html);
        }

        function changeRobotInfo(e) {
            // console.log("changeRobotInfo " + e.type);
            $.ajax({
               type: 'POST',
               headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
               },
               url: "<?php echo e(route('robots.getrobot' )); ?>",
               data: { id: e.value },
               success: function(data) {
                    // console.log("SUCCES " + JSON.stringify(data));
                    $(e).closest('.robot-select').find('.robot-ostype-info').html(data.ostype);
                    $(e).closest('.robot-select').find('.robot-osversion-info').html(data.osversion);
               },
               fail: function(e) {
                   console.log("ERROR " + e);
               }
            });
        }

        function delRobot(e) {
             $(e).closest('tr').remove();
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>