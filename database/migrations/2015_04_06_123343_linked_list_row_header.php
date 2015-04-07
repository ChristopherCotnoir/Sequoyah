<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LinkedListRowHeader extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('syllabary_row_header', function(Blueprint $table)
		{
 			$table->integer('next_id');
      $table->integer('prev_id');
      $table->dropColumn('index');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('syllabary_row_header', function(Blueprint $table)
		{
      $table->dropColumn('next_id');
      $table->dropColumn('prev_id');
      $table->integer('index');
		});
	}

}
