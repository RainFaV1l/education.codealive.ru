<?php

namespace App\Http\Livewire\Application;

use App\Models\CourseUser;
use Livewire\Component;

class ApplicationShow extends Component
{

    // Свойства
    public $applications;

    // События
    protected $listeners = ['resetApplications'];

    // Базлвый запрос
    public function baseQuery()
    {
        return CourseUser::query()->where('user_id', '=', auth()->user()->id);
    }

    // Метод события
    public function resetApplications()
    {
        $this->applications = $this->baseQuery()->get();
    }

    // Получение всех заявок
    public function all()
    {
        $this->applications = $this->baseQuery()->get();
    }

    // Получение активных заявок
    public function inProcessing()
    {
        $this->applications = $this->baseQuery()->where('course_users_status_id', '=', 2)->get();
    }

    // Получение принятых заявок
    public function accepted()
    {
        $this->applications = $this->baseQuery()->where('course_users_status_id', '=', 3)->get();
    }

    // Отмена заявки
    public function unsubscribe(CourseUser $application)
    {
        // Проверка
        if ($application->course_users_status_id !== 2) {
            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'error', 'text' => 'Не удалось отклонить заявку!']);

            // Возвращаем false 
            return false;
        }

        // Отмена заявки
        $application->delete();

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Заявка успешно отменена.']);

        // Обновление компонента
        $this->emit('resetApplications');
    }

    // Начальная установка
    public function mount()
    {
        // Получение всех заявок
        $this->applications = $this->baseQuery()->get();
    }

    // Рендеринг компонента
    public function render()
    {
        // Показ вида
        return view('livewire.application.applicationsShow');
    }
}
