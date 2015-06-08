@extends('layouts.template')


@section('content')
    <!--main-->
    <div class="container">
        <hr>
        <div class="row">
            <h1 class="text-center">Forgot Password ?</h1>
            <div class="col-lg-4 col-lg-offset-4">
                @if($errors)
                    <div class="form-group has-error">
                        @foreach($errors as $error)
                            <p class="not_valid">{{$error}}</p>
                        @endforeach
                    </div>

                @endif
                {{Form::open(array('url' => 'forgot', 'method' => 'post'))}}
                <div class="form-group">
                    <p>Enter your email and we send you new pass config page.</p>
                    <input type="text" name="email"  class="form-control" placeholder="E-mail" id="forgot_pass_email" value="{{(isset($old_date)?$old_date:'')}}"/>
                    <p class="help-block">field is invalid</p>
                    <p class="help-block" id="no_unique">email not exist</p>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-default" value="Send" id="forgot_pass_submit">
                </div>
                {{Form::close()}}
            </div>
        </div>
        <hr>
    </div>
@stop