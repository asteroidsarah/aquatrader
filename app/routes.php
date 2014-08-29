<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Route::get('/', function()
// {
// 	// return View::make('hello');
// 	// return User::all(); //Use this to get the models and print them out. Don't need to write a SQL query! 

// 	return View::make("type");


// });

//curly braces part is the dynamic bit. nb the url will for some reason still work if you use type instead of types
Route::get('types/{id}', function($id) 
{
	// return View::make('hello');
	// return User::all(); //Use this to get the models and print them out. Don't need to write a SQL query! 
	$oType = Type::find($id); //use the type id the user gives you and load it. Need to then pass it over to the view using BINDING
	return View::make("type")->with("type",$oType); //with is the binding part


});

Route::get('users/new', function()
{
	// return View::make('hello');
	// return User::all(); //Use this to get the models and print them out. Don't need to write a SQL query! 

	return View::make("newUserForm");


});

Route::post('users', function()
{	
	$aRules = array(
		"username" => "required|unique:users", //will go to the users table and check that the username doesn't already exist
		"password" => "required|confirmed",
		"firstname" => "required",
		"lastname" => "required",
		"email" => "required|email|unique:users" //email here checks the input is a valid email format
		);
	$aMessages = array(
		'email' => 'Dude!! your :attribute format is wrong',
		'required' => 'I think you forgot something... (hint hint, :attribute)'
		);

	//validate input
	$oValidator = Validator::make(Input::all(),$aRules, $aMessages); //pass in the set of rules and the user input when you make the validator

	if($oValidator->fails()){
		// redirect to users/new with sticky data and error messages
		return Redirect::to("users/new")->withErrors($oValidator) //tell withErrors where the errors are coming from
										->withInput(); //input will detect current input in input class and will pass that set of input on. This is called "flashing data" in framework terms
	}else{
		//create new user. Get the user input, since that's the info we need to create the new user
		$aDetails = Input::all(); //will give all the input the user entered, as an array.
		$aDetails["password"] = Hash::make($aDetails["password"]); //hash the password

		//redirect to home page or whatevs
		//To make the new user, can use constructor or factory patterns
		User::create($aDetails); //tell laravel which fields to fill by altering model (protected fillable)

		//for now, redirect to page with type id = 1
		return Redirect::to("types/1");


	}
});

	Route::get('users/{id}', function($id){

		$oUser = User::find($id); //in the controller, your user is oUser

		return View::make("userDetails")->with("user",$oUser); //binding the oUser of the passed in id into the view under that first parameter, "user"

})->before("auth"); //applying filter

	Route::get('users/{id}/edit', function($id){

		$oUser = User::find($id);

		return View::make("editUserForm")->with("user", $oUser);

		//to make sticky data, bind the data to the form. Get id, load the model, bind it and then echo out the values
		
	});

	Route::put('users/{id}', function($id){

		$aRules = array(
			'firstname' => 'required',
			'lastname' => 'required',
			'email' => 'required|email|unique:users,email,'.$id //last parameter here is the exception (db table field and user id), since if they didn't update email validation will think it's not unique and freak out
			);

		//validate data
		$oValidator = Validator::make(Input::all(),$aRules);

		if($oValidator->passes()){
			//update user detail
			$oUser = User::find($id);
			$oUser->fill(Input::all()); //instead of setting each property separately. This uses the fillable we made already
			$oUser->save();
			
			//redirect to user page
			return Redirect::to("users/".$id);			


		}else{
			//redirect to editUserForm with sticky input and errors
			return Redirect::to('users/'.$id.'/edit')->withErrors($oValidator)->withInput();
		}


	});

	Route::get('login', function()
	{
		return View::make("loginForm");


	});

	Route::post('login', function()
	{
		$aLoginDetails = array(
			'username' => Input::get('username'),
			'password' => Input::get('password')
			);

		if(Auth::attempt($aLoginDetails)){
			//redirect to home page
			return Redirect::intended("users/".Auth::user()->id); //this redirects to home page as a fallback, but ideally (using intended) should redirect back to the page they were on before logging in

		}else{
			//send back to login page with errors
			return Redirect::to("login")->with("error","Try again"); //this width is not binding data (it is not on view) it is creating flash data on the redirect, sending info to the session for use in the next request

		}
		


	});

	Route::get('logout', function()
	{
		Auth::logout();
		return Redirect::to('types/1');
	});

	Route::post('orderlines', function()
	{
		//Get the product id
		$iProductID = Input::get("productID");

		//add product id to shopping cart
		Session::get("cart")->addToCart(Input::get("productID"),1); //this second parameter is because the original cart code let you choose how many to add

		//redirect back to the type page
		$oProduct = Product::find($iProductID); //load the product so we can then find its type id
		return Redirect::to("types/".$oProduct->type_id);

	});

