@extends('layouts.template')


@section('content')
    <div class="container">
        <hr>
        <div class="row vertical-center-row">
            <div class="col-md-4 col-md-offset-4">
                <h2>Reset Password</h2>
                {{ Form::open(array('url' => '/save_pass', 'method' => 'post')) }}
                    @if($errors)
                        <div class="form-group">
                            @foreach($errors as $error)
                                <p class="not_valid">{{$error}}</p>
                            @endforeach
                        </div>
                    @endif
                @if(isset($id))
                    <input type="hidden" name="id" value="{{$id}}">
                @endif
                    <div class="form-group">
                        <label for="new_password">New password</label>
                        <input id="new_password" class="form-control" placeholder="new password" name="new_password" type="password" value="">
                        <p class="help-block">field is invalid</p>
                    </div>
                    <div class="form-group">
                        <label for="new_confirm_pass">Confirm password</label>
                        <input id="new_confirm_pass" class="form-control" placeholder="confirm new password" name="new_confirm_pass" type="password" value="">
                        <p class="help-block">password not same</p>
                    </div>

                @if(!isset($id))
                    <a href="profile" type="button" class="btn btn-default" data-dismiss="modal">cancel</a>
                @endif
                    <button id="save_new_pass" type="submit" class="btn btn-primary">Save changes</button>
                {{Form::close()}}

            </div>
        </div>
        <hr>
    </div>

@stop