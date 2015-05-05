<?php namespace Sequoyah\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = ['project_id', 'name', 'syllabary_id'];
}