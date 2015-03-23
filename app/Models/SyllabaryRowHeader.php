<?php namespace Sequoyah\Models;

use Illuminate\Database\Eloquent\Model;

class SyllabaryRowHeader extends Model {

	protected $table = 'syllabary_row_header';

	protected $fillable = ['syllabary_id', 'ipa', 'symbol_id', 'index'];
}
