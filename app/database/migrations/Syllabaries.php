<?php

use Illuminate\Database\Migrations\Migration;

class SyllabariesTable extends Migration
{
	public function up()
	{
		Schema::create('syllabaries', function($table)
		{
			$table->bigIncrements('id');
			$table->string('name');
			$table->date('created_at');
			$table->date('updated_at');
		});
	}

	public function down()
	{
		Schema::drop('syllabaries');
	}
}