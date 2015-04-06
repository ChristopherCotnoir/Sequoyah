<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSyllabaryRowHeaderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syllabary_row_header', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('syllabary_id')->unsigned();
			$table->string('ipa', 10);
      		$table->bigInteger('symbol_id')->unsigned();
			$table->bigInteger('index')->unsigned();
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
		Schema::drop('syllabary_row_header');
	}

}
