<?php

use Illuminate\Database\Migrations\Migration;

class SyllabaryRowHeadersTable extends Migration
{	
	public function up()
	{
		Schema::create('syllabary_row_headers', function($table)
		{
			$table->bigIncrements('id');
			$table->string('name');
			$table->bigInteger('index');
			$table->string('IPA');
			$table->string('pronunciation');
		});
	}

	public function down()
	{
		Schema::drop('syllabary_row_headers');
	}
}