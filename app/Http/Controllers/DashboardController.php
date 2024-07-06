<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    // Конструктор
    public function __construct()
    {
        $this->authorize('view-admin-dashboard', [self::class]);
    }

    // Главная страница
    public function index()
    {
        return view('livewire.admin.dashboard.dashboard');
    }

    // Курсы
    public function courses()
    {
        return view('livewire.admin.dashboard.dashboard-courses');
    }

    // Уроки
    public function lessons()
    {
        return view('livewire.admin.dashboard.dashboard-lessons');
    }

    // Категории
    public function categories()
    {
        return view('livewire.admin.dashboard.dashboard-categories');
    }

    // Пользователи
    public function users()
    {
        return view('livewire.admin.dashboard.dashboard-users');
    }

    // Группы
    public function groups()
    {
        return view('livewire.admin.dashboard.dashboard-groups');
    }

    // Заявки
    public function applications()
    {
        return view('livewire.admin.dashboard.dashboard-applications');
    }

    // Модули
    public function modules() {
        return view('livewire.admin.dashboard.dashboard-modules');
    }

    // Отзывы
    public function reviews() {
        return view('livewire.admin.dashboard.dashboard-reviews');
    }
}
