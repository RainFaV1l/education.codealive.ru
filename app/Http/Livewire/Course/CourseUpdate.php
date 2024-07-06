<?php

namespace App\Http\Livewire\Course;

use App\Http\Livewire\BaseComponent;
use App\Models\Course as CourseAlias;
use App\Models\CourseCategory;
use App\Models\CourseLevel;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class CourseUpdate extends BaseComponent
{
    // Превью изображения
    use WithFileUploads;

    // Свойства
    public $users;
    public $categories;
    public $course;
    public $levels;
    public $course_id;
    public $name;
    public $price;
    public $author;
    public $course_category_id;
    public $course_level_id;
    public $description;
    public $course_icon_path;
    public $course_banner_path;

    // Событие
    protected $listeners = [
        'getCourse',
    ];

    // Правила для проверки
    protected $rules = [
        'name' => ['required', 'string'],
        'price' => ['required', 'numeric', 'max:1000000'],
        'author' => ['required', 'numeric'],
        'course_category_id' => ['required', 'numeric'],
        'course_level_id' => ['required', 'numeric'],
        'description' => ['required', 'string'],
    ];

    // Получение курса
    public function getCourse()
    {
        $this->course = CourseAlias::findOrFail($this->course_id);
    }

    // Обновление курса
    public function update($id)
    {
        // Валидация
        $validated = $this->validate();

        // Путь
        $path = 'public/images';

        // Проверка
        if ($this->course_icon_path) {
            // Валидация изображния
            $validated['course_icon_path']  = $this->validate([
                'course_icon_path' => ['required', 'image', 'max:5120'],
            ]);

            // Загрузка изображения
            $validated['course_icon_path'] = $this->imageUploadRepository->uploadSingleImage($this->course_icon_path, $path);
        }

        CourseAlias::query()->where('id', '=', $id)->update($validated);

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Курс успешно отредактирован.']);

        $this->emit('getCourse');
    }

    // Рендер курса
    public function render()
    {
        $this->users = User::all();
        $this->categories = CourseCategory::all();
        $this->levels = CourseLevel::all();
        return view('livewire.admin.course.editForm');
    }

    // Начальная установка
    public function mount()
    {
        // Получение курсов
        $this->getCourse();
        
        // Конструктор свойств
        $this->name = $this->course->name;
        $this->price = $this->course->price;
        $this->author = $this->course->author;
        $this->course_category_id = $this->course->course_category_id;
        $this->course_level_id = $this->course->course_level_id;
        $this->description = $this->course->description;
    }
}
