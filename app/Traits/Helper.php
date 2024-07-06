<?php

namespace App\Traits;

use App\Models\LessonModule;
use App\Models\UserModule;

trait Helper
{
    // Определяем пройден ли модуль
    function isPassedModule(int $module_id) : bool
    {
        // Получение количества всех уроков модуля
        $allCourseModuleLessonsCount = LessonModule::query()->where('lesson_modules.module_id', '=', $module_id)->count();

        // Получение списка пользователей модуля
        $moduleUsers = UserModule::query()->select('student_id')
            ->where('user_modules.module_id', '=', $module_id)
            ->get();

        // Количество пользователей модуля
        $moduleUsersCount = $moduleUsers->count();

        // Инициализация счетчика
        $counter = 0;

        // Перебор пользователей модуля
        foreach ($moduleUsers as $user) {

            // Получение количества пройденных уроков пользователя модуля
            $getFinishLessonsCount = LessonModule::query()
                ->select('id')
                ->join('lesson_users', 'lesson_modules.lesson_id', 'lesson_users.lesson_id')
                ->where('lesson_modules.module_id', '=', $module_id)
                ->where('lesson_users.user_id', '=', $user->student_id)
                ->where('lesson_users.lesson_users_status_id', '=', 3)
                ->count();

            // Если пользователь прошел все уроки модуля, то увеличиваем счетчик
            if($getFinishLessonsCount === $allCourseModuleLessonsCount) $counter++;

        }

        // Если все пользователи прошли все уроки модуля, то возвращаем true
        if($moduleUsersCount === $counter) return true;

        // Иначе false
        return false;
    }
}