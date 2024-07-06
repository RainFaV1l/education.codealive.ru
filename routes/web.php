<?php


use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupModuleController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TeacherPanelController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::group(['namespace' => 'App\Http\Livewire'], function () {});

Route::controller(IndexController::class)->group(function () {
    Route::get('/', 'index')->name('index.index');
    Route::get('/#benefits', 'index')->name('index.benefits');
    Route::get('/#about', 'index')->name('index.about');
    Route::get('/#review', 'index')->name('index.review');
});

Route::controller(CatalogController::class)->group(function () {
    Route::get('/catalog', 'index')->name('catalog.index');
    Route::get('/catalog/{course}', 'show')->name('catalog.show');
});

Route::controller(UserController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('profile', 'index')->name('profile.index');
    Route::post('profile/changeAvatar', 'changeAvatar')->name('profile.changeAvatar');
});

Route::controller(TeacherPanelController::class)->middleware(['auth', 'teacher'])->prefix('teacher-panel')->group(function () {
    Route::get('/courses', 'courses')->name('teacher-panel.courses');
    Route::get('/courses/{id}/groups', 'groups')->name('teacher-panel.groups');
    Route::get('/courses/{course_id}/groups/{group_id}/module/{module_id}', 'group')->name('teacher-panel.group');
});

Route::controller(DashboardController::class)->middleware(['auth', 'admin'])->prefix('dashboard')->group(function () {
    Route::get('/show', 'index')->name('dashboard.index');
    Route::get('/lessons', 'lessons')->name('dashboard.lessons');
    Route::get('/courses', 'courses')->name('dashboard.courses');
    Route::get('/categories', 'categories')->name('dashboard.categories');
    Route::get('/users', 'users')->name('dashboard.users');
    Route::get('/groups', 'groups')->name('dashboard.groups');
    Route::get('/applications', 'applications')->name('dashboard.applications');
    Route::get('/modules', 'modules')->name('dashboard.modules');
    Route::get('/reviews', 'reviews')->name('dashboard.reviews');

    Route::controller(GroupModuleController::class)->prefix('modules')->group(function () {
        Route::get('/add', 'add')->name('modules.add');
        Route::get('/{id}/edit', 'edit')->name('modules.edit');
        Route::get('/{id}/more', 'more')->name('modules.more');
        Route::get('/{id}/more/add', 'addLesson')->name('modules.addLesson');
    });

    Route::controller(AdminUserController::class)->prefix('users')->group(function () {
        Route::get('/{id}/edit', 'edit')->name('users.edit');
        Route::get('/{user}/delete', 'delete')->name('users.delete');
    });

    Route::controller(GroupModuleController::class)->prefix('modules')->group(function () {
        Route::get('/add', 'add')->name('modules.add');
        Route::get('/{id}/edit', 'edit')->name('modules.edit');
        Route::get('/{id}/more', 'more')->name('modules.more');
        Route::get('/{id}/more/add', 'addLesson')->name('modules.addLesson');
    });
    Route::controller(CourseController::class)->prefix('courses')->group(function () {
        Route::get('/add', 'add')->name('courses.add');
        Route::post('/add', 'store')->name('courses.store');
        Route::get('/{id}/edit', 'edit')->name('courses.edit');
        Route::get('/{id}/more', 'more')->name('courses.more');
        Route::get('/{id}/admin/more', 'adminMore')->name('courses.admin.more');
    });

    Route::controller(CategoryController::class)->prefix('categories')->group(function () {
        Route::get('/add', 'addView')->name('categories.categoryAddView');
        Route::post('/add', 'store')->name('categories.categoryAdd');
        Route::get('/{id}/edit', 'editView')->name('categories.categoryEditView');
        Route::post('/{id}/edit', 'update')->name('categories.categoryEdit');
        Route::post('/{id}/delete', 'destroy')->name('categories.categoryDelete');
    });

    Route::controller(GroupController::class)->prefix('groups')->group(function () {
        Route::get('/{id}/more', 'more')->name('groups.more');
        Route::get('/{id}/more/user/{user_id}', 'moreUser')->name('groups.moreUser');
        Route::get('/add', 'addView')->name('groups.addView');
        Route::post('/add', 'store')->name('groups.store');
        Route::get('/{id}/edit', 'editView')->name('groups.editView');
        Route::post('/{id}/edit', 'update')->name('groups.update');
        Route::post('/{id}/delete', 'destroy')->name('groups.destroy');
    });

    Route::controller(LessonController::class)->prefix('lessons')->group(function () {
        Route::get('/add', 'add')->name('lessons.add');
        Route::get('/{id}/add', 'add')->name('lessons.addId');
        Route::post('/add', 'store')->name('lessons.store');
        Route::get('/{id}/edit', 'edit')->name('lessons.edit');
        Route::post('/{id}/edit', 'update')->name('lessons.update');
        Route::get('/{lesson_id}/more', 'dashboardMore')->name('dashboard.lessons.more');
    });

    Route::controller(ApplicationController::class)->prefix('applications')->group(function () {
        // Route::get('/add', 'create')->name('applications.create');
    });
});

Route::controller(CourseController::class)->middleware(['auth'])->prefix('courses')->group(function () {
    Route::get('/', 'index')->name('courses.index');
    Route::get('/{id}/more', 'more')->name('courses.more.subscribe')->middleware(['subscribe']);
    Route::get('/{id}/gift', 'gift')->name('courses.gift')->middleware(['subscribe', 'gift']);
    Route::get('/{id}/pdf', 'pdf')->name('courses.pdf')->middleware(['subscribe', 'gift']);
    Route::get('/{id}/pdf/show', 'showPdf')->name('courses.showPdf')->middleware(['subscribe', 'gift']);
});

Route::controller(ApplicationController::class)->middleware(['auth'])->prefix('applications')->group(function () {
    Route::get('/', 'index')->name('applications.index');
});

Route::controller(LessonController::class)->middleware(['auth'])->prefix('lessons')->group(function () {
    Route::get('/module/{module_id}/lesson/{lesson_id}/more', 'more')->name('lessons.more')->middleware(['lesson', 'module']);
});

Route::controller(AuthenticatedSessionController::class)->middleware(['guest'])->prefix('oauth/login')->group(function() {
    Route::get('create', 'create')->name('pautinaid.create');
    Route::get('redirect', 'redirect')->name('pautinaid.redirect');
});

Route::get('storage/{name}', function ($name) {

    $path = storage_path($name);

    $mime = \File::mimeType($path);

    header('Content-type: ' . $mime);

    return readfile($path);
    
})->where('name', '(.*)');

Route::post('storage/{name}', function ($name) {

    $path = storage_path($name);

    $mime = \File::mimeType($path);

    header('Content-type: ' . $mime);

    return readfile($path);

})->where('name', '(.*)');

//Route::get('/courses/add/livewire', \App\Http\Livewire\Courses::class);

//dd(Route::getRoutes());
//Auth::routes();

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require_once __DIR__ . '/jetstream.php';