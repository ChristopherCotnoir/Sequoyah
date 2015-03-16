<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSyllabariesTable extends Migration {

	public function up()
	{
		Schema::create('syllabaries', function($table)
		{
			$table->bigIncrements('id');
			$table->string('name');
			
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('syllabaries');
	}
}
