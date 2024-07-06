<?php

namespace App\Http\Livewire\Profile;

use App\Http\Livewire\BaseComponent;
use App\Mail\User\ChangeEmail;
use App\Models\ChangeEmail as ModelsChangeEmail;
use App\Models\User;
use App\Notifications\ChangeEmail as NotificationsChangeEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ProfileEmail extends BaseComponent
{
    // Свойства
    public $user;
    public $email;
    public $password;
    public $code;

    // Поля для валидации
    protected $rules = [
        'email' => 'required|string|email|max:255|unique:users,email',
    ];

    // Очитска input
    public function clearInput()
    {
        // Очитска input
        $this->password = '';
    }

    // Метод для проверки актуальности кода смены email
    public function changeEmailDateCheck($changeEmail)
    {
        // Перевод времени в Unix-время
        $expires_at = strtotime($changeEmail['expires_at']);

        // Проверка
        if ($expires_at > time()) {
            // Код действителен
            return true;
        }

        // Время закончилось
        return false;
    }

    // Проверка отправлен ли код  восстановления по email
    public function checkIsExistChangeEmailCode()
    {
        // Запрос
        $changeEmail = ModelsChangeEmail::query()->where('user_id', '=', auth()->user()->id)->where('change_check', '=', false)->orderBy('created_at', 'desc')->first();

        // Проверка на наличие
        if (!isset($changeEmail)) {
            // Возвращение значение
            return false;
        }

        // Проверка
        if ($changeEmail) {
            // Вызов функции
            $check = $this->changeEmailDateCheck($changeEmail);

            // Проверка
            if ($check) {
                // Возвращение значение
                return $changeEmail;
            }
        }

        // Возвращение значение
        return false;
    }

    // Функция для проверки кода
    public function codeCheck($userCode, $databaseCode)
    {
        // Проверка
        if ($userCode == $databaseCode) {
            // Возвращение значения
            return true;
        }

        // Возвращение значения
        return false;
    }

    // Функция обновления email
    public function updateEmail()
    {
        // Проверка
        $changeEmail = $this->checkIsExistChangeEmailCode();

        // Проверка
        if (!$changeEmail) {
            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'error', 'text' => 'Ошибка при проверке смены кода восстановления email. Возможно введен не правильный код!']);

            // Возвращение значения
            return false;
        }

        // Валидация
        $validated = $this->validate([
            'code' => 'required|numeric|max:100000',
        ], [
            'code.max' => 'Код не должен быть больше 5 символов.'
        ]);

        // Првоерка кода
        if ($this->codeCheck($validated['code'], $changeEmail['code'])) {

            // Обработка ошибок
            try {

                // Запуск транзакции
                DB::beginTransaction();

                // Обновление
                User::query()->where('id', '=', auth()->user()->id)->update([
                    'email' => $changeEmail['new_email'],
                ]);

                // Сброс подтверждения пароля
                if ($changeEmail['old_email'] !== $changeEmail['new_email']) {
                    // Находим пользователя
                    $user = User::find(auth()->user()->id);

                    // Сброс подтверджение почты
                    $user->update(['email_verified_at' => null]);

                    // Отправка новго сообщения на подтверджение почты
                    auth()->user()->sendEmailVerificationNotification();
                }

                // Отметка смены email
                $changeEmail = ModelsChangeEmail::query()->where('user_id', '=', auth()->user()->id)->update(['change_check' => true]);

                // Сохранение
                DB::commit();
            } catch (\Exception $exception) {

                // Откат изменений при появлении ошибки
                DB::rollBack();

                // Возвращение сообщения ошибки
                return $exception->getMessage();
            }

            // Редирект
            return $this->emit('redirect', '/profile');

            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Успешная смена email.']);
        }

        // Создание уведомления
        $this->dispatchBrowserEvent('notification', ['type' => 'error', 'text' => 'Неверный код.']);

        return false;
    }

    // Получение кода
    public function getChangeEmailCode()
    {
        // Валидация
        $validated = $this->validate();

        // Проверка
        $check = $this->profileService->checkUserPassword($this->password, auth()->user()->password);

        if (!$check) {
            // Создание уведомления
            $this->dispatchBrowserEvent('notification', ['type' => 'error', 'text' => 'Неверный пароль!']);

            // Останавливаем выполнение функции
            return;
        }

        // Обработка ошибок
        try {

            // Запуск транзакции
            DB::beginTransaction();

            // Сохранение старой почты
            $oldEmail = auth()->user()->email;

            // Генерация кода для отправки по почте
            $code = mt_rand(10000, 99999);

            // Отправка email
            // Mail::to($oldEmail)->send(new ChangeEmail($code));
            Notification::send(auth()->user(), new NotificationsChangeEmail($code));

            // Формирование времени
            $time = Carbon::now();

            // Прибавление 5 минут к времени
            $time = $time->addMinute(5)->toDateTimeString();

            // Проверка не активна ли смена email
            if ($this->checkIsExistChangeEmailCode()) {
                // Возвращение false
                return false;

                // Уведомление
                $this->dispatchBrowserEvent('notification', ['type' => 'error', 'text' => 'Код уже отправлен отправлен.']);
            }

            // Запись информации о коде в базу данных
            ModelsChangeEmail::query()->create([
                'code' => $code,
                'user_id' => auth()->user()->id,
                'new_email' => $validated['email'],
                'old_email' => $oldEmail,
                'expires_at' => $time,
            ]);

            // Редирект пользователя
            $this->emit('redirect', '/profile');

            // Уведомление
            $this->dispatchBrowserEvent('notification', ['type' => 'success', 'text' => 'Код для смены email успешно отправлен.']);

            // Сохранение
            DB::commit();
        } catch (\Exception $exception) {

            // Откат изменений при появлении ошибки
            DB::rollBack();

            // Возвращение сообщения ошибки
            return $exception->getMessage();
        }

        // Очитска полей input
        $this->clearInput();
    }

    // Начальная инициализация
    public function mount($user)
    {
        // Присваивание свойству email значения
        $this->email = $user->email;
    }

    // Рендер
    public function render()
    {
        // Показ шаблона
        return view('livewire.profile.profile-email', ['user']);
    }
}
