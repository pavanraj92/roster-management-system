<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\VisibilitySettingController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RosterController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Route::get('/admin', function () {
//     return redirect()->route('admin.login');
// });

Route::name('admin.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Guest Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login']);

        Route::get('register', [AuthController::class, 'showRegister'])->name('register');
        Route::post('register', [AuthController::class, 'register']);

        Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
        Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

        Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
        Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    });

    /*
    |--------------------------------------------------------------------------
    | Authenticated Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {

        Route::match(['get', 'post'], 'logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('dashboard', [DashboardController::class, 'index'])
            ->name('dashboard')
            ->middleware('permission:dashboard_access');

        // Pages
        Route::resource('pages', PageController::class)->middleware('permission:page_access');
        Route::post('pages/toggle-status/{id}', [PageController::class, 'toggleStatus'])->name('pages.toggle-status');

        // Staffs
        Route::resource('staff', StaffController::class)->middleware('permission:user_access');
        Route::post('staff/toggle-status/{id}', [StaffController::class, 'toggleStatus'])->name('staff.toggle-status');

        // Users
        Route::resource('user', UserController::class)->middleware('permission:user_access');
        Route::post('user/toggle-status/{id}', [UserController::class, 'toggleStatus'])->name('user.toggle-status');


        // Roles & Permissions
        Route::resource('roles', RoleController::class)->middleware('permission:role_access');
        Route::resource('permissions', PermissionController::class)->middleware('permission:role_access');
        Route::post('roles/{role}/permissions', [RoleController::class, 'assignPermissions'])->name('roles.assign-permissions');

        // Email Templates
        Route::resource('email-templates', EmailTemplateController::class)->middleware('permission:email_template_access');
        Route::post('email-templates/toggle-status/{id}', [EmailTemplateController::class, 'toggleStatus'])->name('email-templates.toggle-status');

        /*
        |--------------------------------------------------------------------------
        | Settings
        |--------------------------------------------------------------------------
        */
        Route::prefix('settings')->name('settings.')->middleware('permission:setting_access')->group(function () {

            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::post('update', [SettingController::class, 'update'])->name('update');
            Route::get('visibility', [VisibilitySettingController::class, 'index'])->name('visibility.index');
            Route::post('visibility', [VisibilitySettingController::class, 'update'])->name('visibility.update');
        });

        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */
        Route::prefix('profile')->name('profile.')->group(function () {

            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::post('update', [ProfileController::class, 'updateProfile'])->name('update');
            Route::post('change-password', [ProfileController::class, 'changePassword'])->name('change-password');
            Route::post('update-avatar', [ProfileController::class, 'updateProfileImage'])->name('update-avatar');
        });

        Route::get('roster', [RosterController::class, 'index'])->name('roster');
        Route::post('/roster/store', [RosterController::class,'store'])->name('roster.store');
    });
});
