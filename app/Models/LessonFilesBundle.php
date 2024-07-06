<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonFilesBundle extends Model
{
    use HasFactory;
//    use SoftDeletes;

    // Ручное связывание модели с таблицой
    protected $table = 'lesson_files_bundles';
    // Разрешение на запросы
    protected $guarded = false;

    public function file()
    {
        return $this->belongsTo(LessonFile::class, 'file_id', 'id');
    }
}
