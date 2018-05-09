@extends('layouts.app')

@section('content')
  <div class="panel panel-body-default">
    <div class="panel-body">

      {!!Form::open()!!}
        <div class="form-group col-md-4">
          {!! Form::label('email', 'E-mail:', ['class' => 'control-label']) !!}
          {!! Form::text('email', null, ['class' => 'form-control']) !!}
      </div>

      <div class="form-group col-md-4">
        {!! Form::label('password','Current password',['class' => 'control-label']) !!}
        {!! Form::text('oldpassword','') !!}
      {!!Form::close()!!}

    </div>
  </div>

@endsection
