<?php

use App\Http\Controllers\FileExplorerController;
use App\Http\Middleware\EnsureStudent; 
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\Auth\StudentLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfficerAppointmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/image', [ProfileController::class, 'updateImage'])->name('profile.update-image');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware([EnsureStudent::class])->group(function () {
    Route::get('/appointment-calendar', [AppointmentController::class, 'showAppointmentCalendar'])->name('student.appointment-calendar');
    Route::post('/appointment/confirm/{id}', [AppointmentController::class, 'confirmAppointment'])->name('appointment.confirm');
    Route::post('/appointment/request', [AppointmentController::class, 'requestAppointment'])->name('appointment.request');

});

// Officer Routes
Route::get('/officer/login', [OfficerController::class, 'login'])->name('officer.login');
Route::post('/officer/authenticate', [OfficerController::class, 'authenticate'])->name('officer.authenticate');

// Protected Officer Routes
Route::middleware(['auth', 'check.officer.role'])->group(function () {
    Route::get('/officer/dashboard', [OfficerController::class, 'dashboard'])->name('officer.dashboard');
    Route::post('/officer/logout', [OfficerController::class, 'logout'])->name('officer.logout');
});

// Enrollment Routes
Route::prefix('enrollment')->name('enrollment.')->group(function () {
    Route::get('/', [App\Http\Controllers\EnrollmentController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\EnrollmentController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\EnrollmentController::class, 'store'])->name('store');
    Route::get('/{enrollment}', [App\Http\Controllers\EnrollmentController::class, 'show'])->name('show');
    Route::get('/{enrollment}/edit', [App\Http\Controllers\EnrollmentController::class, 'edit'])->name('edit');
    Route::put('/{enrollment}', [App\Http\Controllers\EnrollmentController::class, 'update'])->name('update');
    Route::delete('/{enrollment}', [App\Http\Controllers\EnrollmentController::class, 'destroy'])->name('destroy');
});

// File Explorer Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/file-explorer/{path?}', [FileExplorerController::class, 'index'])
        ->where('path', '.*')
        ->name('file-explorer.index');

    Route::get('/file-explorer/download/{path}', [FileExplorerController::class, 'download'])
        ->where('path', '.*')
        ->name('file-explorer.download');

    Route::delete('/file-explorer/delete/{path}', [FileExplorerController::class, 'delete'])
        ->where('path', '.*')
        ->name('file-explorer.delete');

    Route::get('/file-explorer/trash', [FileExplorerController::class, 'trash'])
        ->name('file-explorer.trash');

    Route::get('/file-explorer/restore/{path}', [FileExplorerController::class, 'restore'])
        ->where('path', '.*')
        ->name('file-explorer.restore');

    Route::delete('/file-explorer/delete-permanently/{path}', [FileExplorerController::class, 'deletePermanently'])
        ->where('path', '.*')
        ->name('file-explorer.delete-permanently');

    Route::post('/file-explorer/upload', [FileExplorerController::class, 'upload'])
        ->name('file-explorer.upload');

    Route::post('/file-explorer/create-folder', [FileExplorerController::class, 'createFolder'])
        ->name('file-explorer.create-folder');

    Route::post('/file-explorer/create-file', [FileExplorerController::class, 'createFile'])
        ->name('file-explorer.create-file');

    Route::post('/file-explorer/move', [FileExplorerController::class, 'moveFile'])
        ->name('file-explorer.move');
});

    Route::get('/officer/appointments/index', [OfficerAppointmentController::class, 'index'])->name('officer.appointments.index');
    Route::get('/officer/appointments/create', [OfficerAppointmentController::class, 'create'])->name('officer.appointments.create');
    Route::post('/officer/appointments/store', [OfficerAppointmentController::class, 'store'])->name('officer.appointments.store');
    Route::get('/appointments/{id}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::post('/appointment/confirm/{id}', [AppointmentController::class, 'confirmAppointment'])->name('appointment.confirm');
    Route::post('/appointment/feedback/{id}', [AppointmentController::class, 'provideFeedback'])->name('appointment.feedback');
    Route::get('/officer/appointments/manage', [AppointmentController::class, 'showTeacherAppointments'])->name('officer.appointments.manage');
    Route::post('/appointment/reschedule/{id}', [AppointmentController::class, 'rescheduleAppointment'])->name('appointment.reschedule');
    Route::get('/officer/appointments/appointments-manage', [AppointmentController::class, 'showTeacherAppointments'])->name('officer.appointments.appointments-manage');
    Route::post('/appointment/schedule/{id}', [AppointmentController::class, 'scheduleAppointment'])->name('appointment.schedule');
    Route::delete('/appointment/cancel/{id}', [AppointmentController::class, 'cancelAppointment'])->name('appointment.cancel');
    Route::post('/appointment/mark-completed/{id}', [AppointmentController::class, 'markAsCompleted'])->name('appointment.mark-completed');
    Route::post('/appointment/mark-availability', [AppointmentController::class, 'markAvailability'])->name('appointment.markAvailability');
    Route::get('/get-available-teachers/{date}', [AppointmentController::class, 'getAvailableTeachers']);
// Override the default login routes
    Route::get('login', [StudentLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [StudentLoginController::class, 'login']);

// Protected student routes
    Route::middleware(['auth', 'check.student.role'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Add other student-specific routes here
});

// routes/web.php
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');


require __DIR__.'/auth.php';
