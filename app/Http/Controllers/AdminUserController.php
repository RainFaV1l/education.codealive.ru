<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminUserController extends Controller
{

    // Страница редактирования
    public function edit($id)
    {
        // Получение пользователя
        $user = User::find($id);

        // Показание вида
        return view('livewire.admin.user.edit', compact(['user']));
    }

    // Удаление
    public function delete(User $user)
    {
        // Мягкое удаление пользователя
        $user = $user->delete();

        // Создание уведомления
        session()->flash('success', 'Пользователь успешно удален.'); 

        // Редирект пользователя
        return redirect()->route('dashboard.users');

    }
}
