<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Info extends Eloquent implements UserInterface, RemindableInterface {

	public static $rules = array(
    'email'=>'required|email|unique:users',
	'username'=>'required|alpha_dash|between:3,10|unique:users'
    );

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'userinfo';

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

}