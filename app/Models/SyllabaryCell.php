<?php namespace Sequoyah\Models;

use Illuminate\Database\Eloquent\Model;

class SyllabaryCell extends Model {

	protected $table = 'syllabary_cell';

	protected $fillable = ['syllabary_id', 'row_id', 'col_id', 'deleted', 'symbol_id'];

	public function symbol()
	{
		return $this->hasOne('Sequoyah\Models\Symbol', 'id', 'symbol_id');
	}
}
