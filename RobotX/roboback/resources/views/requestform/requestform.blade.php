@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Request</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('requestform_submit') }}">
                        {{ csrf_field() }}

                        <label class="col-md-9 control-label">Step 1: Enter your Contact Information</label></br></br>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phonenumber') ? ' has-error' : '' }}">
                            <label for="phonenumber" class="col-md-4 control-label">Phone number</label>

                            <div class="col-md-6">
                                <input id="phonenumber" type="text" class="form-control" name="phonenumber" value="{{ old('phonenumber') }}" required>

                                @if ($errors->has('phonenumber'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phonenumber') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <label class="col-md-9 control-label">Step 2: Enter your Company Information</label></br></br>

                        <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                            <label for="company" class="col-md-4 control-label">Company</label>

                            <div class="col-md-6">
                                <input id="company" type="text" class="form-control" name="company" value="{{ old('company') }}" required>

                                @if ($errors->has('company'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-md-4 control-label">Address</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('postalcode') ? ' has-error' : '' }}">
                            <label for="postalcode" class="col-md-4 control-label">Postal code</label>

                            <div class="col-md-6">
                                <input id="Postal" type="text" class="form-control" name="postalcode" value="{{ old('postalcode') }}" required>

                                @if ($errors->has('postalcode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('postalcode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Request
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
