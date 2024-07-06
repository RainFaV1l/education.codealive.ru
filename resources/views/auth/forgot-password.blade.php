@extends('layouts.app')

@section('page-title') Восстановление пароля @endsection

@section('padding-none') padding-none @endsection

@section('content')
<div class="forgot-password">
    <div class="forgot-password__container container">
        <div class="forgot-password__header">
            <h2 class="forgot-password__title">Восстановление пароля</h2>
            <div class="forgot-password__subtitle">
                Забыли пароль? Без проблем. Просто сообщите нам свой адрес электронной почты, и мы отправим вам ссылку для сброса пароля, которая позволит вам выбрать новый.
            </div>
        </div>
        @if (session('status'))
        <div class="forgot-password__status">
            {{ session('status') }}
        </div>
        @endif

        {{-- <x-jet-validation-errors class="mb-4" /> --}}

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="error__input-column">
                <div class="input-column @error('email') error @enderror">
                    <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    <label for="email">Email</label>
                </div>
                @error('email')
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

{{-- <x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Забыли пароль? Без проблем. Просто сообщите нам свой адрес электронной почты, и мы отправим вам ссылку для сброса пароля, которая позволит вам выбрать новый.') }}
</div>

@if (session('status'))
<div class="mb-4 font-medium text-sm text-green-600">
    {{ session('status') }}
</div>
@endif

<x-jet-validation-errors class="mb-4" />

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="block">
        <x-jet-label for="email" value="{{ __('Email') }}" />
        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-jet-button>
            {{ __('Сбросить') }}
        </x-jet-button>
    </div>
</form>
</x-jet-authentication-card>
</x-guest-layout>
--}}
@endsection