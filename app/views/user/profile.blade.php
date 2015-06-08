@extends('layouts.template')



@section('content')
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <h2>Profile</h2>
                <div class="form-group">
                    <label for="email">Email</label>
                    <div id="old_email" class="form-control default_cursor">{{$user->email}}</div>
                </div>
                <div class="form-group">
                    <label for="user_name">User name</label>
                    <div id="old_user_name" class="form-control default_cursor">{{$user->user_name}}</div>
                </div>
                <div class="form-group">
                    <label for="Phone number">Phone number</label>
                    <div id="old_phone_number" class="form-control default_cursor">{{$user->phone_number}}</div>
                </div>
                <a href="editProfile" type="button" class="btn btn-danger" data-toggle="modal" data-target="#edit" id="edit_button">Edit</a>
                <a href="resetpassword" type="button" class="btn btn-link col-md-offset-5" data-toggle="modal" data-target="#myModal" id="reset_pass_button">Reset Password</a>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Profile</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 ">
                        <div class="form-group">
                            <p class="help-block" id="not_exist">this user does not exist</p>
                        </div>
                        <div class="form-group">
                            <label for="user_name">User Name</label>
                            <input id="user_name" class="form-control" placeholder="User Name" name="user_name" type="text" value="{{$user->user_name}}">
                            <p class="help-block">field is invalid</p>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone number</label>
                            <input id="phone_number" class="form-control" placeholder="Phone number" name="user_name" type="text" value="{{$user->phone_number}}">
                            <p class="help-block">field is invalid</p>
                        </div>

                        <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                        <button id="saveProfile" type="button" class="btn btn-primary">Save changes</button>

                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Reset Password</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 ">
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                        <button id="save_new_pass" type="button" class="btn btn-primary">Save changes</button>

                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
        <hr>
    </div>
@stop