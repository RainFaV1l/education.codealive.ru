<?php

namespace App\Http\Livewire\Admin\Group;

use App\Models\CourseUser;
use App\Services\Search\Service;
use Livewire\Component;

class GroupShow extends Component
{
    // Объявление свойст
    public $groupInfo;
    public $groupUsers;
    public $search;

    protected $service;

    // Объявление события для обноления списка пользователей группы после удаления пользователя из группы
    protected $listeners = [
        'refreshGroupUsers'
    ];

    // Объявление базового метода для одинкаовых базовых запросов
    public function baseQuery()
    {

        //        $query =  $this->groupUsers = User::query()
        //            ->select('course_users.id as course_users_id',
        //                'group_id',
        //                'users.id as user_id',
        //                'users.name',
        //                'users.surname',
        //                'users.patronymic',
        //                'users.email',
        //                'users.tel',
        //                'users.last_auth_date',
        //            )
        //            ->rightJoin('course_users', 'users.id', '=', 'course_users.user_id')
        //            ->where('group_id', '=', $this->groupInfo->id)
        //            ->where('course_users.course_users_status_id', '=', 3);
        //
        //        $fields = [ 'surname', 'name', 'patronymic' ];
        //
        //        $this->service->multipleSearch($query, $fields, $this->search);

        $this->groupUsers = CourseUser::query()
            ->select(
                'course_users.id as course_users_id',
                'group_id',
                'users.id as user_id',
                'users.pautina_id as pautina_id',
                'users.name',
                'users.surname',
                'users.patronymic',
                'users.email',
                'users.tel',
                'users.last_auth_date',
            )
            ->leftJoin('users', 'course_users.user_id', '=', 'users.id')
            ->where('group_id', '=', $this->groupInfo->id)
            ->where('course_users.course_users_status_id', '=', 3)
            ->where('users.surname', 'LIKE', '%' . trim($this->search) . '%')
            ->groupBy('user_id')
            ->orderBy('surname')
            ->get();
    }

    // Функция обноления
    public function refreshGroupUsers()
    {
        $this->baseQuery();
    }

    // Функция для поиска
    public function search()
    {
        $this->baseQuery();
    }

    // Service $service
    public function mount()
    {
        $this->baseQuery();
    }

    // Удаление группы
    public function delete($user_id)
    {

        // Удаление пользователя из группы
        CourseUser::query()->where('user_id', '=', $user_id)->where('group_id', '=', $this->groupInfo->id)->delete();

        // Обновление списка пользователей группы
        $this->emit('refreshGroupUsers');

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Группа успешно удалена.']);
    }

    // Рендер компонента
    public function render()
    {
        // Базовый запрос
        $this->baseQuery();

        // Показ вида
        return view('livewire.admin.group.group-show');
    }
}
