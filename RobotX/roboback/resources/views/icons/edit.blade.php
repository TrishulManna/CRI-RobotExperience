@extends('layouts.app')

@section('content')
    @if( isset($icon) )
        {!! Form::model($icon, [
            'method' => 'PATCH',
            'id' => 'edit-database',
            'route' => ['icons.update', $icon->id]
        ]) !!}
    @else
        {!! Form::open([
            'method' => 'POST',
            'id' => 'edit-database',
            'route' => 'icons.store'
        ]) !!}
    @endif

    <div class="container">

        <div id="form-errors" style="color: red; font-weight: bold; padding-bottom: 5px;"></div>

        <div class="form-group">
            {!! Form::label('name', 'Name of this icon:', ['class' => 'control-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('icon', 'Icon:', ['class' => 'control-label']) !!}
            <div id="current_icon" class="input-group">
                @if( isset($icon) )
                    <img src="{{ 'data:image/' . $icon->type . ';base64,' . $icon->icon }}"/>
                @else
                    <i class="fa fa-info pull-right list-icon"></i>
                @endif
            </div>
        </div>

        {!! Form::hidden('type', null, ['id' => 'type']) !!}
        {!! Form::hidden('icon', null, ['id' => 'icon']) !!}
        <div id="icon-upload" class="dropzone drop-upload" style="margin-bottom: 20px;"></div>

        <div class="form-group">
            {!! Form::label('text', 'Description:', ['class' => 'control-label']) !!}
            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5']) !!}
        </div>

        @if(isset($project_id) && $project_id)
            {!! Form::hidden('project_id', $project_id) !!}
        @endif

        {!! Form::submit('Save Icon', ['class' => 'btn btn-primary btn-block']) !!}

        {!! Form::close() !!}

    </div>
@endsection

@section('javascript')
    <script>
        $("#edit-database").ajaxform( { form: 'Icon', index: "{{ route('icons.index') }}" } );

        $(document).ready(function() {
            $("#icon-upload").dropzone({
                url: "{{ route('icons.saveicon') }}",
                maxFiles: 1,
                maxFilesize: 1,
                uploadMultiple: false,
                paramName: 'uploadfile',
                acceptedFiles: 'image/*',
                dictDefaultMessage: "Click or drag to upload icon <br />",
                createImageThumbnails: true,
                thumbnailHeight: 150,
                accept: function(file, done) {
                    console.log("accept.url=" + '{{ route('icons.saveicon') }}');
                    console.log("accept.file=" + JSON.stringify(file));
                    done();
                },
                sending: function(file, xhr, formData) {
                    // console.log("accept.sending=" + $('[name=_token]').val());
                    formData.append("_token", $('[name=_token').val());
                },
                error: function(file, message) {
                    console.log("error.file=" + JSON.stringify(file));
                    // console.log("error.message=" + message);
                    $("#form-errors").html("Upload icon not successful!");
                    $("#icon-upload").html("");
                    $("#image").val("");
                },
                success: function(file, response) {
                    console.log("success.file=" + JSON.stringify(file));
                    console.log("success.response=" + JSON.stringify(response));
                    $("#icon").val(response.file);
                    $("#type").val(response.type);
                    $("#current_icon").html("<img src='data:image/" + response.type + ";base64," + response.file + "'/>")
                    $("#icon-upload").html("");
                }
            });
        });
    </script>
@endsection
