<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function reviews() {
        return $this->hasMany(Review::class, 'review_statuses_id', 'id');
    }
}
