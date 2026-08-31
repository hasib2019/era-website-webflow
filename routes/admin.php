<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CaseStudyController;
use App\Http\Controllers\Admin\ChangelogController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StatController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
| Prefixed /admin and named admin.* from bootstrap/app.php. Each route names the
| permission that unlocks it; the sidebar hides what the signed-in role cannot use.
*/

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
        ->middleware('permission:dashboard.view')
        ->name('dashboard');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    // ---------------------------------------------------------------- pages
    Route::middleware('permission:pages.view')->group(function () {
        Route::get('pages', [PageController::class, 'index'])->name('pages.index');
        Route::get('pages/{page}', [PageController::class, 'edit'])->name('pages.edit');
    });

    Route::middleware('permission:pages.edit')->group(function () {
        Route::put('pages/{page}', [PageController::class, 'update'])->name('pages.update');
        Route::put('pages/{page}/sections/{section}', [PageController::class, 'updateSection'])
            ->name('pages.sections.update');
    });

    // ---------------------------------------------------------------- media
    Route::get('media', [MediaController::class, 'index'])
        ->middleware('permission:media.view')->name('media.index');

    Route::middleware('permission:media.upload')->group(function () {
        Route::post('media', [MediaController::class, 'store'])->name('media.store');
        Route::put('media/{medium}', [MediaController::class, 'update'])->name('media.update');
    });

    Route::delete('media/{medium}', [MediaController::class, 'destroy'])
        ->middleware('permission:media.delete')->name('media.destroy');

    // ---------------------------------------------------------------- menus
    Route::middleware('permission:menus.manage')->group(function () {
        Route::get('menus', [MenuController::class, 'index'])->name('menus.index');
        Route::get('menus/{menu}', [MenuController::class, 'edit'])->name('menus.edit');
        Route::post('menus/{menu}/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');
        Route::post('menus/{menu}/items', [MenuController::class, 'storeItem'])->name('menus.items.store');
        Route::put('menus/{menu}/items/{item}', [MenuController::class, 'updateItem'])->name('menus.items.update');
        Route::delete('menus/{menu}/items/{item}', [MenuController::class, 'destroyItem'])->name('menus.items.destroy');
    });
});

/*
 * Content collections all share ResourceController, so their routes are declared
 * once from a table rather than repeated nine times.
 */
Route::middleware('auth')->group(function () {
    $collections = [
        'services' => [ServiceController::class, 'services.manage'],
        'case-studies' => [CaseStudyController::class, 'case-studies.manage'],
        'posts' => [PostController::class, 'posts.manage'],
        'jobs' => [JobController::class, 'jobs.manage'],
        'testimonials' => [TestimonialController::class, 'testimonials.manage'],
        'team' => [TeamController::class, 'team.manage'],
        'clients' => [ClientController::class, 'clients.manage'],
        'faqs' => [FaqController::class, 'faqs.manage'],
        'stats' => [StatController::class, 'stats.manage'],
        'changelog' => [ChangelogController::class, 'changelog.manage'],
    ];

    foreach ($collections as $slug => [$controller, $permission]) {
        Route::middleware('permission:' . $permission)->group(function () use ($slug, $controller) {
            Route::get($slug, [$controller, 'index'])->name($slug . '.index');
            Route::get($slug . '/create', [$controller, 'create'])->name($slug . '.create');
            Route::post($slug, [$controller, 'store'])->name($slug . '.store');
            Route::post($slug . '/reorder', [$controller, 'reorder'])->name($slug . '.reorder');
            Route::get($slug . '/{id}/edit', [$controller, 'edit'])->name($slug . '.edit');
            Route::put($slug . '/{id}', [$controller, 'update'])->name($slug . '.update');
            Route::delete($slug . '/{id}', [$controller, 'destroy'])->name($slug . '.destroy');
        });
    }
});

Route::middleware('auth')->group(function () {
    // ---------------------------------------------------------------- inbox
    Route::middleware('permission:messages.view')->group(function () {
        Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    });

    Route::middleware('permission:messages.manage')->group(function () {
        Route::put('messages/{message}', [MessageController::class, 'update'])->name('messages.update');
        Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    });

    Route::get('applications', [ApplicationController::class, 'index'])
        ->middleware('permission:applications.view')->name('applications.index');

    Route::get('subscribers', [SubscriberController::class, 'index'])
        ->middleware('permission:subscribers.view')->name('subscribers.index');

    Route::get('activity', [ActivityController::class, 'index'])
        ->middleware('permission:activity.view')->name('activity.index');

    // ---------------------------------------------------------------- administration
    Route::get('users', [UserController::class, 'index'])
        ->middleware('permission:users.view')->name('users.index');

    Route::middleware('permission:users.manage')->group(function () {
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::middleware('permission:roles.manage')->group(function () {
        Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });

    Route::middleware('permission:settings.manage')->group(function () {
        Route::get('settings', [SettingsController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    });
});
