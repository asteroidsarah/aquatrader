@extends('includes.template')
@section('content')	
<h2>New Product</h2>
			{{ Form::open(array('url' => 'products', 'files'=>true)) }}

				{{Form::label('name', 'Name')}}
				{{Form::text('name')}}
				{{$errors->first('name', '<p class="error">:message</p>')}}

				{{Form::label('description', 'Description')}}
				{{Form::text('description')}}
				{{$errors->first('description', '<p class="error">:message</p>')}}

				{{Form::label('photo', 'Photo')}}
				{{Form::file('photo')}}
				{{$errors->first('photo', '<p class="error">:message</p>')}}

				{{Form::label('price', 'Price')}}
				{{Form::text('price')}}
				{{$errors->first('price', '<p class="error">:message</p>')}}

				{{Form::label('type_id', 'Type')}}
				{{Form::select('type_id', $types)}}
				{{$errors->first('type_id', '<p class="error">:message</p>')}}

					{{Form::reset('Reset')}}
					{{Form::submit('Add')}}

			{{ Form::close() }}
			
@stop
			





 