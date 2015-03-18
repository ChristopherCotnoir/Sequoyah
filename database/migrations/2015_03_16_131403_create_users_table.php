<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->bigInteger('id')->unsigned();
			
			$table->string('username', 128); //user's publically available user name (i.e. JohnSmith) -- case insensitive
			
			$table->text('name'); //user's formal name (i.e. John Smith)
			$table->string('password', 200); //hashed user password (uses laravel hash make)
			
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
	}
}