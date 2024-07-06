<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class UserShow extends Component
{
    // Свойства
    public $users;
    public $search;

    // Переключатель
    public $getAllUsers = true;
    public $getNewUsers = false;
    public $getNoCourseUsers = false;

    // Очистка
    public function clear() {
        $this->getAllUsers = false;
        $this->getNewUsers = false;
        $this->getNoCourseUsers = false;
    }

    // Получение всех пользователей
    public function getAllUsers()
    {
        $this->clear();
        $this->getAllUsers = true;
    }

    // Получение пользователей без курса
    public function getNoCourseUsers()
    {
        $this->clear();
        $this->getNoCourseUsers = true;
    }

    // Базовый запрос
    public function getNewUsers()
    {
        $this->clear();
        $this->getNewUsers = true;
    }

    // Базовый запрос
    public function basicQuery() {
        return $this->users = User::query()
        ->select('users.id', 'surname', 'name', 'patronymic', 'email', 'role_id', 'created_at')
        ->where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('surname', 'like', '%' . $this->search . '%')
            ->orWhere('patronymic', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')->get();
        })
        ->get();
    }

    // Пользователи
    public function searchUsers()
    {
        $this->basicQuery();
    }

    // Все пользователи
    public function getAllUsersQuery()
    {
        $this->basicQuery();
    }

    // Новые пользователи
    public function getNewUsersQuery()
    {
       $this->users = $this->basicQuery()->sortByDesc('created_at');
    }

    // Без курса
    public function getNoCourseUsersQuery()
    {
        $this->users = User::query()->select('users.id', 'surname', 'name', 'patronymic', 'email', 'group_id', 'role_id')
        ->leftJoin('course_users', 'users.id', '=', 'course_users.user_id')
        ->whereNull('course_users.user_id')
        ->where(function ($query) {
            $query->where('surname', 'like', '%' . $this->search . '%')
            ->orWhere('patronymic', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')->get();
        })
        ->get();
    }

    // Рендер
    public function render()
    {
        if($this->getAllUsers === true) {
            $this->getAllUsersQuery();
        }
        else if($this->getNewUsers === true) {
            $this->getNewUsersQuery();
        }
        else if($this->getNoCourseUsers === true) {
            // SELECT * FROM `users` LEFT OUTER JOIN `course_users` ON users.id = course_users.user_id WHERE course_users.user_id IS NULL;
            $this->getNoCourseUsersQuery();
        }
        return view('livewire.admin.user.userShow');
    }
}
