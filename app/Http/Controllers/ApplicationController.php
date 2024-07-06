<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Group;
use App\Models\User;

class ApplicationController extends Controller
{

    // Показ страница с заявками пользоватлея
    public function index()
    {
        return view('livewire.application.applications');
    }

    // Стнраница создания заявки (не работает!)
    public function create()
    {
        $users = User::all();
        $courses = Course::all();
        $groups = Group::all();
        return view('livewire.application.create', compact('users', 'courses', 'groups'));
    }
}
