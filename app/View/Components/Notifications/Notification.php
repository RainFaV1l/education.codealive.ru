<?php

namespace App\View\Components\Notifications;

use Illuminate\View\Component;

class Notification extends Component
{
    // Тип уведомления
    public $type;

    // Текст уведомления
    public $text;

    // Доступные типы
    protected $allowedtypes = [
        'success',
        'info',
        'error',
        'warning',
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $text)
    {
        // Инициализация
        $this->text = $text;

        // Проверка совпадает ли тип со списком из массива
        if (in_array($type, $this->allowedtypes)) {
            // Инициализация
            $this->type = $type;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notifications.notification');
    }
}
