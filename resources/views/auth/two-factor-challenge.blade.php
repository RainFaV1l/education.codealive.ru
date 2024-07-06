<x-guest-layout>
    <div class="two-factor-challenge">
        <div class="two-factor-challenge__container container">
            <div class="two-factor-challenge__content" x-data="{ recovery: false }">
                <div class="two-factor-challenge__header">
                    <h1 class="two-factor-challenge__title">Вход в аккаунт</h1>
                    <p class="two-factor-challenge__subtitle" x-show="!recovery">Пожалуйста, подтвердите доступ к своей учетной записи, введя код аутентификации, предоставленный вашим приложением для аутентификации.</p>
                    <div class="two-factor-challenge__text"  x-show="recovery">Пожалуйста, подтвердите доступ к своей учетной записи, введя один из ваших кодов аварийного восстановления.</div>
                </div>
                <div class="two-factor-challenge__form">
                    <form action="{{ route('two-factor.login') }}" method="post" class="reg-form">
                    @csrf
                    <div class="error__input-column"  x-show="! recovery">
                        <div class="input-column @error('code') error @enderror">
                            <input id="reg-surname" type="text" name="code" class="input" value="{{old('code')}}" autofocus autocomplete="one-time-code">
                            <label for="reg-surname">Код</label>
                        </div>
                        @error('code')
                            <div class="input-column-error__text"> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="error__input-column"  x-show="recovery">
                        <div class="input-column @error('recovery_code') error @enderror">
                        <input id="reg-surname" type="text" name="recovery_code" class="input" value="{{old('recovery_code')}}" autocomplete="one-time-code">
                                <label for="reg-surname">Код восстановления</label>
                        </div>
                        @error('recovery_code')
                            <div class="input-column-error__text"> {{ $message }}</div>
                        @enderror
                    </div>
                    <button type="button" class="recovery-swap__button underline"
                                    x-show="! recovery"
                                    x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                        {{ __('Использовать код восстановления') }}
                    </button>

                    <button type="button" class="recovery-swap__button underline"
                                    x-show="recovery"
                                    x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                        {{ __('Использовать код аутентификации') }}
                    </button>
                    <button type="submit" class="button small">Авторизоваться</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

{{--<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div x-data="{ recovery: false }">
            <div class="mb-4 text-sm text-gray-600" x-show="! recovery">
                {{ __('Пожалуйста, подтвердите доступ к своей учетной записи, введя код аутентификации, предоставленный вашим приложением для аутентификации.') }}
            </div>

            <div class="mb-4 text-sm text-gray-600" x-show="recovery">
                {{ __('Пожалуйста, подтвердите доступ к своей учетной записи, введя один из ваших кодов аварийного восстановления.') }}
            </div>

            <x-jet-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf
                <div class="mt-4" x-show="! recovery">
                    <x-jet-label for="code" value="{{ __('Код') }}" />
                    <x-jet-input id="code" class="block mt-1 w-full" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                </div>

                <div class="mt-4" x-show="recovery">
                    <x-jet-label for="recovery_code" value="{{ __('Код восстановления') }}" />
                    <x-jet-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                </div>

                <div class="flex items-center justify-end mt-4 gap-10">
                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                                    x-show="! recovery"
                                    x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                        {{ __('Использовать код восстановления') }}
                    </button>

                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                                    x-show="recovery"
                                    x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                        {{ __('Использовать код аутентификации') }}
                    </button>

                    <x-jet-button class="ml-4">
                        {{ __('Авторизоваться') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>--}}
