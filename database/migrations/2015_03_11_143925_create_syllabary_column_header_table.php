<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSyllabaryColumnHeaderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syllabary_column_header', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('syllabary_id')->unsigned();
			$table->string('ipa', 10);
			$table->integer('index')->unsigned();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syllabary_column_header');
	}

}
