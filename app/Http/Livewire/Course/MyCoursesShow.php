<?php

namespace App\Http\Livewire\Course;

use App\Models\CourseUser;
use App\Models\GroupModule;
use App\Models\LessonModule;
use App\Models\LessonUser;
use App\Models\Lesson;
use App\Models\UserModule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MyCoursesShow extends Component
{
    // Объявление свойтсв
    public $applications;
    public $progressBarResult;
    public $courses_id = [];

    // Базовый запрос
    public function baseQuery($return = false)
    {

        $query = CourseUser::query()->where('course_users.user_id', '=', Auth::user()->id)->where('course_users.course_users_status_id', '=', 3);

        $this->applications = $query->get();

        if($return) return $query;

    }

    // Проверка деления на ноль
    public function divideByZeroCheck($allCourseLessons, $allCourseLearnedLessons, $value)
    {

        // Объявление переменной результата
        $result = [];

        // Проверка на ошибку
        if ($allCourseLessons === 0) {

            $result = ['course_id'  => $value->course_id, 'result' => 0,];
        } else {

            $result = ['course_id'  => $value->course_id, 'result' => $allCourseLearnedLessons / $allCourseLessons * 100,];
        }

        // Возвращение результата
        return $result;
    }

    // Изначальная инициализация
    public function getLearnedAndAllLessonsQuery($application, $user_id)
    {

        // Получение всех уроков курса
        $allCourseLessons = Lesson::query()->select('id')->where('course_id', '=', $application->course_id)->count();

        // Получение всех пройденных уроков курса
        $allCourseLearnedLessons = Lesson::query()
            ->select('lesson.id')
            ->join('lesson_users', 'lessons.id', '=', 'lesson_users.lesson_id')
            ->where('lesson_users.user_id', '=', $user_id)
            ->where('lesson_users.lesson_users_status_id', '=', 3)
            ->where('lessons.course_id', '=', $application->course_id)
            ->count();

        return $this->divideByZeroCheck($allCourseLessons,  $allCourseLearnedLessons, $application);
    }

    // Функция определения пройденных и общего количества уроков
    public function getLearnedAndAllLessons($applications, $user_id)
    {

        if(!$applications) return 0;

        // Объявление переменной результата
        $result = [];

        // Перебор значений
        foreach ($applications as $application) {

            // Перебор значений
            $tempResult = [];

            $tempResult = $this->getLearnedAndAllLessonsQuery($application, $user_id);

            // Добавление в массив
            array_push($result, $tempResult);
        }

        // Возвращение результата
        return $result;
    }



    // Получение пройденных курсов
    public function getCompletedCourses($applications, $user_id)
    {

        if(!$applications) return [];

        // Объявляем переменную результата
        $result = [];

        // Получаем результат
        $elements = $this->getLearnedAndAllLessons($applications, $user_id);

        // Перебираем результат
        foreach ($elements as $element) {

            if ($element['result'] === 100) {

                $result[] = $element['course_id'];

            }

        }

        // Возвращаем результат
        return $result;

    }

    // Получение всех курсов
    public function all()
    {

        $completed_courses = $this->getCompletedCoursesByCertificate();

        $uncompleted_courses = $this->getUncompletedCoursesByCertificate($completed_courses);

        $sortedCourses = $this->sortCourses($completed_courses, $uncompleted_courses);

        $this->applications = $this->getApplications($sortedCourses) ? $this->getApplications($sortedCourses) : null;

    }

    // Выносим базовый запрос активных и пройденных курсов
    public function baseActiveOrCompletedQuery()
    {
        return CourseUser::query()
            ->select(
                'course_users.course_id',
                'course_users.user_id',
                'course_users.group_id',
                'course_users.course_users_status_id',
            )
            ->where('user_id', '=', Auth::user()->id)
            ->where('course_users_status_id', '=', 3);

    }

    // Получение активных курсов
    public function active()
    {

        // Получение id пройденных курсов
        $this->courses_id = $this->getCompletedCourses($this->applications, auth()->user()->id);

        // Получение базового запроса
        $this->applications = $this->baseActiveOrCompletedQuery();

        // Получение активных курсов
        $this->applications = $this->applications->whereNotIn('course_users.course_id',  $this->courses_id)->get();

    }

    // Получение пройденных курсов
    public function completed()
    {
        // Получение id пройденных курсов
        $this->courses_id = $this->getCompletedCourses($this->applications, auth()->user()->id);

        // Получение базового запроса
        $this->applications = $this->baseActiveOrCompletedQuery();

        // Получение пройденных курсов
        $this->applications = $this->applications->whereIn('course_users.course_id',  $this->courses_id)->get();
    }

    // Метод для получения результатов прогресс бара
    public function progressBar()
    {
        // Получение результатов
        $this->progressBarResult = $this->getLearnedAndAllLessons($this->applications, auth()->user()->id);
    }

    // Поиск пройденных курсов по наличию сертификата
    protected function getCompletedCoursesByCertificate() {

        return $this->baseQuery(return: true)
            ->select('course_users.course_id')
            ->join('certificates', function ($join) {
                $join->on('course_users.course_id', '=', 'certificates.course_id')
                    ->where('course_users.user_id', '=', auth()->user()->id);
            })
            ->whereNotNull('certificates.id')
            ->select('course_users.course_id')
            ->distinct()
            ->get();

    }

    protected function getUncompletedCoursesByCertificate($completedCourses)
    {
        return $this->baseQuery(return: true)
            ->select('course_id')
            ->whereNotIn('course_id', $completedCourses)
            ->get();
    }

    protected function sortCourses($completedCourses, $uncompletedCourses)
    {
        $sortedCourses = $uncompletedCourses->pluck('course_id')->merge($completedCourses->pluck('course_id'));
        return $sortedCourses->all();
    }

    protected function getApplications($sortedCourses)
    {

        $orderByString = '';

        foreach ($sortedCourses as $key => $value) {
            $orderByString .= "WHEN course_id = " . $value . " THEN " . $key . " ";
        }

        $orderByString = trim($orderByString);

        if($orderByString === '') return $this->baseQuery();

        return $this->baseQuery(return: true)
        ->whereIn('course_id', $sortedCourses)
        ->orderByRaw(DB::raw("CASE $orderByString END"))
        ->get();

    }


    // Изначальная инициализация
    public function mount()
    {

        $completed_courses = $this->getCompletedCoursesByCertificate();

        $uncompleted_courses = $this->getUncompletedCoursesByCertificate($completed_courses);

        $sortedCourses = $this->sortCourses($completed_courses, $uncompleted_courses);

        $this->applications = $this->getApplications($sortedCourses);

    }

    // Метод для рендера
    public function render()
    {
        // Вызов метода прогресс бара
        $this->progressBar();

        // Возвращение шаблона
        return view('livewire.course.my-courses-show');
    }
}
