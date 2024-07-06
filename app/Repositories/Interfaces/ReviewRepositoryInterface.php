<?php

namespace App\Repositories\Interfaces;

use App\Models\Review;

interface ReviewRepositoryInterface
{

    // Метод для проверки наличия значение в таблицу
    public function checkIsIssetValueInTable(Review $review);
    
}
