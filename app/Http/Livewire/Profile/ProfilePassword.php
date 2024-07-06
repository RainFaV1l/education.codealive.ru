<?php

namespace App\Http\Livewire\Profile;

use App\Http\Livewire\BaseComponent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilePassword extends BaseComponent
{

    // Свойства
    public $user;
    public $current_password;
    public $password;
    public $password_confirmation;

    // Правило для проверки
    protected $rules = [
        'password' => ['required', 'string', 'min:6', 'same:password_confirmation'],
        'current_password' => ['required', 'string', 'min:6',],
        'password_confirmation' => ['required'],
    ];

    // Очищение input
    public function clearInput()
    {
        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';
    }

    // Обновление
    public function update()
    {
        // Валидация
        $validated = $this->validate($this->rules);

        // Вызов функции для обновления пароля
        $check = $this->profileService->changePasswordFunc($validated, auth()->user()->password);

        // Проверка смены пароля
        if ($check) {
            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Успешная смена пароля.']);

            // Очистка полей
            $this->clearInput();

            return;
        }

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'error', 'text' => 'Неверный пароль!']);
    }

    // Рендер
    public function render()
    {
        return view('livewire.profile.profile-password');
    }
}
