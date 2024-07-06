<?php

namespace App\Repositories;

use App\Models\Review;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ReviewRepository implements ReviewRepositoryInterface
{
    // Метод для проверки наличия значение в таблицу
    public function checkIsIssetValueInTable($review_id)
    {
        // Запрос
        $query = Review::query()->where('id', '=', $review_id)->where('review_statuses_id', '=', 1)->get();

        // Проверка
        if ($query->count() !== 1) {
            // Возвращение false
            return false;
        }

        // Возвращение true
        return true;
    }
}
