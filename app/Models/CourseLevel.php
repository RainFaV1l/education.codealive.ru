<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLevel extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function courses()
    {
        return $this->hasMany(Course::class, 'course_level_id', 'id');
    }
}
