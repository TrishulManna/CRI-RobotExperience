@extends('layouts.app')

@section('content')
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

    <div class="container">

        <div id="form-errors"></div>


        <div class="form-group">
            {!! Form::label('name', 'Name of this text:', ['class' => 'control-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        @if( isset($text) )
            <div class="form-group">
                {!! Form::label('id', 'ID / Created / Modified:', ['class' => 'control-label']) !!}
                <br /> ff
                {!! Form::text('id', $text->id, ['class' => '', 'readonly' => 'readonly']) !!}
                {!! Form::text('created', $text->createdDate(), ['class' => '', 'readonly' => 'readonly']) !!}
                {!! Form::text('updated', $text->updatedDate(), ['class' => '', 'readonly' => 'readonly']) !!}
            </div>
        @endif

        <div class="form-group">
            {!! Form::label('icon', 'Icon:', ['class' => 'control-label']) !!}
            <div class="input-group">
                @if( isset($text->icondata ) )
                    {!! Form::hidden('icon', $text->icondata->id, ['id' => 'text-icon']) !!}
                    <img src="{{ 'data:image/' . $text->icondata->type . ';base64,' . $text->icondata->icon }}"/>
                @else
                    {!! Form::hidden('icon', 'fa-commenting-o', ['id' => 'text-icon']) !!}
                    <i class="fa fa-commenting-o list-icon"></i>
                @endif
                @if( isset($text) )
                    {!! Form::hidden('text_id', $text->id) !!}
                   <a id="add-icon-link" onclick="addIcon()" href="#" class="btn btn-default align-right text-icon-selector" data-title="Add icon to text" data-toggle="lightbox"><i class="fa fa-external-link action-icon"></i> Link Icon</a>
                @else
                    {!! Form::hidden('text_id', 'NEW') !!}
                    <a id="add-icon-link" onclick="addIcon()" href="#" class="btn btn-default align-right text-icon-selector" data-title="Add icon to text" data-toggle="lightbox"><i class="fa fa-external-link action-icon"></i> Link Icon</a>
                @endif
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('text', 'Text to speak:', ['class' => 'control-label']) !!}
            {!! Form::textarea('text', null, ['class' => 'form-control', 'rows' => '5']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('basemenu', 'Base Menu:', ['class' => 'control-label']) !!}
            {!! Form::select('basemenu', $base_menus, null, ['class' => 'form-control', 'single' => 'single']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('languages', 'Language:', ['class' => 'control-label']) !!}
            {!! Form::select('language', $languages, null, ['class' => 'form-control', 'single' => 'single']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('voicecommands', 'Voice Commands:', ['class' => 'control-label']) !!}
            {!! Form::textarea('voicecommands', null, ['class' => 'form-control', 'rows' => '5']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('animations', 'Animation:', ['class' => 'control-label']) !!}
            {!! Form::select('animations[]', $animations, null, ['class' => 'form-control', 'multiple' => 'multiple']) !!}
         </div>

        <div class="form-group">
            {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5']) !!}
        </div>

        @if(isset($project_id) && $project_id)
            {!! Form::hidden('project_id', $project_id) !!}
        @endif

        {!! Form::submit('Save Text', ['class' => 'btn btn-primary btn-block']) !!}

        {!! Form::close() !!}

    </div>
@endsection

@section('javascript')
    <script>
        $("#edit-database").ajaxform( { form: 'Text', index: "{{ route('texts.index') }}" } );

        $(document).ready(function() {
        });

        function addIcon() {
            $("#add-icon-link").attr("href", "{{ route('texts.icons', 'ID') }}?" + $("#edit-database").serialize());
            return false;
        }
    </script>
@endsection
