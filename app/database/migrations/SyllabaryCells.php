<?php

use Illuminate\Database\Migrations\Migration;

class SyllabaryCellsTable extends Migration
{
	public function up()
	{
		Schema::create('syllabary_cells', function($table)
		{
			$table->bigIncrements('id');
		});
	}

	public function down()
	{
		Schema::drop('syllabary_cells');
	}
}