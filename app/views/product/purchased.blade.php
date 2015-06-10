@extends('layouts.template')

@section('content')
    <div class="border">
    </div>
    <div class="container">
        <hr>
        <div class="row">
        @if(isset($products))
        @foreach($products as $product)
            <div class="col-lg-12" style="border: 1px solid snow">
                <h2><p class="text-center">{{$product->product_name}}</p></h2>
                <div class="col-lg-3" style="border: 1px solid snow"><img style="width: 200px;" src="{{$product->photo_path}}" alt=""/></div>
                <div class="col-lg-6" style="border: 1px solid snow;padding: 10px">
                    {{$product->product_description}}
                    <p>{{$product->product_price}} {{$product->price_currency}}</p>
                    <p>{{$product->qty}} {{$product->price_currency}}</p>

                </div>
            </div>
            @endforeach
                    @endif
        </div>

        <hr>

    </div>
@stop