<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {

	public function up()
	{
		Schema::create('projects', function($table)
		{
			$table->bigIncrements('id');
			$table->string('name');
			
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('projects');
	}
}
