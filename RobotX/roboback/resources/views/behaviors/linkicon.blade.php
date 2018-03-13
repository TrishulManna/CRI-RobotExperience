{!! Form::open([
      'method' => 'POST',
      'id' => 'edit-database',
      'route' => 'behaviors.saveicon'
  ]) !!}

<div id="form-errors"></div>

<div class="form-group">
    {!! Form::label('icon', 'Select icon to add to this behavior:', ['class' => 'control-label']) !!}
    {!! Form::select('icon', $icons, null, ['class' => 'form-control', 'single' => 'single']) !!}
</div>

{!! Form::hidden('behavior_id', $behavior_id, null, ['class' => 'form-control']) !!}

{!! Form::submit('Add to Behavior', ['class' => 'btn btn-primary btn-block']) !!}

{!! Form::close() !!}

<script>
    $("#edit-database").ajaxform();

    $(document).ready(function() {
       $("select").selectize();
    });
</script>