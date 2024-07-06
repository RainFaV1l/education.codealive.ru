<?php

namespace App\Http\Livewire\Module;

use App\Models\Course;
use App\Models\Group;
use App\Models\GroupModule;
use Livewire\Component;

class ModuleStore extends Component
{
    // Свойства
    public $courses;
    public $groups;
    public $course_id;
    public $group_id;
    public $module_number;

    // Событие
    protected $rules = [
        'course_id' => ['required', ''],
        'group_id' => ['required', 'numeric'],
        'module_number' => ['required', 'numeric'],
    ];

    // Рендер компоненета
    public function render()
    {
        // Получение данных
        $this->courses = Course::all();
        $this->groups = Group::all();

        // Показ вида
        return view('livewire.admin.module.store');
    }

    // Обнуление полей
    public function clearInputs()
    {
        // Очистка полей
        $this->course_id = '';
        $this->group_id = '';
        $this->module_number = '';
    }

    // Создание модууля
    public function store()
    {
        // Валдиция
        $validated = $this->validate($this->rules);

        // Запрос на создание
        GroupModule::create($validated);

        // Обнуление полей
        $this->clearInputs();

        // Создание уведомления
        // session()->flash('success', 'Модуль успешно добавлен.');

        // Редирект
        // $this->emit('redirect', '/dashboard/modules');

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Модуль успешно добавлен.']);
    }
}
