<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CourseUser;
use App\Models\Review;

class IndexController extends Controller
{
    // Главная страница
    public function index()
    {

        // Получение популярных курсов
        $popularCourses = CourseUser::query()
            ->select('courses.id as course_id')
            ->selectRaw('COUNT(course_users.course_id) as count')
            ->rightJoin('courses', 'course_users.course_id', '=', 'courses.id')
            ->groupBy('course_users.course_id')
            ->orderBy('count', 'desc')
            ->take(4)->get();

        // Получение всех отзывов
        $reviews = Review::query()->where('review_statuses_id', '=', 2)->get();

        // Рендеринг страницы
        return view('livewire.index', compact('popularCourses', 'reviews'));

    }
}
