<?php

use Illuminate\Database\Migrations\Migration;

class ProjectRolesTable extends Migration
{
	//All of the available roles for projects
	public static Access = [
		'Guest' => 0,
		'Read' => 1,
		'ReadWrite' => 2,
		'Administrate' => 3
	];
	
	public function up()
	{
		Schema::create('project_roles', function($table)
		{
			$table->bigIncrement('id');
			$table->varchar('name', 32);
		});
	}

	public function down()
	{
		Schema::drop('project_members');
	}
}