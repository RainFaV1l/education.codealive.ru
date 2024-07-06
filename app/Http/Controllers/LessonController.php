<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lesson\LessonStoreRequest;

class LessonController extends BaseController
{
    // Страница добавления
    public function add($id = null)
    {
        // Проверка есть ли id курса
        if ($id == null) {
            // Если нет, то передаем на страницу все курсы
            $courses = Course::all();
            // Показание страницы
            return view('livewire.admin.lesson.add', compact('courses'));
        } else {
            // Если есть, то передаем на страницу один курс
            $course = Course::findOrFail($id);
            // Показание страницы
            return view('livewire.admin.lesson.add', compact('course'));
        }
    }

    // Страница редактирования
    public function edit($id)
    {
        //Получение данных
        $lesson_id = $id;
        $lesson = Lesson::findOrFail($id);
        $courses = Course::All();
        // Показание страницы
        return view('livewire.admin.lesson.edit', compact('lesson_id', 'lesson', 'courses'));
    }

    // Страница подробнее
    public function more($module_id, $lesson_id)
    {
        //Получение данных
        $lesson = Lesson::find($lesson_id);
        // Показание страницы
        return view('livewire.lesson.one-lesson', compact(['lesson_id', 'lesson', 'module_id']));
    }

    // Страница подробнее (для администратора)
    public function dashboardMore($lesson_id)
    {
        //Получение данных
        $lesson = Lesson::find($lesson_id);
        // Показание страницы
        return view('livewire.lesson.one-lesson', compact(['lesson_id', 'lesson']));
    }

    // Добавление урока
    public function store(LessonStoreRequest $request)
    {
        // Создание урока
        $this->lessonRepository->createLesson($request);

        // Редирект
        return redirect()->route('courses.admin.more', $request->course_id);
    }
}
