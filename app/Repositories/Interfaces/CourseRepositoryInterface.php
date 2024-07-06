<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\Course\CourseStoreRequest;

interface CourseRepositoryInterface
{
    // Метод для добавления курса
    public function courseStore(CourseStoreRequest $request);
}
