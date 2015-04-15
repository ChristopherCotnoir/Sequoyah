<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SyllabaryCellAddFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('syllabary_cell', function(Blueprint $table)
		{
      $table->integer('syllabary_id')->unsigned();
      $table->integer('row_id');
      $table->integer('col_id');
      $table->boolean('deleted');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('syllabary_cell', function(Blueprint $table)
		{
			//
		});
	}

}
