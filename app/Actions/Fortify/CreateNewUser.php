<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'surname' => ['required', 'string',  'min:5', 'max:50', 'regex:/^[А-Яа-яёЁ\s-]+$/iu'],
            'name' => ['required', 'string',  'min:2', 'max:50', 'regex:/^[А-Яа-яёЁ\s-]+$/iu'],
            'patronymic' => ['nullable', 'string',  'min:5', 'max:50', 'regex:/^[А-Яа-яёЁ\s-]+$/iu'],
            'birthday_date' => ['required', 'date', 'max:255'],
            'tel' => ['required', 'string', 'min:17', 'max:17', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'surname' => $input['surname'],
            'name' => $input['name'],
            'patronymic' => $input['patronymic'],
            'birthday_date' => $input['birthday_date'],
            'last_auth_date' => date('Y-m-d h-m-s', time()),
            'tel' => $input['tel'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
