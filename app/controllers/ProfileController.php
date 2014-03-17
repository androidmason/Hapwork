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
	public function getUploadForm() {
		return View::make('image/upload-form');
	}

	public function postUpload() {
		$file = Input::file('image');
		$input = array('image' => $file);
		$rules = array(
			'image' => 'image'
		);
		$validator = Validator::make($input, $rules);
		if ( $validator->fails() )
		{
			return Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);

		}
		else {
			$destinationPath = 'uploads/';
			$filename = $file->getClientOriginalName();
			Input::file('image')->move($destinationPath, $filename);
			return Response::json(['success' => true, 'file' => asset($destinationPath.$filename)]);
		}

	}



?>