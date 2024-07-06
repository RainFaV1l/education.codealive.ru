<?php

namespace App\Http\Livewire\Course;

use App\Models\CourseUser;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CourseSubscribe extends Component
{

    // Свойства
    public $course_id;

    // Отправка заявки
    public function subscribe()
    {
        // Базовая япроверка
        if (!isset(Auth::user()->id) && ($this->course_id === '' || is_null($this->course_id))) {
            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'error', 'text' => 'Не удалось отправить заявку!']);

            // Останавливаем выполнение метода
            return false;
        }

        // Проверка отправлял ли пользователь заявку
        $application = CourseUser::query()->where('user_id', '=', Auth::user()->id)->where('course_id', '=', $this->course_id)->count();

        // Если записи нет в базе данных, то происходит отправка заявки
        if ($application === 0) {
            // Создание заявки
            CourseUser::create([
                'user_id' => Auth::user()->id,
                'course_id' => $this->course_id,
            ]);

            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Заявка успешно отправлена.']);

            // Редирект на страницу заявок
            $this->emit('redirect', '/applications');

            // Успешнре завершение
            return true;
        }

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'error', 'text' => 'Не удалось отправить заявку!']);
    }

    // Рендер страницы
    public function render()
    {
        // Показ вида
        return view('livewire.course.course-subscribe');
    }
}
