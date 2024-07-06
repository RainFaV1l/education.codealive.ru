<?php

namespace App\Http\Livewire\Module;

use App\Models\GroupModule;
use App\Models\Lesson;
use App\Models\LessonModule;
use App\Models\UserModule;
use App\Models\UserModulesStatus;
use Livewire\Component;

class ModuleShow extends Component
{
    // Свойства
    public $module_id;
    public $search_users;
    public $module_lessons;
    public $allUsers;
    public $group_modules;
    public $group_users;
    public $statuses;
    public $active;

    // События
    protected $listeners = ['getUsersComponent'];

    // Состояние уроки
    public function lessons()
    {
        $this->active = 'lessons';
    }

    // Состояние рользователи
    public function users()
    {
        $this->active = 'users';
    }

    // Базовый запрос
    public function moduleLessonsBaseQuery()
    {
        $this->module_lessons = LessonModule::query()
            ->select(
                'lesson_modules.id',
                'lesson_modules.module_id',
                'lessons.id as lesson_id',
                'lessons.name',
                'lessons.lesson_number',
                'lesson_modules.created_at',
                'lesson_modules.updated_at'
            )
            ->leftJoin('lessons', 'lesson_modules.lesson_id', '=', 'lessons.id')
            ->where('lesson_modules.module_id', '=', $this->module_id)
            ->get();
    }

    // Базовый запрос
    public function moduleUsersBaseQuery()
    {
        $this->group_modules = GroupModule::query()
            ->select(
                'group_modules.id',
                'group_modules.course_id',
                'group_modules.group_id',
                'group_modules.created_at',
                'group_modules.updated_at',
                'users.id as user_id',
                'users.surname',
                'users.name',
                'users.patronymic'
            )
            ->leftJoin('groups', 'group_modules.group_id', '=', 'groups.id')
            ->rightJoin('course_users', 'group_modules.group_id', '=', 'course_users.group_id')
            ->leftJoin('users', 'course_users.user_id', '=', 'users.id')
            ->leftJoin('courses', 'courses.id', '=', 'course_users.course_id')
            ->whereColumn('group_modules.course_id', '=', 'course_users.course_id') // Добавляем условие сравнения course_id
            ->where('group_modules.id', '=', $this->module_id)
            ->groupBy('users.id')
            ->get();
    }

    // Принятие
    public function accept($user_id, $index, $status_id)
    {

        // Проверка
        if ($status_id === []) return false;

        // Проверка
        $check = UserModule::query()
            ->where('student_id', '=', $user_id)
            ->where('module_id', '=', $this->module_id)
            ->get()->count();

        // Если пользователь в первый раз проходит данный модуль, то мы создаем привязку пользователя к модули, иначе обновляем
        if ($check === 0) {
            // Создание
            UserModule::query()->create([
                'module_id' => $this->module_id,
                'student_id' => $user_id,
                'status_id' => $status_id[$index]
            ]);

            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Пользователь успешно добавлен в модуль.']);
            
            // Возвращение значение
            return true;
        }

        // Обновление
        UserModule::query()
        ->where('student_id', '=', $user_id)
        ->where('module_id', '=', $this->module_id)
        ->update([
            'module_id' => $this->module_id,
            'student_id' => $user_id,
            'status_id' => $status_id[$index]
        ]);

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Пользователь успешно обновлен в модуле.']);

        return true;
    }

    // Удаление пользователя из модуля
    public function reject($user_id)
    {
        // Удаление привялки пользователя к модулю
        UserModule::query()->where('student_id', '=', $user_id)->delete();

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Пользователь успешно удален с модуля.']);
    }

    // Поиск
    public function searchModuleUsers($search)
    {
        // Удаление пробелов
        $search = trim($search);

        // Запрос поиска
        $this->group_modules = GroupModule::query()
            ->select(
                'group_modules.id',
                'group_modules.course_id',
                'group_modules.group_id',
                'group_modules.created_at',
                'group_modules.updated_at',
                'users.id as user_id',
                'users.surname',
                'users.name',
                'users.patronymic'
            )
            ->leftJoin('groups', 'group_modules.group_id', '=', 'groups.id')
            ->leftJoin('course_users', 'group_modules.group_id', '=', 'course_users.group_id')
            ->leftJoin('users', 'course_users.user_id', '=', 'users.id')
            ->where('group_modules.id', '=', $this->module_id)
            ->where('course_users.course_users_status_id', '=', 3)
            ->where('users.surname', 'LIKE', '%' . $search . '%')
            ->groupBy('users.id')
            ->get();
    }

    // Поиск
    public function searchModuleLessons($search)
    {
        // Удаление пробелов
        $search = trim($search);
        
        // Запрос поиска
        $this->module_lessons = Lesson::query()
            ->select(
                'lesson_modules.id',
                'lesson_modules.module_id',
                'lessons.id as lesson_id',
                'lessons.name',
                'lessons.lesson_number',
                'lesson_modules.created_at',
                'lesson_modules.updated_at'
            )
            ->leftJoin('lesson_modules', 'lesson_modules.lesson_id', '=', 'lessons.id')
            ->where('lesson_modules.module_id', '=', $this->module_id)
            ->where('lessons.name', 'LIKE', '%' . $search . '%')
            ->get();
    }

    // Удаление модуля
    public function destroy($module_lesson_id)
    {
        // Удаление
        LessonModule::destroy($module_lesson_id);

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Модуль успешно удален.']);
    }

    // Рендер компонента
    public function render()
    {
        // Получение данных
        $this->statuses = UserModulesStatus::all();
        $this->moduleLessonsBaseQuery();
        $this->moduleUsersBaseQuery();

        // Показ вида
        return view('livewire.admin.module.show');
    }
}
