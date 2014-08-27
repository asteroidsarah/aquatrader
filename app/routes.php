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

});

	Route::get('users/{id}/edit', function($id){
		
	});

