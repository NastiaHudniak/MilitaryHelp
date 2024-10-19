<?php

use App\Http\Controllers\LabController;
use App\Http\Middleware\CheckAge;
use App\Http\Middleware\CheckName;
use App\Http\Middleware\Check;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MilitaryHomeController;
use App\Http\Controllers\MilitaryAddApplicationsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [LabController::class, 'main']);
Route::get('/lab1', [LabController::class, 'index']);
Route::get('/about', [LabController::class, 'about']);
Route::get('/contact', [LabController::class, 'contact']);
Route::get('/hobbies', [LabController::class, 'hobbies']) -> middleware(Check::class);


Route::prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/users/search', [UserController::class, 'search'])->name('admin.users.search');
    Route::get('/users/filter', [UserController::class, 'filter'])->name('admin.users.filter');
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
    Route::get('/applications/export', [ApplicationController::class, 'export'])->name('admin.applications.export');
});

//
//Route::prefix('admin/products/{product}')->group(function () {
//    Route::get('/images/add', [ProductImageController::class, 'create'])->name('admin.products.images.add');
//    Route::post('/images', [ProductImageController::class, 'store'])->name('admin.products.images.store');
//    Route::get('/images/edit', [ProductImageController::class, 'edit'])->name('admin.products.images.edit');
//    Route::put('/images/{image}', [ProductImageController::class, 'update'])->name('admin.products.images.update');
//    Route::delete('/images/{image}', [ProductImageController::class, 'destroy'])->name('admin.products.images.delete');
//});


Route::prefix('user')->group(function () {
    Route::get('/landing', [LandingController::class, 'index'])->name('user.landing.index');
});

Route::prefix('user')->group(function () {
    Route::get('/military/index', [MilitaryHomeController::class, 'index'])->name('user.military.index');
    Route::get('/military/create', [MilitaryAddApplicationsController::class, 'create'])->name('user.military.create');
    Route::post ('/military', [MilitaryAddApplicationsController::class, 'store'])->name('user.military.store');

});



Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});
