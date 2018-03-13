@extends('layouts.app')

@section('content')

    @if (isset($behavior))
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

    <div class="container">

        <div id="form-errors" style="color: red; font-weight: bold; padding-bottom: 5px;"></div>

        <div class="form-group">
            {!! Form::label('name', 'Name of this behavior:', ['class' => 'control-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        @if (isset($behavior))
            <div class="form-group">
                {!! Form::label('id', 'ID / Created / Modified:', ['class' => 'control-label']) !!}
                <br />
                {!! Form::text('id', $behavior->id, ['class' => '', 'readonly' => 'readonly']) !!}
                {!! Form::text('created', $behavior->createdDate(), ['class' => '', 'readonly' => 'readonly']) !!}
                {!! Form::text('updated', $behavior->updatedDate(), ['class' => '', 'readonly' => 'readonly']) !!}
            </div>
        @endif

        <div class="form-group">
            {!! Form::label('icon', 'Icon:', ['class' => 'control-label']) !!}
            <div class="input-group">
                @if (isset($behavior->icondata))
                    {!! Form::hidden('icon', $behavior->icondata->id, ['id' => 'behavior-icon']) !!}
                    <img src="{{ 'data:image/' . $behavior->icondata->type . ';base64,' . $behavior->icondata->icon }}"/>
                @else
                    {!! Form::hidden('icon', 'fa-commenting-o', ['id' => 'behavior-icon']) !!}
                    <i class="fa fa-smile-o list-icon"></i>
                @endif
                @if (isset($behavior))
                    {!! Form::hidden('behavior_id', $behavior->id) !!}
                   <a id="add-icon-link" onclick="addIcon()" href="#" class="btn btn-default align-right text-icon-selector" data-title="Add icon to behavior" data-toggle="lightbox"><i class="fa fa-external-link action-icon"></i> Link Icon</a>
                @else
                    {!! Form::hidden('behavior_id', 'NEW') !!}
                    <a id="add-icon-link" onclick="addIcon()" href="#" class="btn btn-default align-right text-icon-selector" data-title="Add icon to behavior" data-toggle="lightbox"><i class="fa fa-external-link action-icon"></i> Link Icon</a>
                @endif
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('Video', 'Video:', ['class' => 'control-label']) !!}
            {{ Form::token() }}
            {!! Form::hidden('type', null, ['id' => 'type']) !!}
            {!! Form::hidden('vfile', null, ['id' => 'vfile']) !!}
            <div id="from-upload-video" class="dropzone drop-upload" style="margin-bottom: 20px;"></div>
        </div>
        <!--
        -->

        <div class="form-group">
            {!! Form::label('slug', 'Internal name:', ['class' => 'control-label']) !!}
            {!! Form::text('slug', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('behaviortype', 'Type Behavior:', ['class' => 'control-label']) !!}
            {!! Form::select('behaviortype', $behavior_types, null, ['class' => 'form-control', 'single' => 'single']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('basemenu', 'Base Menu:', ['class' => 'control-label']) !!}
            {!! Form::select('basemenu', $base_menus, null, ['class' => 'form-control', 'single' => 'single']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('languages', 'Language:', ['class' => 'control-label']) !!}
            {!! Form::select('languages[]', $languages, null, ['class' => 'form-control', 'multiple' => 'multiple']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('voicecommands', 'Voice Commands:', ['class' => 'control-label']) !!}
            {!! Form::textarea('voicecommands', null, ['class' => 'form-control', 'rows' => '5']) !!}
        </div>

       <div class="form-group">
            {!! Form::label('sayanimation', 'Say Animation:', ['class' => 'control-label']) !!}
            {!! Form::checkbox('sayanimation', 'true', (Form::getValueAttribute('sayanimation') == 'true'?true:false), ['class' => 'project-animation-checkbox', 'id' => 'sayanimation']) !!}
       </div>

        <div class="form-group">
            {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('robots', 'Suitable For:', ['class' => 'control-label']) !!}
            <div id="robot_list" class="">
                @if (isset($behavior))
                   @foreach ($behavior->robots as $index => $robot)
                        <div class="robot-select" style="padding-bottom: 3px;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 50%;">
                                        {!! Form::select('robot_version[]', $robotnames, $robot->id, ['class' => 'form-control', 'single' => 'single', 'onchange' => 'changeRobotInfo(this)']) !!}
                                    </td>
                                    <td style="width: 10%; padding-left: 20px">
                                        <span style="font-weight: bold">OS:</span> <span class="robot-ostype-info" >{!!$robot->ostype!!}</span>
                                    </td>
                                    <td style="width: 10%; padding-left: 1px">
                                        <span style="font-weight: bold">Version:</span> <span class="robot-osversion-info">{!!$robot->osversion!!}</span>
                                    </td>
                                    <td style="width: 5px; padding-left: 1px">
                                        <a class="bhv-remove-robot" onclick="delRobot(this)">
                                            <i class="fa fa-trash pull-right list-icon"></i>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                      @endforeach
                @endif
            </div>
            <a class="btn btn-default align-right" onclick="addRobotSelect()">
                <i class="fa fa-plus action-icon robot-add-icon" title="New robot"></i>
            </a>
        </div>

        @if (isset($project_id) && $project_id)
            {!! Form::hidden('project_id', $project_id) !!}
        @endif

        {!! Form::submit('Save Behavior', ['class' => 'btn btn-primary btn-block']) !!}

        {!! Form::close() !!}

    </div>

@endsection

@section('javascript')
    <script>
        $("#edit-database").ajaxform( { form: 'Behavior', index: "{{ route('behaviors.index') }}" } );

        $(document).ready(function() {
            $("#from-upload-video").dropzone({
                url: "{{ route('behaviors.savevideo') }}",
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                method: 'post',
                maxFiles: 1,
                maxFilesize: 100000,
                uploadMultiple: false,
                paramName: 'uploadfile',
                acceptedFiles: 'video/*,image/*',
                dictDefaultMessage: "Click or drag to upload video <br />",
                // createImageThumbnails: true,
                // thumbnailHeight: 150,
                accept: function(file, done) {
                    console.log("accept.url=" + '{{ route('behaviors.savevideo') }}');
                    console.log("accept.file=" + JSON.stringify(file));
                    done();
                },
                sending: function(file, xhr, formData) {
                    console.log("sending.file=" + JSON.stringify(file));
                    console.log("sending.formData=" + JSON.stringify(formData));
                    // console.log("accept.sending=" + $('[name=_token]').val());
                    formData.append("_token", $('[name=_token').val());
                    formData.append("uploadfile", '/Users/geert/Desktop/RoboTest/test.mp4');
                },
                error: function(file, message) {
                    console.log("error.file=" + JSON.stringify(file));
                    console.log("error.message=" + message);
                    $("#form-errors").html("Upload video not successful!");
                    $("#form-upload-video").html("");
                    $("#vfile").val("");
                },
                success: function(file, response) {
                    console.log("success.file=" + JSON.stringify(file));
                    console.log("success.response=" + JSON.stringify(response));
                    $("#vfile").val(response.file);
                    $("#type").val(response.type);
                    $("#form-upload-video").html("");
                }
            });
        });

        function addIcon() {
            $("#add-icon-link").attr("href", "{{ route('behaviors.icons', 'ID') }}?" + $("#edit-database").serialize());
            return false;
        }

        function addRobotSelect() {
            var html = '<div class="robot-select" style="padding-bottom: 3px;"><table style="width: 100%;"><tr>' +
                       '<td style="width: 50%;">{!! Form::select('robot_version[]', $robotnames, null, ['class' => 'form-control', 'single' => 'single', 'onchange' => 'changeRobotInfo(this)']) !!}</td>';
            @if (isset($robot))
                html = html + '<td style="width: 10%; padding-left: 20px"><span style="font-weight: bold">OS:</span> <span class="robot-ostype-info" >{!!$robot->ostype!!}</span></td>' +
                              '<td style="width: 10%; padding-left: 1px"><span style="font-weight: bold">Version:</span> <span class="robot-osversion-info">{!!$robot->osversion!!}</span></td>' +
                              '<td style="width: 5px; padding-left: 1px"><a class="bhv-remove-robot" onclick="delRobot(this)"><i class="fa fa-trash pull-right list-icon"></i></a></td>';
            @else
                html = html + '<td style="width: 10%; padding-left: 20px"><span style="font-weight: bold">OS:</span> <span class="robot-ostype-info" ></span></td>' +
                              '<td style="width: 10%; padding-left: 1px"><span style="font-weight: bold">Version:</span> <span class="robot-osversion-info"></span></td>' +
                              '<td style="width: 5px; padding-left: 1px"><a class="bhv-remove-robot" onclick="delRobot(this)"><i class="fa fa-trash pull-right list-icon"></i></a></td>';
            @endif
            html = html + '</tr></table></div>';
            $("#robot_list").append(html);
        }

        function changeRobotInfo(e) {
            // console.log("changeRobotInfo " + e.type);
            $.ajax({
               type: 'POST',
               headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
               },
               url: "{{ route('robots.getrobot' ) }}",
               data: { id: e.value },
               success: function(data) {
                    // console.log("SUCCES " + JSON.stringify(data));
                    $(e).closest('.robot-select').find('.robot-ostype-info').html(data.ostype);
                    $(e).closest('.robot-select').find('.robot-osversion-info').html(data.osversion);
               },
               fail: function(e) {
                   console.log("ERROR " + e);
               }
            });
        }

        function delRobot(e) {
             $(e).closest('tr').remove();
        }
    </script>
@endsection
