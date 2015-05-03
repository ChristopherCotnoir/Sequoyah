<?php namespace Sequoyah\Models;

use Illuminate\Database\Eloquent\Model;

class UndoRecord extends Model {

	protected $table = 'undo_records';

	protected $fillable = ['syllabary_id', 'json_data'];
}
