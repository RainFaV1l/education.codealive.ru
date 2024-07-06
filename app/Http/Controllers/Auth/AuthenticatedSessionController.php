<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return Socialite::driver('laravelpassport')->stateless()->redirect();
    }

    public function redirect()
    {
        $pautinaUser = Socialite::driver('laravelpassport')->stateless()->user();

        $pautinaUser->level = match($pautinaUser->level) {
            'ADMIN' => 3,
            default => 1,
        };

        $userFind = User::query()->where('email', $pautinaUser->getEmail())->first();

        $email_verified_at = Carbon::now();

        if(!empty($userFind->email_verified_at)) {
            $email_verified_at = $userFind->email_verified_at;
        }

        $user = User::updateOrCreate([
            'email' => $pautinaUser->getEmail(),
        ], [
            'name' => $pautinaUser['name'],
            'surname' => $pautinaUser['surname'],
            'patronymic' => $pautinaUser['patronymic'],
            'role_id' => $pautinaUser['level'],
            'email' => $pautinaUser->getEmail(),
            'profile_photo_path' => $pautinaUser->getAvatar(),
            'phone' => $pautinaUser['phone'],
            'created_at' => $pautinaUser['reg_date'],
            'pautina_id' => $pautinaUser->getId(),
            'last_auth_date' => Carbon::now(),
            'email_verified_at' => $email_verified_at,
        ]);

        Auth::login($user);

        return redirect()->route('profile.index');
    }
}
