<?php echo Form::open([
      'method' => 'POST',
      'id' => 'edit-database',
      'route' => 'texts.savelink'
  ]); ?>


<div id="form-errors"></div>

<div class="form-group">
    <?php echo Form::label('texts[]', 'Select texts to add to this dashboard:', ['class' => 'control-label']); ?>

    <?php echo Form::select('texts[]', $texts, null, ['class' => 'form-control', 'single' => 'single']); ?>

</div>

<?php echo Form::hidden('project_id', $project_id, null, ['class' => 'form-control']); ?>


<?php echo Form::submit('Add to Dashboard', ['class' => 'btn btn-primary btn-block']); ?>


<?php echo Form::close(); ?>


<script>
    $("#edit-database").ajaxform( { form: 'LinkText', index: "<?php echo e(route('projects.edit', $project_id)); ?>" } );

    $(document).ready(function() {
       $("select").selectize();
    });
</script>