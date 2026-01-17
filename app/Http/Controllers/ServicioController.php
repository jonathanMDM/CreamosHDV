<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::withCount('ventas')
            ->withSum('ventas', 'valor_servicio')
            ->orderBy('orden', 'asc')
            ->orderBy('nombre_servicio', 'asc')
            ->get();
        
        return view('servicios.index', compact('servicios'));
    }

    public function create()
    {
        return view('servicios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_servicio' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'icono' => 'nullable|string|max:255',
            'valor' => 'required|numeric|min:0',
            'porcentaje_comision' => 'required|numeric|min:0|max:100',
            'orden' => 'required|integer|min:0',
        ]);

        $validated['visible_en_landing'] = $request->has('visible_en_landing');

        Servicio::create($validated);

        return redirect()->route('servicios.index')
            ->with('success', 'Servicio creado exitosamente');
    }

    public function show(Servicio $servicio)
    {
        $servicio->load('ventas.asesor');
        return view('servicios.show', compact('servicio'));
    }

    public function edit(Servicio $servicio)
    {
        return view('servicios.edit', compact('servicio'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $validated = $request->validate([
            'nombre_servicio' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'icono' => 'nullable|string|max:255',
            'valor' => 'required|numeric|min:0',
            'porcentaje_comision' => 'required|numeric|min:0|max:100',
            'orden' => 'required|integer|min:0',
        ]);

        $validated['visible_en_landing'] = $request->has('visible_en_landing');

        $servicio->update($validated);

        return redirect()->route('servicios.index')
            ->with('success', 'Servicio actualizado exitosamente');
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->delete();

        return redirect()->route('servicios.index')
            ->with('success', 'Servicio eliminado exitosamente');
    }
}
