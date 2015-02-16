<?php

use Illuminate\Database\Migrations\Migration;

class UsersTable extends Migration
{
	public function up()
	{
		Schema::create('users', function($table)
		{
			$table->increments('id');
			$table->string('user_name');
			$table->string('name');
			$table->string('password', 60); //hashed
			$table->boolean('is_enabled')->default(1);
			$table->boolean('is_sysadmin')->default(0);
			$table->date('created_at');
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}