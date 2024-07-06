<?php

namespace App\Http\Livewire\Lesson;

use App\Http\Livewire\Course\Course;
use App\Models\Course as CourseAlias;
use App\Models\Lesson;
use App\Models\LessonFile;
use App\Models\LessonFilesBundle;
use App\Models\LessonVideo;
use App\Models\LessonVideosBundle;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use App\Http\Livewire\BaseComponent;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class LessonUpdate extends BaseComponent
{
    use WithFileUploads;

    public $lesson_id;

    public $lesson;
    public $courses;

    public $name;
    public $task;
    public $description;
    public $lesson_number;
    public $course_id;

    public Collection $files;
    public Collection $videos;


    public $file_path = [];

    public $counter = [];
    public $video;
    public $i = 1;

    protected $rules = [
        'name' => ['required', 'string'],
        'task' => ['required', 'string'],
        'description' => ['required', 'string'],
        'lesson_number' => ['required', 'numeric'],
        'course_id' => ['required', 'numeric'],
    ];

    protected $listeners = [
        'refreshComponent' => 'getFiles',
        'refreshVideos' => 'getVideos',
    ];

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->counter ,$i);
    }

    public function remove($i)
    {
        unset($this->counter[$i]);
    }

    private function resetInputFields(){
        $this->video = '';
    }

    public function getFiles() {
        $this->files = LessonFilesBundle::query()->where('lesson_id', '=', $this->lesson->id)->get();
    }

    public function getVideos() {
        $this->videos = LessonVideosBundle::query()->where('video_id', '=', $this->lesson->id)->get();
    }

    public function update($id)
    {
        // Валидация
        $validated = $this->validate();

        // Обновление основной информации
        Lesson::query()->where('id', '=', $id)->update($validated);
    
        // Обновление компонента
        $this->emit('refreshComponent');

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Информация урока успешно изменена.']);

        // Проверка
        if($this->file_path !== null && count($this->file_path) > 0) {

             // Обработка ошибок
            try {

                // Запуск транзакции
                DB::beginTransaction();

                // Загрузка файлов в таблицу lesson_files
                $paths = $this->imageUploadRepository->uploadMultiImages($this->file_path, 'public/lessons');

                // Перебор путей
                foreach($paths as $path) {

                    // Сохранение пути
                    $lessonFile = LessonFile::create([
                        'file_path' => $path,
                    ]);

                    // Связка таблиц
                    LessonFilesBundle::create([
                        'lesson_id' => $id,
                        'file_id' => $lessonFile->id
                    ]);
                }

                // Обновление компонента
                $this->emit('refreshComponent');

                // Создание уведомления
                $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Фотография успешно добавлена.']);

                // Обновление пути
                $this->file_path = [];

                // Сохранение
                DB::commit();
            } catch (\Exception $exception) {

                // Откат изменений при появлении ошибки
                DB::rollBack();

                // Создание уведомления
                $this->dispatchBrowserEvent('notification', ['type' => 'error', 'text' => 'Не удалось добавить фотографию!']);

                // Возвращение сообщения ошибки
                return $exception->getMessage();
            }
            
        }
        
        // if ($this->file_path !== null && count($this->file_path) > 0) {
        //     $validatedFile['file_path']  = $this->validate([
        //         'file_path' => ['required', 'max:5120'],
        //     ]);
        //     foreach ($this->file_path as $file) {
        //         $validatedFile['file_path'] = $file->store('public/lessons');
        //         $lessonFile = LessonFile::create($validatedFile);
        //         LessonFilesBundle::create([
        //             'lesson_id' => $id,
        //             'file_id' => $lessonFile->id
        //         ]);
        //     }
        //     $this->emit('refreshComponent');
        //     $this->file_path = '';
        // }

        // Загрузка путей видео в таблицу lesson_videos

        // Првоерка
        if($this->video !== null && count($this->video) > 0) {
             // Обработка ошибок
            try {

                // Запуск транзакции
                DB::beginTransaction();

                // Валидация
                $validatedDate = $this->validate([
                    'video.0' => 'required',
                    'video.*' => 'required',
                ]);
        
                // Перебор массива
                foreach ($this->video as $key => $value) {
                    // Заполнение таблицы lesson_videos
                    $lessonVideo = LessonVideo::create(['video_path' => $this->video[$key]]);

                    // Заполнение таблицы связки lesson_videosBundle
                    LessonVideosBundle::create([
                        'lesson_id' => $id,
                        'video_id' => $lessonVideo->id,
                    ]);
                }
        
                // Обновление компонента
                $this->emit('refreshVideos');
        
                // Создание уведомления
                $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Видео успешно добавлено.']);
        
                // Обнуление счетчика
                $this->counter = [];

                // Обнуление input
                $this->resetInputFields();

                // Сохранение
                DB::commit();
            } catch (\Exception $exception) {

                // Откат изменений при появлении ошибки
                DB::rollBack();

                // Создание уведомления
                $this->dispatchBrowserEvent('notification', ['type' => 'error', 'text' => 'Не удалось добавить видео!']);

                // Возвращение сообщения ошибки
                return $exception->getMessage();
            }
        }

    }

    public function deleteFile(LessonFile $file) {
        $file->delete();
        $this->emit('refreshComponent');
        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Фотография успешно удалена.']);
    }

    public function deleteVideo(LessonVideo $video) {
        $video->delete();
        $this->emit('refreshVideos');
        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Видео успешно удалено.']);
    }

    public function render()
    {
        $this->videos = LessonVideosBundle::query()->where('lesson_id', '=', $this->lesson->id)->get();
        $this->files = LessonFilesBundle::query()->where('lesson_id', '=', $this->lesson->id)->get();
        return view('livewire.admin.lesson.editForm');
    }

    public function mount()
    {
        $this->name = $this->lesson->name;
        $this->task = $this->lesson->task;
        $this->description = $this->lesson->description;
        $this->lesson_number = $this->lesson->lesson_number;
        $this->course_id = $this->lesson->course_id;
    }
}
