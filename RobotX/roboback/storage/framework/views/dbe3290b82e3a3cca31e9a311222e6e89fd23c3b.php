<?php echo Form::open([
      'method' => 'POST',
      'id' => 'edit-database',
      'route' => 'behaviors.saveicon'
  ]); ?>


<div id="form-errors"></div>

<div class="form-group">
    <?php echo Form::label('icon', 'Select icon to add to this behavior:', ['class' => 'control-label']); ?>

    <?php echo Form::select('icon', $icons, null, ['class' => 'form-control', 'single' => 'single']); ?>

</div>

<?php echo Form::hidden('behavior_id', $behavior_id, null, ['class' => 'form-control']); ?>


<?php echo Form::submit('Add to Behavior', ['class' => 'btn btn-primary btn-block']); ?>


<?php echo Form::close(); ?>


<script>
    $("#edit-database").ajaxform();

    $(document).ready(function() {
       $("select").selectize();
    });
</script>