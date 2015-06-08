@extends('layouts.template')

@section('content')
    <div class="border">
    </div>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-lg-12" style="border: 1px solid snow">

                <h2><p class="text-center">{{$product->product_name}}</p></h2>
                <div class="col-lg-3" style="border: 1px solid snow"><img style="width: 200px;" src="{{$product->photo_path}}" alt=""/></div>
                <div class="col-lg-6" style="border: 1px solid snow;padding: 10px">
                    {{$product->product_description}}
                    <p>{{$product->product_price}} {{$product->price_currency}}</p>
                    {{ Form::open(['method' => 'post']) }}
                    <p>
                        <input type="hidden" value="{{ $product->id }}" name="id[]"/>
                        <div class="form-group">
                            <input type="number" value="1" min="1"  max="{{$product->qty - $product->sold_qty}}" name="quantity[{{ $product->id}}]" class="prod form-control">
                            <p class="help-block">field is invalid</p>
                            <p class="help-block low" >enter low quantity</p>
                        </div>
                        <button type="submit" class="add_to_cart button" formaction="/addcart"></button>
                        <button type="submit" class="buy_now button" formaction="/payment"></button>
                    </p>
                    {{ Form::close() }}
                </div>
                <div class="col-lg-3" style="border: 1px solid snow">
                    <h4 class="text-center"> Contact</h4>
                    <p>E-mail: {{$user->email}}</p>
                    <p>Name: {{$user->user_name}}</p>
                    <p>Phone: {{$user->phone_number}}</p>
                </div>
            </div>
        </div>
        <hr>
    </div>
@stop