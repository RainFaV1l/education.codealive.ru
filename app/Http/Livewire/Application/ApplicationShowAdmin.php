<?php

namespace App\Http\Livewire\Application;

use App\Models\CourseUser;
use App\Models\Group;
use App\Models\GroupModule;
use App\Models\UserModule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ApplicationShowAdmin extends Component
{
    // Свойства
    public $applications;
    public $groups;
    public $group_id;
    public $search;

    // Правила
    protected $rules = [
        'name' => ['required', 'string'],
        'price' => ['required', 'numeric', 'max:1000000'],
        'author' => ['required', 'numeric'],
        'course_category_id' => ['required', 'numeric'],
        'course_level_id' => ['required', 'numeric'],
        'description' => ['required', 'string'],
    ];

    // События
    protected $listeners = [
        'refreshComponent' => 'getApplications',
        'refreshGroups' => 'getGroups'
    ];

    // Базовый запрос
    public function baseApplicationQuery() {
        // Получение заявок
        return $this->applications = CourseUser::query()->whereHas('user', function (Builder $query) {
            $query->where('name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('surname', 'LIKE', '%' . $this->search . '%')
                ->orWhere('patronymic', 'LIKE', '%' . $this->search . '%');
        })->orderByDesc('created_at')->get();
    }

    
    // Обновление заявок
    public function getApplications() {
        // Базовый запрос
        $this->baseApplicationQuery();
    }

    // Обновление групп
    public function getGroups() {
        // Получение всех групп
        $this->groups = Group::all();
    }

    // Поиск по заявкам
    public function searchApplications()
    {
        // Базовый запрос
        $this->baseApplicationQuery();
    }

    // Начальная установка
    public function mount() {
        // Базовый поиск
        $this->baseApplicationQuery();

        // Получение всех групп
        $this->groups = Group::all();
    }

    // Рендер компонента
    public function render()
    {
        // Показ вида
        return view('livewire.application.applicationShowAdmin');
    }

    // Приянтие
    public function accept(CourseUser $application, $index) {
        // Проверка
        if(!$this->group_id) return false;

        // Получения значения из массива
        $this->group_id = $this->group_id[$index];

        // Обновление статуса
        $application->update(['course_users_status_id' => 3, 'group_id' => $this->group_id]);

        // Полчение модулей групп
        $group_modules = GroupModule::query()->select('user_modules.id')
            ->join('user_modules', 'group_modules.id', '=', 'user_modules.module_id')
            ->where('group_modules.group_id', '=', $this->group_id)
            ->where('user_modules.student_id', '=', $application->user_id)
            ->get();

        // Если модули есть,
        if(isset($group_modules)) {
            // То перебираем их,
            foreach ($group_modules as $group_module) {
                // И удаляем.
                UserModule::query()->where('id', '=', $group_module->id)->delete();
            }
        }

        // Обновление компонента
        $this->emit('refreshComponent');
        $this->emit('refreshGroups');

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Заявка успешно принята.']);
    }

    // Отклонение
    public function reject(CourseUser $application) {
        // Обновление статуса
        $application->update([
            'course_users_status_id' => 1,
            'group_id' => null
        ]);

        // Обновление компонента
        $this->emit('refreshComponent');
        $this->emit('refreshGroups');

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Заявка успешно отклонена.']);
    }
}
