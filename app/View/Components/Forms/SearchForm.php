<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class SearchForm extends Component
{
    // Название функции
    public $funcName;

    // Текст формы поиска
    public $text;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($funcName, $text)
    {

        // Инициализация
        $this->text = $text;

        // Инициализация
        $this->funcName = $funcName;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        // Показ вида
        return view('components.forms.search-form');

    }
}
