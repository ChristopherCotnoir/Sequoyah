<?php

use Illuminate\Database\Migrations\Migration;

class SyllabaryColumnHeadersTable extends Migration
{	
	public function up()
	{
		Schema::create('syllabary_colun_headers', function($table)
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
		Schema::drop('syllabary_column_headers');
	}
}