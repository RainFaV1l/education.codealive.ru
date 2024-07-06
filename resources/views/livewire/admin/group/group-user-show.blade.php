<div class="admin-panel-info__tables">
    <div class="admin-panel-info__new-users admin-panel-info-new-users admin-panel-info-users">
        <div class="admin-panel-info-new-users__container">
            <div class="admin-panel-info-new-users__header">
                <h3 class="admin-panel-info-new-users__title">Курсы группы (Пользователь)</h3>
                <div class="admin-panel-info-new-users__buttons">
                    <a href="{{ route('groups.addView') }}" class="admin-panel-info-groups__button">Добавить группу</a>
                </div>
            </div>
            <div class="users-table group-courses-user-table">
                <div class="admin-panel-info-new-users__table new-users-table">
                    <div class="new-users-table__item new-users-table__header">
                        <p class="new-users-table__name id">id курса</p>
                        <p class="new-users-table__name surname">Фамилия</p>
                        <p class="new-users-table__name name">Название курса</p>
                        <p class="new-users-table__name status">Статус курса</p>
                        <p class="new-users-table__name all-status">Общий статуc</p>
                        <p class="new-users-table__name admin-control__buttons admin-control__hide buttons">
                            <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.8639 10.6986L11.9375 16.625L9.91735 14.6049M13.5 1C6.59644 1 1 6.59644 1 13.5C1 20.4036 6.59644 26 13.5 26C20.4036 26 26 20.4036 26 13.5C26 6.59644 20.4036 1 13.5 1Z" stroke="#6C63FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg" class="fill-svg">
                                <path d="M18.6265 9.78769C19.017 9.39717 19.017 8.764 18.6265 8.37348C18.236 7.98295 17.6028 7.98295 17.2123 8.37348L18.6265 9.78769ZM8.37348 17.2123C7.98295 17.6028 7.98295 18.236 8.37348 18.6265C8.764 19.017 9.39716 19.017 9.78769 18.6265L8.37348 17.2123ZM17.2123 18.6265C17.6028 19.017 18.236 19.017 18.6265 18.6265C19.017 18.236 19.017 17.6028 18.6265 17.2123L17.2123 18.6265ZM9.78769 8.37348C9.39716 7.98295 8.764 7.98295 8.37348 8.37348C7.98295 8.764 7.98295 9.39716 8.37348 9.78769L9.78769 8.37348ZM25 13.5C25 19.8513 19.8513 25 13.5 25V27C20.9558 27 27 20.9558 27 13.5H25ZM13.5 25C7.14873 25 2 19.8513 2 13.5H0C0 20.9558 6.04416 27 13.5 27V25ZM2 13.5C2 7.14873 7.14873 2 13.5 2V0C6.04416 0 0 6.04416 0 13.5H2ZM13.5 2C19.8513 2 25 7.14873 25 13.5H27C27 6.04416 20.9558 0 13.5 0V2ZM17.2123 8.37348L12.7929 12.7929L14.2071 14.2071L18.6265 9.78769L17.2123 8.37348ZM12.7929 12.7929L8.37348 17.2123L9.78769 18.6265L14.2071 14.2071L12.7929 12.7929ZM18.6265 17.2123L14.2071 12.7929L12.7929 14.2071L17.2123 18.6265L18.6265 17.2123ZM14.2071 12.7929L9.78769 8.37348L8.37348 9.78769L12.7929 14.2071L14.2071 12.7929Z" fill="#6C63FF" />
                            </svg>
                        </p>
                    </div>
                    <div class="row__items">
                        @if(isset($courses))
                        @foreach($courses as $course)
                        <div class="new-users-table__item new-users-table__header">
                            <p class="new-users-table__name id">id курса</p>
                            <p class="new-users-table__name surname">Фамилия</p>
                            <p class="new-users-table__name name">Название курса</p>
                            <p class="new-users-table__name status">Статус курса</p>
                            <p class="new-users-table__name all-status">Общий статуc</p>
                            <p class="new-users-table__name admin-control__buttons admin-control__hide buttons">
                                <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.8639 10.6986L11.9375 16.625L9.91735 14.6049M13.5 1C6.59644 1 1 6.59644 1 13.5C1 20.4036 6.59644 26 13.5 26C20.4036 26 26 20.4036 26 13.5C26 6.59644 20.4036 1 13.5 1Z" stroke="#6C63FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg" class="fill-svg">
                                    <path d="M18.6265 9.78769C19.017 9.39717 19.017 8.764 18.6265 8.37348C18.236 7.98295 17.6028 7.98295 17.2123 8.37348L18.6265 9.78769ZM8.37348 17.2123C7.98295 17.6028 7.98295 18.236 8.37348 18.6265C8.764 19.017 9.39716 19.017 9.78769 18.6265L8.37348 17.2123ZM17.2123 18.6265C17.6028 19.017 18.236 19.017 18.6265 18.6265C19.017 18.236 19.017 17.6028 18.6265 17.2123L17.2123 18.6265ZM9.78769 8.37348C9.39716 7.98295 8.764 7.98295 8.37348 8.37348C7.98295 8.764 7.98295 9.39716 8.37348 9.78769L9.78769 8.37348ZM25 13.5C25 19.8513 19.8513 25 13.5 25V27C20.9558 27 27 20.9558 27 13.5H25ZM13.5 25C7.14873 25 2 19.8513 2 13.5H0C0 20.9558 6.04416 27 13.5 27V25ZM2 13.5C2 7.14873 7.14873 2 13.5 2V0C6.04416 0 0 6.04416 0 13.5H2ZM13.5 2C19.8513 2 25 7.14873 25 13.5H27C27 6.04416 20.9558 0 13.5 0V2ZM17.2123 8.37348L12.7929 12.7929L14.2071 14.2071L18.6265 9.78769L17.2123 8.37348ZM12.7929 12.7929L8.37348 17.2123L9.78769 18.6265L14.2071 14.2071L12.7929 12.7929ZM18.6265 17.2123L14.2071 12.7929L12.7929 14.2071L17.2123 18.6265L18.6265 17.2123ZM14.2071 12.7929L9.78769 8.37348L8.37348 9.78769L12.7929 14.2071L14.2071 12.7929Z" fill="#6C63FF" />
                                </svg>
                            </p>
                        </div>
                        <div class="new-users-table__item" wire:key="{{ $course->id }}">
                            <p class="new-users-table__name id">{{ $course->id }}</p>
                            <p class="new-users-table__name surname">{{ $user->surname }}</p>
                            <p class="new-users-table__name name">{{ $course->name }}</p>
                            @php

                            // Получаем экземпляр класса
                            $groupUserShow = new \App\Http\Livewire\Admin\Group\GroupUserShow();

                            // Получаем результат статуса курса
                            $result = $groupUserShow->checkCourseStatus($course->id, $user_id);

                            // Получаем результат, выдан ли сертификат
                            $certificate = $groupUserShow->checkCourseAllStatus($course->id, $user_id);

                            @endphp

                            @if($result['result'] === 100)
                            <p class="new-users-table__name status completed">Пройдено на {{ $result['result'] }}%</p>
                            @else
                            <p class=" new-users-table__name status active">Пройдено на {{ round($result['result']) }}%</p>
                            @endif
                            @if($certificate)
                            <p class="new-users-table__name all-status completed">Сертификат выдан</p>
                            @else
                            <p class=" new-users-table__name all-status active">Сертификат не выдан</p>
                            @endif
                            <p class="new-users-table__name admin-control__buttons lessons-buttons">
                                <button wire:click="issue({{ $course->id }}, {{ $user_id }})">
                                    <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.8639 10.6986L11.9375 16.625L9.91735 14.6049M13.5 1C6.59644 1 1 6.59644 1 13.5C1 20.4036 6.59644 26 13.5 26C20.4036 26 26 20.4036 26 13.5C26 6.59644 20.4036 1 13.5 1Z" stroke="#6C63FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                                <button wire:click="cancel({{ $course->id }}, {{ $user_id }})">
                                    <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg" class="fill-svg">
                                        <path d="M18.6265 9.78769C19.017 9.39717 19.017 8.764 18.6265 8.37348C18.236 7.98295 17.6028 7.98295 17.2123 8.37348L18.6265 9.78769ZM8.37348 17.2123C7.98295 17.6028 7.98295 18.236 8.37348 18.6265C8.764 19.017 9.39716 19.017 9.78769 18.6265L8.37348 17.2123ZM17.2123 18.6265C17.6028 19.017 18.236 19.017 18.6265 18.6265C19.017 18.236 19.017 17.6028 18.6265 17.2123L17.2123 18.6265ZM9.78769 8.37348C9.39716 7.98295 8.764 7.98295 8.37348 8.37348C7.98295 8.764 7.98295 9.39716 8.37348 9.78769L9.78769 8.37348ZM25 13.5C25 19.8513 19.8513 25 13.5 25V27C20.9558 27 27 20.9558 27 13.5H25ZM13.5 25C7.14873 25 2 19.8513 2 13.5H0C0 20.9558 6.04416 27 13.5 27V25ZM2 13.5C2 7.14873 7.14873 2 13.5 2V0C6.04416 0 0 6.04416 0 13.5H2ZM13.5 2C19.8513 2 25 7.14873 25 13.5H27C27 6.04416 20.9558 0 13.5 0V2ZM17.2123 8.37348L12.7929 12.7929L14.2071 14.2071L18.6265 9.78769L17.2123 8.37348ZM12.7929 12.7929L8.37348 17.2123L9.78769 18.6265L14.2071 14.2071L12.7929 12.7929ZM18.6265 17.2123L14.2071 12.7929L12.7929 14.2071L17.2123 18.6265L18.6265 17.2123ZM14.2071 12.7929L9.78769 8.37348L8.37348 9.78769L12.7929 14.2071L14.2071 12.7929Z" fill="#6C63FF" />
                                    </svg>
                                </button>
                            </p>
                        </div>
                        @endforeach
                        @else
                        Ничего не найдено
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>