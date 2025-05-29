<?php

use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ApplicationImageController;
use App\Http\Controllers\ApplicationLikeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\EditMilitaryImageController;
use App\Http\Controllers\EditVolunteerImageController;
use App\Http\Controllers\FavoriteUserController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\Landing\LandingController;
use App\Http\Controllers\Military\Account\MilitaryEditUserController;
use App\Http\Controllers\Military\Account\MilitaryViewAccountController;
use App\Http\Controllers\Military\MilitaryAddApplicationsController;
use App\Http\Controllers\Military\MilitaryApplicationImageController;
use App\Http\Controllers\Military\MilitaryHomeController;
use App\Http\Controllers\Military\MilitaryViewApplicationController;
use App\Http\Controllers\Military\MilitaryViewVolunteerController;
use App\Http\Controllers\Military\VolunteerRatingController;
use App\Http\Controllers\UserImageController;
use App\Http\Controllers\Volunteer\Account\VolunteerEditUserController;
use App\Http\Controllers\Volunteer\Account\VolunteerViewAccountController;
use App\Http\Controllers\Volunteer\VolunteerConfirmationApplicationController;
use App\Http\Controllers\Volunteer\VolunteerHomeController;
use App\Http\Controllers\Volunteer\VolunteerViewApplicationController;
use App\Http\Controllers\Volunteer\VolunteerViewConfirmApplicationController;
use App\Http\Controllers\Volunteer\VolunteerViewInfoMilitaryController;
use App\Http\Controllers\Volunteer\VolunteerViewMilitaryController;
use App\Http\Middleware\Check;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [LandingController::class, 'index'])->name('user.landing.index');
Route::get('/lab1', [LabController::class, 'index']);
Route::get('/about', [LabController::class, 'about']);
Route::get('/contact', [LabController::class, 'contact']);
Route::get('/hobbies', [LabController::class, 'hobbies']) -> middleware(Check::class);

Route::prefix('admin')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('admin.home.index');

});
Route::get('/', [LandingController::class, 'index'])->name('user.landing.index');



Route::prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/users/search', [UserController::class, 'search'])->name('admin.users.search');
    Route::get('/users/filter', [UserController::class, 'filter'])->name('admin.users.filter');
    Route::get('/admin/users/export', [UserController::class, 'exportPDF'])->name('admin.users.export');
});

Route::prefix('admin')->group(function () {
    Route::get('/applications', [ApplicationController::class, 'index'])->name('admin.applications.index');
    Route::get('/applications/create', [ApplicationController::class, 'create'])->name('admin.applications.create');
    Route::post('/applications', [ApplicationController::class, 'store'])->name('admin.applications.store');
    Route::get('/applications/{application}/edit', [ApplicationController::class, 'edit'])->name('admin.applications.edit');
    Route::put('/applications/{application}', [ApplicationController::class, 'update'])->name('admin.applications.update');
    Route::delete('/applications/{application}', [ApplicationController::class, 'destroy'])->name('admin.applications.destroy');
    Route::get('/applications/search', [ApplicationController::class, 'search'])->name('admin.applications.search');
    Route::get('/applications/filter', [ApplicationController::class, 'filter'])->name('admin.applications.filter');
    Route::get('/admin/applications/export', [ApplicationController::class, 'exportPDF'])->name('admin.applications.export');
});

Route::prefix('admin')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    Route::get('/categories/search', [CategoryController::class, 'search'])->name('admin.categories.search');
    Route::get('/categories/filter', [CategoryController::class, 'filter'])->name('admin.categories.filter');
    Route::get('/admin/categories/export', [CategoryController::class, 'exportPDF'])->name('admin.categories.export');
});

Route::prefix('admin/applications/{application}')->group(function () {
    Route::get('/images/create', [ApplicationImageController::class, 'create'])->name('admin.applications.images.create');
    Route::post('/images', [ApplicationImageController::class, 'store'])->name('admin.applications.images.store');
    Route::get('/images/edit', [ApplicationImageController::class, 'edit'])->name('admin.applications.images.edit');
    Route::put('/images/{image}', [ApplicationImageController::class, 'update'])->name('admin.applications.images.update');
    Route::delete('/images/{image}', [ApplicationImageController::class, 'destroy'])->name('admin.applications.images.delete');
});

Route::prefix('admin/users/{user}')->group(function () {
    Route::get('/images/create', [UserImageController::class, 'create'])->name('admin.users.images.create');
    Route::post('/images', [UserImageController::class, 'store'])->name('admin.users.images.store');
    Route::get('/images/edit', [UserImageController::class, 'edit'])->name('admin.products.images.edit');
    Route::put('/images/{image}', [UserImageController::class, 'update'])->name('admin.products.images.update');
    Route::delete('/images/{image}', [UserImageController::class, 'destroy'])->name('admin.products.images.delete');
});



Route::prefix('user')->group(function () {
    Route::get('/military/view_app', [MilitaryViewApplicationController::class, 'index'])->name('user.military.view_app');
    Route::get('/military/view_account', [MilitaryViewAccountController::class, 'index'])->name('user.military.view_account');
    Route::get('/military/{user}/edit_account', [MilitaryEditUserController::class, 'edit'])->name('user.military.edit_account');
    Route::put('/military/{user}', [MilitaryEditUserController::class, 'update'])->name('user.military.update_account');
    Route::get('/military/vol/view_volunteer', [MilitaryViewVolunteerController::class, 'index'])->name('user.military.vol.view_volunteer');
    Route::get('/military/vol/search', [MilitaryViewVolunteerController::class, 'search'])->name('user.military.vol.search');
});

Route::prefix('user/military/{application}')->group(function () {
    Route::get('/images/create', [MilitaryApplicationImageController::class, 'create'])->name('user.military.images.create');
    Route::post('/images', [MilitaryApplicationImageController::class, 'store'])->name('user.military.images.store');
    Route::get('/images/edit', [MilitaryApplicationImageController::class, 'edit'])->name('user.military.images.edit');
    Route::put('/images/{image}', [MilitaryApplicationImageController::class, 'update'])->name('user.military.images.update');
    Route::delete('/images/{image}', [MilitaryApplicationImageController::class, 'destroy'])->name('user.military.images.delete');
});


Route::prefix('user')->group(function () {
    Route::get('/military/index', [MilitaryHomeController::class, 'index'])->name('user.military.index');
    Route::get('/military/create', [MilitaryAddApplicationsController::class, 'create'])->name('user.military.create');
    Route::post ('/military', [MilitaryAddApplicationsController::class, 'store'])->name('user.military.store');
    Route::get('/military/{application}/edit', [MilitaryViewApplicationController::class, 'edit'])->name('user.military.edit');
    Route::get('military/account/{user}/edit_photo', [EditMilitaryImageController::class, 'edit'])->name('user.military.account.edit_photo');
    Route::post('military/account/{user}/update_photo', [EditMilitaryImageController::class, 'update'])->name('user.military.account.update_photo');


    Route::put('/appl/{application}', [MilitaryViewApplicationController::class, 'update'])->name('user.military.update');


    Route::delete('/military/{application}', [MilitaryViewApplicationController::class, 'destroy'])->name('user.military.destroy');
    Route::get('/military/search', [MilitaryViewApplicationController::class, 'search'])->name('user.military.search');
    Route::get('/military/applications/filter', [MilitaryViewApplicationController::class, 'getFilteredApplications'])
        ->name('military.applications.filter');


    Route::get('/military/export', [MilitaryViewApplicationController::class, 'export'])->name('user.military.export');
    Route::get('military/pdf/{id}', [MilitaryViewApplicationController::class, 'generatePDF'])->name('user.military.pdf');

});



Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});


Route::prefix('auth')->group(function () {

    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');
    Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');

});

Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');



Route::prefix('user')->group(function () {
    Route::get('/volunteer/index', [VolunteerHomeController::class, 'index'])->name('user.volunteer.index');
    Route::get('/volunteer/view_account', [VolunteerViewAccountController::class, 'index'])->name('user.volunteer.view_account');
    Route::get('/volunteer/{user}/edit_account', [VolunteerEditUserController::class, 'edit'])->name('user.volunteer.edit_account');
    Route::put('/volunteer/{user}', [VolunteerEditUserController::class, 'update'])->name('user.volunteer.update_account');
    Route::get('/volunteer/mil/view_military', [VolunteerViewMilitaryController::class, 'index'])->name('user.volunteer.mil.view_military');
    Route::get('/volunteer/mil/search', [VolunteerViewMilitaryController::class, 'search'])->name('user.volunteer.mil.search');
    Route::get('/volunteer/view_app', [VolunteerViewApplicationController::class, 'index'])->name('user.volunteer.view_app');
    Route::get('/volunteer/search', [VolunteerViewApplicationController::class, 'search'])->name('user.volunteer.search');
    Route::get('/volunteer/filter', [VolunteerViewApplicationController::class, 'filter'])->name('user.volunteer.filter');
    Route::get('/volunteer/confirm/view_confirm_app', [VolunteerViewConfirmApplicationController::class, 'index'])->name('user.volunteer.confirm.view_confirm_app');
    Route::get('/volunteer/view_info_military/{id}', [VolunteerViewInfoMilitaryController::class, 'index'])->name('user.volunteer.view_info_military');
    Route::get('/volunteer/confirm_application/{id}', [VolunteerConfirmationApplicationController::class, 'index'])->name('user.volunteer.confirm_application');
    Route::post('/volunteer/confirm_application/{id}', [VolunteerConfirmationApplicationController::class, 'confirm'])->name('user.volunteer.confirm_application.confirm');

    Route::get('/volunteer/confirm/search', [VolunteerViewConfirmApplicationController::class, 'search'])->name('user.volunteer.confirm.search');
    Route::get('/volunteer/confirm/{id}/edit_confirm_app', [VolunteerViewConfirmApplicationController::class, 'edit'])->name('user.volunteer.confirm.edit_confirm_app');
    Route::put('/volunteer/confirm/{id}', [VolunteerViewConfirmApplicationController::class, 'update'])->name('user.volunteer.confirm.update_app');

// Додайте ці маршрути
    Route::put('/volunteer/confirm/{id}/delete_comment', [VolunteerViewConfirmApplicationController::class, 'deleteComment'])->name('user.volunteer.confirm.delete_comment');
    Route::put('/volunteer/confirm/{id}/reject_application', [VolunteerViewConfirmApplicationController::class, 'rejectApplication'])->name('user.volunteer.confirm.reject_application');


    Route::get('volunteer/account/{user}/edit_photo', [EditVolunteerImageController::class, 'edit'])->name('user.volunteer.account.edit_photo');
    Route::post('volunteer/account/{user}/update_photo', [EditVolunteerImageController::class, 'update'])->name('user.volunteer.account.update_photo');

    Route::get('volunteer/pdf/{id}', [VolunteerViewApplicationController::class, 'generatePDF'])->name('user.volunteer.pdf');

});




Route::get('/military', [MilitaryHomeController::class, 'index'])->name('military.index');
Route::get('/military/rate/{application}', [MilitaryHomeController::class, 'rateVolunteer'])->name('military.rate');
Route::post('/military/rating/{application}', [MilitaryHomeController::class, 'storeRating'])->name('military.storeRating');



Route::post('/send-feedback', [FeedbackController::class, 'send'])->name('feedback.send');

// routes/web.php
Route::post('/applications/like/toggle/{application}', [ApplicationLikeController::class, 'toggleLike']);

Route::get('/military/export/pdf', [MilitaryViewApplicationController::class, 'exportAllApplicationsToPDF'])
    ->name('user.military.exportAllPDF');


Route::post('/users/{user}/favorite', [FavoriteUserController::class, 'toggle']);



