@extends('includes.template')
@section('content')	
	<h2>User Details</h2>

	<h4>Username:</h4>
	<p>{{{$user->username}}}</p>

	<h4>First name:</h4>
	<p>{{{$user->firstname}}}</p>

	<h4>Last name:</h4>
	<p>{{{$user->lastname}}}</p>

	<h4>Email:</h4>
	<p>{{{$user->email}}}</p>

	<a href="{{URL::to('users/'.$user->id.'/edit')}}" class="button">Edit details</a>
			
@stop
			





 