<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Asesor;
use App\Models\Servicio;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $añoActual = $request->get('año', now()->year);
        
        // Determinar la semana actual según la lógica de pagos
        $fechaHoy = now();
        $semanaActualNum = $request->get('semana');
        
        if (!$semanaActualNum) {
            // Si no viene semana, buscar el número de semana de hoy según la lógica de pagos (Lunes-Domingo)
            $primerDia = \Carbon\Carbon::create($añoActual, 1, 1);
            $inicioAño = $primerDia->copy();
            while ($inicioAño->dayOfWeek !== \Carbon\Carbon::MONDAY) {
                $inicioAño->subDay();
            }
            $semanaActualNum = (int)$inicioAño->diffInWeeks($fechaHoy) + 1;
        }

        $semanaActual = $semanaActualNum;

        if ($semanaActual > 53) $semanaActual = 53;
        if ($semanaActual < 1) $semanaActual = 1;

        $query = Venta::with(['asesor', 'servicio']);

        // Filtrar por asesor si no es admin
        if ($user->role !== 'admin') {
            $asesor = Asesor::where('user_id', $user->id)->first();
            if (!$asesor) {
                return redirect()->route('dashboard')->with('error', 'No tienes un perfil de asesor vinculado.');
            }
            $query->where('asesor_id', $asesor->id);
        }

        // Calcular fechas exactas (Lunes a Domingo)
        $fecha = \Carbon\Carbon::create($añoActual, 1, 1);
        while ($fecha->dayOfWeek !== \Carbon\Carbon::MONDAY) {
            $fecha->subDay();
        }
        $fecha->addWeeks($semanaActual - 1);
        
        $inicio = $fecha->copy()->startOfDay();
        $fin = $fecha->copy()->addDays(6)->endOfDay();

        $ventas = $query->whereBetween('created_at', [$inicio, $fin])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('ventas.index', compact('ventas', 'semanaActual', 'añoActual', 'inicio', 'fin'));
    }

    public function create()
    {
        $user = auth()->user();
        $asesores = Asesor::orderBy('nombre_completo')->get();
        $servicios = Servicio::orderBy('nombre_servicio')->get();
        
        // Si es asesor, pre-seleccionar o limitar
        $myAsesor = $user->role !== 'admin' ? Asesor::where('user_id', $user->id)->first() : null;
        
        return view('ventas.create', compact('asesores', 'servicios', 'myAsesor'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        $rules = [
            'servicio_id' => 'required|exists:servicios,id',
            'comprobante' => 'nullable|image|max:5120', // Máx 5MB
        ];

        if ($user->role === 'admin') {
            $rules['asesor_id'] = 'required|exists:asesors,id';
        }

        $validated = $request->validate($rules);

        // Si es asesor, el asesor_id viene de su perfil
        if ($user->role !== 'admin') {
            $asesor = Asesor::where('user_id', $user->id)->first();
            if (!$asesor) return back()->with('error', 'No tienes perfil de asesor.');
            $asesor_id = $asesor->id;
            $estado = 'pendiente';
        } else {
            $asesor_id = $validated['asesor_id'];
            $estado = 'aprobada';
        }

        $servicio = Servicio::findOrFail($validated['servicio_id']);
        $valorServicio = $servicio->valor;
        $comision = ($valorServicio * $servicio->porcentaje_comision) / 100;

        $imageUrl = null;
        if ($request->hasFile('comprobante')) {
            $result = $request->file('comprobante')->storeOnCloudinary('ventas');
            $imageUrl = $result->getSecurePath();
        }

        Venta::create([
            'asesor_id' => $asesor_id,
            'servicio_id' => $validated['servicio_id'],
            'valor_servicio' => $valorServicio,
            'comision' => $comision,
            'image_url' => $imageUrl,
            'estado' => $estado,
        ]);

        return redirect()->route('ventas.index')
            ->with('success', 'Venta registrada exitosamente. ' . ($estado === 'pendiente' ? 'Pendiente de aprobación.' : 'Comisión: $' . number_format($comision, 0, ',', '.')));
    }

    public function show(Venta $venta)
    {
        $venta->load(['asesor', 'servicio']);
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        $asesores = Asesor::orderBy('nombre_completo')->get();
        $servicios = Servicio::orderBy('nombre_servicio')->get();
        
        return view('ventas.edit', compact('venta', 'asesores', 'servicios'));
    }

    public function update(Request $request, Venta $venta)
    {
        $validated = $request->validate([
            'asesor_id' => 'required|exists:asesors,id',
            'servicio_id' => 'required|exists:servicios,id',
        ]);

        // Obtener el servicio para recalcular la comisión
        $servicio = Servicio::findOrFail($validated['servicio_id']);
        
        // Calcular la comisión
        $valorServicio = $servicio->valor;
        $comision = ($valorServicio * $servicio->porcentaje_comision) / 100;

        // Actualizar la venta
        $venta->update([
            'asesor_id' => $validated['asesor_id'],
            'servicio_id' => $validated['servicio_id'],
            'valor_servicio' => $valorServicio,
            'comision' => $comision,
        ]);

        return redirect()->route('ventas.index')
            ->with('success', 'Venta actualizada exitosamente');
    }

    public function destroy(Venta $venta)
    {
        $venta->delete();

        return redirect()->route('ventas.index')
            ->with('success', 'Venta eliminada exitosamente');
    }

    public function aprobar(Venta $venta)
    {
        $venta->update(['estado' => 'aprobada']);
        return back()->with('success', 'Venta aprobada correctamente.');
    }

    public function rechazar(Request $request, Venta $venta)
    {
        $venta->update([
            'estado' => 'rechazada',
            'motivo_rechazo' => $request->motivo_rechazo
        ]);
        return back()->with('success', 'Venta marcada como rechazada con su respectivo motivo.');
    }
}
