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
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'cedula' => 'required|string|unique:asesors,cedula',
            'email' => 'required|email|unique:users,email|unique:asesors,email',
            'banco' => 'required|in:Nequi,Bancolombia,Daviplata,Nu,Otros',
            'numero_cuenta' => 'required|string',
            'whatsapp' => 'required|string',
            'ciudad' => 'required|string|max:255',
        ]);

        $asesor = Asesor::create($validated);

        // Crear usuario vinculado automáticamente
        $user = User::create([
            'name' => $asesor->nombre_completo,
            'email' => $asesor->email,
            'password' => Hash::make($asesor->cedula),
            'role' => 'asesor',
        ]);

        $asesor->update(['user_id' => $user->id]);

        return redirect()->route('asesores.index')
            ->with('success', 'Asesor registrado exitosamente. Ya puede iniciar sesión con su correo y cédula.');
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
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'cedula' => 'required|string|unique:asesors,cedula,' . $asesor->id,
            'email' => 'required|email|unique:asesors,email,' . $asesor->id,
            'banco' => 'required|in:Nequi,Bancolombia,Daviplata,Nu,Otros',
            'numero_cuenta' => 'required|string',
            'whatsapp' => 'required|string',
            'ciudad' => 'required|string|max:255',
        ]);

        $asesor->update($validated);

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
        $asesor->delete();

        return redirect()->route('asesores.index')
            ->with('success', 'Asesor eliminado exitosamente');
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
}
