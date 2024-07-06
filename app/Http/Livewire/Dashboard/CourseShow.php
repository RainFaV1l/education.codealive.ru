<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class CourseShow extends Component
{

    // Свойства
    public $courses;
    public $search;

    // События
    protected $listeners = [
        'refreshComponent' => 'getCourses',
    ];

    // Базовый запрос
    public function baseQuery()
    {
        $this->courses = Course::where('name', 'like', '%' . $this->search . '%')->get();
    }


    // Поиск по курсам
    public function searchCourses()
    {
        $this->baseQuery();
    }


    // Получение курсов
    public function getCourses()
    {
        $this->courses = Course::all();
    }


    // Удаление курса
    public function destroy($id)
    {
        try {
            // Удаление курса
            Course::find($id)->delete();

            // Обновление компонента
            $this->emit('refreshComponent');

            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Курс успешно удален.']);
        } catch (\Exception $e) {
            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'error', 'text' => 'Не удалось удалить курс:' . $e]);
        }
    }


    // Рендер
    public function render()
    {
        // Базовый запрос
        $this->baseQuery();

        // Рендеринг вида
        return view('livewire.admin.dashboard.course-show');
    }
}
