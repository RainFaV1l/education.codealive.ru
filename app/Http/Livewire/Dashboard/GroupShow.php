<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class GroupShow extends Component
{
    // Свойства
    public $groups;
    public $search;

    // Базовый запрос поиска
    public function baseQuery() {
        $this->groups = Group::where('name', 'like', '%' . $this->search . '%')->get();
    }

    // Поиск по названию
    public function searchGroups() {
        // Базовый запрос поиска
        $this->baseQuery();
    }

    // Начальная установка
    public function mount()
    {
        $this->groups = Group::all();
    }

    // Рендеринг компонеента
    public function render()
    {
        // Базовый запрос поиска
        $this->baseQuery();
        
        // Показ вида
        return view('livewire.admin.dashboard.group-show');
    }
}
