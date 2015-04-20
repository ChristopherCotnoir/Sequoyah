<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAudioSample extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('syllabary_column_header', function(Blueprint $table)
		{
			$table->string('audio_sample', 100)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('syllabary_column_header', function(Blueprint $table)
		{
			$table->dropColumn('audio_sample');
		});
	}

}
