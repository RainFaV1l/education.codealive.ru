<div class="admin-panel-info__tables">
    <div class="admin-panel-info__new-users admin-panel-info-new-users admin-panel-info-users">
        <div class="admin-panel-info-new-users__container">
            <div class="admin-panel-info-new-users__header">
                <h3 class="admin-panel-info-new-users__title">{{ $groupInfo->name }}</h3>
                <form wire:submit.prevent="search()" class="admin-panel-info-new-users__form">
                    <input wire:model.debounce.500ms="search" type="search" placeholder="Поиск по пользователям">
                    <button type="submit">
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="6.5" cy="6.5" r="5.75" stroke="#1D1D39" stroke-opacity="0.6" stroke-width="1.5" />
                            <line x1="11.0607" y1="11" x2="16" y2="15.9393" stroke="#1D1D39" stroke-opacity="0.6" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </button>
                </form>
                <div class="admin-panel-info-new-users__buttons">
                    <a href="{{ route('groups.addView') }}" class="admin-panel-info-groups__button">Добавить группу</a>
                </div>
            </div>
            <div class="users-table group-users-table">
                <div class="admin-panel-info-new-users__table new-users-table">
                    <div class="new-users-table__item new-users-table__header">
                        <p class="new-users-table__name id">№</p>
                        <p class="new-users-table__name name">Имя</p>
                        <p class="new-users-table__name surname">Фамилия</p>
                        <p class="new-users-table__name patronymic">Отчество</p>
                        <p class="new-users-table__name last-auth-date">Дата входа</p>
                        <p class="new-users-table__name admin-control__buttons admin-control__hide buttons">
                            <svg width="23" height="5" viewBox="0 0 23 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="2.5" cy="2.5" r="2.5" fill="transparent" />
                                <circle cx="11.5" cy="2.5" r="2.5" fill="transparent" />
                                <circle cx="20.5" cy="2.5" r="2.5" fill="transparent" />
                            </svg>
                            <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.5 5.625H22.5M8.75 1.875H16.25M10 18.125V10.625M15 18.125V10.625M16.875 23.125H8.125C6.74429 23.125 5.625 22.0057 5.625 20.625L5.05425 6.92704C5.02466 6.21688 5.59239 5.625 6.30317 5.625H18.6968C19.4076 5.625 19.9753 6.21688 19.9457 6.92704L19.375 20.625C19.375 22.0057 18.2557 23.125 16.875 23.125Z" stroke="#6C63FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </p>
                    </div>
                    <div class="row__items">
                        @if(isset($groupUsers))
                        @foreach($groupUsers as $index => $groupUser)
                        <div class="new-users-table__item new-users-table__header">
                            <p class="new-users-table__name id">№</p>
                            <p class="new-users-table__name name">Имя</p>
                            <p class="new-users-table__name surname">Фамилия</p>
                            <p class="new-users-table__name patronymic">Отчество</p>
                            <p class="new-users-table__name last-auth-date">Дата входа</p>
                            <p class="new-users-table__name admin-control__buttons admin-control__hide buttons">
                                <svg width="23" height="5" viewBox="0 0 23 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="2.5" cy="2.5" r="2.5" fill="transparent" />
                                    <circle cx="11.5" cy="2.5" r="2.5" fill="transparent" />
                                    <circle cx="20.5" cy="2.5" r="2.5" fill="transparent" />
                                </svg>
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.5 5.625H22.5M8.75 1.875H16.25M10 18.125V10.625M15 18.125V10.625M16.875 23.125H8.125C6.74429 23.125 5.625 22.0057 5.625 20.625L5.05425 6.92704C5.02466 6.21688 5.59239 5.625 6.30317 5.625H18.6968C19.4076 5.625 19.9753 6.21688 19.9457 6.92704L19.375 20.625C19.375 22.0057 18.2557 23.125 16.875 23.125Z" stroke="#6C63FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </p>
                        </div>
                        <div class="new-users-table__item" wire:key="{{ $groupUser->user_id }}">
                            <p class="new-users-table__name id">{{ $groupUser->pautina_id ? $groupUser->pautina_id : $groupUser->user_id }}</p>
                            <p class="new-users-table__name name">{{ $groupUser->name }}</p>
                            <p class="new-users-table__name surname">{{ $groupUser->surname }}</p>
                            <p class="new-users-table__name patronymic">{{ $groupUser->patronymic }}</p>
                            <p class="new-users-table__name last-auth-dat">{{ $groupUser->last_auth_date }}</p>
                            <p class="new-users-table__name admin-control__buttons lessons-buttons">
                                <a href="{{ route('groups.moreUser', [$groupInfo->id, $groupUser->user_id]) }}">
                                    <svg width="23" height="5" viewBox="0 0 23 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="2.5" cy="2.5" r="2.5" fill="#6C63FF" />
                                        <circle cx="11.5" cy="2.5" r="2.5" fill="#6C63FF" />
                                        <circle cx="20.5" cy="2.5" r="2.5" fill="#6C63FF" />
                                    </svg>
                                </a>
                                <button wire:click="delete({{ $groupUser->user_id }})">
                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.5 5.625H22.5M8.75 1.875H16.25M10 18.125V10.625M15 18.125V10.625M16.875 23.125H8.125C6.74429 23.125 5.625 22.0057 5.625 20.625L5.05425 6.92704C5.02466 6.21688 5.59239 5.625 6.30317 5.625H18.6968C19.4076 5.625 19.9753 6.21688 19.9457 6.92704L19.375 20.625C19.375 22.0057 18.2557 23.125 16.875 23.125Z" stroke="#6C63FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </p>
                        </div>
                        @endforeach
                        @else

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>