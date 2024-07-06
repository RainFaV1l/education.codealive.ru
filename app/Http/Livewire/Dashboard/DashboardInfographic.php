<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Course;
use App\Models\Group;
use App\Models\User;
use App\Models\CourseUser;
use App\Models\LessonUser;
use Livewire\Component;

class DashboardInfographic extends Component
{
    public $userCount;
    public $courseCount;
    public $groupCount;
    public $applicationsCount;
    public $checkingAssignmentsCount;

    public function render()
    {
        $this->userCount = User::all()->count();
        $this->courseCount = Course::all()->count();
        $this->groupCount = Group::all()->count();
        $this->applicationsCount = CourseUser::query()->where('course_users_status_id', '=', 2)->count();
        $this->checkingAssignmentsCount = LessonUser::query()->where('lesson_users_status_id', '=', 2)->count();
        return view('livewire.admin.dashboard.dashboard-infographic');
    }
}
