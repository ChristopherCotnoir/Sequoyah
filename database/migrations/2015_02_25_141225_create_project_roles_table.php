<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectRolesTable extends Migration {

	public function up()
	{
		Schema::create('project_roles', function($table)
		{
			$table->bigIncrements('id');
			$table->string('name', 32);
		});
	}

	public function down()
	{
		Schema::drop('project_roles');
	}

}
