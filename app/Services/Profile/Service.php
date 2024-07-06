<?php

namespace App\Services\Profile;

use App\Models\User;
use App\Repositories\ImageUploadRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Service
{
    // Свойства
    private $imageUploadRepository;

    // Создание экземпляров сторонних классов
    public function __construct(ImageUploadRepository $imageUploadRepository)
    {
        // Передача свойству экземпляра класса
        $this->imageUploadRepository = $imageUploadRepository;
    }

    // Метод для смена аватарки полльзователя
    public function changeAvatar($request, $validated)
    {
        // Обработка ошибок
        try {
            // Запуск транзакции
            DB::beginTransaction();

            // Получение файла
            $file = $request->file('profile_photo_path');

            // Путь для загрузки файла
            $path = 'public/avatars';

            // Загрузка одного изображения
            $validated['profile_photo_path'] = $this->imageUploadRepository->uploadSingleImage($file, $path);

            // Удаление старой аватарки
            $this->imageUploadRepository->destroyFile(\auth()->user()->profile_photo_file);

            // Проверка загрузилось ли изображение
            if (!$validated['profile_photo_path']) {
                // Возвращение false
                return false;
            }

            // Обновление аватарки
            $user = User::query()->where('id', '=', auth()->user()->id)->update($validated);

            // Создание уведомления
            session()->flash('success', 'Аватарка успешно изменена.');

            // Сохранение
            DB::commit();
        } catch (\Exception $exception) {

            // Откат изменений при появлении ошибки
            DB::rollBack();

            // Возвращение сообщения ошибки
            return $exception->getMessage();
        }

        // Создание уведомления об ошибке
        session()->flash('error', 'Не удалось сменить автарку!');
    }

    // Метод для проверки пародя пользователя
    public function checkUserPassword($currentPassword, $userPassword)
    {
        // Хэширование пароля
        $password = Hash::make($currentPassword);

        // Проверка совпадает ли пароль
        if (!Hash::check($currentPassword, $userPassword)) {
            // Возвращаем false
            return false;
        }

        // Возвращаем пароля
        return $password;
    }

    // Смена пароля
    public function changePasswordFunc($validated, $userPassword)
    {
        // Получение текущего пароля
        $currentPassword = $validated['current_password'];

        // Проверка пароля
        $check = $this->checkUserPassword($currentPassword, $userPassword);

        if (!$check) {
            // Возвращаем false
            return false;
        }

        // Хэширование нового пароля
        $newPassword = Hash::make($validated['password']);

        // Обновляем пароль
        User::query()->where('id', '=', Auth::user()->id)->update(['password' => $newPassword]);

        // Возвращаем true
        return true;
    }





    // .... Не используется! Смотреть код  в компоненте livewire .... //





    public function changePersonalInfo($validated)
    {
        User::query()->where('id', '=', Auth::user()->id)->update($validated);
    }

    public function changeEmail($validated)
    {

        $validated['password'] = Hash::make($validated['password']);

        $user = User::query()->select('password')->find(Auth::id());

        if (!Hash::check($validated['password'], $user->password)) {
            return back()->withErrors(['invalid_email' => 'Неверный пароль.']);
        }

        $user::query()->where('id', '=', Auth::user()->id)->update($validated);
    }

    public function changeTel($request, $validated)
    {

        $validated['password'] = Hash::make($request['password_tel']);

        $user = User::query()->select('password')->find(Auth::id());

        if (!Hash::check($request['password_tel'], $user->password)) {
            return back()->withErrors(['invalid_tel' => 'Неверный пароль.'])->withInput($request->all());
        }

        $user::query()->where('id', '=', Auth::user()->id)->update($validated);
    }

    public function changePassword($request, $validated)
    {

        $validated['password'] = Hash::make($request['password_new']);

        $user = User::query()->select('password')->find(Auth::id());

        if (!Hash::check($request['password_old'], $user->password)) {
            return back()->withErrors(['invalid_password' => 'Неверный пароль.'])->withInput($request->all());
        }

        $user::query()->where('id', '=', Auth::user()->id)->update($validated);

        return redirect(route('profile.index'));
    }
}
