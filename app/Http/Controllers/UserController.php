<?php


namespace App\Http\Controllers;

use App\Http\Requests\Profile\ChangeAvatarRequest;
use App\Http\Requests\Profile\changeEmailRequest;
use App\Http\Requests\Profile\ChangePasswordRequest;
use App\Http\Requests\Profile\changePersonalInfoRequest;
use App\Http\Requests\Profile\ChangeTelRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{

    // Метод для показа профиля пользователя
    public function index()
    {
        // Получение пользователя
        $user = User::getInfo(Auth::id());

        // Показ вида
        return view('livewire.profile.profile', compact('user'));
    }

    // Метод для смена аватарки полльзователя
    public function changeAvatar(ChangeAvatarRequest $request)
    {
        // Валидация данных
        $validated = $request->validated();

        // Смена аватарки
        $this->profile->changeAvatar($request, $validated);

        // Редирект пользователя
        return redirect()->route('profile.index');
    }

    // Метод для смены персональной информации пользователя
    public function changePersonalInfo(changePersonalInfoRequest $request)
    {
        // Валидация данных
        $validated = $request->validated();

        // Смена персональной информации пользователя
        $this->profile->changePersonalInfo($validated);

        // Редирект пользователя
        return redirect()->route('profile.index');
    }

    // Метод для смены почты пользователя
    public function changeEmail(changeEmailRequest $request)
    {
        // Валидация данных
        $validated = $request->validated();

        // Смена почты пользователя
        $this->profile->changeEmail($validated);

        // Редирект пользователя
        return redirect(route('profile.index'));
    }

    // Метод для смены телефона пользователя
    public function changeTel(ChangeTelRequest $request)
    {
        // Валидация данных
        $validated = $request->validated();


        // Смена телефона пользователя
        $this->profile->changeTel($request, $validated);

        // Редирект пользователя
        return redirect(route('profile.index'));
    }

    // Метод для смены пароля пользователя
    public function changePassword(ChangePasswordRequest $request)
    {
        // Валидация данных
        $validated = $request->validated();

        // Смены пароля пользователя
        $this->profile->changePassword($request, $validated);

        // Редирект пользователя
        return redirect(route('profile.index'));
    }
}
