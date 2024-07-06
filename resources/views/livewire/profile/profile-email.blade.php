<div>
    <div class="profile__personal-password profile__personal-email">
        <div class="title-subtitle">
            <div class="title">Смена email</div>
            @auth()
            @isset(auth()->user()->email_verified_at)
            <p class="subtitle verified">Ваш email подтвержден.</p>
            @endif
            @endauth
            <div class="subtitle"></div>
        </div>
        @if(App\Http\Livewire\Profile\ProfileEmail::checkIsExistChangeEmailCode())
        <form wire:submit.prevent="updateEmail()">
            @else
            <form wire:submit.prevent="getChangeEmailCode()">
                @endif
                <div class="form__item">
                    <div class="error__input-column">
                        <div class="input-column @error('email') error @enderror @error('invalid_email') error @enderror">
                            <input wire:ignore value="{{ $email }}" wire:model="email" class="input" id="profile-password_1" type="text" required autofocus autocomplete="email">
                            <label for="profile-password_1">Email</label>
                        </div>
                        @error('invalid_email')
                        <div class="input-column-error__text"> {{ $message }}</div>
                        @enderror
                        @error('email')
                        <div class="input-column-error__text"> {{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form__item">
                    <div class="error__input-column">
                        @if(App\Http\Livewire\Profile\ProfileEmail::checkIsExistChangeEmailCode())
                        <div class="input-column @error('invalid') error @enderror @error('code') error @enderror">
                            <input wire:ignore wire:model="code" class="input" id="profile-new-password" type="text" required autofocus>
                            <label for="profile-new-password">Код подтверждения</label>
                        </div>
                        @error('code')
                        <div class="input-column-error__text"> {{ $message }}</div>
                        @enderror
                        @else
                        <div class="input-column @error('invalid') error @enderror @error('password') error @enderror">
                            <input wire:ignore wire:model="password" class="input" id="profile-new-password" type="password" required autofocus>
                            <label for="profile-new-password">Пароль</label>
                        </div>
                        @error('invalid_password')
                        <div class="input-column-error__text"> {{ $message }}</div>
                        @enderror
                        @error('password')
                        <div class="input-column-error__text"> {{ $message }}</div>
                        @enderror
                        @endif
                    </div>
                </div>
                <div class="form__item-button">
                    <button type="submit" class="button">Сохранить</button>
                </div>
            </form>
    </div>
</div>