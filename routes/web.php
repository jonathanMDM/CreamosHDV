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

// Password Change Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', function () {
        return view('auth.change-password');
    })->name('password.change');
    
    Route::post('/change-password', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        $user->update([
            'password' => \Hash::make($request->password),
            'must_change_password' => false,
        ]);

        return redirect()->route('dashboard')->with('success', '¡Contraseña actualizada exitosamente!');
    })->name('password.update.first');
});

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

    // Mantenimiento (Temporal)
    Route::get('/system/migrate', function() {
        if (auth()->user()->role === 'admin') {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            return "Migraciones ejecutadas exitosamente. El software está listo para empezar desde 1.";
        }
        abort(403);
    });

    // Redirect home to dashboard
    Route::get('/home', function() {
        return redirect()->route('dashboard');
    })->name('home');
});
