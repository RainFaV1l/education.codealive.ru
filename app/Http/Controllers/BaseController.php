<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\ImageUploadRepositoryInterface;
use App\Repositories\Interfaces\LessonRepositoryInterface;
use App\Services\Catalog\Service;
use App\Services\Profile\Service as Profile;
use App\Services\Course\Service as Course;

class BaseController extends Controller
{
    // Паттерн Service
    protected $profile;
    protected $course;
    protected $catalogService;

    // Паттерн Репозиторий
    protected $courseRepository;
    protected $imageUploadRepository;
    protected $lessonRepository;

    public function __construct(Profile $profile, Course $course, Service $catalogService, CourseRepositoryInterface $courseRepository, ImageUploadRepositoryInterface $imageUploadRepository, LessonRepositoryInterface $lessonRepository)
    {
        // Паттерн Service
        $this->profile = $profile;
        $this->course = $course;
        $this->catalogService = $catalogService;

        // Паттерн Репозиторий
        $this->courseRepository = $courseRepository;
        $this->imageUploadRepository = $imageUploadRepository;
        $this->lessonRepository = $lessonRepository;
    }
}
