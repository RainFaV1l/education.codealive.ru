@extends('layouts.login-register')

@section('page-title') Авторизация @endsection

@section('content')
    <section class="auth">
        <div class="auth-wrapper">
            <div class="auth__img">
                <img src="{{asset('assets/img/auth.png')}}" alt="img">
            </div>
            <div class="auth__info">
                <div class="auth-title">Вход</div>
                <div class="account-create">Нет профиля? Скорей <a class="create-account-link" href="{{route('register')}}">создавай</a>, это бесплатно!</div>
{{--                <x-jet-validation-errors class="mb-4" />--}}
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="auth-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="error__input-column">
                        <div class="input-column @error('email') error @enderror">
                            <input class="input" id="auth-email" type="email" name="email" value="{{old('email')}}" required autofocus>
                            <label for="auth-email">Email</label>
                        </div>
                        @error('email')
                            <div class="input-column-error__text"> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="error__input-column">
                        <div class="input-column @error('email') error @enderror">
                            <input type="password" id="auth-password" name="password" class="input" required autocomplete="current-password">
                            <label for="auth-password">Пароль</label>
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

                    <label for="remember_me" class="flex items-center">
                        <x-jet-checkbox id="remember_me" name="remember" />
                        <span class="remember-me__text">{{ __('Запомнить меня') }}</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="remember-me__text" href="{{ route('password.request') }}">Забыли пароль?</a>
                    @endif
                    <div class="oauth__buttons">
                        <a href="{{ route('pautinaid.create') }}" class="oauth__button oauth-button">
                            <img class="oauth-button__img" src="{{ asset('assets/img/logos/pautina-logo.png') }}" alt="logo">
                            <span class="oauth-button__text">Войти через Паутина ID</span>
                        </a>
                    </div>
                    <button class="button">Войти</button>
                </form>
            </div>
        </div>
    </section>
@endsection('content')

@section('login-register-header')
    <header class="login-register-header element-animation opacity-anim">
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
                    <a href="{{'register'}}" class="login-register-header__button">Создать</a>
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

{{--        @if (session('status'))--}}
{{--            <div class="mb-4 font-medium text-sm text-green-600">--}}
{{--                {{ session('status') }}--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        <form method="POST" novalidate action="{{ route('login') }}">--}}
{{--            @csrf--}}

{{--            <div>--}}
{{--                <x-jet-label for="email" value="{{ __('Email') }}" />--}}
{{--                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />--}}
{{--            </div>--}}

{{--            <div class="mt-4">--}}
{{--                <x-jet-label for="password" value="{{ __('Password') }}" />--}}
{{--                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />--}}
{{--            </div>--}}

{{--            <div class="block mt-4">--}}
{{--                <label for="remember_me" class="flex items-center">--}}
{{--                    <x-jet-checkbox id="remember_me" name="remember" />--}}
{{--                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>--}}
{{--                </label>--}}
{{--            </div>--}}

{{--            <div class="flex items-center justify-end mt-4">--}}
{{--                @if (Route::has('password.request'))--}}
{{--                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">--}}
{{--                        {{ __('Forgot your password?') }}--}}
{{--                    </a>--}}
{{--                @endif--}}

{{--                <x-jet-button class="ml-4">--}}
{{--                    {{ __('Log in') }}--}}
{{--                </x-jet-button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </x-jet-authentication-card>--}}
{{--</x-guest-layout>--}}