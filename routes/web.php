<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsesorController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\RecursoController;
use Illuminate\Support\Facades\Auth;

// Public Landing Page
Route::get('/', function () {
    $servicios = \App\Models\Servicio::all();
    return view('welcome', compact('servicios'));
});

Route::get('/home', function () {
    return view('welcome');
})->name('home');


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
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',      // Al menos una mayúscula
                'regex:/[0-9]/',      // Al menos un número
                'regex:/[@$!%*#?&]/', // Al menos un carácter especial
            ],
        ], [
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, un número y un carácter especial.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
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
    
    // Manual de Usuario
    Route::get('/manual', function () {
        return view('manuales.index');
    })->name('manuales.index');
    
    // Asesores
    Route::post('/asesores/{asesor}/usuario', [AsesorController::class, 'crearUsuario'])->name('asesores.usuario');
    Route::post('/asesores/{asesor}/toggle-usuario', [AsesorController::class, 'toggleUsuario'])->name('asesores.toggle-usuario');
    Route::put('/asesores/{asesor}/cambiar-clave', [AsesorController::class, 'cambiarClave'])->name('asesores.cambiar-clave');
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
    Route::post('/pagos/{id}/enviar-correo', [PagoController::class, 'enviarCorreo'])->name('pagos.enviar-correo');

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


});
