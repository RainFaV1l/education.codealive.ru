<?php

namespace App\Http\Controllers;

use App\Models\CourseCategory;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\DestroyRequest;
use App\Http\Requests\Category\UpdateRequest;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CategoryController extends Component
{
    // Показ страницы добавления категории
    public function addView() {
        // Показ страницы
        return view('livewire.admin.category.addCategory');
    }

    // Сохранение
    public function store(StoreRequest $request) {

        // Валидация
        $validated = $request->validated();

        // Добавление группы
        CourseCategory::query()->create($validated);

        // Создание уведомления
        session()->flash('success', 'Категория успешно добавлена.');

        // Редирект
        return redirect()->route('dashboard.categories');
    }

    // Показ страницы редактирования
    public function editView($id) {
        // Получение информации о курсе
        $category = CourseCategory::findOrFail($id);

        // Возвращение вида
        return view('livewire.admin.category.editCategory', compact('category'));
    }

    // Обновление группы
    public function update(UpdateRequest $request, $id) {
        // Валидация
        $validated = $request->validated();

        // Обноление
        CourseCategory::query()->where('id', '=', $id)->update($validated);
                
        // Создание уведомления
        session()->flash('success', 'Категория успешно обновлена.');

        // Редирект
        return redirect(route('dashboard.categories'));
    }

    // Удаление группы
    public function destroy(DestroyRequest $request) {
        // Валидация
        $validated = $request->validated();

        // Удаление
        CourseCategory::destroy($validated['category_id']);

        // Создание уведомления
        session()->flash('success', 'Категория успешно удалена.');

        // Редирект
        return redirect(route('dashboard.categories'));
    }
}
