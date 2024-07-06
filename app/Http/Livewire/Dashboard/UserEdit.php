<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserEdit extends Component
{

    // Свойства
    public $user;
    public $name;
    public $surname;
    public $patronymic;
    public $email;
    public $password;
    public $role_id;

    // Правила
    protected $rules = [
    'name' => 'required|string|max:50',
    'surname' => 'required|string|max:50',
    'patronymic' => 'nullable|string|max:50',
    'password' => 'nullable|string',
    'role_id' => 'required|numeric',
    'email' => 'required|string|email|max:255',
    ];

    // Начальная установка
    public function mount()
    {
        $this->name = $this->user->name;
        $this->surname = $this->user->surname;
        $this->patronymic = $this->user->patronymic;
        $this->email = $this->user->email;
        $this->role_id = $this->user->role_id;
        $this->roles = UserRole::all();

    }

    // Обновление
    public function save() {

        // Валидация
        $validated = $this->validate();

        // Хэширование пароля
        if(isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        // Обновление
        User::query()->where('id', '=', $this->user->id)->update($validated);

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Пользователь успешно отредактирован.']);

    }

    // Рендер
    public function render()
    {
        return view('livewire.admin.user.editForm');
    }
}
