<?php
class ProfileController extends BaseController{
	public function user($username){
		$user = User::where('firstname','=',$username);
		if($user->count()){
		$user = $user->first();
		return View::make('users.user')
				->with('user',$user);
		}
		return App::abort(404);
	}
	public function store()
{
    $validator = Validator::make(Input::all(), Article::$rules);
 
    if ($validation->passes())
    {
        $article = new Article;
        $article->title   = Input::get('title');
        $article->slug    = Str::slug(Input::get('title'));
        $article->body    = Input::get('body');
        $article->user_id = Sentry::getUser()->id;
        $article->save();
 
        // Now that we have the article ID we need to move the image
        if (Input::hasFile('image'))
        {
            $article->image = Image::upload(Input::file('image'), 'articles/' . $article->id);
            $article->save();
        }
 
        Notification::success('The article was saved.');
 
        return Redirect::route('admin.articles.edit', $article->id);
    }
 
    return Redirect::back()->withInput()->withErrors($validation->errors);
}
 
public function update($id)
{
    $validation = new ArticleValidator;
 
    if ($validation->passes())
    {
        $article = Article::find($id);
        $article->title   = Input::get('title');
        $article->slug    = Str::slug(Input::get('title'));
        $article->body    = Input::get('body');
        $article->user_id = Sentry::getUser()->id;
        if (Input::hasFile('image')) $article->image   = Image::upload(Input::file('image'), 'articles/' . $article->id);
        $article->save();
 
        Notification::success('The article was saved.');
 
        return Redirect::route('admin.articles.edit', $article->id);
    }
 
    return Redirect::back()->withInput()->withErrors($validation->errors);
}

 public function upload()
{
	$rules = array(
    'profile_img'     => 'image|max:3000'
);
   $validator = Validator::make(Input::all(), $rules);
   
      if ($validator->passes()) {
        // validation has passed, save user in 
			
		Image::upload(Input::file('image'), 'uploads/' , true);
		
		}
		else {
        return Redirect::to('users/profile')->with('message', 'The following errors occurred')->withErrors($validator)->withInput(); 
        }
   
}

/*public function multiUpload()
{
	if (Input::hasFile('file[]')) {
    $all_uploads = Input::file('file[]');
	$folder = Input::get('folder');
    // Make sure it really is an array
    if (!is_array($all_uploads)) {
        $all_uploads = array($all_uploads);
    }

    $error_messages = array();

    // Loop through all uploaded files
    foreach ($all_uploads as $upload) {
        // Ignore array member if it's not an UploadedFile object, just to be extra save
        if (!is_a($upload, 'Symfony\Component\HttpFoundation\File\UploadedFile')) {
            continue;
        }

        $validator = Validator::make(
            array('file' => $upload),
            array('file' => 'required|mimes:jpeg,png|image|max:5000')
        );

        if ($validator->passes()) {
            Image::upload($upload, 'uploads/'.$folder , true);
        } else {
            // Collect error messages
            $error_messages[] = 'File "' . $upload->getClientOriginalName() . '":' . $validator->messages()->first('file');
        }
    }

    // Redirect, return JSON, whatever...
    return $error_messages;
} else {
    // No files have been uploaded
}
}*/

public function multiUpload(){
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
        return Response::json('success', 200);
    } else {
        return Response::json('error', 400);
    }
}

}
?>