@extends('includes.template')
@section('content')
			<h2>Your cart</h2>
		
			<div class="cart">
				<div>
					<span><h4>Product</h4></span><span><h4>Price</h4></span><span><h4>Quantity</h4></span><span><h4>Subtotal</h4></span>
				</div>
				<?php $fTotal = 0 ?> <!-- initialising Total value -->
				@foreach($cart->contents as $key=>$value) <!-- loop through contents array (via the getter) to build up a list of orderline info -->
				<div>
					<span>{{Product::find($key)->name}}</span> <!-- we know the id, can use that to load the product and get the name -->
					<span>$ {{Product::find($key)->price}}</span>
					<span>{{$value}}</span>
					<span>$ {{Product::find($key)->price * $value}}</span>
				</div>
				<?php $fTotal += Product::find($key)->price * $value ?> <!-- multiply price by quantity for each product in the loop, then add all of them together, so we can echo in out below  -->
				@endforeach

				<div>
					<span></span><span></span><span><h4>Total</h4></span><span><h4>$ {{$fTotal}}</h4></span>
				</div>
			</div>

			{{Form::open(array('url' =>'orders'))}}
				{{Form::submit("Check out")}}
			{{Form::close()}}
			
@stop