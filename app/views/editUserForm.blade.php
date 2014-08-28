@extends('includes.template')
@section('content')	
<h2> Edit User Details</h2>
			{{ Form::model($user, array('url' => 'users/'.$user->id, 'method'=>'put')) }}
				{{Form::label('username', 'Username')}}
				{{Form::text('username', $user->username, array('disabled'=>'disabled'))}}
				{{$errors->first('username', '<p class="error">:message</p>')}}

				{{Form::label('firstname', 'Firstname')}}
				{{Form::text('firstname')}}
				{{$errors->first('firstname', '<p class="error">:message</p>')}}	

				{{Form::label('lastname', 'Lastname')}}
				{{Form::text('lastname')}}
				{{$errors->first('lastname', '<p class="error">:message</p>')}}	

				{{Form::label('email', 'Email')}}
				{{Form::text('email')}}
				{{$errors->first('email', '<p class="error">:message</p>')}}

					{{Form::submit('Submit')}}

			{{ Form::close() }}
			
@stop
			





 