<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $startOfWeek = \Carbon\Carbon::now()->startOfWeek();
        
        if ($user->role === 'admin') {
            $totalAsesores = \App\Models\Asesor::count();
            $totalServicios = \App\Models\Servicio::count();
            $totalVentas = \App\Models\Venta::where('estado', 'aprobada')
                ->where('created_at', '>=', $startOfWeek)
                ->count();
            $totalComisiones = \App\Models\Venta::where('estado', 'aprobada')
                ->where('created_at', '>=', $startOfWeek)
                ->sum('comision');
            $totalIngresos = \App\Models\Venta::where('estado', 'aprobada')
                ->where('created_at', '>=', $startOfWeek)
                ->sum('valor_servicio');
            
            $ventasRecientes = \App\Models\Venta::with(['asesor', 'servicio'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            $topAsesores = \App\Models\Asesor::withCount(['ventas' => function($query) use ($startOfWeek) {
                $query->where('estado', '!=', 'rechazada')
                      ->where('created_at', '>=', $startOfWeek);
            }])
            ->withSum(['ventas' => function($query) use ($startOfWeek) {
                $query->where('estado', '!=', 'rechazada')
                      ->where('created_at', '>=', $startOfWeek);
            }], 'comision')
            ->orderBy('ventas_sum_comision', 'desc')
            ->take(5)
            ->get();
        } else {
            // Lógica para Asesor
            $asesor = \App\Models\Asesor::where('user_id', $user->id)->first();
            
            if (!$asesor) {
                return view('dashboard', [
                    'totalAsesores' => 0, 'totalServicios' => 0, 'totalVentas' => 0,
                    'totalComisiones' => 0, 'totalIngresos' => 0,
                    'ventasRecientes' => collect(), 'topAsesores' => collect(),
                    'error' => 'No tienes un perfil de asesor vinculado. Contacta al administrador.'
                ]);
            }

            $totalAsesores = 1;
            $totalServicios = \App\Models\Servicio::count();
            $totalVentas = \App\Models\Venta::where('asesor_id', $asesor->id)
                ->where('estado', 'aprobada')
                ->where('created_at', '>=', $startOfWeek)
                ->count();
            $totalComisiones = \App\Models\Venta::where('asesor_id', $asesor->id)
                ->where('estado', 'aprobada')
                ->where('created_at', '>=', $startOfWeek)
                ->sum('comision');
            $totalIngresos = \App\Models\Venta::where('asesor_id', $asesor->id)
                ->where('estado', 'aprobada')
                ->where('created_at', '>=', $startOfWeek)
                ->sum('valor_servicio');
            
            $ventasRecientes = \App\Models\Venta::where('asesor_id', $asesor->id)
                ->with(['asesor', 'servicio'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            $topAsesores = collect([$asesor->loadCount(['ventas' => function($query) use ($startOfWeek) {
                $query->where('estado', '!=', 'rechazada')
                      ->where('created_at', '>=', $startOfWeek);
            }])->loadSum(['ventas' => function($query) use ($startOfWeek) {
                $query->where('estado', '!=', 'rechazada')
                      ->where('created_at', '>=', $startOfWeek);
            }], 'comision')]);
        }
        
        return view('dashboard', compact(
            'totalAsesores',
            'totalServicios',
            'totalVentas',
            'totalComisiones',
            'totalIngresos',
            'ventasRecientes',
            'topAsesores'
        ));
    }
}
