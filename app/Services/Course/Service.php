<?php

namespace App\Services\Course;

use App\Models\Certificate;
use App\Models\CourseUser;
use App\Models\GroupModule;
use App\Models\Lesson;
use App\Models\LessonModule;
use App\Models\LessonUser;
use App\Models\Review;
use App\Models\UserModule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class Service
{

    // Сервисы для контроллера - СourseController

    // Функция проверки на то, закончил ли пользователь курс

    // Общий запрос на проверку сертификата
    public function baseCheckCertificateQuery($course_id, $user_id)
    {

        // Формируем запрос для проверки
        $check = Certificate::query()
            ->where('course_id', '=', $course_id)
            ->where('user_id', '=', $user_id)
            ->get();

        return $check;
    }

    // Метод на то, есть ли пользователь в таблице сертификатов
    public function checkCertificateQuery($course_id, $user_id)
    {

        // Формируем запрос для проверки
        $check = $this->baseCheckCertificateQuery($course_id, $user_id);

        // Проверка есть ли такая запись
        if ($check->count() === 1) {
            // Возврщаение true
            return true;
        }

        // Возвращение значения
        return false;
    }

    // Метод на то, прошел ли пользователь данный курс в первый раз
    public function checkIsPassedCertificateQuery($course_id, $user_id)
    {

        // Формируем запрос для проверки
        $check = $this->baseCheckCertificateQuery($course_id, $user_id);

        // Проверка есть ли запись
        if ($check->count() === 0) {

            // Возвращение false
            return false;

        }

        // Получаем первый элемент
        $check = $check[0];

        // Проверяем истинно ли значение из бд
        if (!$check->isPassed) {

            // Возвращение true
            return true;

        }

        // Возвращение значения
        return 'passed';

    }

    // Функция для проверки существование отзыва в таблице
    public function isIsset($course_id, $user_id)
    {

        // Запрос в базу
        $query = Review::query()
            ->where('course_id', '=', $course_id)
            ->where('user_id', '=', $user_id)
            ->get();

        // Определяем true или false
        $result = $query->count() === 0 ? true : false;

        // Возвращаем результат
        return $result;
    }

    // Функция для отправки отзыва
    public function reviewStore($validated)
    {

        // Объявление свойства
        $result = false;

        // Запрос проверки
        $check = $this->isIsset($validated['course_id'], $validated['user_id']);

        // Проверка
        if ($check) {

            // Обработка ошибок
            try {

                // Запуск транзакции
                DB::beginTransaction();

                // Запись в базу данных
                $result = Review::query()->create($validated);

                // Сохранение
                DB::commit();

            } catch (\Exception $exception) {

                // Откат изменений при появлении ошибки
                DB::rollBack();

                // Возвращение сообщения ошибки
                return $exception->getMessage();
            }
        }

        // Если результат false, то возвращаем false
        if (!$result) {
            return false;
        }

        // Иначе true
        return true;
    }

    // Базовый запрос для создания pdf
    public function pdfBaseQuery($course_id, $user_id)
    {

        // Запрос
        $data = Certificate::query()
            ->select(
                'certificates.id',
                'certificates.created_at',
                'users.name',
                'users.surname',
                'users.patronymic',
                'courses.name as course_name'
            )
            ->leftJoin('users', 'certificates.user_id', '=', 'users.id')
            ->leftJoin('courses', 'certificates.course_id', '=', 'courses.id')
            ->where('certificates.course_id', '=', $course_id)
            ->where('certificates.user_id', '=', $user_id)
            ->get()[0];

        // Возращение значения
        return $data;
    }

    // Метод для генерации pdf
    public function pdfGenerate($data)
    {

        // Генерация
        $pdf = PDF::loadView('livewire.certificate.certificate', compact('data'))
            ->setOption(['dpi' => 300, 'defaultFont' => 'sans-serif'])
            ->setPaper('a4', 'landscape')
            ->setWarnings(false);

        // Возращение значения
        return $pdf;
    }

    // Метод для формирования базового запроса more
    public function moreCourseModulesQuery($course_id, $user_id, $status)
    {
        // Запрос
        $data = CourseUser::query()
            ->select(
                'course_users.user_id',
                'course_users.group_id',
                'group_modules.module_number',
                'group_modules.id as module_id',
                'user_modules.status_id'
            )
            ->leftJoin('group_modules', 'course_users.group_id', '=', 'group_modules.group_id')
            ->leftJoin('user_modules', 'group_modules.id', '=', 'user_modules.module_id')
            ->where('course_users.course_users_status_id', '=', $status)
            ->where('course_users.user_id', '=', $user_id)
            ->where('user_modules.student_id', '=', $user_id)
            ->where('group_modules.course_id', '=', $course_id)
            ->where('course_users.course_id', '=', $course_id)
            ->orderBy('group_modules.id')->get();

        // Возращение значения
        return $data;
    }

    // Метод для проверки статуса урока
    public function lessonStatusCheck($lesson_id, $user_id, $status)
    {
        // Запрос
        $lessonStatusCheck = \App\Models\LessonUser::query()
            ->where('lesson_id', '=', $lesson_id)
            ->where('user_id', '=', $user_id)
            ->where('lesson_users_status_id', '=', $status)
            ->get();

        // Возвращение ответа
        return $lessonStatusCheck;
    }


    // Метод для получения недоступных модулей
    public function moreDisabledModulesQuery($course_id, $course, $course_modules)
    {

        // Запрос
        $data = GroupModule::query()
            ->where('course_id', '=', $course_id)
            ->orderBy('module_number')->get();

        // Возращение значения
        return $data;
    }

    // Метод получения всех уроков
    public function allLessonsQuery($course_module)
    {

        // Запрос
        $lessons = LessonModule::query()->where('module_id', '=', $course_module->module_id)->get();

        // Возращение значения
        return $lessons;
    }

    // Метод для запроса на получение всех уроков
    public function calculateAllLessons($course_module, $allLessonsCount)
    {

        // Запрос
        $lessons = $this->allLessonsQuery($course_module);

        // Подсчёт общего количества уроков
        $allLessonsCount = $allLessonsCount + $lessons->count();

        // Возращение значения
        return $allLessonsCount;
    }

    // Метод получения пройденных уроков
    public function learnedLessonsQuery($course_module)
    {

        // Запрос
        $learnedLessons = LessonUser::query()
            ->leftJoin('lesson_modules', 'lesson_modules.lesson_id', '=', 'lesson_users.lesson_id')
            ->where('lesson_users.user_id', '=', Auth::user()->id)
            ->where('lesson_users.lesson_users_status_id', '=', 3)
            ->where('lesson_modules.module_id', '=', $course_module->module_id)
            ->get();

        // Возращение значения
        return $learnedLessons;
    }

    // Метод для запроса на получение всех пройденных уроков
    public function calculateLearnedLessons($course_module, $learnedLessonsCount)
    {

        // Запрос на получение всех пройденных уроков
        $learnedLessons = $this->learnedLessonsQuery($course_module);

        // Подсчёт общего количества
        $learnedLessonsCount = $learnedLessonsCount + $learnedLessons->count();

        // Возращение значения
        return $learnedLessonsCount;
    }

    // Метод получения пройденных уроков модуля
    public function learnedModuleLessonsQuery($course_module)
    {

        // Запрос
        $moduleLearnedLessons = LessonModule::query()
            ->join('lesson_users', 'lesson_modules.lesson_id', '=', 'lesson_users.lesson_id')
            ->where('lesson_modules.module_id', '=', $course_module->module_id)
            ->where('lesson_users.lesson_users_status_id', '=', 3)->get();

        // Возращение значения
        return $moduleLearnedLessons;
    }

    // Метод для запроса на получение всех уроков модуля
    public function calculateAllModuleLessons($course_module)
    {

        // Запрос на получение всех пройденных уроков
        $moduleLearnedLessons = $this->learnedModuleLessonsQuery($course_module);

        // Подсчёт общего количества
        $moduleLearnedLessonsCount = $moduleLearnedLessons->count();

        // Возращение значения
        return $moduleLearnedLessonsCount;
    }

    // Метод получения всех уроков модуля
    public function moduleLessonsQuery($course_module)
    {

        // Запрос на получение всех уроков модуля
        $moduleLessons = LessonModule::query()->where('lesson_modules.module_id', '=', $course_module->module_id)->get();

        // Возращение значения
        return $moduleLessons;
    }

    // Метод для запроса на получение пройденных уроков модуля
    public function calculateLearnedModuleLessons($course_module)
    {

        // Запрос на получение всех пройденных уроков
        $moduleLessons = $this->moduleLessonsQuery($course_module);

        // Подсчёт общего количества
        $moduleLessonsCount = $moduleLessons->count();

        // Возращение значения
        return $moduleLessons;
    }

    // Вычисление общего количества уроков курса
    public function getAllCourseLessonsCount($course_id)
    {

        // Объявление переменной
        $allLessonsCount = 0;

        // Запрос
        $lessons = Lesson::query()->where('course_id', '=', $course_id);

        // Вычисление количества
        $allLessonsCount = $lessons->count();

        // Возвращение значения
        return $allLessonsCount;

    }

    // Метод для вычисления количества пройденных модулей и уроков
    public function getLearnedModulesCountMoreController($course_modules)
    {

        // Объявление переменной
        $learnedModuleCount = 0;
        $allLessonsCount = 0;
        $learnedLessonsCount = 0;

        // Перебор значений
        foreach ($course_modules as $course_module) {

            // Запрос на получение всех уроков
            $allLessonsCount = $this->calculateAllLessons($course_module, $allLessonsCount);

            // Запрос на получение пройденных уроков
            $learnedLessonsCount = $this->calculateAllLessons($course_module, $learnedLessonsCount);

            // Запрос на получение всех уроков модуля
            $moduleLessonsCount = $this->calculateLearnedModuleLessons($course_module);

            // Запрос на получение пройденных уроков модуля
            $moduleLearnedLessonsCount = $this->calculateLearnedModuleLessons($course_module);


            // Проверка на пройден ли модуль
            if ($moduleLessonsCount === $moduleLearnedLessonsCount) {

                // Подсчет всех пройденных курсов модули
                $learnedModuleCount = $learnedModuleCount + 1;
            }
        }

        // Возвращение значения
        return [
            'learnedModuleCount' => $learnedModuleCount,
            'allLessonsCount' => $allLessonsCount,
            'learnedLessonsCount' => $learnedLessonsCount,
        ];
    }


    // Сервисы для компонентов Livewire - OneCourseLearnShow

    // Получение id доступных пользователю модулей
    public function setOpenModuleId($course_modules)
    {

        // Объявление переменной
        $open_module_id = [];

        // Перебор значений
        foreach ($course_modules as $course_module) :

            // Добавление значений в переменную
            $open_module_id[] = $course_module->module_id;

        endforeach;

        // Возращение значения
        return $open_module_id;
    }

    // Получение недоступных пользователю модулей
    public function setDisabledModules($course_id, $open_module_id)
    {

        // Запрос
        $show_disabled_modules = GroupModule::query()
            ->where('course_id', '=', $course_id)
            ->whereNotIn('group_modules.id', $open_module_id)
            ->orderBy('module_number')
            ->get();

        // Возращение значения
        return $show_disabled_modules;
    }

    // Метод для получения количества пройденных уроков модуля
    public function getLearnedModulesCount($group_modules)
    {

        $learnedModuleCount = 0;

        foreach ($group_modules as $group_module) {

            $allLessonsCount = 0;
            $learnedLessonsCount = 0;

            $allLessons = LessonModule::query()->where('lesson_modules.module_id', '=', $group_module->module_id)->get();
            $learnedLessons = LessonUser::query()
                ->select(
                    'lesson_users.lesson_id',
                    'lesson_users.user_id',
                    'lesson_modules.module_id',
                    'lesson_users.lesson_users_status_id',
                    'lesson_users.task',
                    'group_modules.course_id'
                )
                ->join('lesson_modules', 'lesson_users.lesson_id', '=', 'lesson_modules.lesson_id')
                ->join('group_modules', 'lesson_modules.module_id', '=', 'group_modules.id')
                ->where('lesson_modules.module_id', '=', $group_module->module_id)
                ->where('lesson_users.lesson_users_status_id', '=', 3)
                ->where('group_modules.course_id', '=', $group_module->course_id)
                ->groupBy('lesson_users.lesson_id')
                ->get();

            $allLessonsCount = $allLessonsCount + $allLessons->count();
            $learnedLessonsCount = $learnedLessonsCount + $learnedLessons->count();

            if ($allLessonsCount === $learnedLessonsCount and $allLessonsCount !== 0 and $learnedLessonsCount !== 0) {
                $learnedModuleCount = $learnedModuleCount + 1;
            }
        }

        return $learnedModuleCount;
    }

    // Метод возвращающий количество пройденных и общее количество уроков курса
    public function getLearnedAndAllCorseLessons($course_id, $user_id)
    {

        // Получение общего количества уроков
        $allLessons = Lesson::query()->where('course_id', '=', $course_id)->get();

        // Получение количества пройденных уроков
        $allLearnedLessons = LessonUser::query()
            ->leftJoin('lessons', 'lessons.id', '=', 'lesson_users.lesson_id')
            ->where('lessons.course_id', '=', $course_id)
            ->where('lesson_users.lesson_users_status_id', '=', 3)
            ->where('lesson_users.user_id', '=', $user_id)
            ->get();

        if ($allLessons->count() === 0) {
            $allLessonsCount = 0;
        } else {
            $allLessonsCount = $allLessons->count();
        }

        if ($allLearnedLessons->count() === 0) {
            $allLearnedLessonsCount = 0;
        } else {
            $allLearnedLessonsCount = $allLearnedLessons->count();
        }

        return [
            'allLessonsCount' => $allLessonsCount,
            'allLearnedLessonsCount' => $allLearnedLessonsCount,
        ];
    }

    // Получение id пройденных модулей курса
    public function completedModulesOperations($group_modules)
    {

        $completedModulesId = [];

        foreach ($group_modules as $group_module) {

            $allLessonsCount = 0;
            $learnedLessonsCount = 0;

            $allLessons = LessonModule::query()->where('lesson_modules.module_id', '=', $group_module['module_id'])->get();

            $learnedLessons = LessonUser::query()
                ->select(
                    'lesson_users.lesson_id',
                    'lesson_users.user_id',
                    'lesson_modules.module_id',
                    'lesson_users.lesson_users_status_id',
                    'lesson_users.task',
                    'group_modules.course_id'
                )
                ->leftJoin('lesson_modules', 'lesson_users.lesson_id', '=', 'lesson_modules.lesson_id')
                ->leftJoin('group_modules', 'lesson_modules.module_id', '=', 'group_modules.id')
                ->where('lesson_modules.module_id', '=', $group_module['module_id'])
                ->where('lesson_users.lesson_users_status_id', '=', 3)
                ->where('group_modules.course_id', '=', $group_module['course_id'])
                ->get();

            $allLessonsCount = $allLessonsCount + $allLessons->count();
            $learnedLessonsCount = $learnedLessonsCount + $learnedLessons->count();

            if ($allLessonsCount === $learnedLessonsCount and $allLessonsCount !== 0 and $learnedLessonsCount !== 0) {

                array_push($completedModulesId, $group_module['module_id']);
            }
        }

        return $completedModulesId;
    }
}
