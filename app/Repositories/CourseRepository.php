<?php

namespace App\Repositories;

use App\Http\Requests\Course\CourseStoreRequest;
use App\Models\Course;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\ImageUploadRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CourseRepository implements CourseRepositoryInterface
{

    // Свойства для подключения сторонних репозиториев
    private $imageUploadRepository;

    // Конструктор для подключение сторонних репозиториев
    public function __construct(ImageUploadRepositoryInterface $imageUploadRepository)
    {
        // Репозиторий для загрузки изображений
        $this->imageUploadRepository = $imageUploadRepository;
    }

    // Метод для добавления курса
    public function courseStore(CourseStoreRequest $request)
    {
        // Валидация данных
        $validated = $request->validated();

        // Обработка ошибок
        try {

            // Запуск транзакции
            DB::beginTransaction();

            // Файл
            $file = $request->file('course_icon_path');

            // Путь для загрузки файла
            $path = 'public/courses';

            // Метод для загрузки одного файла
            $validated['course_icon_path'] = $this->imageUploadRepository->uploadSingleImage($file, $path);

            // Проверка загрузилось ли изображение
            if (!$validated['course_icon_path']) {
                // Возвращение false
                return false;
            }

            // Создание курса
            Course::query()->create($validated);

            // Создание уведомления
            session()->flash('success', 'Курс успешно создан.');

            // Сохранение
            DB::commit();

        } catch (\Exception $exception) {

            // Откат изменений при появлении ошибки
            DB::rollBack();

            // Создание уведомления об ошибке
            session()->flash('error', 'Не удалось создать курс!');

            // Возвращение сообщения ошибки
            return $exception->getMessage();
        }
    }
}
