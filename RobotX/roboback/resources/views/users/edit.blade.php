@extends('layouts.app')

@section('content')
    @if( isset($user) )
        {!! Form::model($user, [
            'method' => 'PATCH',
            'id' => 'edit-database',
            'route' => ['users.update', $user->id]
        ]) !!}
    @else
        {!! Form::open([
            'method' => 'POST',
            'id' => 'edit-database',
            'route' => 'users.store'
        ]) !!}
    @endif

    <div class="container">

        <div id="form-errors" style="color: red; font-weight: bold; padding-bottom: 5px;"></div>

        <div class="form-group">
            {!! Form::label('name', 'name user:', ['class' => 'control-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('email', 'E-mail:', ['class' => 'control-label']) !!}
            {!! Form::text('email', null, ['class' => 'form-control']) !!}
        </div>

      

        {!! Form::submit('Save Users', ['class' => 'btn btn-primary btn-block']) !!}

        {!! Form::close() !!}

    </div>
@endsection

@section('javascript')
    <script>
        $("#edit-database").ajaxform( { form: 'user', index: "{{ route('users.index') }}" } );

        $(document).ready(function() {
        });
    </script>
@endsection
