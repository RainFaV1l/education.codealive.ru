@extends('layouts.app-dashboard')

@section('page-title')
    Страница курса
@endsection

@section('content')
    <section class="admin-panel">
        <div class="admin-panel__container">
            <div class="admin-panel-content">
                @include('components.admin-aside')
                <div class="admin-panel-content__content">
                    <div class="admin-panel-content-aside__header admin-panel-content-aside-header">
                        <div class="admin-panel-content-aside-header__container">
                            <h1 class="admin-panel-content-aside-header__title">Панель администратора</h1>
                            <p class="admin-panel-content-aside-header__subtitle">Информация о уроках курса</p>
                            <div class="admin-panel-line"></div>
                        </div>
                    </div>
                    <div class="admin-panel-info__tables">
                        <div class="admin-panel-info__new-users admin-panel-info-new-users admin-panel-info-users">
                            @livewire('dashboard.course-lessons-show', ['course_id' => $course_id])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection('content')
