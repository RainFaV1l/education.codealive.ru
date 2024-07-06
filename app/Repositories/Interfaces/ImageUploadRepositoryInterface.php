<?php

namespace App\Repositories\Interfaces;

interface ImageUploadRepositoryInterface
{
    // Метод для добавления обычного изображения
    public function uploadSingleImage($file, $storePath);
    // Метод для удаления файла
    public function destroyFile(array $data);
}
