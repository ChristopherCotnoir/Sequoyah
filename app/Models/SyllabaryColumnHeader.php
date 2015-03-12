<?php namespace Sequoyah\Models;

use Illuminate\Database\Eloquent\Model;

class SyllabaryColumnHeader extends Model {

	protected $table = 'syllabary_column_header';

	protected $fillable = ['syllabary_id', 'ipa', 'index'];
}
