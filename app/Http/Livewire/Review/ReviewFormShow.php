<?php

namespace App\Http\Livewire\Review;

use App\Models\Review;
use App\Services\Course\Service;
use Livewire\Component;

class ReviewFormShow extends Component
{

    public $course;

    public $course_id;
    public $user_id;
    public $rating;
    public $description;

    private $courseService;

    public $rules = [
        'course_id' => 'required|numeric',
        'user_id' => 'required|numeric',
        'rating' => 'required|numeric',
        'description' => 'required|string|max:200',
    ];

    public function boot(Service $service)
    {

        $this->courseService = $service;
    }

    public function mount()
    {

        $this->user_id = auth()->user()->id;
        $this->course_id = $this->course->id;
    }

    public function render()
    {

        return view('livewire.review.review-form-show');
    }


    // Метод для отправки отзыва
    public function reviewStore()
    {

        // Убераем пробелы
        $this->description = trim($this->description);

        // Валидация данных
        $validated = $this->validate();

        // Вызов метода класса course (Service)
        $review = $this->courseService->reviewStore($validated);

        // Проверка
        if ($review) {
            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Отзыв успешно отправлен на модерацию.']);
            // Редирект пользователя
            $this->emit('redirect', '/courses/' . $validated['course_id'] . '/gift');
        } else {
            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Вы уже оставили отзыв на данный курс.']);
            // Добавление новой ошибки
            // $this->addError('isset', 'Вы уже оставили отзыв на данный курс.');
        }
    }
}
