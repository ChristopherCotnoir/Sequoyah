<?php namespace Sequoyah\Models;

use Illuminate\Database\Eloquent\Model;

class Syllabary extends Model
{
    protected $table = 'syllabaries';

    protected $fillable = ['name'];
}
