{!! Form::open([
      'method' => 'POST',
      'id' => 'edit-database',
      'route' => 'behaviors.savelink'
  ]) !!}

<div id="form-errors"></div>

<div class="form-group">
    {!! Form::label('behaviors[]', 'Select behaviors to add to this dashboard:', ['class' => 'control-label']) !!}
    {!! Form::select('behaviors[]', $behaviors, null, ['class' => 'form-control', 'single' => 'single']) !!}
</div>

{!! Form::hidden('project_id', $project_id, null, ['class' => 'form-control']) !!}

{!! Form::submit('Add to Dashboard', ['class' => 'btn btn-primary btn-block']) !!}

{!! Form::close() !!}

<script>
    $("#edit-database").ajaxform( { form: 'LinkBehavior', index: "{{ route('projects.edit', $project_id) }}" } );

    $(document).ready(function() {
       $("select").selectize();
    });
</script>