<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\CalendarioController;
use Illuminate\Support\Facades\Route;


Route::post('/calendario/restaurar-manual', [CalendarioController::class, 'restaurarManual'])
    ->name('calendario.restaurarManual');
Route::get('/', [CalendarioController::class, 'publico'])->name('calendario.publico');

// Ruta pública directa
Route::get('/calendario-publico', [CalendarioController::class, 'publico'])->name('calendario.publico');

Route::middleware(['auth'])->group(function () {

    // CALENDARIO ADMIN
    Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');
    Route::get('/calendario/dia/{fecha}', [CalendarioController::class, 'show'])->name('calendario.show');

    // PERFIL
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Acciones internas protegidas
    Route::post('/calendario', [CalendarioController::class, 'store'])->name('calendario.store');
    Route::delete('/calendario/{id}', [CalendarioController::class, 'destroy'])->name('calendario.destroy');

    Route::put('/empleados/{id}/toggle', [EmpleadosController::class, 'toggle']);
});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('empleados', EmpleadosController::class);
});
Route::post('/calendario/asignar-manual', [CalendarioController::class, 'asignarManual'])
    ->name('calendario.asignarManual');
    Route::post('/calendario/asignar-manual', [CalendarioController::class, 'asignarManual'])
    ->name('calendario.asignarManual');


Route::get('/dashboard', function () {
    return redirect('/empleados');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';