<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
	protected $collection = 'courses_collection';
    protected $fillable = ['courseName','startDate','endDate','courseImage'];
    protected $hidden = ['updated_at', 'created_at'];


    public function capabilities()
    {
        return $this->hasMany(Capability::class,'courseId');
    }
}