<?php

namespace App\Http\Livewire\Course;

use App\Models\Course as ModelsCourse;
use App\Models\CourseCategory;
use App\Models\CourseLevel;
use Livewire\Component;

class Course extends Component
{

    // Свойства
    public $categories;
    public $courses;
    public $author;
    public $course_levels;

    // Активные переменные
    public $level_id = null;
    public $category_id = null;

    // События
    protected $listeners = [
        'refreshLevels',
        'refreshCategories',
    ];

    // Сброс уровней сложности
    public function refreshLevels()
    {
        $this->level_id = null;
    }

    // Сброс категорий
    public function refreshCategories()
    {
        $this->category_id = null;
    }

    // Рендер страницы
    public function render()
    {
        if ($this->level_id === null && $this->category_id === null) {
            $this->courses = ModelsCourse::all();
        } elseif ($this->level_id !== null && $this->category_id === null) {
            $this->courses = ModelsCourse::where('course_level_id', '=', $this->level_id)->get();
        } elseif ($this->level_id === null && $this->category_id !== null) {
            $this->courses = ModelsCourse::where('course_category_id', '=', $this->category_id)->get();
        } elseif ($this->level_id !== null && $this->category_id !== null) {
            $this->courses = ModelsCourse::where('course_category_id', '=', $this->category_id)->where('course_level_id', '=', $this->level_id)->get();
        }
        return view('livewire.course.course');
    }

    // Начальная установка
    public function mount()
    {
        $this->categories = CourseCategory::all();
        $this->course_levels = CourseLevel::all();
        $this->courses = ModelsCourse::all();
    }

    // Установка уровня сложности
    public function setLevelId($level_id)
    {
        $this->level_id = $level_id;
    }

    // Установка категории
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }
}
