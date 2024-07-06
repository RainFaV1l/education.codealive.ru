@extends('layouts.app')

@section('page-title') {{ $course->name }} @endsection

@section('footer-gray-color') footer-gray-color @endsection

@section('content')
<section class="direction-banner">
    <div class="container">
        <div class="direction-banner__wrapper">
            <div class="direction-banner__head">
                <a href="{{ route('index.index') }}">Главная</a>
                <p>/</p>
                <a href="{{ route('catalog.index') }}">Каталог</a>
                <p>/</p>
                <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), $course['id']) }}">{{ $course->name }}</a>
            </div>
            <div class="direction-banner__main">
                <div class="direction-banner__info">
                    <div class="direction-title-text">
                        <div class="direction-banner__title">
                            {{ $course->name }}
                        </div>
                        <div class="direction-banner__text">
                            {{ $course->description }}
                        </div>
                    </div>
                    @auth
                        @if(\Illuminate\Support\Facades\Auth::user()->role_id === 1)
                            @if(\App\Models\CourseUser::checkSubscribe($course->id))
                                <a class="button" href="{{ route('courses.index') }}">Продолжить обучение</a>
{{--                                <button class="button subscribe-course-error-modal-button">Заявка отправлена</button>--}}
                            @else
                                @livewire('course.course-subscribe', ['course_id' => $course['id']])
                            @endif
                        @endif
                    @endauth
                    @guest()
                        <button class="button guest-subscribe-course-modal-button">Записаться</button>
                    @endguest
                </div>
                <div class="direction-banner__img">
                    <img src="{{ $course->icon_url }}" alt="Иконка баннера">
                </div>
            </div>
            <div class="direction-banner__end">
                <div class="direction-banner__lessons">
                    <p>Уровень - {{ $course->level['name'] }}</p>
                    <p>Категория - {{ $course->category['name'] }}</p>
                    <p>{{ \App\Models\CourseUser::formatCount($allLessonsCount) }}</p>
                </div>
                <div class="direction-banner__creator">
                    Автор курса:
                    {{ \App\Models\User::getFioShort($course->user->surname, $course->user->name, $course->user->patronymic) }}
                </div>
            </div>
        </div>
    </div>
</section>
<section class="proposal">
    <div class="container">
        <div class="title">
            <h2>Что мы предлагаем?</h2>
            <div class="line"></div>
        </div>
        <div class="proposal-wrapper">
            <div class="proposal__item">
                <div class="img">
                    <img src="{{ asset('assets/img/p1.png') }}" alt="Преимущество 1">
                </div>
                <div class="proposal__title-text">
                    <h3>Работа с куратором</h3>
                    <p>Курсы предусматривают очные встречи с куратороми для объяснения темы</p>
                </div>
            </div>
            <div class="proposal__item">
                <div class="img">
                    <img src="{{ asset('assets/img/p2.png') }}" alt="Преимущество 2">
                </div>
                <div class="proposal__title-text">
                    <h3>Открытый доступ</h3>
                    <p>Мы гарантируем неограниченный доступ к купленным вами курсам.</p>
                </div>
            </div>
            <div class="proposal__item">
                <div class="img">
                    <img src="{{ asset('assets/img/p3.png') }}" alt="Преимущество 3">
                </div>
                <div class="proposal__title-text">
                    <h3>Много практики</h3>
                    <p>Мы используем практический метод обучения. Меньше лекций, больше практики!</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="how">
    <div class="container">
        <div class="title">
            <h2>Как проходит обучение?</h2>
            <div class="line line1"></div>
        </div>
        <div class="how-wrapper">
            <div class="how__info">
                <div class="how__item">
                    <div class="number">
                        01
                    </div>
                    <div class="proposal__title-text">
                        <h3>Выбрать направление</h3>
                        <p>Во первых, необходимо определиться с выбором направления. Это можно сделать
                            самостоятельно в сети интернет или обратиться к нашим специалистам.
                        </p>
                    </div>
                </div>
                <div class="how__item">
                    <div class="number">
                        02
                    </div>
                    <div class="proposal__title-text">
                        <h3>Авторизоваться</h3>
                        <p>Для записи на курс необходиом авторизоваться на сайте. Авторизация проходит наиболее
                            удобным для пользователя образом.
                        </p>
                    </div>
                </div>
                <div class="how__item">
                    <div class="number">
                        03
                    </div>
                    <div class="proposal__title-text">
                        <h3>Подать заявку</h3>
                        <p>Для выбора направления необходимо подать заявку, заполнив форму подачи заявки некоторыми
                            данными и подождать одобрение заявки.
                        </p>
                    </div>
                </div>
                <div class="how__item">
                    <div class="number">
                        04
                    </div>
                    <div class="proposal__title-text">
                        <h3>Начать обучение</h3>
                        <p>Остается только просмотреть курс и решить задачи, которые максимально близки к реальным
                            задачам и загрузить решения на сервер.
                        </p>
                    </div>
                </div>
            </div>
            <div class="how__img">
                <img src="{{ asset('assets/img/how.png') }}" alt="Как начать обучение?">
            </div>
        </div>
    </div>
</section>
<section class="program">
    <div class="container">
        <div class="title">
            <h2>Программа обучения</h2>
            <div class="line"></div>
        </div>
        <div class="program-lessons">
            <p><span>{{ $allLessonsCount }}</span> {{ \App\Models\CourseUser::formatCount($allLessonsCount, true) }}</p>
        </div>
        <div class="program-themes">
            @foreach ($course->lessons as $lesson)
                <x-accordion-item :item="$lesson" number="lesson_number" name="name">{{ $lesson['preview_description'] }}</x-accordion-item>
            @endforeach
        </div>
    </div>
</section>
<section class="reviews section-padding">
    <div class="container">
        <div class="title">
            <h2>Отзыв на курс</h2>
            <div class="line line1"></div>
        </div>
        <div class="score">
            <p>Средняя оценка курса {{ $avgRating }} из 5</p>
            <img src="{{ asset('assets/img/star.svg') }}" alt="Отзыв">
        </div>
    </div>
    <div class="reviews-slider__wrapper">
        <div class="swiper reviews-slider">
            <div class="swiper-wrapper">
                @foreach($reviews as $review)
                <div class="swiper-slide">
                    <div class="text">
                        «{{ $review->description }}»
                    </div>
                    <div class="user">
                        <div class="ava">
                            @if(!empty($review->user->profile_photo_path))
                            <img src="{{ $review->user->user_url }}" alt="Аватарка пользователя">
                            @else
                            <img src="{{ asset('assets/avatar/gamer.webp') }}" alt="Аватарка пользователя">
                            @endif
                        </div>
                        <div class="name">
                            {{ $review->user->surname . ' ' . $review->user->name }}
                        </div>
                        <div class="rating">
                            @switch($review->rating)
                            @case(5)
                            <img src="{{asset('assets/img/reviews/stars/star_5.webp')}}" alt="Рейтинг оценки 5">
                            @break
                            @case(4)
                            <img src="{{asset('assets/img/reviews/stars/star_4.webp')}}" alt="Рейтинг оценки 4">
                            @break
                            @case(3)
                            <img src="{{asset('assets/img/reviews/stars/star_3.webp')}}" alt="Рейтинг оценки 3">
                            @break
                            @case(2)
                            <img src="{{asset('assets/img/reviews/stars/star_2.webp')}}" alt="Рейтинг оценки 2">
                            @break
                            @case(1)
                            <img src="{{asset('assets/img/reviews/stars/star_1.webp')}}" alt="Рейтинг оценки 1">
                            @break
                            @endswitch
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="slider-buttons">
                <div class="prev">
                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="30" cy="30" r="30" transform="rotate(-180 30 30)" fill="url(#paint0_linear_331_1787)" />
                        <path d="M34 18L20.9407 28.7273C20.4537 29.1273 20.4537 29.8727 20.9407 30.2727L34 41" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <defs>
                            <linearGradient id="paint0_linear_331_1787" x1="1.90735e-06" y1="-1.90735e-06" x2="60" y2="60" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#F8A4D8" />
                                <stop offset="1" stop-color="#6C63FF" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="next">
                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="30" cy="30" r="30" fill="url(#paint0_linear_723_3663)" />
                        <path d="M26 42L39.0593 31.2727C39.5463 30.8727 39.5463 30.1273 39.0593 29.7273L26 19" stroke="white" stroke-width="3" stroke-linecap="round" />
                        <defs>
                            <linearGradient id="paint0_linear_723_3663" x1="0" y1="0" x2="60" y2="60" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#F8A4D8" />
                                <stop offset="1" stop-color="#6C63FF" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="subscribe__now subscribe section-padding">
    <div class="container">
        <div class="subscribe__row">
            <div class="subscribe__column">
                <div class="subscribe__title-subtitle">
                    <h1 class="subscribe__title">Начни развиваться вместе с нами!</h1>
                    <p class="subscribe__text">Подай заявку и учись вместе с нами! Пройдя курс ты познаешь
                        много новой, полезной и интересной информации.</p>
                </div>
                @auth
                @if(\Illuminate\Support\Facades\Auth::user()->role_id === 1)
                @if(\App\Models\CourseUser::checkSubscribe($course->id))
                <button class="button subscribe-course-error-modal-button">Заявка отправлена</button>
                @else
                @livewire('course.course-subscribe', ['course_id' => $course['id']])
                @endif
                @endif
                @endauth
                @guest()
                <button class="button guest-subscribe-course-modal-button">Записаться на курс</button>
                @endguest
                {{-- <a href="#" class="subscribe__button">Записаться на курс</a>--}}
            </div>
            <div class="subscribe__icon">
                <img src="{{ asset('assets/img/subscribe.png') }}" alt="icon">
            </div>
        </div>
    </div>
</section>
@endsection('content')