@extends('layouts.template')


@section('content')
    <div class="border">
    </div>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h2>Edit Product</h2>
                {{ Form::open(array('url' => '/edit', 'method' => 'post', 'files' => true, 'id' => 'add')) }}
                    <div class="col-sm-6">
                    @if($errors)
                            <div class="form-group">
                                @foreach($errors as $error)
                                    <p class="not_valid">{{$error}}</p>
                                @endforeach
                            </div>
                        @endif
                        <input type="hidden" value="{{$id}}" name="prod_id" id="prod_id">
                        <div class="form-group">
                            <label for="prod_name">Product name</label>
                            <input id="prod_name" class="form-control" placeholder="Name" name="name" type="text" value="{{(isset($product->product_name))?$product->product_name:(isset($date['name'])?$date['name']:'')}}">
                            <p class="help-block">field is invalid</p>
                        </div>
                        <div class="form-group">
                            <label for="prod_desc">Product description</label>
                            <input id="prod_desc" class="form-control" placeholder="Description" name="description" type="text" value="{{(isset($product->product_description))?$product->product_description:(isset($date['description'])?$date['description']:'')}}">
                            <p class="help-block">field is invalid</p>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="prod_price">Product price</label>
                                <input id="prod_price" class="form-control" placeholder="Product price" name="price" type="text" value="{{(isset($product->product_price))?$product->product_price:(isset($date['price'])?$date['price']:'')}}">
                                <p class="help-block">invalid price</p>
                            </div>
                            <div>
                                <label for="prod_price">Currency</label>
                                <select id="currency"  size="1" name="currency">
                                    @foreach($currency as $currenc)
                                        @if((isset($product->price_currency)?$product->price_currency:(isset($date['currency'])?$date['currency']:'')) && (isset($product->price_currency)?$product->price_currency:(isset($date['currency'])?$date['currency']:'')) == $currenc)
                                            <option selected value="{{$currenc}}">{{$currenc}}</option>
                                        @else
                                            <option value="{{$currenc}}">{{$currenc}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <p class="help-block">field is invalid</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="qty">Product quantity</label>
                            <input id="qty" class="form-control" placeholder="Quantity" name="qty" type="text" value="{{(isset($product->qty))?$product->qty:(isset($date['qty'])?$date['qty']:'')}}">
                            <p class="help-block">field is invalid</p>
                        </div>
                        <div class="form-group" id="categories">
                            <a style="cursor: pointer">Categories +</a>
                        </div>
                        <div class="hidee" style="display: none">
                            <p class="text-center">Choose categories</p>
                            <hr>
                            @foreach($categories as $categori)
                                <div class="col-lg-10">
                                    <label for="{{$categori->category_name}}">{{$categori->category_name}}</label>
                                </div>
                                <div class="col-lg-2">
                                    <input id="{{$categori->category_name}}" class="checkbox "  @if(in_array($categori->id, isset($prod_categories_id)?$prod_categories_id:($date['category']?$date['category']:''))) checked @endif name="category" type="checkbox" value="{{$categori->id}}">
                                </div>
                            @endforeach
                        </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="form-group">
                            <p class="text-center">Choose photo</p>
                            <img style="width: 200px" src="{{(isset($product->photo_path)?$product->photo_path:(isset($date['photo'])?$date['photo']:''))}}" alt=""/>
                            <input id="photo" class="form-control" name="photo" type="file">
                            <p class="help-block">field is invalid</p>
                        </div>


                        <a href="/myproducts" class="btn btn-default" data-dismiss="modal">Back</a>
                        <button  type="submit" id="edit_prod" class="btn btn-primary">Save</button>
                    {{Form::close()}}
                </div>
            </div>
        </div>
        <hr>
    </div>

@stop