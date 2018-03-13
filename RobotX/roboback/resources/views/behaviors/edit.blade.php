@if( isset($behavior) )
    {!! Form::model($behavior, [
        'method' => 'PATCH',
        'id' => 'edit-database',
        'route' => ['behaviors.update', $behavior->id]
    ]) !!}
@else
    {!! Form::open([
        'method' => 'POST',
        'id' => 'edit-database',
        'route' => 'behaviors.store'
    ]) !!}
@endif

<div id="form-errors"></div>

<div class="form-group">
    {!! Form::label('name', 'Name of this behavior:', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('slug', 'Internal name:', ['class' => 'control-label']) !!}
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

@if(isset($project_id) && $project_id)
    {!! Form::hidden('project_id', $project_id) !!}
@endif

{!! Form::submit('Save text', ['class' => 'btn btn-primary btn-block']) !!}

{!! Form::close() !!}

<script>
    $("#edit-database").ajaxform();
</script>