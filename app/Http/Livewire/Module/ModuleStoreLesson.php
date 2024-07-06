<?php

namespace App\Http\Livewire\Module;

use App\Models\Lesson;
use App\Models\LessonModule;
use App\Models\GroupModule;
use Livewire\Component;

class ModuleStoreLesson extends Component
{
    // Свойства
    public $lessons;
    public $lesson_id;
    public $module_id;

    // Правила
    protected $rules = [
        'lesson_id' => ['required', 'numeric'],
        'module_id' => ['required', 'numeric'],
    ];

    // Рендер компонента
    public function render()
    {
        // Получение GroupModule
        $course_id = GroupModule::find($this->module_id);

        // Получение уроков
        $this->lessons = Lesson::query()
            ->select('lessons.id', 'lessons.name')
            ->where('course_id', '=', $course_id->course_id)
            ->whereNotIn(
                'id',
                LessonModule::select('lesson_id')
                    ->where('module_id', '=', $this->module_id)
            )
            ->get();

        // Показание вида
        return view('livewire.admin.module.storeLesson');
    }

    // Сохранение
    public function store()
    {
        // Валидация
        $validated = $this->validate($this->rules);

        // Добавление урока в модуль
        LessonModule::create($validated);

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Урок успешно добавлен.']);

        // Редирект пользователя
        // return redirect()->to('/dashboard/modules/' . $this->module_id . '/more');
    }
}
