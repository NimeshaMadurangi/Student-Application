<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// My Student Routes

Route::get('/student-form', [StudentController::class, 'create'])->name('student-form');

Route::get('/student-index', [StudentController::class, 'view'])->name('student-index');

Route::post('/students', [StudentController::class, 'store']);

Route::get('/students', [StudentController::class, 'index']);;

Route::delete('/students/{id}', [StudentController::class, 'destroy']);

Route::put('/students/{id}', [StudentController::class, 'updateStatus']);

Route::get('/edit-student', [StudentController::class, 'edit'])->name('edit.student');

Route::put('/students/{id}', [StudentController::class, 'update']);

require __DIR__.'/auth.php';
