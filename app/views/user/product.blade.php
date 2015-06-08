@extends('layouts.template')


@section('content')
    <div class="border">
    </div>
    <div class="container">
        <hr>
        <div class="row">
            {{--<div class="col-md-4 col-md-offset-4">--}}
                <h2>Products</h2>
                <a href="/add" ><i class="glyphicon glyphicon-plus">Add new</i></a>
                @if(isset($products))
                    @foreach($products as $product)
                        <hr>
                        <div class="row">
                            <div class="col-lg-2"><img style="width: 150px;"  src="{{$product->photo_path}}"></div>

                            <div class="col-lg-8">

                            <h2>{{$product->product_name}}</h2>
                                <span>{{$product->product_description}}</span>
                                <p>{{$product->product_price}} {{$product->price_currency}}</p>

                            </div>
                            <div class="col-lg-2"><a href="/edit/{{$product->id}}" ><i class="glyphicon glyphicon-edit">Edit</i></a>
                                <a href="/delete/{{$product->id}}" ><i class="glyphicon glyphicon-remove">Delete</i></a></div>
                        </div>
                    @endforeach
                @else
                    <div class="form-group">
                        <label for="email">You don't have products for add new product click <a href="add">Add new</a></label>
                    </div>
                @endif
            {{--</div>--}}
        </div>
        <hr>
    </div>

@stop