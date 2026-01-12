<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use Illuminate\Http\Request;

class RecursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recursos = Recurso::orderBy('categoria')->orderBy('nombre')->get();
        return view('recursos.index', compact('recursos'));
    }

    public function create()
    {
        return view('recursos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'url' => 'required|url',
            'categoria' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string'
        ]);

        Recurso::create($request->all());

        return redirect()->route('recursos.index')->with('success', 'Recurso creado exitosamente.');
    }

    public function edit(Recurso $recurso)
    {
        return view('recursos.edit', compact('recurso'));
    }

    public function update(Request $request, Recurso $recurso)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'url' => 'required|url',
            'categoria' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string'
        ]);

        $recurso->update($request->all());

        return redirect()->route('recursos.index')->with('success', 'Recurso actualizado exitosamente.');
    }

    public function destroy(Recurso $recurso)
    {
        $recurso->delete();
        return redirect()->route('recursos.index')->with('success', 'Recurso eliminado exitosamente.');
    }
}
