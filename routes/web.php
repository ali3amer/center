<?php

use App\Livewire\Course;
use App\Livewire\Employee;
use App\Livewire\Expense;
use App\Livewire\Hall;
use App\Livewire\Report;
use App\Livewire\Student;
use App\Livewire\Teacher;
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
Route::get('/teacher', Teacher::class);
Route::get('/report', Report::class);
Route::get('/user', User::class);
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
