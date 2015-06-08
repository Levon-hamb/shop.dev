@extends('layouts.template')

@section('content')
    <div class="border">
    </div>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h2>Add Product</h2>
                {{ Form::open(array('url' => '/add', 'method' => 'post', 'files' => true, 'id' => 'add')) }}
                <div class="col-sm-6">
                    @if($errors)
                        <div class="form-group">
                            @foreach($errors as $error)
                                <p class="not_valid">{{$error}}</p>
                            @endforeach
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="prod_name">Product name</label>
                        <input id="prod_name" class="form-control" placeholder="Name" name="name" type="text"
                               value="{{isset($old_data['name'])?$old_data['name']:''}}">

                        <p class="help-block">field is invalid</p>
                    </div>
                    <div class="form-group">
                        <label for="prod_desc">Product description</label>
                        <input id="prod_desc" class="form-control" placeholder="Description" name="description"
                               type="text" value="{{isset($old_data['description'])?$old_data['description']:''}}">

                        <p class="help-block">field is invalid</p>
                    </div>
                    <div class="form-group">
                        <label for="prod_price">Product price</label>
                        <input id="prod_price" class="form-control" placeholder="Product price" name="price" type="text"
                               value="{{isset($old_data['price'])?$old_data['price']:''}}">

                        <p class="help-block">invalid price</p>
                        <label for="prod_price">Currency</label>
                        <select id="currency" size="1" name="currency">
                            @foreach($currency as $currenc)
                                @if(isset($old_data['currency']) && $old_data['currency'] == $currenc)
                                    <option selected value="{{$currenc}}">{{$currenc}}</option>
                                @else
                                    <option value="{{$currenc}}">{{$currenc}}</option>
                                @endif
                            @endforeach
                        </select>

                        <p class="help-block">field is invalid</p>
                    </div>
                    <div class="form-group">
                        <label for="qty">Product quantity</label>
                        <input id="qty" class="form-control" placeholder="Quantity" name="qty" type="text"
                               value="{{isset($old_data['qty'])?$old_data['qty']:''}}">

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
                                <input id="{{$categori->category_name}}" class="checkbox " name="category"
                                       type="checkbox" value="{{$categori->id}}">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <p class="text-center">Choose photo</p>
                        <input id="photo" class="form-control" name="photo" type="file">

                        <p class="help-block">field is invalid</p>
                    </div>
                    <a @if(Auth::user()->is_admin)href="/admin/myproducts" @else href="/myproducts"
                       @endif class="btn btn-default" data-dismiss="modal">Back</a>
                    <button type="submit" id="add_prod" class="btn btn-primary">Add</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
        <hr>
    </div>
@stop