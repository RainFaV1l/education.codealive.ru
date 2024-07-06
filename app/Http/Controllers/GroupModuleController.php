<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GroupModuleController extends Controller
{
    // Страница добавления модуля
    public function add() {
        return view('livewire.admin.module.add');
    }

    // Страница редактирования
    public function edit($module_id) {
        return view('livewire.admin.module.edit', compact('module_id'));
    }

    // Страница подробнее
    public function more($module_id) {
        return view('livewire.admin.module.more', compact('module_id'));
    }

    // Страница добавления урока
    public function addLesson($module_id) {
        return view('livewire.admin.module.addLesson', compact('module_id'));
    }
}
