@extends('includes.template')
@section('content')	
<h2>Register New Account</h2>
			{{ Form::open(array('url' => 'users')) }}
				{{Form::label('username', 'Username')}}
				{{Form::text('username')}}
				{{$errors->first('username', '<p class="error">:message</p>')}}

				{{Form::label('password', 'Password')}}
				{{Form::password('password')}}
				{{$errors->first('password', '<p class="error">:message</p>')}}

				{{Form::label('password_confirmation', 'Confirm password')}}
				{{Form::password('password_confirmation')}}

				{{Form::label('firstname', 'Firstname')}}
				{{Form::text('firstname')}}
				{{$errors->first('firstname', '<p class="error">:message</p>')}}	

				{{Form::label('lastname', 'Lastname')}}
				{{Form::text('lastname')}}
				{{$errors->first('lastname', '<p class="error">:message</p>')}}	

				{{Form::label('email', 'Email')}}
				{{Form::text('email')}}
				{{$errors->first('email', '<p class="error">:message</p>')}}


					{{Form::reset('Reset')}}
					{{Form::submit('Register')}}

			{{ Form::close() }}
			
@stop
			





 