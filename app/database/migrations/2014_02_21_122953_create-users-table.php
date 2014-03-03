<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	Schema::create('users' , function(Blueprint $table)
	{
	$table->increments('id');
    $table->string('name', 20);
	$table->string('email', 100)->unique();
	$table->string('username', 20)->unique(); 	
    $table->string('city', 20);  
	$table->string('talent', 50); 	
    $table->string('password', 64);
	$table->string('profilepic', 255);
    $table->timestamps();
	});
	Schema::create('galleries' , function(Blueprint $table)
	Schema::create('galleries' , function(Blueprint $table)
	{
	$table->increments('id');
    $table->string('username', 20);
	$table->string('email', 100)->unique();
    $table->string('location', 255);
    $table->timestamps();
	});
	
}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
		Schema::drop('gallery');
	}

}
