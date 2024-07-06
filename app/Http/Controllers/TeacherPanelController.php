<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherPanelController extends Controller
{
    // Получение курсов
    public function courses() {
        return view('livewire.teacher-panel.courses');
    }

    // Получение групп
    public function groups($course_id) {
        return view('livewire.teacher-panel.groups', compact('course_id'));
    }

    // Получение группы
    public function group($course_id, $group_id, $module_id) {
        return view('livewire.teacher-panel.group', compact('course_id','group_id', 'module_id'));
    }
}
