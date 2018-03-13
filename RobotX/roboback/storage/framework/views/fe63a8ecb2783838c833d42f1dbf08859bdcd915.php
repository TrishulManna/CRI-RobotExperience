<?php $__env->startSection('content'); ?>
    <?php if( isset($text) ): ?>
        <?php echo Form::model($text, [
            'method' => 'PATCH',
            'id' => 'edit-database',
            'route' => ['texts.update', $text->id]
        ]); ?>

    <?php else: ?>
        <?php echo Form::open([
            'method' => 'POST',
            'id' => 'edit-database',
            'route' => 'texts.store'
        ]); ?>

    <?php endif; ?>

    <div class="container">

        <div id="form-errors"></div>


        <div class="form-group">
            <?php echo Form::label('name', 'Name of this text:', ['class' => 'control-label']); ?>

            <?php echo Form::text('name', null, ['class' => 'form-control']); ?>

        </div>

        <?php if( isset($text) ): ?>
            <div class="form-group">
                <?php echo Form::label('id', 'ID / Created / Modified:', ['class' => 'control-label']); ?>

                <br /> ff
                <?php echo Form::text('id', $text->id, ['class' => '', 'readonly' => 'readonly']); ?>

                <?php echo Form::text('created', $text->createdDate(), ['class' => '', 'readonly' => 'readonly']); ?>

                <?php echo Form::text('updated', $text->updatedDate(), ['class' => '', 'readonly' => 'readonly']); ?>

            </div>
        <?php endif; ?>

        <div class="form-group">
            <?php echo Form::label('icon', 'Icon:', ['class' => 'control-label']); ?>

            <div class="input-group">
                <?php if( isset($text->icondata ) ): ?>
                    <?php echo Form::hidden('icon', $text->icondata->id, ['id' => 'text-icon']); ?>

                    <img src="<?php echo e('data:image/' . $text->icondata->type . ';base64,' . $text->icondata->icon); ?>"/>
                <?php else: ?>
                    <?php echo Form::hidden('icon', 'fa-commenting-o', ['id' => 'text-icon']); ?>

                    <i class="fa fa-commenting-o list-icon"></i>
                <?php endif; ?>
                <?php if( isset($text) ): ?>
                    <?php echo Form::hidden('text_id', $text->id); ?>

                   <a id="add-icon-link" onclick="addIcon()" href="#" class="btn btn-default align-right text-icon-selector" data-title="Add icon to text" data-toggle="lightbox"><i class="fa fa-external-link action-icon"></i> Link Icon</a>
                <?php else: ?>
                    <?php echo Form::hidden('text_id', 'NEW'); ?>

                    <a id="add-icon-link" onclick="addIcon()" href="#" class="btn btn-default align-right text-icon-selector" data-title="Add icon to text" data-toggle="lightbox"><i class="fa fa-external-link action-icon"></i> Link Icon</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo Form::label('text', 'Text to speak:', ['class' => 'control-label']); ?>

            <?php echo Form::textarea('text', null, ['class' => 'form-control', 'rows' => '5']); ?>

        </div>

        <div class="form-group">
            <?php echo Form::label('basemenu', 'Base Menu:', ['class' => 'control-label']); ?>

            <?php echo Form::select('basemenu', $base_menus, null, ['class' => 'form-control', 'single' => 'single']); ?>

        </div>

        <div class="form-group">
            <?php echo Form::label('languages', 'Language:', ['class' => 'control-label']); ?>

            <?php echo Form::select('language', $languages, null, ['class' => 'form-control', 'single' => 'single']); ?>

        </div>

        <div class="form-group">
            <?php echo Form::label('voicecommands', 'Voice Commands:', ['class' => 'control-label']); ?>

            <?php echo Form::textarea('voicecommands', null, ['class' => 'form-control', 'rows' => '5']); ?>

        </div>

        <div class="form-group">
            <?php echo Form::label('animations', 'Animation:', ['class' => 'control-label']); ?>

            <?php echo Form::select('animations[]', $animations, null, ['class' => 'form-control', 'multiple' => 'multiple']); ?>

         </div>

        <div class="form-group">
            <?php echo Form::label('description', 'Description:', ['class' => 'control-label']); ?>

            <?php echo Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5']); ?>

        </div>

        <?php if(isset($project_id) && $project_id): ?>
            <?php echo Form::hidden('project_id', $project_id); ?>

        <?php endif; ?>

        <?php echo Form::submit('Save Text', ['class' => 'btn btn-primary btn-block']); ?>


        <?php echo Form::close(); ?>


    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
        $("#edit-database").ajaxform( { form: 'Text', index: "<?php echo e(route('texts.index')); ?>" } );

        $(document).ready(function() {
        });

        function addIcon() {
            $("#add-icon-link").attr("href", "<?php echo e(route('texts.icons', 'ID')); ?>?" + $("#edit-database").serialize());
            return false;
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>