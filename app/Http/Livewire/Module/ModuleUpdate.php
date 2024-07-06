<?php

namespace App\Http\Livewire\Module;

use App\Models\Course;
use App\Models\Group;
use App\Models\GroupModule;
use Livewire\Component;

class ModuleUpdate extends Component
{
    // Свойства
    public $courses;
    public $groups;
    public $module;
    public $module_id;
    public $course_id;
    public $group_id;
    public $module_number;
    public $course_name;
    public $group_name;

    // Событие
    protected $listener = [
        'refreshModules' => 'getModules',
    ];

    // Правила
    protected $rules = [
        'course_id' => ['required', 'numeric'],
        'group_id' => ['required', 'numeric'],
        'module_number' => ['required', 'numeric'],
    ];

    // Обновление компонента
    public function getModules()
    {
        // Начальная установка
        $this->module = GroupModule::find($this->module_id);
        $this->module_number = $this->module->module_number;
        $this->course_id = $this->module->course_id;
        $this->group_id = $this->module->group_id;
        $this->render();
    }

    // Изменение статуса и получение данных
    public function changeCourseEvent($value)
    {
        // id курса
        $this->course_id = $value;

        // Название курса
        $this->course_name = Course::find($this->course_id)->name;
    }

    // Изменение статуса и получение данных
    public function changeGroupEvent($value)
    {
        // id группы
        $this->group_id = $value;

        // Название группы
        $this->group_name = Group::find($this->group_id)->name;
    }

    // Рендер компоненета
    public function render()
    {
        // Показ шаблона
        return view('livewire.admin.module.update');
    }

    // Начальная устанвока
    public function mount()
    {
        // Присваивание данных
        $this->courses = Course::all();
        $this->groups = Group::all();
        $this->module = GroupModule::find($this->module_id);
        $this->module_number = $this->module->module_number;
        $this->course_id = $this->module->course_id;
        $this->group_id = $this->module->group_id;
        $this->course_name = $this->module->course->name;
        $this->group_name = $this->module->group->name;
    }

    // Обновление модуля
    public function update()
    {
        // Валидация
        $validated = $this->validate($this->rules);

        // Запрос на обновление
        GroupModule::query()->where('id', '=', $this->module_id)->update($validated);

        // Обновление компонента
        $this->emit('refreshModules');

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Модуль успешно обновлен.']);
    }
}
