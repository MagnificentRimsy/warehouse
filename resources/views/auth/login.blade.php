@extends('layouts.auth')

@section('content')

    <style>

        @media screen and (min-width: 480px){
            .panel{
                margin-left: 25%;
            }

        }

    </style>
            <div style="background-color: white;padding:50px;" class="panel panel-default col-md-6" align="center">
                <div class="panel-heading">
                    <img src="{{ url('logo2.png') }}" alt="" style="padding-bottom: 30px; ">
                    
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6" style="padding-bottom: 10px;">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 " align="center">
                                <button type="submit" class="btn btn-primary" style="    padding-right: 40px;
                                padding-left: 40px;">
                                    Login
                                </button><span><a style="maring-left: 11px;" class="btn-link" href="{{ route('password.request') }}">
                                    Forgot ?
                                </a></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

@endsection
