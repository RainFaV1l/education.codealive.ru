<?php

namespace App\Http\Controllers;

use App\Models\CourseUser;
use App\Models\Group;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use App\Http\Requests\Group\StoreRequest;
use App\Http\Requests\Group\UpdateRequest;
use App\Http\Requests\Group\DestroyRequest;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class GroupController extends Component
{

    // Страница добавления
    public function addView()
    {
        // Получение преподавателей
        $teachers = User::query()->where('role_id', '>', 1)->get();

        // Показ сстраницы
        return view('livewire.admin.group.addGroup', compact('teachers'));
    }

    // Страница редактирования
    public function editView($id)
    {
        // Получение преподавателей
        $teachers = User::query()->where('role_id', '=', 2)->get();

        // Получение группы
        $group = Group::findOrFail($id);

        // Показ сстраницы
        return view('livewire.admin.group.editGroup', compact('teachers', 'group'));
    }

    // Сохранение группы
    public function store(StoreRequest $request)
    {
        // Валидация
        $validated = $request->validated();

        // Создание группы
        Group::query()->create($validated);

        // Создание уведомления
        session()->flash('success', 'Группа успешно создана.');

        // Редирект пользователя
        return redirect(route('dashboard.groups'));
    }

    // Обновление группы
    public function update(UpdateRequest $request, $id)
    {
        // Валидация
        $validated = $request->validated();

        // Обновление группы
        Group::query()->where('id', '=', $id)->update($validated);

        // Создание уведомления
        session()->flash('success', 'Группа успешно обновлена.');

        // Редирект пользователя
        return redirect(route('dashboard.groups'));
    }

    // Удаление группы
    public function destroy(DestroyRequest $request)
    {
        // Валидация
        $validated = $request->validated();

        // Удаление группы
        Group::destroy($validated['group_id']);

        // Создание уведомления
        session()->flash('success', 'Группа успешно удалена.');

        // Редирект пользователя
        return redirect(route('dashboard.groups'));
    }

    // Подробности группы
    public function more($group_id)
    {
        // Получение информации о группе
        $groupInfo = Group::query()->find($group_id);

        // Показ сстраницы
        return view('livewire.admin.group.more', compact('groupInfo'));
    }

    // Подробности пользователей группы
    public function moreUser($group_id, $user_id)
    {
        // Получение информации о группе
        $group = Group::query()->find($group_id);

        // Показ сстраницы
        return view('livewire.admin.group.more-user', compact('user_id', 'group_id', 'group'));
    }
}
