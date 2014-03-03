<?php

class UsersController extends BaseController{
  protected $layout = "layouts.home";
  
  public function __construct() {
    $this->beforeFilter('csrf', array('on'=>'post'));
	$this->beforeFilter('auth', array('only'=>array('getProfile')));
}
  
  public function getProfile() {
    $this->layout->content = View::make('home.profile');
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

  public function getSignIn() {
     $this->layout->content = View::make('users.profile');
}
  public function getLogout() {
    Auth::logout();
    return Redirect::to('users/login')->with('message', 'Your are now logged out!');
}
  public function post_upload(){
 
    $input = Input::all();
    $rules = array(
        'file' => 'image|max:3000',
    );
 
    $validation = Validator::make($input, $rules);
 
    if ($validation->fails())
    {
        return Response::make($validation->errors->first(), 400);
    }
 
    $file = Input::file('file');
 
    $destinationPath = 'uploads/'.str_random(8);
	$filename = $file->getClientOriginalName();
	//$extension =$file->getClientOriginalExtension(); 
	$upload_success = Input::file('file')->move($destinationPath, $filename);
 
if( $upload_success ) {
   return View::make('home.profile')
									->with('creatyst',$creatyst);
} else {
   return Response::json('error', 400);
}
}

public function postMultiupload(){
	$input = Input::all();
    $rules = array(
        'file' => 'image|max:3000',
    );
 
    $validation = Validator::make($input, $rules);
 
    if ($validation->fails())
    {
        return Response::make($validation->errors->first(), 400);
    }
 
    $file = Input::file('file[]');
 
    $extension = File::extension($file['name']);
    $directory = path('public').'uploads/'.Input::get('folder');
    $filename = sha1(time().time()).".{$extension}";
 
    $upload_success = Input::upload('file', $directory, $filename);
 
    if( $upload_success ) {
       return View::make('home.profile')
									->with('creatyst',$creatyst);
    } else {
        return Response::json('error', 400);
    }
}


}

?>
