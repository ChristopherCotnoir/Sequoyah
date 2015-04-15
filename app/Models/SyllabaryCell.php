<?php namespace Sequoyah\Models;

use Illuminate\Database\Eloquent\Model;

class SyllabaryCell extends Model {

	protected $table = 'syllabary_cell';

	protected $fillable = ['syllabary_id', 'row_id', 'col_id', 'deleted'];
}
