@extends('layouts.template')


@section('content')
	<!--main--><hr>
	<div class="border">
	</div>
	<div class="container">
		<div class="row">
			@if(Session::get('message'))
				<p class="text-center has-error" style="color: #c9302c">{{Session::get('message')}}</p>
			@endif
		@for($i = (count($products) - 1); $i >= 0 ; $i--)
			<div class="col-lg-4 item">
				<div class="panel panel-default">
					<div class="panel-thumbnail">
						<img src="{{$products[$i]['photo_path']}}" class="img-responsive">
					</div>
					<div class="panel-body">
						<div class="col-sm-8">
							<p class="lead">
								<a href="/product/{{$products[$i]['id']}}">{{$products[$i]['product_name']}}</a>
							</p>
							{{ Form::open(['method' => 'post']) }}
							<p id="button">{{$products[$i]['product_price']}}  {{$products[$i]['price_currency']}}
								<input type="hidden" value="{{ $products[$i]['id'] }}" name="id[]"/>
								<div class="form-group">
								Quantity<input type="number" value="1" min="1" max="{{$products[$i]['qty']-$products[$i]['sold_qty']}}" name="quantity[{{ $products[$i]['id'] }}]" class="prod form-control">
								{{$products[$i]['sold_qty']}} sold
								<p class="help-block">field is invalid</p>
								<p class="help-block low" >enter low quantity</p>
								</div>
								<button type="submit" class="add_to_cart button" formaction="/addcart"></button>
								<button type="submit" class="buy_now button" formaction="/payment"></button>
							</p>
							{{ Form::close() }}
						</div>
					</div>

				</div>
			</div>
		@endfor
		</div>
		<hr>
	</div>
@stop