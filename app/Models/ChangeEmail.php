<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'new_email',
        'old_email',
        'expires_at',
        'code',
        'change_check',
    ];
}
