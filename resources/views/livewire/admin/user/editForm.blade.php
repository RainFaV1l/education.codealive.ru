<div class="admin-panel-info__tables">
    <div class="admin-panel-info__new-users admin-panel-info-new-users admin-panel-info-users">
        <div class="admin-panel-info-new-users__container admin-crud">
            <div class="add-course__form add-course-form">
                <form class="course-edit-form" method="post" wire:submit.prevent="save()" enctype="multipart/form-data">
                    @csrf
                    <input wire:ignore wire:model="name" type="text" class="add-course-form__input" placeholder="Имя">
                    @error('name')
                    {{ $message }}
                    @enderror
                    <input wire:ignore wire:model="surname" type="text" class="add-course-form__input" placeholder="Фамилия">
                    @error('surname')
                    {{ $message }}
                    @enderror
                    <input wire:ignore wire:model="patronymic" type="text" class="add-course-form__input" placeholder="Отчество">
                    @error('patronymic')
                    {{ $message }}
                    @enderror
                    <input wire:ignore wire:model="email" type="email" class="add-course-form__input" placeholder="Email">
                    @error('email')
                    {{ $message }}
                    @enderror
                    <input wire:ignore wire:model="password" type="password" class="add-course-form__input" placeholder="Установить новый пароль">
                    @error('password')
                    {{ $message }}
                    @enderror
                    <select wire:model="role_id" class="add-course-form__input add-course-form__select">
                        @foreach ($roles as $role)
                        <option @if ($role_id===$role->id) selected @endif value="{{ $role->id }}">
                            {{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('role_id')
                    {{ $message }}
                    @enderror
                    <div class="add-course-column-button">
                        <a href="{{ route('dashboard.users') }}" class="admin-panel-info-new-users__button">Назад</a>
                        <button type="submit" class="admin-panel-info-groups__button">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>