<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Asesor;
use App\Models\Venta;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\ComprobantePagoMail;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        // Obtener el año actual
        $añoActual = $request->get('año', Carbon::now()->year);
        
        // Generar todas las semanas del año
        $semanas = $this->generarSemanasDelAño($añoActual);
        
        // Obtener todos los pagos del año actual agrupados por semana
        $pagos = Pago::with('asesor')
            ->where('año', $añoActual)
            ->where('tipo', 'semanal')
            ->orderBy('semana', 'desc')
            ->get()
            ->groupBy('semana');

        // Obtener los bonos mensuales del año actual agrupados por mes
        $bonosMensuales = Pago::with('asesor')
            ->where('año', $añoActual)
            ->where('tipo', 'mensual')
            ->orderBy('mes', 'desc')
            ->get()
            ->groupBy('mes');
        
        return view('pagos.index', compact('semanas', 'pagos', 'bonosMensuales', 'añoActual'));
    }

    public function generarPagosSemana(Request $request)
    {
        $semana = $request->semana;
        $año = $request->año;
        
        // Calcular fechas de la semana
        $fechas = $this->obtenerFechasSemana($semana, $año);
        
        // Validar que la semana ya haya terminado (debe ser después del domingo)
        $hoy = Carbon::now();
        $domingoSemana = $fechas['fin'];
        
        if ($hoy->lt($domingoSemana)) {
            return redirect()->route('pagos.index')
                ->with('warning', '⚠️ No puedes generar pagos para la Semana ' . $semana . ' todavía. Esta semana termina el ' . $domingoSemana->translatedFormat('l d \d\e F \d\e Y') . '. Los pagos se generan después del domingo.');
        }
        
        // Obtener todos los asesores
        $asesores = Asesor::all();
        
        foreach ($asesores as $asesor) {
            // Obtener ventas de la semana (excluyendo rechazadas)
            $ventas = Venta::where('asesor_id', $asesor->id)
                ->where('estado', '!=', 'rechazada')
                ->whereBetween('created_at', [$fechas['inicio'], $fechas['fin']])
                ->get();
            
            $cantidadVentas = $ventas->count();
            
            if ($cantidadVentas > 0) {
                $totalComisiones = $ventas->sum('comision');
                
                // Los pagos semanales ahora solo incluyen comisiones puras.
                // Los bonos se consolidan en el pago mensual al final del mes.
                $bonificacion = 0;
                $totalPagar = $totalComisiones;
                
                // Buscar si ya existe un pago semanal
                $pagoExistente = Pago::where('asesor_id', $asesor->id)
                    ->where('semana', $semana)
                    ->where('año', $año)
                    ->where('tipo', 'semanal')
                    ->first();
                
                if ($pagoExistente) {
                    // Solo actualizar si NO ha sido pagado
                    if (!$pagoExistente->pagado) {
                        $pagoExistente->update([
                            'total_comisiones' => $totalComisiones,
                            'bonificacion' => $bonificacion,
                            'total_pagar' => $totalPagar,
                            'cantidad_ventas' => $cantidadVentas,
                        ]);
                    }
                } else {
                    // Crear nuevo registro de pago semanal
                    Pago::create([
                        'asesor_id' => $asesor->id,
                        'tipo' => 'semanal',
                        'semana' => $semana,
                        'año' => $año,
                        'fecha_inicio_semana' => $fechas['inicio'],
                        'fecha_fin_semana' => $fechas['fin'],
                        'total_comisiones' => $totalComisiones,
                        'bonificacion' => $bonificacion,
                        'total_pagar' => $totalPagar,
                        'cantidad_ventas' => $cantidadVentas,
                        'pagado' => false,
                    ]);
                }
            } else {
                // Si no hay ventas, eliminar el pago si existe y NO ha sido pagado
                Pago::where('asesor_id', $asesor->id)
                    ->where('semana', $semana)
                    ->where('año', $año)
                    ->where('tipo', 'semanal')
                    ->where('pagado', false)
                    ->delete();
            }
        }
        
        return redirect()->route('pagos.index')
            ->with('success', 'Pagos semanales actualizados');
    }

    public function generarBonoMensual(Request $request)
    {
        $mes = $request->mes;
        $año = $request->año;
        
        $inicioMes = Carbon::create($año, $mes, 1)->startOfMonth();
        $finMes = $inicioMes->copy()->endOfMonth();
        
        // Validar que el mes ya haya terminado
        $hoy = Carbon::now();
        
        if ($hoy->lt($finMes)) {
            $nombreMes = $finMes->translatedFormat('F');
            return redirect()->route('pagos.index')
                ->with('warning', '⚠️ No puedes procesar bonos de ' . ucfirst($nombreMes) . ' todavía. El mes termina el ' . $finMes->translatedFormat('d \d\e F \d\e Y') . '. Los bonos se procesan después del fin de mes.');
        }
        
        $asesores = Asesor::all();
        $bonosGenerados = 0;
        
        foreach ($asesores as $asesor) {
            $ventasMes = Venta::where('asesor_id', $asesor->id)
                ->where('estado', '!=', 'rechazada')
                ->whereBetween('created_at', [$inicioMes, $finMes])
                ->get();
            
            $cantidadVentas = $ventasMes->count();
            
            // Solo generar bono mensual si el asesor tiene 10 o más ventas en el mes
            if ($cantidadVentas >= 10) {
                $totalVentasValor = $ventasMes->sum('valor_servicio');
                $totalComisionesArt = $ventasMes->sum('comision');
                
                // El bono mensual es el 5% del total de las ventas (valor_servicio)
                $bonoMensual = $totalVentasValor * 0.05;
                
                $pagoExistente = Pago::where('asesor_id', $asesor->id)
                    ->where('mes', $mes)
                    ->where('año', $año)
                    ->where('tipo', 'mensual')
                    ->first();
                
                if ($pagoExistente) {
                    if (!$pagoExistente->pagado) {
                        $pagoExistente->update([
                            'total_comisiones' => $totalComisionesArt,
                            'bonificacion' => $bonoMensual,
                            'total_pagar' => $bonoMensual,
                            'cantidad_ventas' => $cantidadVentas,
                        ]);
                        $bonosGenerados++;
                    }
                } else {
                    Pago::create([
                        'asesor_id' => $asesor->id,
                        'tipo' => 'mensual',
                        'mes' => $mes,
                        'año' => $año,
                        'total_comisiones' => $totalComisionesArt,
                        'bonificacion' => $bonoMensual,
                        'total_pagar' => $bonoMensual,
                        'cantidad_ventas' => $cantidadVentas,
                        'pagado' => false,
                    ]);
                    $bonosGenerados++;
                }
            } else {
                // Si tiene menos de 10 ventas, eliminar el bono si existe y NO ha sido pagado
                Pago::where('asesor_id', $asesor->id)
                    ->where('mes', $mes)
                    ->where('año', $año)
                    ->where('tipo', 'mensual')
                    ->where('pagado', false)
                    ->delete();
            }
        }
        
        return redirect()->route('pagos.index')
            ->with('success', "Bonos mensuales generados: {$bonosGenerados} asesor(es) con 10+ ventas");
    }

    public function marcarPagado($id)
    {
        // Iniciamos con una transacción por seguridad, aunque es una sola actualización
        $pago = Pago::with('asesor')->findOrFail($id);
        $mensajeExtra = "";
        $tipoMensaje = 'success';

        try {
            // --- INICIO LÓGICA DE DATOS (Misma que en comprobante) ---
            $ventas = collect();
            if ($pago->tipo == 'semanal') {
                $fechas = $this->obtenerFechasSemana($pago->semana, $pago->año);
                $ventas = Venta::with('servicio')
                    ->where('asesor_id', $pago->asesor_id)
                    ->where('estado', '!=', 'rechazada')
                    ->whereBetween('created_at', [$fechas['inicio'], $fechas['fin']])
                    ->get();
            } else {
                $inicioMes = Carbon::create($pago->año, $pago->mes, 1)->startOfMonth();
                $finMes = $inicioMes->copy()->endOfMonth();
                $ventas = Venta::with('servicio')
                    ->where('asesor_id', $pago->asesor_id)
                    ->where('estado', '!=', 'rechazada')
                    ->whereBetween('created_at', [$inicioMes, $finMes])
                    ->get();
            }
            // --- FIN LÓGICA DE DATOS ---

            // Intentar Generar PDF y Enviar Correo
            // Usamos el facade root para evitar conflictos de alias
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pagos.pdf', compact('pago', 'ventas'));
            
            // Opcional: Configurar papel si es necesario
            $pdf->setPaper('letter', 'portrait');
            
            $pdfContent = $pdf->output();

            if ($pago->asesor->email) {
                Mail::to($pago->asesor->email)->send(new ComprobantePagoMail($pago, $pago->asesor, $pdfContent));
                $mensajeExtra = " y comprobante enviado a " . $pago->asesor->email;
            }

        } catch (\Exception $e) {
            // Si algo falla en el PDF o Correo, NO detenemos el pago. Solo avisamos.
            \Log::error("Error en proceso de comprobante (Pago ID: $id): " . $e->getMessage());
            $mensajeExtra = ". ADVERTENCIA: El pago se guardó, pero hubo un error generando/enviando el comprobante PDF (" . $e->getMessage() . ")";
            $tipoMensaje = 'warning'; // Cambiamos alerta a amarilla
        }

        // Siempre marcamos como pagado, pase lo que pase con el PDF
        $pago->update([
            'pagado' => true,
            'fecha_pago' => Carbon::now(),
        ]);
        
        return redirect()->back()
            ->with($tipoMensaje, 'Pago marcado como pagado' . $mensajeExtra);
    }

    public function marcarNoPagado($id)
    {
        $pago = Pago::findOrFail($id);
        $pago->update([
            'pagado' => false,
            'fecha_pago' => null,
        ]);
        
        return redirect()->back()
            ->with('success', 'Pago marcado como no pagado');
    }

    public function comprobante($id)
    {
        $pago = Pago::with('asesor')->findOrFail($id);
        
        $ventas = collect();
        
        if ($pago->tipo == 'semanal') {
            // Obtener fechas de la semana
            $fechas = $this->obtenerFechasSemana($pago->semana, $pago->año);
            $ventas = Venta::with('servicio')
                ->where('asesor_id', $pago->asesor_id)
                ->where('estado', '!=', 'rechazada')
                ->whereBetween('created_at', [$fechas['inicio'], $fechas['fin']])
                ->get();
        } else {
            // Obtener bono mensual (ventas del mes completo)
            $inicioMes = Carbon::create($pago->año, $pago->mes, 1)->startOfMonth();
            $finMes = $inicioMes->copy()->endOfMonth();
            $ventas = Venta::with('servicio')
                ->where('asesor_id', $pago->asesor_id)
                ->where('estado', '!=', 'rechazada')
                ->whereBetween('created_at', [$inicioMes, $finMes])
                ->get();
        }

        return view('pagos.comprobante', compact('pago', 'ventas'));
    }

    private function generarSemanasDelAño($año)
    {
        $semanas = [];
        
        // Encontrar el lunes de la semana que contiene el 1 de enero
        $primerDia = Carbon::create($año, 1, 1);
        $fecha = $primerDia->copy();
        
        // Retroceder hasta encontrar el lunes de esa semana
        while ($fecha->dayOfWeek !== Carbon::MONDAY) {
            $fecha->subDay();
        }
        
        $semanaNumero = 1;
        // Generar 53 semanas para cubrir todo el año
        while ($semanaNumero <= 53) {
            $inicio = $fecha->copy(); // Lunes
            $fin = $fecha->copy()->addDays(6); // Domingo (día de pago)
            
            $semanas[] = [
                'numero' => $semanaNumero,
                'inicio' => $inicio,
                'fin' => $fin,
                'es_domingo' => $fin->dayOfWeek === Carbon::SUNDAY,
            ];
            
            $fecha->addWeek();
            $semanaNumero++;
        }
        
        return $semanas;
    }

    private function obtenerFechasSemana($semana, $año)
    {
        // Encontrar el lunes de la semana que contiene el 1 de enero
        $primerDia = Carbon::create($año, 1, 1);
        $fecha = $primerDia->copy();
        
        // Retroceder hasta encontrar el lunes de esa semana
        while ($fecha->dayOfWeek !== Carbon::MONDAY) {
            $fecha->subDay();
        }
        
        // Avanzar a la semana solicitada (semana 1 = primera semana, no sumar nada)
        $fecha->addWeeks($semana - 1);
        
        $inicio = $fecha->copy()->startOfDay(); // Lunes
        $fin = $fecha->copy()->addDays(6)->endOfDay(); // Domingo
        
        return [
            'inicio' => $inicio,
            'fin' => $fin,
        ];
    }

    public function actualizarTodos(Request $request)
    {
        $año = $request->año;
        $semanasActualizadas = 0;
        $mesesActualizados = 0;
        
        // Actualizar todas las semanas del año
        for ($semana = 1; $semana <= 52; $semana++) {
            $fechas = $this->obtenerFechasSemana($semana, $año);
            $asesores = Asesor::all();
            
            foreach ($asesores as $asesor) {
                $ventasSemana = Venta::where('asesor_id', $asesor->id)
                    ->where('estado', '!=', 'rechazada')
                    ->whereBetween('created_at', [$fechas['inicio'], $fechas['fin']])
                    ->get();
                
                $cantidadVentas = $ventasSemana->count();
                if ($cantidadVentas > 0) {
                    $totalComisiones = $ventasSemana->sum('comision');
                    
                    $pagoExistente = Pago::where('asesor_id', $asesor->id)
                        ->where('semana', $semana)
                        ->where('año', $año)
                        ->where('tipo', 'semanal')
                        ->first();
                    
                    if ($pagoExistente) {
                        if (!$pagoExistente->pagado) {
                            $pagoExistente->update([
                                'total_comisiones' => $totalComisiones,
                                'total_pagar' => $totalComisiones,
                                'cantidad_ventas' => $cantidadVentas,
                            ]);
                            $semanasActualizadas++;
                        }
                    } else {
                        Pago::create([
                            'asesor_id' => $asesor->id,
                            'tipo' => 'semanal',
                            'semana' => $semana,
                            'año' => $año,
                            'total_comisiones' => $totalComisiones,
                            'total_pagar' => $totalComisiones,
                            'cantidad_ventas' => $cantidadVentas,
                            'pagado' => false,
                        ]);
                        $semanasActualizadas++;
                    }
                } else {
                    Pago::where('asesor_id', $asesor->id)
                        ->where('semana', $semana)
                        ->where('año', $año)
                        ->where('tipo', 'semanal')
                        ->where('pagado', false)
                        ->delete();
                }
            }
        }
        
        // Actualizar todos los meses del año
        for ($mes = 1; $mes <= 12; $mes++) {
            $inicioMes = Carbon::create($año, $mes, 1)->startOfMonth();
            $finMes = $inicioMes->copy()->endOfMonth();
            $asesores = Asesor::all();
            
            foreach ($asesores as $asesor) {
                $ventasMes = Venta::where('asesor_id', $asesor->id)
                    ->where('estado', '!=', 'rechazada')
                    ->whereBetween('created_at', [$inicioMes, $finMes])
                    ->get();
                
                $cantidadVentas = $ventasMes->count();
                
                if ($cantidadVentas >= 10) {
                    $totalVentasValor = $ventasMes->sum('valor_servicio');
                    $totalComisionesArt = $ventasMes->sum('comision');
                    $bonoMensual = $totalVentasValor * 0.05;
                    
                    $pagoExistente = Pago::where('asesor_id', $asesor->id)
                        ->where('mes', $mes)
                        ->where('año', $año)
                        ->where('tipo', 'mensual')
                        ->first();
                    
                    if ($pagoExistente) {
                        if (!$pagoExistente->pagado) {
                            $pagoExistente->update([
                                'total_comisiones' => $totalComisionesArt,
                                'bonificacion' => $bonoMensual,
                                'total_pagar' => $bonoMensual,
                                'cantidad_ventas' => $cantidadVentas,
                            ]);
                            $mesesActualizados++;
                        }
                    } else {
                        Pago::create([
                            'asesor_id' => $asesor->id,
                            'tipo' => 'mensual',
                            'mes' => $mes,
                            'año' => $año,
                            'total_comisiones' => $totalComisionesArt,
                            'bonificacion' => $bonoMensual,
                            'total_pagar' => $bonoMensual,
                            'cantidad_ventas' => $cantidadVentas,
                            'pagado' => false,
                        ]);
                        $mesesActualizados++;
                    }
                } else {
                    Pago::where('asesor_id', $asesor->id)
                        ->where('mes', $mes)
                        ->where('año', $año)
                        ->where('tipo', 'mensual')
                        ->where('pagado', false)
                        ->delete();
                }
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => "<strong>Actualización completada:</strong><br><br>" .
                        "✓ {$semanasActualizadas} pagos semanales actualizados/creados<br>" .
                        "✓ {$mesesActualizados} bonos mensuales actualizados/creados"
        ]);
    }
}
