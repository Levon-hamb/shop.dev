@extends('layouts.template')

@section('content')
<div class="container" id="main">
    <hr>
    <div class="row vertical-center-row">
        <div class="col-md-4 col-md-offset-4">
            <h2>Categories</h2>


            <div class="form-group">
                <hr>
                @foreach($categories as $categori)
                    <div class="col-lg-10">
                        <label for="{{$categori['category_name']}}">{{$categori['category_name']}}</label>
                    </div>
                    <div class="col-lg-1">
                        <a href="/admin/editCategory/{{$categori['id']}}"><i class="glyphicon glyphicon-edit"></i></a>
                    </div>
                    <div class="col-lg-1">
                        <a href="/admin/deleteCategory/{{$categori['id']}}"><i class="glyphicon glyphicon-trash"></i></a>
                    </div>

                @endforeach
            </div>
            {{ Form::open(array('url' => '/admin/addCategory', 'method' => 'post')) }}
                @if($errors)
                    <div class="col-lg-12">
                        <div class="form-group">
                            @foreach($errors as $error)
                                <p class="not_valid">{{$error}}</p>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="col-lg-12">
                    <input type="text" name="category" placeholder="new category" class="form-control" autocomplete="off" required>
                    <button  type="submit" class="btn btn-primary">Add</button>
                </div>
            {{Form::close()}}

        </div>
    </div>
    <hr>
</div>

@stop