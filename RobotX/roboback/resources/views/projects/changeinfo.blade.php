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

<div id="form-errors" style="color: red; font-weight: bold; padding-bottom: 5px;"></div>

<div class="form-group">
    {!! Form::label('name', 'Name of this project:', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('start_time', 'Start time:', ['class' => 'control-label']) !!}
    {!! Form::text('start_time', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('logo', 'Logo:', ['class' => 'control-label']) !!}
    {!! Form::hidden('image', null, ['id' => 'image']) !!}
    <div id="form-upload" class="dropzone drop-upload" style="margin-bottom: 20px;"></div>
</div>

{!! Form::submit('Save project', ['class' => 'btn btn-primary btn-block']) !!}

{!! Form::close() !!}

<script>
    $("#edit-database").ajaxform();
    $(document).ready(function() {
        $('#start_time').datetimepicker({
            lang: 'nl',
            format:'d-m-Y H:i',
            minDate: 0,
            defaultTime: '13:00',
            allowBlank: true
        });
//        $(".dropzone").dropzone({
//            // url: '{{ route('projects.image') }}',
//            url: '{{ asset('/projects/image') }}',
//            maxFiles: 1,
//            maxFilesize: 1,
//            uploadMultiple: false,
//            paramName: 'uploadfile',
//            acceptedFiles: 'image/*',
//            dictDefaultMessage: "Click or drag to upload image <br />",
//            createImageThumbnails: true,
//            thumbnailHeight: 150,
//            accept: function(file, done) {
//// console.log("accept.url=" + '{{ route('projects.image') }}');
//console.log("accept.file=" + JSON.stringify(file));
//                done();
//            },
//            error: function(file, message) {
//console.log("error.file=" + JSON.stringify(file));
//// console.log("error.message=" + message);
//                $("#form-errors").html("Upload image not successful!");
//                $("#form-upload").html("");
//                // $("#form-upload").html(message);
//                $("#image").val("");
////                swal({
////                    title: "Error!",
////                    text: message,
////                    type: "error",
////                    confirmButtonClass: "btn-danger",
////                    confirmButtonText: "Go back"
////                });
//            },
//            success: function(file, response) {
//console.log("success.file=" + JSON.stringify(file));
//console.log("success.response=" + JSON.stringify(response));
//                $("#image").val(response.file);
//            }
//        });
    });

</script>