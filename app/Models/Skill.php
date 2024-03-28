<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
	protected $collection = 'skills_collection';
    protected $fillable = ['skillName','courseId','courseId'];
    protected $hidden = ['updated_at', 'created_at'];
}
