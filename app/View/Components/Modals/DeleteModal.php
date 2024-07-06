<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;

class DeleteModal extends Component
{
    // Название input
    public $name;

    // Название функции
    public $funcName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $funcName)
    {
        // Инициализация
        $this->name = $name;
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
        return view('components.modals.delete-modal');
    }
}
