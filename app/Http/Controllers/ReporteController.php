<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Asesor;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        // Solo administradores pueden ver reportes
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $fechaFin = $request->input('fecha_fin', Carbon::now()->format('Y-m-d'));

        // Ganancias Totales (Ventas Aprobadas)
        $ventas = Venta::where('estado', 'aprobada')
            ->whereBetween('created_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->with(['asesor', 'servicio'])
            ->get();

        $totalIngresos = $ventas->sum('valor_servicio');
        $totalComisionesGeneradas = $ventas->sum('comision');

        // Pagos realizados (lo que ya se pagó a los asesores)
        $pagosRealizados = \App\Models\Pago::where('pagado', true)
            ->whereBetween('fecha_pago', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->sum('total_pagar');

        // Comisiones pendientes (lo aprobado pero no pagado aún)
        // Nota: El sistema de pagos parece ser por semana. Para este reporte, 
        // sumaremos lo que NO esté marcado como pagado en la tabla pagos o lo que no esté en pagos aún.
        // Simplificación: Ganancia Neta = Ingresos - Comisiones Generadas
        $gananciaNetaEsperada = $totalIngresos - $totalComisionesGeneradas;
        $totalPendientePago = $totalComisionesGeneradas - \App\Models\Pago::where('pagado', true)
            ->whereBetween('created_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59']) // Asumiendo que buscamos comisiones de este periodo
            ->sum('total_pagar');

        return view('reportes.index', compact(
            'ventas',
            'totalIngresos',
            'totalComisionesGeneradas',
            'pagosRealizados',
            'gananciaNetaEsperada',
            'fechaInicio',
            'fechaFin'
        ));
    }
}
