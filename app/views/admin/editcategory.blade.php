@extends('layouts.template')

@section('content')
    <div class="container" id="main">
        <hr>
        <div class="row vertical-center-row">
            <div class="col-md-4 col-md-offset-4">
                <h2>Edit Category</h2>

                {{ Form::open(array('url' => '/admin/savecat', 'method' => 'post')) }}
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
                    <input type="text" name="category_name" placeholder="new category" class="form-control" autocomplete="off" required value="{{(isset($cat['category_name']))?$cat['category_name']:''}}">
                    <input type="hidden" name="category_id" value="{{($cat['id'])}}">

                    <button  type="submit" class="btn btn-primary">Save</button>
                </div>
                {{Form::close()}}

            </div>
        </div>
        <hr>
    </div>

@stop