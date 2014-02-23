<?php

class UsersController extends BaseController{
  protected $layout = "layouts.main";
  
  
  public function __construct() {
    $this->beforeFilter('csrf', array('on'=>'post'));
	$this->beforeFilter('auth', array('only'=>array('getProfile')));
}

  public function getLogin() {
    $this->layout->content = View::make('users.login');
}
  
  public function getRegister() {
    $this->layout->content = View::make('users.register');
}

  public function postCreate() {
         
		 $validator = Validator::make(Input::all(), User::$rules);
 
    if ($validator->passes()) {
        // validation has passed, save user in 
		$user = new User;
		$user->firstname = Input::get('firstname');
		$user->city = Input::get('city');
		$user->email = Input::get('email');
		$user->talent = Input::get('talent');
		$user->password = Hash::make(Input::get('password'));
		$user->save();
		return Redirect::to('users/login')->with('message', 'Thanks for registering!');
		}
		else {
        return Redirect::to('users/register')->with('message', 'The following errors occurred')->withErrors($validator)->withInput(); 
        }
}
  
  public function postSignin(){
  
	 $user = array(
        'email' => Input::get('email'),
        'password' => Input::get('password')
    );
	if (Auth::attempt($user)) {
    return Redirect::to('users/profile')->with('message', 'You are now logged in! Welcome to ur profile');
	}
	else {
    return Redirect::to('users/login')
        ->with('message', Input::get('email').Input::get('password'))
        ->withInput();
}
}

  public function getProfile() {
     $this->layout->content = View::make('users.profile');
}
  public function getLogout() {
    Auth::logout();
    return Redirect::to('users/login')->with('message', 'Your are now logged out!');
}
  
}

?>
