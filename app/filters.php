<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//if there's no cart in the session, create one pls

	if(!Session::has("cart")){
		//create cart and store to session
		$oCart = new Cart();
		// $oCart->addToCart(1,3); //3x item 1 //testing
		// $oCart->addToCart(3,2); //2x item 3 //testing
		Session::put("cart",$oCart);
	}

});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		//manipulate intended url if http methods are not GET.
		if(Request::server("REQUEST_METHOD") == "GET"){
		
			Session::put("url.intended",URL::current());
		
		}else{
			Session::put("url.intended",URL::previous()); //redirect to the URL before the one that uses GET, so the user can submit a POST themselves. In this case, redirect to GET cart
		}
		
		return Redirect::guest('login');
	}
});

Route::filter('authorisation', function($route, $request, $authorisedID)
{
	if(Auth::user()->id != $authorisedID){
		return Redirect::to('login'); //redirect to the login route if not the authorised person
	}

});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
