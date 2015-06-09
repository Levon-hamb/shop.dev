@extends('layouts.template')

@section('content')
    <div class="container " >
        <hr>
        {{ Form::open(['method' => 'post']) }}
        <p></p>
        <div class="row">
            <h2>Cart</h2>
            @if(Session::get('message'))
            	<p class="text-center has-error" style="color: #c9302c">{{Session::get('message')}}</p>
            @endif
            @if(Session::has("error"))

                <?php $error = (Session::get('error'));?>
                <div class="form-group has-error">
                    <p class="not_valid">{{var_dump($error)}}</p>
                </div>
            @endif
            @if(isset($products))
                @foreach($products as $product)
                    <hr>
                    <div class="row">
                        <div class="col-lg-2"><img style="width: 150px;"  src="{{$product->photo_path}}"></div>
                        <div class="col-lg-8">

                            <input type="hidden" value="{{ $product->id }}" name="id[]"/>

                            <h2>{{$product->product_name}}</h2>
                            <span>{{$product->product_description}}</span>
                            <p>{{$product->product_price}} {{$product->price_currency}}</p>
                            <div class="form-group">
                                Quantity<input type="number" value="{{$qty[$product->id]}}" min="1" max="{{$product->qty - $product->sold_qty}}" name="quantity[{{ $product->id }}]" class="prod form-control">
                                {{$product->sold_qty}} sold
                                <p class="help-block">field is invalid</p>
                                <p class="help-block low" >enter low quantity</p>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <a href="/deletecartprod/{{$product->id}}" title="delete product"><i class="glyphicon glyphicon-remove">Delete</i></a></div>
                    </div>
                @endforeach
                    <div class="row">
                        <div class="col-lg-offset-10 col-lg-2">
                            <button type="submit" class="glyphicon glyphicon-save btn btn-link " formaction="/savecart">Save</button>
                            {{ Form::close() }}
                        </div>
                    </div>
                    <input type="hidden" value="cart" name="cart"/>
                    <button type="submit" class="buy_now button" formaction="/payment" id="buy"></button>
            @else
                <div class="form-group">
                    <label for="email">You don't have products in your cart for add products click here <a href="/">start add products</a></label>
                </div>
            @endif
        </div>
        <hr>
    </div>
@stop

