<?php

namespace App\Services\Catalog;

use App\Http\Requests\Profile\ChangeAvatarRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Service
{

    // Метод вычисления средней оценки курса
    public function calcCourseAvgRating($reviews)
    {

        // Переменная хранение результата
        $result = 0;

        // Перебор отзывов
        foreach ($reviews as $review) {

            // Вычисление
            $result = $result + $review->rating;
        }

        // Проверка деления на ноль
        if ($reviews->count() !== 0) {

            // Вычисление среднего значения
            $result = $result / $reviews->count();
        }

        // Возвращение результата
        return round($result, 1);
    }
}
