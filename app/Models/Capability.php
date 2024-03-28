<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Capability extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
	protected $collection = 'capabilities_collection';
    protected $fillable = ['capabilityName','courseId'];
    protected $hidden = ['updated_at', 'created_at'];

    public function skills()
    {
        return $this->hasMany(Skill::class,'capabilityId');
    }
}
