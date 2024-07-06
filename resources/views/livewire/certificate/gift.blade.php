@extends('layouts.app')

@section('page-title') Поздравляем! @endsection

@section('padding-none') padding-none @endsection

@section('grey-bg') grey @endsection

@section('content')

<section class="gift" x-data="{ show: false }">
    {{-- Модальное окно отзыва --}}
    @include('livewire.modals.review-modal')
    <div class="container">
        <div class="content">
            <div class="img">
                <img src="{{ asset('assets/img/box.png') }}" alt="Подарок">
            </div>
            <div class="congratulate__header">
                <div class="congratulate">Поздравляем!</div>
                <p>Вы успешно прошли курс «{{ $course->name }}»</p>
            </div>
            <div class="gift-wrapper">
                <a href="{{ route('courses.showPdf', $course->id) }}" class="button one" target="_blank">Просмотреть сертификат</a>
                <a href="{{ route('courses.pdf', $course->id) }}" class="button one" target="_blank">Скачать сертификат</a>
                @php
                // Проверка на то, есть ли отзыв в таблице
                $courseService = new \App\Services\Course\Service();
                @endphp
                @if($courseService->isIsset($course->id, auth()->user()->id))
                <button @click.prevent="show = true" class="button two">Написать отзыв</button>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection