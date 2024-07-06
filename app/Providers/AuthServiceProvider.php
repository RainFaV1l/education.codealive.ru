<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Http\Livewire\DashboardController;
use App\Policies\DashboardControllerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Course' => 'App\Policies\DashboardControllerPolicy',
        'App\Models\Group' => 'App\Policies\DashboardControllerPolicy',
        'App\Models\Lesson' => 'App\Policies\DashboardControllerPolicy',
        'App\Models\CourseCategory' => 'App\Policies\DashboardControllerPolicy',
        'App\Models\User' => 'App\Policies\DashboardControllerPolicy',

//        DashboardController::class => DashboardControllerPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Подтвердите адрес электронной почты')
                ->line('Пожалуйста, нажмите на кнопку ниже, чтобы подтвердить свой адрес электронной почты.')
                ->action('Подтвердить', $url)
                ->line('Если вы не создавали учетную запись, никаких дальнейших действий не требуется.');
        });

    }
}
