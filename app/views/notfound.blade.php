@extends('layouts.template')


@section('content')
    <!--main-->
    <div class="container" >
        <hr>
        <div class="row">
            @if($errors)
                <div class="form-group">
                    @foreach($errors as $error)
                        <p class="not_valid">{{$error}}</p>
                    @endforeach
                </div>
            @endif
            <h1 class="text-center">Page Not Found 404</h1>
        </div>
        <hr>
    </div>
@stop