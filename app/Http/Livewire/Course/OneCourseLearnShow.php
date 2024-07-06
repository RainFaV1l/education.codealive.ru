<?php

namespace App\Http\Livewire\Course;

use App\Http\Livewire\BaseComponent;
use App\Models\CourseUser;
use App\Models\GroupModule;
use App\Models\LessonModule;
use App\Models\Lesson;
use App\Models\LessonUser;
use App\Models\UserModule;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OneCourseLearnShow extends BaseComponent
{
    // Объявление свойств

    // public $show_disabled_modules;
    public $disabled_modules;
    public $course_modules;
    public $course;
    public $group_modules;
    public $learnedModuleCount;
    public $course_id;
    public $open_module_id = [];


    public $result;
    public $percent = 0;

    // Базовый запрос
    public function getGroupModulesQuery()
    {
        // Запрос
        $group_modules = UserModule::query()
            ->select('user_modules.id', 'user_modules.module_id', 'user_modules.student_id', 'group_modules.course_id', 'user_modules.status_id')
            ->leftJoin('group_modules', 'user_modules.module_id', '=', 'group_modules.id')
            ->where('user_modules.student_id', '=', auth()->user()->id)
            ->where('group_modules.course_id', '=', $this->course_id)
            ->get();

        // Возвращение значения
        return $group_modules;
    }

    // Получение всех модулей курса
    public function all()
    {

        $this->course_modules = CourseUser::query()
            ->join('group_modules', 'course_users.group_id', '=', 'group_modules.group_id')
            ->join('user_modules', 'group_modules.id', '=', 'user_modules.module_id')
            ->where('course_users.course_users_status_id', '=', 3)
            ->where('course_users.user_id', '=', \auth()->user()->id)
            ->where('user_modules.student_id', '=', \auth()->user()->id)
            ->where('course_users.course_id', '=', $this->course_id)
            ->orderBy('group_modules.module_number')->get();
    }

    // Получение активных модулей курса
    public function active($group_modules)
    {

        $completedModulesId = $this->courseService->completedModulesOperations($group_modules);

        $this->course_modules = CourseUser::query()
            ->join('group_modules', 'course_users.group_id', '=', 'group_modules.group_id')
            ->join('user_modules', 'group_modules.id', '=', 'user_modules.module_id')
            ->where('course_users.course_users_status_id', '=', 3)
            ->where('course_users.user_id', '=', \auth()->user()->id)
            ->where('user_modules.student_id', '=', \auth()->user()->id)
            ->where('course_users.course_id', '=', $this->course_id)
            ->whereNotIn('group_modules.id', $completedModulesId)
            ->orderBy('group_modules.module_number')->get();
    }

    // Получение пройденных модулей курса
    public function completed($group_modules)
    {

        $completedModulesId = $this->courseService->completedModulesOperations($group_modules);

        $this->course_modules = CourseUser::query()
            ->join('group_modules', 'course_users.group_id', '=', 'group_modules.group_id')
            ->join('user_modules', 'group_modules.id', '=', 'user_modules.module_id')
            ->where('course_users.course_users_status_id', '=', 3)
            ->where('course_users.user_id', '=', \auth()->user()->id)
            ->where('user_modules.student_id', '=', \auth()->user()->id)
            ->where('course_users.course_id', '=', $this->course_id)
            ->whereIn('group_modules.id', $completedModulesId)
            ->orderBy('group_modules.module_number')->get();
    }


    // Метод render
    public function render()
    {

        // Запрос для получения недоступных пользователю модулей курса
        // $this->show_disabled_modules = $this->courseService->setDisabledModules($this->course_id, $this->open_module_id);

        // Запрос для получения group_modules
        $this->group_modules = $this->getGroupModulesQuery();

        // Запрос для получения количества пройденных уроков модуля
        $this->learnedModuleCount = $this->courseService->getLearnedModulesCount($this->group_modules);

        // Запрос для получения количества пройденных и общее количество уроков курса
        $this->result = $this->courseService->getLearnedAndAllCorseLessons($this->course_id, \auth()->user()->id);

        // Проверка на наличие количества пройденных уроков и общего количества уроков
        if (isset($this->result['allLearnedLessonsCount']) and isset($this->result['allLessonsCount']) and $this->result['allLearnedLessonsCount'] !== 0 and $this->result['allLessonsCount'] !== 0) {

            // Вычисление процента
            $this->percent = round($this->result['allLearnedLessonsCount'] / $this->result['allLessonsCount'] * 100);
        }

        // Проверка, есть ли у курса активные модули
        if (isset($this->course_modules)) :

            // Вызов функции получения id доступных пользователю модулей
            $this->open_module_id[] = $this->courseService->setOpenModuleId($this->course_modules);

        endif;

        // Показ шаблона компонента
        return view('livewire.course.one-course-learn-show');
    }
}
