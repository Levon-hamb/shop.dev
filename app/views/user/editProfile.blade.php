@extends('layouts.template')


@section('content')
    <div class="container">
        <hr>
        <div class="row vertical-center-row">
            <div class="col-md-4 col-md-offset-4">
                <h2>Edit Profile</h2>
                {{ Form::open(array('url' => 'saveProfile', 'method' => 'post')) }}
                @if($errors)
                <div class="form-group">
                    @foreach($errors as $error)
                        <p class="not_valid">{{$error}}</p>
                    @endforeach
                </div>
                @endif
                <div class="form-group">
                    <label for="user_name">User name</label>
                    <input id="user_name" class="form-control" placeholder="User Name" name="user_name" type="text" value="{{(isset($user->user_name))?$user->user_name:((isset($old_date['user_name']))?$old_date['user_name']:'')}}">
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone number</label>
                    <input id="phone_number" class="form-control" placeholder="Phone number" name="phone_number" type="text" value="{{(isset($user->phone_number))?$user->phone_number:((isset($old_date['phone_number']))?$old_date['phone_number']:'')}}">
                </div>
                <a href="profile" class="btn btn-default" data-dismiss="modal">cancel</a>
                <button  type="submit" id="saveProfile" class="btn btn-primary">Save changes</button>
                {{Form::close()}}

            </div>
        </div>
        <hr>
    </div>

@stop