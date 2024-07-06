<?php

namespace App\Http\Livewire\Profile;

use App\Http\Livewire\BaseComponent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileTel extends BaseComponent
{
    // Свойства
    public $user;
    public $tel;
    public $password;

    // Правила
    protected $rules = [
        'tel' => ['required', 'string', 'min:17', 'max:17', 'unique:users'],
    ];

    // Очистка полей
    public function clearInput()
    {
        $this->password = '';
    }

    // Обновление
    public function update()
    {
        // Валидация
        $validated = $this->validate();
        $this->validate(['password' => ['required']]);

        // Проверка
        $check = $this->profileService->checkUserPassword($this->password, auth()->user()->password);

        if (!$check) {
            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'error', 'text' => 'Неверный пароль!']);

            // Останавливаем выполнение функции
            return;
        }

        // Обновление телефона
        User::query()->where('id', '=', Auth::user()->id)->update($validated);

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Успешная смена телефона.']);

        // Очистка полей
        $this->clearInput();
    }

    // Начальная установка
    public function mount($user)
    {
        $this->tel = $user->tel;
    }


    // Рендер странциы
    public function render()
    {
        return view('livewire.profile.profile-tel');
    }
}
