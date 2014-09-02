<?php

class UserController extends \BaseController {

	public function __construct(){
		$this->beforeFilter("auth", array('only'=>array('edit', 'show', 'update'))); //this refers to the controller. Method runs filter before any actions executed. Second parameter is which actions you want to apply the first parameter to.

		//if there's a logged in user, then check it's the right person
		if(Auth::check()){ //if auth check is true, logged in
			$authorisedID = Request::segment(2); //accesses the second segment of the request 
			//apply the authorisation filter
			$this->beforeFilter('authorisation:'.$authorisedID, array('only'=>array('edit', 'show', 'update')));
		}
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return View::make("newUserForm");
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
		return Redirect::to("users/create")->withErrors($oValidator) //tell withErrors where the errors are coming from
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
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		$oUser = User::find($id); //in the controller, your user is oUser

		return View::make("userDetails")->with("user",$oUser); //binding the oUser of the passed in id into the view under that first parameter, "user"

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//

		$oUser = User::find($id);

		return View::make("editUserForm")->with("user", $oUser);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
