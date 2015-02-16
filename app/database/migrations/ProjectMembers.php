<?php

use Illuminate\Database\Migrations\Migration;

class ProjectMembersTable extends Migration
{
	public function up()
	{
		Schema::create('project_members', function($table)
		{
			$table->bigInteger('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			
			$table->bigInteger('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects');
			
			$table->smallInteger('access')->default(0);
		});
	}

	public function down()
	{
		Schema::drop('project_members');
	}
}