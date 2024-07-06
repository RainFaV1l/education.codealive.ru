<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Lesson;
use Livewire\Component;

class LessonsShow extends Component
{
    // Свойства
    public $lessons;
    public $search;

    // События
    protected $listeners = [
        'refreshComponent' => 'getLessons',
    ];

    // Базовый запрос
    public function baseQuery() {
        // Запрос
        $this->lessons = Lesson::where('name', 'like', '%' . $this->search . '%')->get();
    }

    // Поиск уроков
    public function searchLessons()
    {
        // Базовый запрос
        $this->baseQuery();
    }

    // Получение уроков
    public function getLessons()
    {
        // Базовый запрос
        $this->baseQuery();
    }

    // Удаление урока
    public function destroy($id)
    {
        // Обработка ошибок
        try {
            // Удаление урока
            Lesson::find($id)->delete();

            // Обновление компонента
            $this->emit('refreshComponent');
            
            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Урок успешно удален.']);

        } catch (\Exception $e) {
          // Создание уведомления
          $this->dispatchBrowserEvent('notification', ['type' => 'error', 'text' => 'Не удалось удалить урок:' . $e]);
        }
    }

    // Рендер компонента
    public function render()
    {
        // Базовый запрос
        $this->baseQuery();

        // Показ вида
        return view('livewire.admin.dashboard.lessons-show');
    }
}
