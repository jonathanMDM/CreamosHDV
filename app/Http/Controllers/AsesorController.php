<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AsesorController extends Controller
{
    public function index()
    {
        $asesores = Asesor::withCount(['ventas' => function($query) {
            $query->where('estado', '!=', 'rechazada');
        }])
        ->withSum(['ventas' => function($query) {
            $query->where('estado', '!=', 'rechazada');
        }], 'comision')
        ->orderBy('created_at', 'desc')
        ->get();
        
        return view('asesores.index', compact('asesores'));
    }

    public function create()
    {
        return view('asesores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'cedula' => 'required|string|unique:asesors,cedula',
            'email' => 'required|email|unique:users,email|unique:asesors,email',
            'banco' => 'required|string',
            'banco_nombre_otro' => 'required_if:banco,Otros|nullable|string|max:255',
            'numero_cuenta' => 'required|string',
            'whatsapp' => 'required|string',
            'ciudad' => 'required|string|max:255',
        ]);

        $asesor = Asesor::create($request->all());

        // Crear usuario vinculado automáticamente
        $user = User::create([
            'name' => $asesor->nombre_completo,
            'email' => $asesor->email,
            'password' => Hash::make($asesor->cedula),
            'role' => 'asesor',
            'must_change_password' => true, // Forzar cambio de contraseña
        ]);

        $asesor->update(['user_id' => $user->id]);

        // Enviar notificación con credenciales
        $user->notify(new \App\Notifications\WelcomeAdvisorNotification($asesor->email, $asesor->cedula));

        return redirect()->route('asesores.index')
            ->with('success', 'Asesor registrado exitosamente. Se ha enviado un correo con sus credenciales (Contraseña inicial: Cédula).');
    }

    public function show(Asesor $asesor)
    {
        $asesor->load('ventas.servicio');
        return view('asesores.show', compact('asesor'));
    }

    public function edit(Asesor $asesor)
    {
        return view('asesores.edit', compact('asesor'));
    }

    public function update(Request $request, Asesor $asesor)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'cedula' => 'required|string|unique:asesors,cedula,' . $asesor->id,
            'email' => 'required|email|unique:asesors,email,' . $asesor->id,
            'banco' => 'required|string',
            'banco_nombre_otro' => 'required_if:banco,Otros|nullable|string|max:255',
            'numero_cuenta' => 'required|string',
            'whatsapp' => 'required|string',
            'ciudad' => 'required|string|max:255',
        ]);

        $asesor->update($request->all());

        // Actualizar usuario vinculado si existe
        if ($asesor->user) {
            $asesor->user->update([
                'name' => $asesor->nombre_completo,
                'email' => $asesor->email,
            ]);
            
            // Si la cédula cambió, opcionalmente actualizar el password
            // Pero mejor dejarlo como está a menos que el admin quiera resetearlo
        }

        return redirect()->route('asesores.index')
            ->with('success', 'Asesor actualizado exitosamente');
    }

    public function destroy(Asesor $asesor)
    {
        // Guardar referencia al usuario antes de borrar el asesor
        $user = $asesor->user;
        
        $asesor->delete();
        
        // Borrar usuario permanentemente si existe
        if ($user) {
            $user->delete();
        }

        return redirect()->route('asesores.index')
            ->with('success', 'Asesor y su cuenta de usuario eliminados permanentemente.');
    }

    public function crearUsuario(Asesor $asesor)
    {
        if ($asesor->user_id) {
            return back()->with('error', 'Este asesor ya tiene un usuario vinculado.');
        }

        // Usar su correo registrado o uno genérico si no tiene
        $email = $asesor->email ?: (strtolower(str_replace(' ', '.', $asesor->nombre_completo)) . $asesor->id . '@creamoshdv.com');
        
        $user = User::create([
            'name' => $asesor->nombre_completo,
            'email' => $email,
            'password' => Hash::make($asesor->cedula), // Password inicial es su cédula
            'role' => 'asesor',
            'must_change_password' => true, // Forzar cambio de contraseña
        ]);

        $asesor->update(['user_id' => $user->id, 'email' => $email]);

        return back()->with('success', "Usuario creado para el asesor. \nEmail: $email \nPassword: (Cédula del asesor)");
    }

    public function toggleUsuario(Asesor $asesor)
    {
        if (!$asesor->user_id || !$asesor->user) {
            return back()->with('error', 'El asesor no tiene un usuario vinculado.');
        }

        $user = $asesor->user;
        $user->is_active = !$user->is_active;
        $user->save();

        $estado = $user->is_active ? 'habilitado' : 'deshabilitado';
        return back()->with('success', "Acceso al portal $estado correctamente para el asesor.");
    }
    public function cambiarClave(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $asesor = Asesor::findOrFail($id);
        
        if (!$asesor->user_id) {
            // Intentar buscar usuario por email si no está vinculado
            $user = User::where('email', $asesor->email)->first();
            if ($user) {
                // Vincular si se encuentra
                $asesor->user_id = $user->id;
                $asesor->save();
            } else {
                return back()->with('error', 'Este asesor no tiene un usuario de sistema. Genérelo primero.');
            }
        } else {
            $user = User::findOrFail($asesor->user_id);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Contraseña restablecida correctamente.');
    }
}
