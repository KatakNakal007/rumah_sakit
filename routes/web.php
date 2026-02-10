<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';



Route::resource('patients', PatientController::class);
Route::resource('doctors', DoctorController::class);
Route::resource('schedules', ScheduleController::class);
Route::resource('appointments', AppointmentController::class);
Route::get('/appointments/{appointment}/pdf', [AppointmentController::class, 'exportPdf'])->name('appointments.pdf');

Route::resource('queues', QueueController::class);
Route::get('/queues', [QueueController::class, 'index'])->name('queues.index');
Route::post('/queues/{id}/call', [QueueController::class, 'call'])->name('queues.call');
Route::post('/queues/{id}/finish', [QueueController::class, 'finish'])->name('queues.finish');

Route::get('/queues/create', [QueueController::class, 'create'])->name('queues.create');
Route::post('/queues', [QueueController::class, 'store'])->name('queues.store');

Route::get('/appointments/print-today', [AppointmentController::class, 'printToday'])->name('appointments.printToday');
Route::post('/appointments/export-combined-chart', [AppointmentController::class, 'exportCombinedChart'])
    ->name('appointments.exportCombinedChart');

Route::get('/admin/dashboard', [AppointmentController::class, 'dashboard'])
    ->name('admin.dashboard');


Route::get('/schedules/by-doctor/{doctor}', [ScheduleController::class, 'getByDoctor']);
