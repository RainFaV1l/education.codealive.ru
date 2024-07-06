<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\GroupModule;
use App\Models\LessonModule;
use App\Models\Review;
use Illuminate\Http\Request;

class CatalogController extends BaseController
{
    // Показ страницы каталога
    public function index()
    {
        // Рендеринг вида
        return view('livewire.catalog');
    }

    // Страница одного курса в каталоге
    public function show(Course $course)
    {
        // Вычисление общего количества уроков
        $allLessonsCount = $course->lessons->count();

        // Получение отзывов данного курса
        $reviews = Review::query()->where('course_id', '=', $course->id)->where('review_statuses_id', '=', 2)->get();

        // Получение средней оценки курса
        $avgRating = $this->catalogService->calcCourseAvgRating($reviews);

        // Рендеринг вида
        return view('livewire.course.one-course', compact('course', 'allLessonsCount', 'reviews', 'avgRating'));
    }
}
