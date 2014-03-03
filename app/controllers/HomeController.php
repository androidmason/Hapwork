<?php

class HomeController extends BaseController {

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
		$user->username = Input::get('username');
		$user->talent = Input::get('talent');
		$user->password = Hash::make(Input::get('password'));
		$user->save();
		return Redirect::to('login')->with('message', 'Thanks for registering!');
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
     return View::make('home.profile')
        ->with('creatyst', $creatyst);
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
  public function post_upload(){
 
    $input = Input::all();
    $rules = array(
        'file' => 'image|max:5000',
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
   return Response::json('success', 200);
} else {
   return Response::json('error', 400);
}
}

public function postMultiupload(){
	$input = Input::all();
    $rules = array(
        'file' => 'image|max:5000',
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
        return Response::json('success', 200);
    } else {
	    
        return Response::json('error', 400);
		
    }
}

}

?>


