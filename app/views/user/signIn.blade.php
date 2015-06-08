@extends('layouts.template')

@section('content')
    <div class="container">
        <hr>
        <div class="row vertical-center-row">
            <div class="col-md-4 col-md-offset-4">
                <h2>Sign In</h2>
                <div class="form-group">
                    <p class="help-block" id="not_exist">this user does not exist</p>
                    @if(isset($not_exist))
                        <p class="not_valid">{{$not_exist}}</p>
                    @endif
                </div>
                {{ Form::open(array('url' => 'signin', 'method' => 'post')) }}
                @if($errors)
                    <div class="form-group has-error">
                        @foreach($errors as $error)
                            <p class="not_valid">{{$error}}</p>
                        @endforeach
                    </div>
                @endif
                    <div class="form-group">
                        <input id="email" class="form-control" placeholder="E-mail" name="email" type="email" required value="{{isset($old_data['email']) ? $old_data['email'] : ''}}">
                        <p class="help-block">field is invalid</p>
                    </div>
                    <div class="form-group">
                        <input id="password" class="form-control" placeholder="Password" name="password" required type="password" value="{{isset($old_data['password']) ? $old_data['password'] : ''}}">
                        <p class="help-block">field is invalid</p>
                    </div>
                    <input id="signIn" class="btn btn-success " type="submit" value="Login">
                    <label class="col-md-offset-3" for="checkbox">remember me <input id="checkbox" type="checkbox" name="remember" checked></label>
                {{Form::close()}}
                <a href="forgotpass">Forgot password ?</a>
            </div>
        </div>
        <hr>
    </div>

@stop