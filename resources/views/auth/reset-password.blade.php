@extends('layouts.app')

@section('page-title') Восстановление пароля @endsection

@section('padding-none') padding-none @endsection

@section('content')
    <div class="forgot-password">
        <div class="forgot-password__container container">
            <div class="forgot-password__header">
                <h2 class="forgot-password__title">Восстановление пароля</h2>
            </div>

            {{-- <x-jet-validation-errors class="mb-4" /> --}}

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="error__input-column">
                    <div class="input-column @error('email') error @enderror">
                        <input class="input" id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus>
                        <label for="email">Email</label>
                    </div>
                    @error('email')
                        <div class="input-column-error__text"> {{ $message }}</div>
                    @enderror
                </div>

                <div class="error__input-column">
                    <div class="input-column @error('password') error @enderror">
                        <input class="input" id="password" type="password" name="password" required autofocus>
                        <label for="password">Пароль</label>
                    </div>
                    @error('password')
                        <div class="input-column-error__text"> {{ $message }}</div>
                    @enderror
                </div>

                
                <div class="error__input-column">
                    <div class="input-column @error('password_confirmation') error @enderror">
                        <input class="input" id="password_confirmation" type="password" name="password_confirmation" required autofocus>
                        <label for="password_confirmation">Подтвердите пароль</label>
                    </div>
                    @error('password_confirmation')
                        <div class="input-column-error__text"> {{ $message }}</div>
                    @enderror
                </div>


                <button type="submit" class="button">Сбросить</button>

                {{-- 
                    <div class="block">
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-jet-button>
                            {{ __('Сбросить') }}
                        </x-jet-button>
                    </div>
                --}}

            </form>
        </div>
    </div>
@endsection


{{-- 
    <x-guest-layout>
        <x-jet-authentication-card>
            <x-slot name="logo">
                <x-jet-authentication-card-logo />
            </x-slot>

            <x-jet-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="block">
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                </div>

                <div class="mt-4">
                    <x-jet-label for="password" value="{{ __('Password') }}" />
                    <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-jet-button>
                        {{ __('Сбросить пароль') }}
                    </x-jet-button>
                </div>
            </form>
        </x-jet-authentication-card>
    </x-guest-layout>
--}}