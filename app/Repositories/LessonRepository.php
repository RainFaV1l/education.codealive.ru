<?php

namespace App\Repositories;

use App\Repositories\Interfaces\LessonRepositoryInterface;
use App\Repositories\Interfaces\ImageUploadRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\Lesson;
use App\Models\LessonFile;
use App\Models\LessonFilesBundle;
use App\Models\LessonVideo;
use App\Models\LessonVideosBundle;

class LessonRepository implements LessonRepositoryInterface
{
    // Свойства для подключения сторонних репозиториев
    private $imageUploadRepository;

    // Конструктор для подключение сторонних репозиториев
    public function __construct(ImageUploadRepositoryInterface $imageUploadRepository)
    {
        // Репозиторий для загрузки изображений
        $this->imageUploadRepository = $imageUploadRepository;
    }

    // Метод для создания урока
    public function createLesson($request) {
         // Обработка ошибок
         try {

            // Запуск транзакции
            DB::beginTransaction();

            // Валидируем через request
            $validated = $request->validated();

            // Загрузка информации урока в таблицу lessons
            $lesson = Lesson::create($validated);

            // Проверка
            if(!is_null($request->file('file_path')) && count($request->file('file_path')) > 0) {

                // Формируем путь
                $path = 'public/lessons';

                // Загрузка файлов в таблицу lesson_files
                $paths = $this->imageUploadRepository->uploadMultiImages($request->file('file_path'), $path);

                // Перебоп путей изображений
                foreach($paths as $path) {
                    // Сохранение пути файла в таблицу lesson_files
                    $lessonFiles = LessonFile::create([
                        'file_path' => $path,
                    ]);

                    // Заполнение таблицы связки
                    LessonFilesBundle::create([
                        'lesson_id' => $lesson->id,
                        'file_id' => $lessonFiles->id,
                    ]);
                }
                
            }

            // Проверка
            if(count($request->inputs) > 0 && !is_null($request->inputs[0]['video_path'])) {

                // Сохранение путей видео в таблицу lesson_videos
                foreach ($request->inputs as $input) {
                    // Сохранение пути
                    $lessonVideo = LessonVideo::create($input);

                    // Заполнение таблицы связки lesson_videosBundle
                    LessonVideosBundle::create([
                        'lesson_id' => $lesson->id,
                        'video_id' => $lessonVideo->id,
                    ]);
                }
            }

            // Добавление уведомления
            session()->flash('success', 'Урок успешно создан.');

            // Сохранение
            DB::commit();
        } catch (\Exception $exception) {

            // Откат изменений при появлении ошибки
            DB::rollBack();

            // Создание уведомления об ошибке
            session()->flash('error', 'Не удалось создать урок!');

            // Возвращение сообщения ошибки
            return $exception->getMessage();
        }
    }
}
