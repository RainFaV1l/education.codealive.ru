<?php

namespace App\Http\Livewire;

use App\Repositories\ImageUploadRepository;
use App\Repositories\ReviewRepository;
use App\Services\Course\Service;
use App\Services\Profile\Service as ProfileService;
use Livewire\Component;

class BaseComponent extends Component
{

    protected $courseService;
    protected $profileService;
    protected $reviewRepository;
    protected $imageUploadRepository;

    public function boot(Service $courseService, ProfileService $profileService, ReviewRepository $reviewRepository, ImageUploadRepository $imageUploadRepository)
    {
        $this->courseService = $courseService;
        $this->reviewRepository = $reviewRepository;
        $this->profileService = $profileService;
        $this->imageUploadRepository = $imageUploadRepository;
    }
}
