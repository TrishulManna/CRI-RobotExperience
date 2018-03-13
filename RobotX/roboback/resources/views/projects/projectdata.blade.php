@extends('layouts.app')

@section('content')
    @if( isset($project) )
        {!! Form::model($project, [
            'method' => 'PATCH',
            'id' => 'edit-database',
            'route' => ['projects.update', $project->id]
        ]) !!}
    @else
        {!! Form::open([
            'method' => 'POST',
            'id' => 'edit-database',
            'route' => 'projects.store'
        ]) !!}
    @endif

    <div class="container">

        <div id="form-errors" style="color: red; font-weight: bold; padding-bottom: 5px;"></div>

        <div class="form-group">
            {!! Form::label('name', 'Name of this dashboard:', ['class' => 'control-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('start_time', 'Start time:', ['class' => 'control-label']) !!}
            {!! Form::text('start_time', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('logo', 'Logo:', ['class' => 'control-label']) !!}
            {!! Form::hidden('image', null, ['id' => 'image']) !!}
            {!! Form::hidden('picture', null, ['id' => 'picture']) !!}
            {!! Form::hidden('imgtype', null, ['id' => 'imgtype']) !!}
            <div id="form-upload" class="dropzone drop-upload" style="margin-bottom: 20px;"></div>
        </div>

        <div class="form-group">
            <table border="0" width="100%">
                <tr>
                    <td width="50%">
                        {!! Form::label('behavior_menus', 'Behavior Menus:', ['class' => 'control-label']) !!}
                    </td>
                    <td width="50%">
                        {!! Form::label('text_menus', 'Text Menus:', ['class' => 'control-label']) !!}
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        <label class="menu-label" for="bhv_dance_menu">
                            {!! Form::checkbox('bhv_dance_menu', 'true', (Form::getValueAttribute('bhv_dance_menu') == 'false'?false:true),  ['class' => 'menu-input', 'id' => 'bhv_dance_menu']) !!} Dance Menu
                        </label>
                    </td>
                    <td width="50%">
                        <label class="menu-label" for="text_dance_menu">
                            {!! Form::checkbox('text_dance_menu', 'true', (Form::getValueAttribute('text_dance_menu') == 'false'?false:true), ['class' => 'menu-input', 'id' => 'text_dance_menu']) !!} Compliments Menu
                        </label>
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        <label class="menu-label" for="bhv_greetings_menu">
                            {!! Form::checkbox('bhv_greetings_menu', 'true', (Form::getValueAttribute('bhv_greetings_menu') == 'false'?false:true), ['class' => 'menu-input', 'id' => 'bhv_greetings_menu']) !!} Greetings Menu
                        </label>
                    </td>
                    <td width="50%">
                        <label class="menu-label" for="text_greetings_menu">
                            {!! Form::checkbox('text_greetings_menu', 'true', (Form::getValueAttribute('text_greetings_menu') == 'false'?false:true), ['class' => 'menu-input', 'id' => 'text_greetings_menu']) !!} Greetings Menu
                        </label>
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        <label class="menu-label" for="bhv_interaction_menu">
                            {!! Form::checkbox('bhv_interaction_menu', 'true', (Form::getValueAttribute('bhv_interaction_menu') == 'false'?false:true), ['class' => 'menu-input', 'id' => 'bhv_interaction_menu']) !!} Action Menu
                        </label>
                    </td>
                    <td width="50%">
                        <label class="menu-label" for="text_interaction_menu">
                            {!! Form::checkbox('text_interaction_menu', 'true', (Form::getValueAttribute('text_interaction_menu') == 'false'?false:true), ['class' => 'menu-input', 'id' => 'text_interaction_menu']) !!} Interaction Menu
                        </label>
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        <label class="menu-label" for="bhv_presentation_menu">
                            {!! Form::checkbox('bhv_presentation_menu', 'true', (Form::getValueAttribute('bhv_presentation_menu') == 'false'?false:true), ['class' => 'menu-input', 'id' => 'bhv_presentation_menu']) !!} Presentation Answers
                        </label>
                    </td>
                    <td width="50%">
                        <label class="menu-label" for="text_presentation_menu">
                            {!! Form::checkbox('text_presentation_menu', 'true', (Form::getValueAttribute('text_presentation_menu') == 'false'?false:true), ['class' => 'menu-input', 'id' => 'text_presentation_menu']) !!} Robot Answers
                        </label>
                    </td>
                </tr>
            </table>
        </div>

        {!! Form::submit('Save Project', ['class' => 'btn btn-primary btn-block']) !!}

        {!! Form::close() !!}

    </div>
@endsection

@section('javascript')
    @if( isset($project) )
        <script>
            $("#edit-database").ajaxform( { form: 'Project', index: "{{ route('projects.edit', $project->id) }}" } );
        </script>
    @else
        <script>
            $("#edit-database").ajaxform( { form: 'Project', index: "{{ route('projects.store') }}" } );
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $('#start_time').datetimepicker({
                lang: 'nl',
                format:'d-m-Y H:i',
                minDate: 0,
                defaultTime: '13:00',
                allowBlank: true
            });

            $("#form-upload").dropzone({
                url: "{{ route('projects.image') }}",
                maxFiles: 1,
                maxFilesize: 1,
                uploadMultiple: false,
                paramName: 'uploadfile',
                acceptedFiles: 'image/*',
                dictDefaultMessage: "Click or drag to upload image <br />",
                createImageThumbnails: true,
                thumbnailHeight: 150,
                accept: function(file, done) {
                    // console.log("accept.url=" + '{{ route('projects.image') }}');
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
                    $("#form-errors").html("Upload image not successful!");
                    $("#form-upload").html("");
                    $("#image").val("");
//                  swal({
//                      title: "Error!",
//                      text: message,
//                      type: "error",
//                      confirmButtonClass: "btn-danger",
//                      confirmButtonText: "Go back"
//                  });
                },
                success: function(file, response) {
                    console.log("success.file=" + JSON.stringify(file));
                    console.log("success.response=" + JSON.stringify(response));
                    $("#image").val(response.file);
                    $("#picture").val(response.picture);
                    $("#imgtype").val(response.imgtype);
                }
            });
        });
    </script>
@endsection