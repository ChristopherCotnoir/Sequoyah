<?php namespace Sequoyah\Models;

use Illuminate\Database\Eloquent\Model;

class SyllabaryRowHeader extends Model {

	protected $table = 'syllabary_row_header';

	protected $fillable = ['syllabary_id', 'ipa', 'symbol_id', 'next_id', 'prev_id', 'audio_sample'];
	
	public function symbol()
	{
		return $this->hasOne('Sequoyah\Models\Symbol', 'id', 'symbol_id');
	}
}
