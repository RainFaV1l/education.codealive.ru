<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class SearchForm extends Component
{
    // Название input
    public $name;

    // Кастомные ошибки input
    public $customError;

    // Текст формы поиска
    public $type;

    protected $allowedtypes = [
        'email',
        'text',
        'color',
        'date',
        'file',
        'number',
        'password',
        'radio',
        'search',
        'tel',
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $customError, $type)
    {
        // Инициализация
        $this->name = $name;
        $this->customError = $customError;

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

        // Показ вида
        return view('components.forms.input');
    }
}
