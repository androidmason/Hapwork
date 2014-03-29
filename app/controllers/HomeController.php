<?php

class HomeController extends BaseController {

  protected $layout = "layouts.main";
 
  
  public function __construct() {
    $this->beforeFilter('csrf', array('on'=>'post'));
	$this->beforeFilter('auth', array('only'=>array('getProfile')));
}

  public function getLogin() {
	if(Auth::check()){
	$creatyst = User::where('email','=',Auth::user()->email)->first();
    return Redirect::to('profile')
           ->with('username', $creatyst->username);
	}
	else
    $this->layout->content = View::make('users.login');
}
  
  public function getRegister() {
    $this->layout->content = View::make('users.register');
}

public function getProfile() {
    return View::make('home.profile');
}

  public function postCreate() {
         
		 $validator = Validator::make(Input::all(), User::$rules);
 
    if ($validator->passes()) {
        // validation has passed, save user in 
		$user = new User;
		$user->firstname = Input::get('firstname');
		$user->lastname = Input::get('lastname');
		$user->city = Input::get('city');
		$user->email = Input::get('email');
		$user->username = Input::get('username');
		$user->talent = Input::get('talent');
		$user->password = Hash::make(Input::get('password'));
		$user->save();
		$users = array(
        'email' => Input::get('email'),
        'password' => Input::get('password')
    );
	if (Auth::attempt($users)) {
	return Redirect::to('profile')
        ->with('username', $user['username']);
	}
		}
		else {
        return Redirect::to('register')->with('message', 'The following errors occurred')->withErrors($validator)->withInput(); 
        }
}
  
  public function postSignin(){
  
	 $user = array(
        'email' => Input::get('email'),
        'password' => Input::get('password')
    );
	if (Auth::attempt($user)) {
	$creatyst = User::where('email','=',$user['email'])->first();
     return Redirect::to('profile')
        ->with('username', $creatyst->username);
	}
	else {
    return Redirect::to('login')
        ->with('message', Input::get('email').Input::get('password'))
        ->withInput();
}
}

  public function getLogout() {
    Auth::logout();
    return Redirect::to('login')->with('message', 'Your are now logged out!');
}
  public function postUpload(){
 
    $input = Input::all();
    $rules = array(
        'size' => 'max:50000',
		'type' => 'mimes:png,jpg,gif');
 
    $validation = Validator::make($input, $rules);
 
    if ($validation->fails())
    {
        return Response::make($validation->errors->first(), 400);
    }
   
    $file = Input::file('file');
	$directory = 'profilepic\\'.Input::get('folder');
    $extension = File::extension($file);    
    $filename = sha1(time().time()).".{$extension}"; 
    $upload_success = Image::upload($file, $directory, false);
	
 
    if( $upload_success ) {
        return Redirect::to('profile')
        ->with('username', Input::get('folder'));
    } else {
	    
        return Response::json('error', 400);
		
    }
}

public function postMultiupload(){
	$input = Input::all();
    $rules = array(
        'size' => 'max:50000',
		'type' => 'mimes:png,jpg,gif,avi,mp4'
    );
 
    $validation = Validator::make($input, $rules);
 
    if ($validation->fails())
    {
        return Response::make($validation->errors->first(), 400);
    }
    
	
    $file = Input::file('file');
	$directory = Input::get('folder');
    $extension = File::extension($file);    
    $filename = sha1(time().time()).".{$extension}"; 
    $upload_success = Image::upload($file, $directory, false);
	
 
    if( $upload_success ) {
        return Redirect::to('profile')
        ->with('username', $directory);
    } else {
	    
        return Response::json('error', 400);
		
    }
}

}

?>


