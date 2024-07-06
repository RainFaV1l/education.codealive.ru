<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'user_id',
        'rating',
        'description',
    ];

    // Связь с пользователем
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Связь с курсом
    public function course() {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    // Связь со статусом
    public function status() {
        return $this->belongsTo(ReviewStatus::class, 'review_statuses_id', 'id');
    }

}
