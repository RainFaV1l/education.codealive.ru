<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ImageUploadRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class ImageUploadRepository implements ImageUploadRepositoryInterface
{
    // Метод для добавления обычного изображения
    public function uploadSingleImage($file, $storePath)
    {
        // Проверка на наличие файла
        if ($file) {

            // Сохранения файла и его пути
            $path = $file->store($storePath);

            // Возвращение пути сохраненого файла
            return $path;
        }

        // Иначе возвращение false
        return false;
    }

    // Метод для добавления обычного изображения
    public function uploadMultiImages($files, $storePath)
    {
        // Проверка на наличие файлов
        if ($files) {

            // Создание массива для хранения путей
            $paths = [];

            // Перебираем файлы
            foreach ($files as $file) {
                // Сохранения файла и его пути
                $path = $file->store($storePath);

                // Добавление пути файла в массив
                array_push($paths, $path);
            }

            // Возвращение пути сохраненого файла
            return $paths;

        }

        // Иначе возвращение false
        return false;
    }

    // Метод для удаления файла
    public function destroyFile(array $data) {
        try {

            // Проверка на существование файла
            if(Storage::exists($data['path'])) Storage::delete($data['path']);

            return true;

        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
