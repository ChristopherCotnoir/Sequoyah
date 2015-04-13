<?php namespace Sequoyah\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMembers extends Model
{
    protected $table = 'project_members';

    protected $fillable = ['user_id', 'project_id', 'access'];
}