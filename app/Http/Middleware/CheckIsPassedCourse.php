<?php

namespace App\Http\Middleware;

use App\Models\Certificate;
use App\Services\Course\Service;
use Closure;
use Illuminate\Http\Request;

class CheckIsPassedCourse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // Получаем экземпляр сервиса
        $service = new Service();

        // Формируем запрос для проверки
        $check = $service->baseCheckCertificateQuery($request->route()->parameter('id'), auth()->user()->id);

        // Проверяем истинна ли значение из бд
        if($check->count() === 0) {

            // Возвращаем ошибку 403
            abort(403);

        }

        // Разрешаем выполнение метода из контроллера
        return $next($request);

    }
}
