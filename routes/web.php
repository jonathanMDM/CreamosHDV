<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsesorController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\RecursoController;
use Illuminate\Support\Facades\Auth;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Auth::routes(['register' => false]);

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Asesores
    Route::post('/asesores/{asesor}/usuario', [AsesorController::class, 'crearUsuario'])->name('asesores.usuario');
    Route::post('/asesores/{asesor}/toggle-usuario', [AsesorController::class, 'toggleUsuario'])->name('asesores.toggle-usuario');
    Route::resource('asesores', AsesorController::class)->parameters([
        'asesores' => 'asesor'
    ]);
    
    // Servicios
    Route::resource('servicios', ServicioController::class);
    
    // Ventas
    Route::post('/ventas/{venta}/aprobar', [VentaController::class, 'aprobar'])->name('ventas.aprobar');
    Route::post('/ventas/{venta}/rechazar', [VentaController::class, 'rechazar'])->name('ventas.rechazar');
    Route::resource('ventas', VentaController::class);
    
    // Pagos
    Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
    Route::post('/pagos/generar', [PagoController::class, 'generarPagosSemana'])->name('pagos.generar');
    Route::post('/pagos/generar-mensual', [PagoController::class, 'generarBonoMensual'])->name('pagos.generar-mensual');
    Route::post('/pagos/{id}/marcar-pagado', [PagoController::class, 'marcarPagado'])->name('pagos.marcar-pagado');
    Route::post('/pagos/{id}/marcar-no-pagado', [PagoController::class, 'marcarNoPagado'])->name('pagos.marcar-no-pagado');
    Route::post('/pagos/actualizar-todos', [PagoController::class, 'actualizarTodos'])->name('pagos.actualizar-todos');
    Route::get('/pagos/{id}/comprobante', [PagoController::class, 'comprobante'])->name('pagos.comprobante');

    // Recursos
    Route::resource('recursos', RecursoController::class);

    // Redirect home to dashboard
    Route::get('/home', function() {
        return redirect()->route('dashboard');
    })->name('home');
});
