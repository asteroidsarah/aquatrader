@extends('includes.template')
@section('content')	
		<h2>{{$type->name}}</h2> <!-- the $type here is the arbitrary chosen keyword from binding model and view in the controller. Is mapped to the property name is because it's mapped to the table via the ORM-->
		@foreach($type->products as $product)	
			<article class="group">
				<img src="{{URL::to('productphotos/'.$product->photo)}}" alt=""> <!-- laravel creating the URL by going to products folder and creating link relative to public folder -->
				<h4>{{$product->name}}</h4>
				<p>{{$product->description}}</p>
				<span class="price"><i class="icon-dollar"></i>{{$product->price}}</span>
				{{Form::open(array('url'=>'orderlines'))}}
				{{Form::hidden("productID",$product->id)}} <!-- key and value pair -->
				<button class="addtocart"><i class="icon-plus"></i></button>
				{{Form::close()}}
			</article>
		@endforeach
			
@stop
			





 