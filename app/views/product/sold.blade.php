@extends('layouts.template')

@section('content')
    <div class="border">
    </div>
    <div class="container">
        <hr>
        @if(isset($products))
        @foreach($products as $product)
            <div  style="border: 1px solid snow;width:200px;float: left;margin-right: 15px">
                <h2><p class="text-center">{{$product->product_name}}</p></h2>
                <img style="width: 200px;" src="{{$product->photo_path}}" alt=""/>
                {{$product->product_description}}
                <p>{{$product->product_price}} {{$product->price_currency}}</p>
                s<p>Quantity {{$product->qty}} </p>
                <p>Date  {{$product->created_at}} </p>
            </div>
        @endforeach
        @endif
        <hr>
    </div>
@stop