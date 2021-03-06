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

// // Route::get('/', function()
// // {
// // 	// return View::make('hello');
// // 	// return User::all(); //Use this to get the models and print them out. Don't need to write a SQL query! 

// // 	return View::make("type");


// // });

// //curly braces part is the dynamic bit. nb the url will for some reason still work if you use type instead of types
Route::get('types/{id}', function($id) 
{
	// return View::make('hello');
	// return User::all(); //Use this to get the models and print them out. Don't need to write a SQL query! 
	$oType = Type::find($id); //use the type id the user gives you and load it. Need to then pass it over to the view using BINDING
	return View::make("type")->with("type",$oType); //with is the binding part


});

// Route::get('users/new', function()
// {
// 	// return View::make('hello');
// 	// return User::all(); //Use this to get the models and print them out. Don't need to write a SQL query! 

// 	// return View::make("newUserForm");


// });

// Route::post('users', function()
// {	
// 	// $aRules = array(
// 	// 	"username" => "required|unique:users", //will go to the users table and check that the username doesn't already exist
// 	// 	"password" => "required|confirmed",
// 	// 	"firstname" => "required",
// 	// 	"lastname" => "required",
// 	// 	"email" => "required|email|unique:users" //email here checks the input is a valid email format
// 	// 	);
// 	// $aMessages = array(
// 	// 	'email' => 'Dude!! your :attribute format is wrong',
// 	// 	'required' => 'I think you forgot something... (hint hint, :attribute)'
// 	// 	);

// 	// //validate input
// 	// $oValidator = Validator::make(Input::all(),$aRules, $aMessages); //pass in the set of rules and the user input when you make the validator

// 	// if($oValidator->fails()){
// 	// 	// redirect to users/new with sticky data and error messages
// 	// 	return Redirect::to("users/new")->withErrors($oValidator) //tell withErrors where the errors are coming from
// 	// 									->withInput(); //input will detect current input in input class and will pass that set of input on. This is called "flashing data" in framework terms
// 	// }else{
// 	// 	//create new user. Get the user input, since that's the info we need to create the new user
// 	// 	$aDetails = Input::all(); //will give all the input the user entered, as an array.
// 	// 	$aDetails["password"] = Hash::make($aDetails["password"]); //hash the password

// 	// 	//redirect to home page or whatevs
// 	// 	//To make the new user, can use constructor or factory patterns
// 	// 	User::create($aDetails); //tell laravel which fields to fill by altering model (protected fillable)

// 	// 	//for now, redirect to page with type id = 1
// 	// 	return Redirect::to("types/1");


// 	// }
// });

// 	Route::get('users/{id}', function($id){

// 		// $oUser = User::find($id); //in the controller, your user is oUser

// 		// return View::make("userDetails")->with("user",$oUser); //binding the oUser of the passed in id into the view under that first parameter, "user"

// })->before("auth"); //applying filter

// 	Route::get('users/{id}/edit', function($id){

// 		// $oUser = User::find($id);

// 		// return View::make("editUserForm")->with("user", $oUser);

// 		//to make sticky data, bind the data to the form. Get id, load the model, bind it and then echo out the values
		
// 	});

// 	Route::put('users/{id}', function($id){

// 		$aRules = array(
// 			'firstname' => 'required',
// 			'lastname' => 'required',
// 			'email' => 'required|email|unique:users,email,'.$id //last parameter here is the exception (db table field and user id), since if they didn't update email validation will think it's not unique and freak out
// 			);

// 		//validate data
// 		$oValidator = Validator::make(Input::all(),$aRules);

// 		if($oValidator->passes()){
// 			//update user detail
// 			$oUser = User::find($id);
// 			$oUser->fill(Input::all()); //instead of setting each property separately. This uses the fillable we made already
// 			$oUser->save();
			
// 			//redirect to user page
// 			return Redirect::to("users/".$id);			


// 		}else{
// 			//redirect to editUserForm with sticky input and errors
// 			return Redirect::to('users/'.$id.'/edit')->withErrors($oValidator)->withInput();
// 		}


// 	});

//registering the route to the controller
Route::resource('users', 'UserController');


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

	Route::get('cart', function()
	{
		return View::make('cart')->with('cart', Session::get('cart')); //second part is binding cart object from the session to the View

		//now that we have access to the cart, we can loop through cart contents and dynamically generate their info in cart.blade.php


	});

	Route::post('orders', function()
	{
		//Create new order
		$oOrder = new Order();
		$oOrder->status = "Pending";
		$oOrder->user_id = Auth::user()->id; //this id coming from the authentication (this is where we know which user we are dealing with)
		$oOrder->save();

		//add orderlines. This is a junction table we need to insert into
		foreach(Session::get('cart')->contents as $productID=>$quantity){
			$oOrder->products()->attach($productID, array('quantity'=> $quantity)); //adds 4 of product 2 into the junction table
		}

		Session::put("cart", new Cart()); //empty the old cart after checkout

		//save the order and orderlines to the database

		return Redirect::to('types/1');
	})->before("auth");

	Route::get('products/create', function(){

		$aTypes = Type::lists("name", "id"); //an array of types for the drop down list in the add new product form. type_id=>value but for some reason it's around the other way

		return View::make("newProductForm")->with('types', $aTypes); //data binding
	})->before("auth|admin");

	Route::post('products', function(){

		//validate input
		$aRules = array(
			"name"=>"required|unique:products",
			"description"=>"required",
			"price"=>"required|numeric",
			"photo"=>"required"
			);

		$oValidator = Validator::make(Input::all(), $aRules);


		if($oValidator->passes()){

			//upload photo. Has enctype so is in server already in the temp folder, so need to just copy into the right location. Need to know what new name you want for your file. We are using product name as photo name because we made the name unique. Normally would add a timestamp etc
			$sNewName = Input::get("name").".".Input::file("photo")->getClientOriginalExtension();
			Input::file("photo")->move("productphotos", $sNewName);

			//create new product
			$aDetails = Input::all();
			$aDetails['photo'] = $sNewName; //since input all only gives text fields, not file fields

			$oProduct = Product::create($aDetails); //using factory pattern (rather than constructor which would need to set each property separately)
			

			//redirect to product list
			return Redirect::to("types/".$oProduct->type_id)->withErrors($oValidator)->withInput();
		}else{
			//redirect to new product form with errors and sticky data
		}

	})->before("auth|admin");


