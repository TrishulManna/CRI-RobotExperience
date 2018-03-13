@if( isset($text) )
    {!! Form::model($text, [
        'method' => 'PATCH',
        'id' => 'edit-database',
        'route' => ['texts.update', $text->id]
    ]) !!}
@else
    {!! Form::open([
        'method' => 'POST',
        'id' => 'edit-database',
        'route' => 'texts.store'
    ]) !!}
@endif

<div id="form-errors"></div>

<div class="form-group">
    {!! Form::label('name', 'Name of this text:', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('text', 'Text to speak:', ['class' => 'control-label']) !!}
    {!! Form::textarea('text', null, ['class' => 'form-control']) !!}
</div>

@if(isset($project_id) && $project_id)
    {!! Form::hidden('project_id', $project_id) !!}
@endif

{!! Form::submit('Save text', ['class' => 'btn btn-primary btn-block']) !!}

{!! Form::close() !!}

<script>
    $("#edit-database").ajaxform();
</script>