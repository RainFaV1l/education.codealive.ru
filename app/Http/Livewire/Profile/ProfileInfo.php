<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProfileInfo extends Component
{

    // Свойства
    public $user;
    public $surname;
    public $name;
    public $patronymic;
    public $birthday_date;

    // Поля для валидации
    protected $rules = [
        'surname' => ['required', 'string',  'min:5', 'max:255', 'regex:/^[А-Яа-яёЁ\s-]+$/iu'],
        'name' => ['required', 'string',  'min:2', 'max:255', 'regex:/^[А-Яа-яёЁ\s-]+$/iu'],
        'patronymic' => ['nullable', 'string',  'min:5', 'max:255', 'regex:/^[А-Яа-яёЁ\s-]+$/iu'],
        'birthday_date' => ['required', 'date', 'max:255'],
    ];

    // Провенрка в реальном времени
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // Обновление данных
    public function update()
    {
        // Валидация
        $validated = $this->validate();

        // Обновление
        User::query()->where('id', '=', Auth::user()->id)->update($validated);

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Персональные данные успешно обновлены.']);
    }

    // Рендер вида
    public function render()
    {
        // Рендер вида
        return view('livewire.profile.profile-info');
    }

    // Начальная установка
    public function mount($user)
    {
        $this->surname = $user->surname;
        $this->name = $user->name;
        $this->patronymic = $user->patronymic;
        $this->birthday_date = $user->birthday_date;
    }
}
