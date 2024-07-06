@extends('layouts.login-register')

@section('page-title') Регистрация @endsection

@section('content')
    <section class="registration">
        <div class="container">
            <div class="reg-wrapper">
                <div class="auth-title">Регистрация</div>
                <div class="account-create">Есть профиль? Скорей <a href="{{ route('login') }}">авторизуйся!</a></div>
{{--                <x-jet-validation-errors class="mb-4" />--}}
                <form action="{{ route('register') }}" method="post" class="reg-form">
                    @csrf
                    <div class="error__input-column">
                        <div class="input-column @error('surname') error @enderror">
                            <input id="reg-surname" type="text" name="surname" class="input" value="{{old('surname')}}" required autofocus autocomplete="surname">
                            <label for="reg-surname">Фамилия</label>
                        </div>
                        @error('surname')
                            <div class="input-column-error__text"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="error__input-column">
                        <div class="input-column @error('name') error @enderror">
                            <input id="reg-name" type="text" name="name" class="input" value="{{old('name')}}" required autofocus autocomplete="name">
                            <label for="reg-name">Имя</label>
                        </div>
                        @error('name')
                            <div class="input-column-error__text"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="error__input-column">
                        <div class="input-column @error('patronymic') error @enderror">
                            <input id="reg-patronymic" type="text" name="patronymic" class="input" value="{{old('patronymic')}}" autofocus autocomplete="patronymic">
                            <label for="reg-patronymic">Отчество</label>
                        </div>
                        @error('patronymic')
                            <div class="input-column-error__text"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="error__input-column">
                        <div class="input-column @error('birthday_date') error @enderror">
                            <input id="reg-birthday_date" type="date" name="birthday_date" class="input" value="{{old('birthday_date')}}" required autofocus autocomplete="birthday">
                            <label for="reg-birthday_date">Дата рождения</label>
                        </div>
                        @error('birthday_date')
                            <div class="input-column-error__text"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="error__input-column">
                        <div class="input-column @error('tel') error @enderror">
                            <input id="reg-tel" type="text" name="tel" class="input tel" value="{{old('tel')}}" required autofocus autocomplete="tel">
                            <label for="reg-tel">Телефон</label>
                        </div>
                        @error('tel')
                            <div class="input-column-error__text"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="error__input-column">
                        <div class="input-column @error('email') error @enderror">
                            <input id="reg-email" type="email" name="email" class="input" value="{{old('email')}}" required autofocus autocomplete="email">
                            <label for="reg-email">Email</label>
                        </div>
                        @error('email')
                            <div class="input-column-error__text"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="error__input-column">
                        <div class="input-column @error('password') error @enderror">
                            <input id="reg-password" type="password" name="password" class="input" value="{{old('password')}}" required autocomplete="new-password">
                            <label for="reg-password">Пароль</label>
                            <div class="show-password">
                                <div class="show">
                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g opacity="0.5">
                                            <path d="M10.9998 5.95833C12.6853 5.95273 14.3382 6.42288 15.7684 7.31475C17.1987 8.20661 18.3482 9.48398 19.0848 11C17.5723 14.0892 14.4832 16.0417 10.9998 16.0417C7.5165 16.0417 4.42734 14.0892 2.91484 11C3.65149 9.48398 4.801 8.20661 6.23123 7.31475C7.66145 6.42288 9.31433 5.95273 10.9998 5.95833ZM10.9998 4.125C6.4165 4.125 2.50234 6.97583 0.916504 11C2.50234 15.0242 6.4165 17.875 10.9998 17.875C15.5832 17.875 19.4973 15.0242 21.0832 11C19.4973 6.97583 15.5832 4.125 10.9998 4.125ZM10.9998 8.70833C11.6076 8.70833 12.1905 8.94978 12.6203 9.37955C13.0501 9.80932 13.2915 10.3922 13.2915 11C13.2915 11.6078 13.0501 12.1907 12.6203 12.6205C12.1905 13.0502 11.6076 13.2917 10.9998 13.2917C10.392 13.2917 9.80915 13.0502 9.37938 12.6205C8.94961 12.1907 8.70817 11.6078 8.70817 11C8.70817 10.3922 8.94961 9.80932 9.37938 9.37955C9.80915 8.94978 10.392 8.70833 10.9998 8.70833ZM10.9998 6.875C8.7265 6.875 6.87484 8.72667 6.87484 11C6.87484 13.2733 8.7265 15.125 10.9998 15.125C13.2732 15.125 15.1248 13.2733 15.1248 11C15.1248 8.72667 13.2732 6.875 10.9998 6.875Z" fill="#1D1D39"/>
                                        </g>
                                    </svg>
                                </div>
                                <div class="hide">
                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.9998 4.125C6.4165 4.125 2.50234 6.97583 0.916504 11C2.50234 15.0242 6.4165 17.875 10.9998 17.875C15.5832 17.875 19.4973 15.0242 21.0832 11C19.4973 6.97583 15.5832 4.125 10.9998 4.125ZM10.9998 15.5833C8.46984 15.5833 6.4165 13.53 6.4165 11C6.4165 8.47 8.46984 6.41667 10.9998 6.41667C13.5298 6.41667 15.5832 8.47 15.5832 11C15.5832 13.53 13.5298 15.5833 10.9998 15.5833ZM10.9998 8.25C9.47817 8.25 8.24984 9.47833 8.24984 11C8.24984 12.5217 9.47817 13.75 10.9998 13.75C12.5215 13.75 13.7498 12.5217 13.7498 11C13.7498 9.47833 12.5215 8.25 10.9998 8.25Z" fill="#1D1D39"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        @error('password')
                            <div class="input-column-error__text"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="error__input-column">
                        <div class="input-column @error('password_confirmation') error @enderror">
                            <input id="reg-password_r" type="password" name="password_confirmation" class="input" value="{{old('password_confirmation')}}" required autofocus autocomplete="new-password">
                            <label for="reg-password_r">Подтвердите пароль</label>
                            <div class="show-password">
                                <div class="show">
                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g opacity="0.5">
                                            <path d="M10.9998 5.95833C12.6853 5.95273 14.3382 6.42288 15.7684 7.31475C17.1987 8.20661 18.3482 9.48398 19.0848 11C17.5723 14.0892 14.4832 16.0417 10.9998 16.0417C7.5165 16.0417 4.42734 14.0892 2.91484 11C3.65149 9.48398 4.801 8.20661 6.23123 7.31475C7.66145 6.42288 9.31433 5.95273 10.9998 5.95833ZM10.9998 4.125C6.4165 4.125 2.50234 6.97583 0.916504 11C2.50234 15.0242 6.4165 17.875 10.9998 17.875C15.5832 17.875 19.4973 15.0242 21.0832 11C19.4973 6.97583 15.5832 4.125 10.9998 4.125ZM10.9998 8.70833C11.6076 8.70833 12.1905 8.94978 12.6203 9.37955C13.0501 9.80932 13.2915 10.3922 13.2915 11C13.2915 11.6078 13.0501 12.1907 12.6203 12.6205C12.1905 13.0502 11.6076 13.2917 10.9998 13.2917C10.392 13.2917 9.80915 13.0502 9.37938 12.6205C8.94961 12.1907 8.70817 11.6078 8.70817 11C8.70817 10.3922 8.94961 9.80932 9.37938 9.37955C9.80915 8.94978 10.392 8.70833 10.9998 8.70833ZM10.9998 6.875C8.7265 6.875 6.87484 8.72667 6.87484 11C6.87484 13.2733 8.7265 15.125 10.9998 15.125C13.2732 15.125 15.1248 13.2733 15.1248 11C15.1248 8.72667 13.2732 6.875 10.9998 6.875Z" fill="#1D1D39"/>
                                        </g>
                                    </svg>
                                </div>
                                <div class="hide">
                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.9998 4.125C6.4165 4.125 2.50234 6.97583 0.916504 11C2.50234 15.0242 6.4165 17.875 10.9998 17.875C15.5832 17.875 19.4973 15.0242 21.0832 11C19.4973 6.97583 15.5832 4.125 10.9998 4.125ZM10.9998 15.5833C8.46984 15.5833 6.4165 13.53 6.4165 11C6.4165 8.47 8.46984 6.41667 10.9998 6.41667C13.5298 6.41667 15.5832 8.47 15.5832 11C15.5832 13.53 13.5298 15.5833 10.9998 15.5833ZM10.9998 8.25C9.47817 8.25 8.24984 9.47833 8.24984 11C8.24984 12.5217 9.47817 13.75 10.9998 13.75C12.5215 13.75 13.7498 12.5217 13.7498 11C13.7498 9.47833 12.5215 8.25 10.9998 8.25Z" fill="#1D1D39"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        @error('password_confirmation')
                            <div class="input-column-error__text"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="reg__row">
{{--                        <div class="g-recaptcha" data-sitekey="6Ldl6VQkAAAAAONB7z5s0khGvLOxwB-YCmIOA_3t"></div>--}}
                        <div class="check-wrapper">
                            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                <input type="checkbox" id="check" name="terms" required>
                                <label for="check">
                                    {!! __('Согласен c {{--:terms_of_service и--}} :privacy_policy', [
                                            {{--'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('условием использования').'</a>', --}}
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('политикой конфиденциальности').'</a>',
                                    ]) !!};
                                </label>
                                @error('terms')
                                    <div class="input-column-error__text"> {{ $message }}</div>
                                @enderror
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="button small">Зарегистрироваться</button>
                </form>
            </div>
        </div>
    </section>
@endsection('content')

@section('login-register-header')
    <header class="login-register-header opacity-anim element-animation">
        <div class="login-register-header__container container">
            <div class="login-register-row">
                <div class="login-register-header__logo">
                    <div class="logo">
                        <a href="{{ route('index.index') }}">
                            Паутина
                        </a>
                    </div>
                </div>
                <div class="login-register-header__buttons">
                    <a href="{{'login'}}" class="login-register-header__button">Войти</a>
                </div>
            </div>
        </div>
    </header>
@endsection('login-register-header')

{{--<x-guest-layout>--}}
{{--    <x-jet-authentication-card>--}}
{{--        <x-slot name="logo">--}}
{{--            <x-jet-authentication-card-logo />--}}
{{--        </x-slot>--}}

{{--        <x-jet-validation-errors class="mb-4" />--}}

{{--        <form method="POST" action="{{ route('register') }}">--}}
{{--            @csrf--}}

{{--            <div>--}}
{{--                <x-jet-label for="name" value="{{ __('Name') }}" />--}}
{{--                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />--}}
{{--            </div>--}}

{{--            <div class="mt-4">--}}
{{--                <x-jet-label for="email" value="{{ __('Email') }}" />--}}
{{--                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />--}}
{{--            </div>--}}

{{--            <div class="mt-4">--}}
{{--                <x-jet-label for="password" value="{{ __('Password') }}" />--}}
{{--                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />--}}
{{--            </div>--}}

{{--            <div class="mt-4">--}}
{{--                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />--}}
{{--                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />--}}
{{--            </div>--}}

{{--            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())--}}
{{--                <div class="mt-4">--}}
{{--                    <x-jet-label for="terms">--}}
{{--                        <div class="flex items-center">--}}
{{--                            <x-jet-checkbox name="terms" id="terms" required />--}}

{{--                            <div class="ml-2">--}}
{{--                                {!! __('I agree to the :terms_of_service and :privacy_policy', [--}}
{{--                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',--}}
{{--                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',--}}
{{--                                ]) !!}--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </x-jet-label>--}}
{{--                </div>--}}
{{--            @endif--}}

{{--            <div class="flex items-center justify-end mt-4">--}}
{{--                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">--}}
{{--                    {{ __('Already registered?') }}--}}
{{--                </a>--}}

{{--                <x-jet-button class="ml-4">--}}
{{--                    {{ __('Register') }}--}}
{{--                </x-jet-button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </x-jet-authentication-card>--}}
{{--</x-guest-layout>--}}
