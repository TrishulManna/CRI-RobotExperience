{!! Form::open([
      'method' => 'POST',
      'id' => 'edit-database',
      'route' => 'texts.saveicon'
  ]) !!}

<div id="form-errors"></div>

<div class="form-group">
    {!! Form::label('icon', 'Select icon to add to this text:', ['class' => 'control-label']) !!}
    {!! Form::select('icon', $icons, null, ['class' => 'form-control', 'single' => 'single']) !!}
</div>

{!! Form::hidden('text_id', $text_id, null, ['class' => 'form-control']) !!}

{!! Form::submit('Add to Text', ['class' => 'btn btn-primary btn-block']) !!}

{!! Form::close() !!}

<script>
    $("#edit-database").ajaxform();

    $(document).ready(function() {
       $("select").selectize();
    });
</script>

