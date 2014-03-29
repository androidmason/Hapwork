<?php
class ProfileController extends BaseController{
	public function user($username){
		$user = User::where('username','=',$username);
		if($user->count()){
		$user = $user->first();
		return View::make('users.user')
				->with('creatyst',$user);
		}
		//return App::abort(404);
	}
	
	public function appendValue($data, $type, $element)
  {
    // operate on the item passed by reference, adding the element and type
    foreach ($data as $key => & $item) {
      $item[$element] = $type;
    }
    return $data;  
  }
	
	public function appendDP($data, $prefix)
  {
    // operate on the item passed by reference, adding the url based on slug
    foreach ($data as $key => & $item) {
		if(!is_null($item['profilepic']))
      $item['profilepic'] = url($prefix.'/'.$item['username'].'/'.$item['profilepic']);
	  else
	  $item['profilepic'] = 'http://www.hapwork.com/images/default_profile.png';
    }
    return $data;  
  }
  public function appendURL($data)
{
  // operate on the item passed by reference, adding the url based on slug
  foreach ($data as $key => & $item) {
    $item['url'] = url('/user/'.$item['username']);
  }
  return $data;  
}
	
	public function index(){
	
	$query = e(Input::get('q',''));

	
 
    $products = User::where('firstname','like','%'.$query.'%')
      ->orderBy('firstname','asc')
      ->get(array('talent','firstname','profilepic','username','city'))->toArray();
 
    $categories = User::where('talent','like','%'.$query.'%')
      ->get(array('talent', 'firstname','profilepic','username','city'))
      ->toArray();
 
    $products   = $this->appendDP($products, 'uploads/profilepic');
    $categories  = $this->appendDP($categories, 'uploads/profilepic');
	
	$products   = $this->appendURL($products);
    $categories  = $this->appendURL($categories);
	
    // Merge all data into one array
    $data = array_merge($products, $categories);
 
    	return Response::json(array(
		'data'=>$data
));
  }
}



?>