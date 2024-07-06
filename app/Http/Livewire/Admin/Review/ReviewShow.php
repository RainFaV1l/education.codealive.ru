<?php

namespace App\Http\Livewire\Admin\Review;

use App\Http\Livewire\BaseComponent;
use App\Models\Review;

class ReviewShow extends BaseComponent
{

    // Базовый запрос для получения отзывов
    public function getReviewsQuery()
    {
        $this->reviews = Review::query()
            ->select('reviews.id as review_id', 
            'reviews.rating', 'reviews.description', 
            'reviews.user_id', 'reviews.course_id', 
            'reviews.review_statuses_id',
            'courses.name',
            'users.surname',
            'users.name',
            'users.patronymic',
            )
            ->leftJoin('courses', 'reviews.course_id', '=', 'courses.id')
            ->leftJoin('users', 'reviews.user_id', '=', 'users.id')
            ->where('courses.name', 'LIKE', '%' . trim($this->search) . '%')
            ->orWhere('users.surname', 'LIKE', '%' . trim($this->search) . '%')
            ->orWhere('users.name', 'LIKE', '%' . trim($this->search) . '%')
            ->orWhere('users.patronymic', 'LIKE', '%' . trim($this->search) . '%')
            ->orderBy('review_statuses_id')->get();
    }

    // Создание события для обновлени компонента
    protected $listener = ['updateComponent'];

    // Метод для обновлени компонента
    public function updateComponent()
    {
        // Получение отзывов
        $this->getReviewsQuery();
    }

    // Инициализация свойст
    public $reviews;
    public $search;

    // Метод для принятия отзыва
    public function accept(Review $review)
    {
        // Проверка на наличие записи
        $check = $this->reviewRepository->checkIsIssetValueInTable($review->id);

        // Проверка
        if ($check) {
            // Запрос
            Review::query()->where('id', '=', $review->id)->update(['review_statuses_id' => 2]);

            // Уведомление
            $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Отзыв успешно принят.']);

            // Обновление компонента
            $this->emit('updateComponent');

            // Возвращение значения
            return true;
        }

        // Уведомление
        $this->dispatchBrowserEvent('notification', ['type' => 'warning', 'text' => 'Отзыв уже принят!']);

        // Возвращение значения
        return false;
    }

    // Метод для отклонения отзыва
    public function reject(Review $review)
    {
        // Проверка на наличие записи
        $check = $this->reviewRepository->checkIsIssetValueInTable($review->id);

        // Проверка
        if (!$check) {

            // Запрос
            $review->delete();

            // Уведомление
            $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Отзыв успешно удален.']);

            // Обновление компонента
            $this->emit('updateComponent');

            // Возвращение значения
            return true;
        }

        // Уведомление
        $this->dispatchBrowserEvent('notification', ['type' => 'warning', 'text' => 'Отзыв уже удален!']);

        // Возвращение значения
        return false;
    }

    // Метод для поиска
    public function searchReviews()
    {
        // Запрос
        $this->getReviewsQuery();
    }

    // Метод для рендера вида
    public function render()
    {
        // Получение отзывов
        $this->getReviewsQuery();

        // Возвращение вида
        return view('livewire.admin.review.review-show');
    }
}
