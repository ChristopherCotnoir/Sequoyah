<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSymbolIdToCell extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('syllabary_cell', function(Blueprint $table)
		{
			$table->integer('symbol_id')->unsigned()->nullable();
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
			$table->dropColumn('symbol_id');
		});
	}

}
