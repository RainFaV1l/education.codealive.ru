<?php

namespace App\Http\Livewire\TeacherPanel;

use App\Models\Group;
use App\Models\LessonComment;
use App\Models\LessonUser;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class GroupShow extends Component
{

    // Свойства
    public $course_id;
    public $group_id;
    public $module_id;
    public $answers;
    public $group;
    public $comment = [];

    // События
    protected $listeners = [
        'updateComponent'
    ];

    // Базовый запрос
    public function baseQuery() {
        // Получение группы
        $this->group = Group::query()->find($this->group_id);

        // Получение ответов
        $this->answers = LessonUser::query()
            ->select('lesson_users.id as lesson_users_id', 'lesson_users.lesson_id', 'lesson_users.lesson_users_status_id',
                'lesson_users.task as user_task', 'users.id as user_id', 'users.name', 'users.surname', 'users.patronymic',
                'lessons.name as lesson_name', 'lessons.lesson_number', 'lessons.task as lesson_task')
            ->join('users', 'lesson_users.user_id', 'users.id')
            ->join('lessons', 'lesson_users.lesson_id', 'lessons.id')
            ->join('group_modules', 'group_modules.course_id', 'lessons.course_id')
            ->where('lessons.course_id', '=', $this->course_id)
            ->where('group_modules.group_id', '=', $this->group_id)
            ->where('group_modules.id', '=', $this->module_id)
            ->where('lesson_users.lesson_users_status_id', '=', 2)
            ->orderBy('users.surname')
            ->get();

//        ->leftJoin('course_users', function ($join) {
//            $join->on('course_users.course_id', '=', 'group_modules.course_id')
//                ->where('course_users.user_id', '=', 'lesson_users.user_id');
//        })
    }

    // Обновление компонента
    public function updateComponent() {
        // Базовый запрос
        $this->baseQuery();
    }

    // Рендер
    public function render()
    {
        // Базовый запрос
        $this->baseQuery();

        // Показ страницы
        return view('livewire.teacher-panel.group-show');
    }

    // Принятие
    public function accept($lesson_users_id) {

        // Запрос на принятие задания
        LessonUser::query()->where('id', '=', $lesson_users_id)->update(['lesson_users_status_id' => 3]);

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Задание успешно принято.']);

        // Обновление компонента
        $this->emit('updateComponent');
    }

    // Отклонение
    public function reject($lesson_users_id, $lesson_id, $user_id,  $index) {

        // Правила для валидации
        $values = [
            'lesson_users_id' => $lesson_users_id,
            'lesson_id' => $lesson_id,
            'user_id' => $user_id,
            'index' => $index,
            'text' => $this->comment,
        ];

        // Правила для валидации
        $rules = [
            'lesson_users_id' => 'required|numeric',
            'lesson_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'index' => 'required|numeric',
            'text' => 'required|string',
        ];

        // Валидация
        Validator::make($values, $rules);

        // Проверка
        if(!isset($this->comment[number_format($index)])) {
            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'error', 'text' => 'Для отклонения введите комментарий!']);

            // Возвращение значения
            return false;
        }

        // Обработка ошибок
        try {

            // Запуск транзакции
            DB::beginTransaction();

             // Создание комментария
            LessonComment::query()->create([
                'lesson_id' => $lesson_id,
                'teacher_id' => Auth::user()->id,
                'student_id' => $user_id,
                'text' => $this->comment[number_format($index)]
            ]);

            // Смена статуса
            LessonUser::query()->where('id', '=', $lesson_users_id)->update(['lesson_users_status_id' => 1]);

            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Задание успешно отклонено.']);

            // Сохранение
            DB::commit();
        } catch (\Exception $exception) {

            // Откат изменений при появлении ошибки
            DB::rollBack();

            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'error', 'text' => 'Не удалось отклонить задание!']);

            // Возвращение сообщения ошибки
            return $exception->getMessage();
        }

        // Обновление компонента
        $this->emit('updateComponent');
    }
}
