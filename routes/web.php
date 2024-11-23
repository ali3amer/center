<?php

use App\Livewire\Bank;
use App\Livewire\Course;
use App\Livewire\Employee;
use App\Livewire\Expense;
use App\Livewire\Hall;
use App\Livewire\Report;
use App\Livewire\Settings;
use App\Livewire\Student;
use App\Livewire\Trainer;
use App\Livewire\Transfer;
use App\Livewire\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/course', Course::class);
Route::get('/employee', Employee::class);
Route::get('/expense', Expense::class);
Route::get('/hall', Hall::class);
Route::get('/student', Student::class);
Route::get('/trainer', Trainer::class);
Route::get('/report', Report::class);
Route::get('/settings', Settings::class);
Route::get('/bank', Bank::class);
Route::get('/transfer', Transfer::class);
Route::get('/user', User::class);
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
