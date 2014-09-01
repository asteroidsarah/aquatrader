<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title>Your Page Title Here :)</title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
  ================================================== -->
  	<link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
	{{HTML::style('stylesheets/base.css')}} <!-- now route is relative to the public folder -->
<!-- 	<link rel="stylesheet" href="stylesheets/skeleton.css"> -->
	{{HTML::style('stylesheets/layout.css')}}

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

</head>
<body>



	<!-- Primary Page Layout
	================================================== -->

	<!-- Delete everything in this .container and get started on your own site! -->

	<div class="container">
		<header>
			<h2 class="logo">Aquatrader <i class="icon-tint"></i></h2>
			<nav>
				<ul class="group">
				@foreach(Type::all() as $type)
					<li><a href="{{URL::to('types/'.$type->id)}}">{{$type->name}}</a></li>
				@endforeach

					
					@if(Auth::guest()) <!-- checking whether there is a user in the session or not. returns true if no current user in session (ie. yes, there is a guest) or false -->
					<li><a href="{{URL::to('login')}}">Login <i class="icon-lock"></i></a></li>
					@else <!-- if they are logged in -->
					<li class="clear"><a href="{{URL::to('users/'.Auth::user()->id)}}">Account <i class="icon-user"></i></a></li>
					<li><a href="{{URL::to('logout')}}">Logout <i class="icon-lock"></i></a></li>
					@endif
					<li><a href="{{URL::to('cart')}}" >{{array_sum(Session::get('cart')->contents)}} items <i class="icon-shopping-cart"></i></a></li>
				</ul>
			</nav>
		</header>
		<div class="main group">
			@yield('content')
		</div>
		<footer></footer>

	</div><!-- container -->


<!-- End Document
================================================== -->
</body>
</html>