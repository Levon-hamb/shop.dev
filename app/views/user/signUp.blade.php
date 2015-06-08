@extends('layouts.template')

@section('content')

    <div class="container">
        <hr>
        <div class="row vertical-center-row">
            <div class="col-md-4 col-md-offset-4">
                <h2>Sign Up</h2>
                {{ Form::open(array('url' => 'signup', 'method' => 'post')) }}
                    @if(isset($not_exist))
                        <p class="not_valid">{{$not_exist}}</p>
                    @endif
                    @if($errors)
                        <div class="form-group has-error">
                            @foreach($errors as $error)
                                <p class="not_valid">{{$error}}</p>
                            @endforeach
                        </div>
                    @endif
                    <div class="form-group">
                        <input class="form-control" id="user_name" placeholder="User name" name="user_name" type="text" value="{{(isset($old_data['user_name'])) ? $old_data['user_name'] : ''}}">
                        <p class="help-block">field is invalid</p>
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="email" placeholder="E-mail" name="email" type="email"required value="{{isset($old_data['email']) ? $old_data['email'] : ''}}">
                        <p class="help-block">field is invalid</p>
                        <p class="help-block" id="no_unique">email is already used</p>
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="phone_number" placeholder="Phone number" required name="phone_number" type="text" value="{{isset($old_data['phone_number'])?$old_data['phone_number']:''}}">
                        <p class="help-block">field is invalid</p>
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="password" placeholder="Password" name="password" required type="password" value="{{isset($old_data['password']) ? $old_data['password'] : ''}}">
                        <p class="help-block">field is invalid</p>
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="re_password" placeholder="Confirm Password" required name="re_password" type="password" value="{{isset($old_data['re_password'])?$old_data['re_password']:''}}">
                        <p class="help-block">passwords not same</p>
                    </div>

                    <input class="btn btn-success" type="submit" value="Sign up" id="signUp">
                {{ Form::close()}}
            </div>
        </div>
        <hr>
    </div>
@stop