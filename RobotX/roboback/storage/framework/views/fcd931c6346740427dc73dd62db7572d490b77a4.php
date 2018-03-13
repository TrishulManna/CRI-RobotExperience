<?php echo Form::open([
      'method' => 'POST',
      'id' => 'edit-database',
      'route' => 'behaviors.savelink'
  ]); ?>


<div id="form-errors"></div>

<div class="form-group">
    <?php echo Form::label('behaviors[]', 'Select behaviors to add to this dashboard:', ['class' => 'control-label']); ?>

    <?php echo Form::select('behaviors[]', $behaviors, null, ['class' => 'form-control', 'single' => 'single']); ?>

</div>

<?php echo Form::hidden('project_id', $project_id, null, ['class' => 'form-control']); ?>


<?php echo Form::submit('Add to Dashboard', ['class' => 'btn btn-primary btn-block']); ?>


<?php echo Form::close(); ?>


<script>
    $("#edit-database").ajaxform( { form: 'LinkBehavior', index: "<?php echo e(route('projects.edit', $project_id)); ?>" } );

    $(document).ready(function() {
       $("select").selectize();
    });
</script>