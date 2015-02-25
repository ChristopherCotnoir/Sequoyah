<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_members', function(Blueprint $table)
		{
			$table->bigInteger('user_id')->unsigned();
			//$table->foreign('user_id')->references('id')->on('users');
			
			$table->bigInteger('project_id')->unsigned();
			//$table->foreign('project_id')->references('id')->on('projects');
			
			$table->smallInteger('access')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('project_members');
	}

}
