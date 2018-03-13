@extends('layouts.app')

@section('content')
    @if( isset($robot) )
        {!! Form::model($robot, [
            'method' => 'PATCH',
            'id' => 'edit-database',
            'route' => ['robots.update', $robot->id]
        ]) !!}
    @else
        {!! Form::open([
            'method' => 'POST',
            'id' => 'edit-database',
            'route' => 'robots.store'
        ]) !!}
    @endif

    <div class="container">

        <div id="form-errors" style="color: red; font-weight: bold; padding-bottom: 5px;"></div>

        <div class="form-group">
            {!! Form::label('type', 'Type robot:', ['class' => 'control-label']) !!}
            {!! Form::text('type', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('name', 'Name of this robot:', ['class' => 'control-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('version', 'Version:', ['class' => 'control-label']) !!}
            {!! Form::text('version', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('ostype', 'Operating System:', ['class' => 'control-label']) !!}
            {!! Form::text('ostype', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('osversion', 'OS Version:', ['class' => 'control-label']) !!}
            {!! Form::text('osversion', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('text', 'Description:', ['class' => 'control-label']) !!}
            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5']) !!}
        </div>

        {!! Form::submit('Save Robot', ['class' => 'btn btn-primary btn-block']) !!}

        {!! Form::close() !!}

    </div>
@endsection

@section('javascript')
    <script>
        $("#edit-database").ajaxform( { form: 'Robot', index: "{{ route('robots.index') }}" } );

        $(document).ready(function() {
        });
    </script>
@endsection
