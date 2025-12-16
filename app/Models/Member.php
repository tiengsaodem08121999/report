<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';

    protected $fillable = [
        "name",
        "key",
        "project_id",
    ];

    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }
}