<?php

namespace App\Http\Livewire\Admin\Group;

use App\Models\Certificate;
use App\Models\CourseUser;
use App\Models\GroupModule;
use App\Models\Lesson;
use App\Models\User;
use App\Services\Search\Service;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GroupUserShow extends Component
{
    // Объявление свойст
    public $user_id;
    public $group_id;
    public $courses;
    public $user;
    public $courseStatus;
    public $allStatus;

    // Создаем свойство для события
    protected $listeners = [
        'refreshComponent'
    ];

    // Функция для обновления компонента
    public function refreshComponent()
    {
        $this->baseQuery();
    }


    // Объявление базового метода для одинкаовых базовых запросов
    public function baseQuery()
    {
        $this->user = User::query()->select('users.surname')->find($this->user_id);

        $this->courses = GroupModule::query()
            ->select('group_modules.id as module_id', 'group_modules.course_id', 'courses.id', 'courses.name')
            ->leftJoin('courses', 'group_modules.course_id', '=', 'courses.id')
            ->where('group_modules.group_id', '=', $this->group_id)
            ->groupBy('courses.id')
            ->get();
    }

    // Проверка деления на ноль
    public function divideByZeroCheck($allCourseLessons, $allCourseLearnedLessons)
    {
        // Объявление переменной результата
        $result = [];

        // Проверка на ошибку
        if ($allCourseLessons->count() === 0) {

            $result = ['result' => 0,];
        } else {

            $result = ['result' => $allCourseLearnedLessons->count() / $allCourseLessons->count() * 100,];
        }

        // Возвращение результата
        return $result;
    }

    // Получение информации о том, что пройден ли курс
    public function getLearnedAndAllLessonsQuery($value, $user_id)
    {
        // Получение всех уроков курса
        $allCourseLessons = Lesson::query()->where('course_id', '=', $value)->get();

        // Получение всех пройденных уроков курса
        $allCourseLearnedLessons = Lesson::query()
            ->join('lesson_users', 'lessons.id', '=', 'lesson_users.lesson_id')
            ->where('lesson_users.user_id', '=', $user_id)
            ->where('lesson_users.lesson_users_status_id', '=', 3)
            ->where('lessons.course_id', '=', $value)
            ->get();

        return $this->divideByZeroCheck($allCourseLessons,  $allCourseLearnedLessons);
    }

    // Метод для проверки статуса прохождения курса
    public function checkCourseStatus($course_id, $user_id)
    {
        return $this->getLearnedAndAllLessonsQuery($course_id, $user_id);
    }

    // Метод для проверки общего статуса
    public function checkCourseAllStatus($course_id, $user_id)
    {
        $check = Certificate::query()->where('course_id', '=', $course_id)->where('user_id', '=', $user_id)->get();

        if ($check->count() !== 0) {
            return true;
        } else {
            return false;
        }
    }

    // Метод для выдачи сертификата
    public function issue($course_id, $user_id)
    {
        // Запрос для проверки
        $check = $this->checkCourseAllStatus($course_id, $user_id);

        // Если нет записи, то создается информация о прохождении курса
        if (!$check) {

            // Обработка ошибок
            try {

                // Запуск транзакции
                DB::beginTransaction();

                Certificate::query()->create([
                    'user_id' => $user_id,
                    'course_id' => $course_id,
                ]);

                // Сохранение
                DB::commit();
            } catch (\Exception $exception) {

                // Откат изменений при появлении ошибки
                DB::rollBack();

                // Возвращение сообщения ошибки
                return $exception->getMessage();
            }
        }

        $this->emit('refreshComponent');
    }

    // Метод для отмены выдачи сертификата
    public function cancel($course_id, $user_id)
    {
        // Запрос для проверки
        $check = $this->checkCourseAllStatus($course_id, $user_id);

        // Если есть запись, то удаляется информация о прохождении курса
        if ($check) {

            // Обработка ошибок
            try {

                // Запуск транзакции
                DB::beginTransaction();

                Certificate::query()
                    ->where('user_id', '=', $user_id)
                    ->where('course_id', '=', $course_id)
                    ->delete();

                // Сохранение
                DB::commit();
            } catch (\Exception $exception) {

                // Откат изменений при появлении ошибки
                DB::rollBack();

                // Возвращение сообщения ошибки
                return $exception->getMessage();
            }
        }

        $this->emit('refreshComponent');
    }

    // Базовый метод
    public function mount()
    {
        $this->baseQuery();
    }

    public function render()
    {
        return view('livewire.admin.group.group-user-show');
    }
}
