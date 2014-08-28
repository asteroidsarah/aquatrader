@extends('includes.template')
@section('content')	
<h2>Login</h2>
			{{ Form::open(array('url' => 'login')) }}
				{{Form::label('username', 'Username')}}
				{{Form::text('username')}}				

				{{Form::label('password', 'Password')}}
				{{Form::password('password')}}
				
					{{Form::reset('Reset')}}
					{{Form::submit('Login')}}

			{{ Form::close() }}
			{{Session::get("error")}} <!-- allows you to get flash data out -->
			
@stop
			





 