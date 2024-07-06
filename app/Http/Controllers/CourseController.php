<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\CourseStoreRequest;
use App\Http\Requests\Course\ReviewStore;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLevel;
use App\Models\CourseUser;
use App\Models\GroupModule;
use App\Models\LessonModule;
use App\Models\LessonUser;
use App\Models\User;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CourseController extends BaseController
{

    // Показ страницы моих курсов
    public function index()
    {

        // Перенаправление админа
        if(\auth()->user()->role_id === 3) {

            return redirect()->route('index.index');

        }

        // Показ вида
        return view('livewire.course.my-courses');

    }

    // Метод для отправки отзыва
    public function reviewStore(ReviewStore $request)
    {

        // Валидация данных
        $validated = $request->validated();

        // Вызываем метод класса course (Service)
        $this->course->reviewStore($validated);

        // Редирект пользователя
        return redirect()->route('courses.gift', $validated->course_id);

    }

    // Метод для показания страницы добавления курса
    public function add()
    {

        // Переменные со значениями
        $users = User::query()->where('role_id', '>', 1)->get();
        $categories = CourseCategory::all();
        $levels = CourseLevel::all();

        // Показ страницы
        return view('livewire.admin.course.add', compact('categories', 'users', 'levels'));

    }

    // Показ страницы окончания курса
    public function gift($course_id)
    {

        // Объявление переменной
        $user_id = \auth()->user()->id;

        // Переменные со значениями
        $course = Course::query()->select('courses.id', 'courses.name')->findOrFail($course_id);

        // Проверка, переходил ли пользователь на эту страницу
        $check = $this->course->checkIsPassedCertificateQuery($course_id, $user_id);

        // Если пользователь ранее не переходил по данной ссылке, то меняем метку в бд
        if ($check) {

            // Смена метки
            Certificate::query()->where('course_id', '=', $course_id)->where('user_id', '=', $user_id)->update([
                'isPassed' => true,
            ]);

        }

        // Показ страницы
        return view('livewire.certificate.gift', compact('course'));

    }

    // Метод для генерации и показания pdf файла
    public function showPdf($course_id)
    {
        // Получение данных для генерации pdf
        $data = $this->course->pdfBaseQuery($course_id, \auth()->user()->id);

        // Генерация pdf
        $pdf = $this->course->pdfGenerate($data);

        // Показ pdf
        return $pdf->stream();
    }

    // Метод для генерации и скачивания pdf файла
    public function pdf($course_id)
    {

        // Получение данных для генерации pdf
        $data = $this->course->pdfBaseQuery($course_id, \auth()->user()->id);

        // Генерация pdf
        $pdf = $this->course->pdfGenerate($data);

        // Скачка pdf
        return $pdf->download($data->surname . '_' . $data->name . '_' . $data->patronymic . '.pdf');

    }

    // Метод для показа подробной информации о курсе
    public function more($course_id)
    {
        // Объявляем пользователя
        $user_id = auth()->user()->id;

        // Проверка на то, есть ли пользователь в таблице сертификатов
        $checkCertificate = $this->course->checkCertificateQuery($course_id, $user_id);

        if ($checkCertificate) {
            // Проверка на то, прошел ли пользователь данный курс в первый раз
            $checkIsPassedCertificate = $this->course->checkIsPassedCertificateQuery($course_id, $user_id);

            // Перенаправляем, если пользователь прошел в первый раз
            if ($checkIsPassedCertificate !== 'passed') {

                // Перенаправление
                return redirect()->route('courses.gift', $course_id);

            }
        }

        // Получаем информацию о курсе
        $course = Course::findOrFail($course_id);

        // Получаем модули курса
        $course_modules = $this->course->moreCourseModulesQuery($course_id, $user_id, 3);

        // Проверка на существование модулей курса
        if ($course_modules->count() == 0) {

            // Запрос для получения недоступных модулей
            $disabled_modules = $this->course->moreDisabledModulesQuery($course_id, $course, $course_modules);

            // Показ шаблона
            return view('livewire.course.one-course-learn', compact('course', 'course_modules', 'disabled_modules', 'course_id'));

        } else {

            // Получение массива
            $data = $this->course->getLearnedModulesCountMoreController($course_modules);

            // Создание переменных и присваивание значений
            $allLessonsCount = $data['allLessonsCount'];
            $learnedLessonsCount = $data['learnedLessonsCount'];
            $learnedModuleCount = $data['learnedModuleCount'];

            // Показ шаблона
            return view('livewire.course.one-course-learn', compact('course', 'course_modules', 'course_id', 'allLessonsCount', 'learnedLessonsCount', 'learnedModuleCount'));

        }
    }

    // Метод для показа подробной информации о курсе для админа
    public function adminMore($course_id)
    {

        // Показ вида
        return view('livewire.admin.dashboard.admin-course-lessons-show', compact('course_id'));

    }

    // Метод для редактирования курса
    public function edit($course_id)
    {

        // Получение всех пользователей
        $users = User::all();

        // Получение всех категорий
        $categories = CourseCategory::all();

        // Получение всех уровней
        $levels = CourseLevel::all();

        // Рендеринг вида
        return view('livewire.admin.course.edit', compact('categories', 'users', 'levels', 'course_id'));

    }

    // Метод для добавления курса
    public function store(CourseStoreRequest $request)
    {

        // Вызов метода добавления курса
        $this->courseRepository->courseStore($request);

        // Перенаправление пользователя
        return redirect()->route('dashboard.courses');

    }
}
