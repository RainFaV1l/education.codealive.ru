<div class="admin-panel-info-new-users__container">
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
    {{-- Подключение модальных окон --}}
    <x-modals.DeleteModal name="курса" funcName="destroy"/>
    <div class="admin-panel-info-new-users__header">
        <h3 class="admin-panel-info-new-users__title">Курсы</h3>
        <form wire:submit.prevent="searchCourses()" class="admin-panel-info-new-users__form">
            <input wire:model.debounce.250ms="search" type="search" placeholder="Поиск курсов по названию">
            <button type="submit">
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="6.5" cy="6.5" r="5.75" stroke="#1D1D39" stroke-opacity="0.6" stroke-width="1.5" />
                    <line x1="11.0607" y1="11" x2="16" y2="15.9393" stroke="#1D1D39" stroke-opacity="0.6" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </button>
        </form>
        <div class="admin-panel-info-new-users__buttons">
            <a href="{{ route('courses.add', null) }}" class="admin-panel-info-groups__button">Добавить курс</a>
        </div>
    </div>
    <div class="users-table courses-table">
        <div class="admin-panel-info-new-users__table new-users-table">
            <div class="new-users-table__item new-users-table__header">
                <p class="new-users-table__name id">id</p>
                <p class="new-users-table__name name">Название</p>
                <p class="new-users-table__name price">Цена</p>
                <p class="new-users-table__name author">Автор</p>
                <p class="new-users-table__name category">Категория</p>
                <p class="new-users-table__name category">Сложность</p>
                <p class="new-users-table__name date">Дата создания</p>
                <p class="new-users-table__name date">Дата изменения</p>
                <p class="new-users-table__name admin-control__buttons courses-buttons admin-control__hide">
                    <svg width="23" height="5" viewBox="0 0 23 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="2.5" cy="2.5" r="2.5" fill="transparent" />
                        <circle cx="11.5" cy="2.5" r="2.5" fill="transparent" />
                        <circle cx="20.5" cy="2.5" r="2.5" fill="transparent" />
                    </svg>
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.5098 3.49116H5.25977C3.1887 3.49116 1.50977 5.17009 1.50977 7.24116V19.7413C1.50977 21.8123 3.1887 23.4913 5.25977 23.4913H17.7598C19.8308 23.4913 21.5098 21.8123 21.5098 19.7413L21.5098 13.4912M7.75977 17.2412L12.3077 16.3248C12.5491 16.2761 12.7708 16.1573 12.9449 15.9831L23.1258 5.79655C23.6139 5.30817 23.6136 4.51651 23.1251 4.02853L20.9684 1.87428C20.48 1.38651 19.6888 1.38684 19.2009 1.87503L9.01889 12.0626C8.84513 12.2364 8.72648 12.4577 8.67779 12.6986L7.75977 17.2412Z" stroke="#6C63FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 5.625H22.5M8.75 1.875H16.25M10 18.125V10.625M15 18.125V10.625M16.875 23.125H8.125C6.74429 23.125 5.625 22.0057 5.625 20.625L5.05425 6.92704C5.02466 6.21688 5.59239 5.625 6.30317 5.625H18.6968C19.4076 5.625 19.9753 6.21688 19.9457 6.92704L19.375 20.625C19.375 22.0057 18.2557 23.125 16.875 23.125Z" stroke="#6C63FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </p>
            </div>
            <div class="row__items">
                @if (isset($courses))
                @foreach ($courses as $course)
                <div class="new-users-table__item new-users-table__header">
                    <p class="new-users-table__name id">id</p>
                    <p class="new-users-table__name name">Название</p>
                    <p class="new-users-table__name price">Цена</p>
                    <p class="new-users-table__name author">Автор</p>
                    <p class="new-users-table__name category">Категория</p>
                    <p class="new-users-table__name category">Сложность</p>
                    <p class="new-users-table__name date">Дата создания</p>
                    <p class="new-users-table__name date">Дата изменения</p>
                    <p class="new-users-table__name admin-control__buttons courses-buttons admin-control__hide">
                        <svg width="23" height="5" viewBox="0 0 23 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="2.5" cy="2.5" r="2.5" fill="transparent" />
                            <circle cx="11.5" cy="2.5" r="2.5" fill="transparent" />
                            <circle cx="20.5" cy="2.5" r="2.5" fill="transparent" />
                        </svg>
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.5098 3.49116H5.25977C3.1887 3.49116 1.50977 5.17009 1.50977 7.24116V19.7413C1.50977 21.8123 3.1887 23.4913 5.25977 23.4913H17.7598C19.8308 23.4913 21.5098 21.8123 21.5098 19.7413L21.5098 13.4912M7.75977 17.2412L12.3077 16.3248C12.5491 16.2761 12.7708 16.1573 12.9449 15.9831L23.1258 5.79655C23.6139 5.30817 23.6136 4.51651 23.1251 4.02853L20.9684 1.87428C20.48 1.38651 19.6888 1.38684 19.2009 1.87503L9.01889 12.0626C8.84513 12.2364 8.72648 12.4577 8.67779 12.6986L7.75977 17.2412Z" stroke="#6C63FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.5 5.625H22.5M8.75 1.875H16.25M10 18.125V10.625M15 18.125V10.625M16.875 23.125H8.125C6.74429 23.125 5.625 22.0057 5.625 20.625L5.05425 6.92704C5.02466 6.21688 5.59239 5.625 6.30317 5.625H18.6968C19.4076 5.625 19.9753 6.21688 19.9457 6.92704L19.375 20.625C19.375 22.0057 18.2557 23.125 16.875 23.125Z" stroke="#6C63FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </p>
                </div>
                <div class="new-users-table__item">
                    <p class="new-users-table__name id">{{ $course['id'] }}</p>
                    <p class="new-users-table__name name">{{ $course['name'] }}</p>
                    <p class="new-users-table__name price">{{ $course['price'] }}</p>
                    <p class="new-users-table__name author">
                        {{ App\Models\User::getFioShort($course->user->surname, $course->user->name, $course->user->patronymic) }}
                    </p>
                    <p class="new-users-table__name category">
                        {{ $course->category['name'] }}
                    </p>
                    <p class="new-users-table__name category">
                        {{ $course->level['name'] }}
                    </p>
                    <p class="new-users-table__name date">{{ $course['created_at'] }}</p>
                    <p class="new-users-table__name date">{{ $course['updated_at'] }}</p>
                    <p class="new-users-table__name admin-control__buttons courses-buttons">
                        <a href="{{ route('courses.more', $course['id']) }}">
                            <svg class="fill-svg" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.083 5.27345C7.76758 5.67384 4.7793 7.57325 3.02148 10.4053C2.87988 10.6299 2.62109 11.1133 2.44531 11.4746C2.1377 12.1094 2.12305 12.1485 2.12305 12.5C2.12305 12.8565 2.13281 12.8858 2.49414 13.6231C2.7041 14.0381 3.02637 14.6094 3.21191 14.8926C5.04297 17.6221 7.93848 19.375 11.2295 19.7315C11.9375 19.8096 13.7979 19.7608 14.4033 19.6533C15.9805 19.3701 17.377 18.8281 18.6025 18.0274C20.3555 16.8848 21.6201 15.4395 22.5527 13.5254C22.8604 12.8906 22.875 12.8516 22.875 12.5C22.875 12.1485 22.8604 12.1094 22.5527 11.4746C22.377 11.1133 22.1182 10.6299 21.9766 10.4053C20.3066 7.71486 17.582 5.89845 14.4033 5.34181C13.8613 5.24904 11.6738 5.20509 11.083 5.27345ZM13.3779 7.32423C16.0977 7.56837 18.5195 8.98927 20.0234 11.2256C20.2139 11.5039 20.4531 11.9043 20.5605 12.1143L20.751 12.5L20.5605 12.8858C19.3887 15.2149 17.0303 16.9922 14.418 17.5244C13.2412 17.7637 11.7861 17.7686 10.5947 17.5293C7.98242 17.0068 5.61426 15.2149 4.4375 12.8858L4.24707 12.5L4.4375 12.1143C4.90625 11.1817 5.75098 10.1172 6.54688 9.44826C8.47559 7.82716 10.8242 7.09962 13.3779 7.32423Z" fill="#6C63FF" />
                                <path d="M11.6338 8.42285C10.8086 8.61328 10.1543 8.97949 9.54395 9.58984C8.74805 10.3906 8.34766 11.3672 8.34766 12.5C8.34766 14.7949 10.1885 16.6504 12.4736 16.6504C13.6406 16.6504 14.6123 16.25 15.4326 15.4346C16.2432 14.6191 16.6484 13.6426 16.6484 12.5049C16.6484 11.6357 16.4287 10.9082 15.9551 10.2002C15.4277 9.40918 14.6953 8.85254 13.7773 8.54492C13.3477 8.39844 13.2402 8.38379 12.6201 8.36914C12.1562 8.35938 11.8389 8.37402 11.6338 8.42285ZM12.8447 10.4492C13.9482 10.6592 14.7197 11.709 14.5537 12.7783C14.4072 13.7109 13.709 14.4092 12.7764 14.5557C11.6875 14.7266 10.6426 13.9404 10.4424 12.8027C10.291 11.9629 10.7988 11.0107 11.5898 10.6396C12.0684 10.415 12.4004 10.3662 12.8447 10.4492Z" fill="#6C63FF" />
                            </svg>
                        </a>
                        <a href="{{ route('courses.admin.more', $course['id']) }}">
                            <svg width="23" height="5" viewBox="0 0 23 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="2.5" cy="2.5" r="2.5" fill="#6C63FF" />
                                <circle cx="11.5" cy="2.5" r="2.5" fill="#6C63FF" />
                                <circle cx="20.5" cy="2.5" r="2.5" fill="#6C63FF" />
                            </svg>
                        </a>
                        <a href="{{ route('courses.edit', $course['id']) }}">
                            <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.5098 3.49116H5.25977C3.1887 3.49116 1.50977 5.17009 1.50977 7.24116V19.7413C1.50977 21.8123 3.1887 23.4913 5.25977 23.4913H17.7598C19.8308 23.4913 21.5098 21.8123 21.5098 19.7413L21.5098 13.4912M7.75977 17.2412L12.3077 16.3248C12.5491 16.2761 12.7708 16.1573 12.9449 15.9831L23.1258 5.79655C23.6139 5.30817 23.6136 4.51651 23.1251 4.02853L20.9684 1.87428C20.48 1.38651 19.6888 1.38684 19.2009 1.87503L9.01889 12.0626C8.84513 12.2364 8.72648 12.4577 8.67779 12.6986L7.75977 17.2412Z" stroke="#6C63FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                        {{-- data-delete-id="{{ $course['id'] }}" class="delete-modal-open" --}}
                        <button wire:click.prevent="destroy( {{ $course['id'] }} )">
                            <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 5.625H22.5M8.75 1.875H16.25M10 18.125V10.625M15 18.125V10.625M16.875 23.125H8.125C6.74429 23.125 5.625 22.0057 5.625 20.625L5.05425 6.92704C5.02466 6.21688 5.59239 5.625 6.30317 5.625H18.6968C19.4076 5.625 19.9753 6.21688 19.9457 6.92704L19.375 20.625C19.375 22.0057 18.2557 23.125 16.875 23.125Z" stroke="#6C63FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </p>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
