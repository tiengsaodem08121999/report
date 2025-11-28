<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $fillable = ['project_name'];
    protected $table = 'projects';

    public function members()
    {
        return $this->hasMany(Members::class, 'project_id');
    }
}
