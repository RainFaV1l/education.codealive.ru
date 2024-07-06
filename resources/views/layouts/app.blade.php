<!DOCTYPE html>
<html lang="ru">
    <!-- Подключение тега head -->
    @include('components.head')
    <body class="@yield('grey-bg')">
        {{-- Подключение модальных окон --}}
        @include('livewire.modals.course-subscribe-auth-modal')
        @include('livewire.modals.course-subscribe-error-modal')
        {{-- Мобильное меню --}}
        @include('livewire.modals.burger-modal')
        {{-- Сообщение о бета-тестировании --}}
        @include('livewire.modals.beta-message')
        {{-- Фон для меню --}}
        <div class="bg-black"></div>
        {{-- Preloader --}}
        <x-preloader/>
        {{-- Подключение уведомлений --}}
        @if (session()->has('success')) <x-notifications.notification type="success" text="{{ session('success') }}" />
        @elseif(session()->has('info')) <x-notifications.notification type="info" text="{{ session('info') }}" />
        @elseif(session()->has('error')) <x-notifications.notification type="error" text="{{ session('error') }}" />
        @elseif(session()->has('warning')) <x-notifications.notification type="warning" text="{{ session('warning') }}" />
        @endif
        {{-- Подключение уведомлений для коомпонента Livewire --}}
        <x-notifications.livewire-notification />
        {{-- Кнопка прокрутки наверх --}}
        <x-buttons.go-up-button/>
        <div class="wrapper">
            <div class="main-section @yield('gray-main-section') @yield('padding-none')">
                {{-- Подключение header --}}
                @include('components.header')
                {{-- Подключение banner --}}
                @yield('banner')
            </div>
            <main class="main">
                {{-- Подключение основного контента --}}
                @yield('content')
            </main>
            {{-- Подключение footer --}}
            @include('components.footer')
        </div>
    </body>
</html>