<!DOCTYPE html>
<html lang="ru">

@include('components.head')

{{-- Подключение уведомлений --}}
@if (session()->has('success'))
<x-notifications.notification type="success" text="{{ session('success') }}" />
@elseif(session()->has('info'))
<x-notifications.notification type="info" text="{{ session('info') }}" />
@elseif(session()->has('error'))
<x-notifications.notification type="error" text="{{ session('error') }}" />
@elseif(session()->has('warning'))
<x-notifications.notification type="warning" text="{{ session('warning') }}" />
@endif

{{-- Подключение уведомлений для коомпонента Livewire --}}
<x-notifications.livewire-notification />

{{-- Preloader --}}
<div class="preloader" id="preloader">
    <div class="lds-roller">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>

{{-- Кнопка прокрутки наверх --}}
<a href="{{ url()->full() }}" class="up">
    <div class="banner-line__figure">
        <svg width="16" height="22" viewBox="0 0 16 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.12688 0.81572C7.5174 0.425196 8.15057 0.425196 8.54109 0.81572L14.9051 7.17968C15.2956 7.57021 15.2956 8.20337 14.9051 8.59389C14.5145 8.98442 13.8814 8.98442 13.4908 8.59389L7.83398 2.93704L2.17713 8.59389C1.78661 8.98442 1.15344 8.98442 0.762917 8.59389C0.372392 8.20337 0.372392 7.57021 0.762917 7.17968L7.12688 0.81572ZM6.83398 21.5228L6.83398 11.5228H8.83398L8.83398 21.5228H6.83398ZM6.83398 11.5228L6.83398 1.52283H8.83398L8.83398 11.5228H6.83398Z" fill="white" />
        </svg>
    </div>
</a>

<body class="grey">
    @include('livewire.modals.burger-modal')
    <div class="bg-black"></div>
    @include('components.admin-header')
    <main>
        @yield('content')
    </main>
    @include('components.admin-footer')
</body>

</html>