<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get("/parse", [\App\Http\Controllers\Test\TestController::class, 'index'])->name('parser.index');
Route::get("/test", [\App\Http\Controllers\Test\TestController::class, 'test'])->name('parser.test');
Route::get("/grab", [\App\Http\Controllers\Test\TestController::class, 'grab'])->name('parser.grab');


Route::get("/faculty", [\App\Http\Controllers\Schedule\FacultyController::class, 'index'])->name('faculty.index');
Route::get("/faculty/{faculty}/{course}", [\App\Http\Controllers\Schedule\GroupController::class, 'index'])->name('group.index');
Route::get("/schedule/{group_id}", [\App\Http\Controllers\Schedule\ScheduleController::class, 'index'])->name('schedule.index');


Route::get("/telegram/", [\App\Http\Controllers\Telegram\IndexController::class, 'index'])->name('telegram.index');
