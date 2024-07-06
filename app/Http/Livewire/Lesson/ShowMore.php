<?php

namespace App\Http\Livewire\Lesson;

use App\Models\Course;
use App\Models\GroupModule;
use App\Models\Lesson;
use App\Models\LessonComment;
use App\Models\LessonModule;
use App\Models\LessonUser;
use App\Models\LessonVideosBundle;
use App\Models\UserModule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\WithPagination;

class ShowMore extends Component
{
    use WithPagination;

    public $lesson_id;
    public $module_id;
    public $lesson;
    public $course;
    public $module_lessons;
    public $task;
    public $user_id;
    public $adminMessage;
    public $percent;

    protected $listeners = ['resetModules'];

    public $rules = [
        'lesson_id' => 'required',
        'user_id' => 'required',
        'task' => 'required',
    ];

    public function baseQuery()
    {
        $this->module_lessons = Lesson::query()
            ->select('user_modules.module_id', 'lessons.id', 'lessons.lesson_number', 'lessons.task', 'lessons.description', 'lessons.name')
            ->join('lesson_modules', 'lessons.id', 'lesson_modules.lesson_id')
            ->join('user_modules', 'lesson_modules.module_id', 'user_modules.module_id')
            ->where('user_modules.student_id', '=', Auth::user()->id)
            ->where('user_modules.module_id', '=', $this->module_id)
            ->get();
    }

    public function resetModules()
    {
        $this->baseQuery();
    }

    // Проверка деления на ноль
    public function divideByZeroCheck($allCourseLessons, $allCourseLearnedLessons)
    {

        // Объявление переменной результата
        $result = [];

        // Проверка на ошибку
        if ($allCourseLessons->count() === 0) {

            $result = 0;
        } else {

            $result = $allCourseLearnedLessons->count() / $allCourseLessons->count() * 100;
        }

        // Возвращение результата
        return $result;
    }

    // Изначальная инициализация
    public function getLearnedAndAllLessonsQuery()
    {

        // Получение всех уроков курса
        $allCourseLessons = LessonModule::query()->where('lesson_modules.module_id', '=', $this->module_id)->get();

        $allCourseLearnedLessons = LessonUser::query()
            ->join('lesson_modules', 'lesson_users.lesson_id', '=', 'lesson_modules.lesson_id')
            ->where('lesson_modules.module_id', '=', $this->module_id)
            ->where('lesson_users.user_id', '=', Auth::user()->id)
            ->where('lesson_users.lesson_users_status_id', '=', 3)
            ->get();

        return $this->divideByZeroCheck($allCourseLessons,  $allCourseLearnedLessons);
    }

    // Функция определения пройденных и общего количества уроков
    public function getLearnedAndAllLessons()
    {

        // Возвращение результата
        return $this->getLearnedAndAllLessonsQuery();
    }

    // Прогресс бар
    public function progressBar()
    {

        $this->percent = $this->getLearnedAndAllLessons();
    }

    // В прогрессе
    static function inProgress($lesson_id)
    {

        $check = LessonUser::query()
            ->where('lesson_id', '=', $lesson_id)
            ->where('user_id', '=', Auth::user()->id)
            ->where('lesson_users_status_id', '=', 2)
            ->get();

        return $check->count();
    }

    // Пройдены ли
    static function isCompleted($lesson_id)
    {

        $check = LessonUser::query()
            ->where('lesson_id', '=', $lesson_id)
            ->where('user_id', '=', Auth::user()->id)
            ->where('lesson_users_status_id', '=', 3)
            ->get();

        return $check->count();
    }

    // Запрос отправки ответа
    public function sendAnswerQuery()
    {

        $this->validate();

        LessonUser::query()->create([
            'lesson_id' => $this->lesson_id,
            'user_id' => Auth::user()->id,
            'task' => $this->task,
            'lesson_users_status_id' => 2
        ]);

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Задание успешно отправлено на проверку.']);
    }

    // Запрос отправки ответа
    public function resendingAnswerQuery()
    {

        $this->validate();

        LessonUser::query()
        ->where('lesson_id', '=', $this->lesson_id)
        ->where('user_id', '=', $this->user_id)
        ->update([
            'task' => $this->task,
            'lesson_users_status_id' => 2
        ]);

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Задание успешно отправлено на повторную проверку.']);
    }

    // Базовый запрос проверки
    public function checkBaseQuery()
    {

        return LessonUser::query()
            ->where('lesson_id', '=', $this->lesson_id)
            ->where('user_id', '=', $this->user_id);
    }

    // Отправка ответа
    public function sendAnswer()
    {

        // Получение id пользователя
        $this->user_id = Auth::user()->id;

        // Проверка
        $check = $this->checkBaseQuery()->get();

        // Проверка на существование
        if ($check->count() === 0) {

            // Отправка ответа
            $this->sendAnswerQuery();

            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Задание успешно отправлено на проверку.']);

            // Обновление компонента
            $this->emit('resetModules');

            // Возвращение значения
            return true;
        }

        // Проверка на отклонено ли
        $check = $this->checkBaseQuery()->where('lesson_users_status_id', '=', 1)->get();

        // Если отклонено
        if ($check->count() === 1) :

            // Отправка на повторную проверку
            $this->resendingAnswerQuery();

            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Задание успешно отправлено на повторную проверку.']);

            // Обновление компонента
            $this->emit('resetModules');

            // Возвращение значения
            return true;

        endif;

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'error', 'text' => 'Не удалось отправить задание на проверку!']);

        // Возвращение значения
        return false;
    }

    // Начальная установка
    public function mount()
    {

        $this->lesson = Lesson::findOrFail($this->lesson_id);
        $this->course = Course::findOrFail($this->lesson->course_id);

        $this->baseQuery();
    }

    // Получение сообщений администратора
    public function getTeacherLessons()
    {

        // Проверка
        if ($this->lesson_id and $this->module_id) {

            // Получение
            $this->adminMessage = LessonComment::query()->where('lesson_id', '=', $this->lesson_id)->where('student_id', '=', Auth::user()->id)->get();
        }
    }

    // Функция рендера
    public function render()
    {

        // Запуск progressBar
        $this->progressBar();

        // Получение сообщений администратора
        $this->getTeacherLessons();

        // Вывод вида
        return view('livewire.lesson.show-more', [
            'videos' => LessonVideosBundle::query()
                ->where('lesson_id', '=', $this->lesson_id)->paginate(1),
            'adminMessage' => $this->adminMessage
        ]);
    }
}
