<?php

namespace App\Providers;

use App\Repositories\ChangeProfileInfoRepository;
use App\Repositories\CourseRepository;
use App\Repositories\ImageUploadRepository;
use App\Repositories\Interfaces\ChangeProfileInfoRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\ImageUploadRepositoryInterface;
use App\Repositories\Interfaces\LivewireFilterRepositoryInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Repositories\Interfaces\LessonRepositoryInterface;
use App\Repositories\LivewireFilterRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\LessonRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CourseRepositoryInterface::class,
            CourseRepository::class
        );
        $this->app->bind(
            ImageUploadRepositoryInterface::class,
            ImageUploadRepository::class
        );
        $this->app->bind(
            ReviewRepositoryInterface::class,
            ReviewRepository::class
        );
        $this->app->bind(
            ChangeProfileInfoRepositoryInterface::class,
            ChangeProfileInfoRepository::class
        );
        $this->app->bind(
            LivewireFilterRepositoryInterface::class,
            LivewireFilterRepository::class
        );
        $this->app->bind(
            LessonRepositoryInterface::class,
            LessonRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Получить службы, предоставляемые поставщиком.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [
            CourseRepositoryInterface::class,
            ImageUploadRepositoryInterface::class,
            ReviewRepositoryInterface::class,
            ChangeProfileInfoRepositoryInterface::class,
            LivewireFilterRepositoryInterface::class,
            LessonRepositoryInterface::class
        ];
    }
}
