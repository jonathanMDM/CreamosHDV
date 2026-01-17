@extends('layouts.app')

@section('title', 'Reporte Financiero - CreamosHDV')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-white">
            <i class="fas fa-chart-line text-primary"></i> Reporte Financiero
        </h1>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-info-custom">
                <i class="fas fa-print"></i> Imprimir / PDF
            </button>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card-custom mb-4">
        <div class="card-body py-3">
            <form action="{{ route('reportes.index') }}" method="GET" class="row align-items-end g-3">
                <div class="col-md-4">
                    <label class="form-label small text-white-50">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" value="{{ $fechaInicio }}" class="form-control form-control-custom">
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-white-50">Fecha Fin</label>
                    <input type="date" name="fecha_fin" value="{{ $fechaFin }}" class="form-control form-control-custom">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="fas fa-filter"></i> Filtrar Reporte
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Resumen Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card-modern stat-card-blue h-100">
                <div class="stat-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-content">
                    <p class="text-white-50 mb-1">Total Ganado</p>
                    <h3 class="fw-bold mb-0">${{ number_format($totalIngresos, 0, ',', '.') }}</h3>
                    <small class="text-success">{{ $ventas->count() }} ventas aprobadas</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-modern stat-card-orange h-100">
                <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="stat-content">
                    <p class="text-white-50 mb-1">Comisiones Pagadas</p>
                    <h3 class="fw-bold mb-0">${{ number_format($pagosRealizados, 0, ',', '.') }}</h3>
                    <small class="text-warning">Pagos liquidados</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-modern h-100" style="border-left: 4px solid #ef4444;">
                <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <p class="text-white-50 mb-1">Pendiente por Pagar</p>
                    <h3 class="fw-bold mb-0" style="color: #ef4444;">${{ number_format($totalComisionesGeneradas - $pagosRealizados, 0, ',', '.') }}</h3>
                    <small class="text-danger">Comisiones pendientes</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-modern stat-card-green h-100" style="border-left: 4px solid #10b981;">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-content">
                    <p class="text-white-50 mb-1">Lo que queda libre</p>
                    <h3 class="fw-bold mb-0" style="color: #10b981;">${{ number_format($gananciaNetaEsperada, 0, ',', '.') }}</h3>
                    <small class="text-white-50">Ganancia neta proyectada</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Detalle de Ventas -->
    <div class="card-custom">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <span><i class="fas fa-file-invoice-dollar me-2"></i> Detalle de Movimientos</span>
            <span class="badge bg-primary">{{ $ventas->count() }} Registros</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Asesor</th>
                            <th>Servicio</th>
                            <th class="text-end">Valor Venta</th>
                            <th class="text-end">Comisión</th>
                            <th class="text-end">Utilidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ventas as $venta)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    <div class="fw-bold">{{ $venta->nombre_cliente }}</div>
                                    <small class="text-white-50">{{ $venta->telefono_cliente }}</small>
                                </td>
                                <td>
                                    @if($venta->asesor)
                                        {{ $venta->asesor->nombre_completo }}
                                    @else
                                        <span class="badge bg-info text-dark">Venta Directa</span>
                                    @endif
                                </td>
                                <td>{{ $venta->servicio ? $venta->servicio->nombre_servicio : 'N/A' }}</td>
                                <td class="text-end fw-bold">${{ number_format($venta->valor_servicio, 0, ',', '.') }}</td>
                                <td class="text-end text-warning">${{ number_format($venta->comision, 0, ',', '.') }}</td>
                                <td class="text-end text-success fw-bold">
                                    ${{ number_format($venta->valor_servicio - $venta->comision, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    No se encontraron ventas para este periodo
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($ventas->count() > 0)
                        <tfoot style="background: rgba(255,255,255,0.05);">
                            <tr class="fw-bold">
                                <td colspan="4" class="text-end">TOTALES:</td>
                                <td class="text-end">${{ number_format($totalIngresos, 0, ',', '.') }}</td>
                                <td class="text-end text-warning">${{ number_format($totalComisionesGeneradas, 0, ',', '.') }}</td>
                                <td class="text-end text-success">${{ number_format($gananciaNetaEsperada, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar-custom, .sidebar-toggle, .btn-info-custom, .navbar-custom, form {
        display: none !important;
    }
    .main-content {
        margin-left: 0 !important;
        padding: 0 !important;
    }
    .card-custom {
        border: none !important;
        box-shadow: none !important;
    }
    body {
        background: white !important;
        color: black !important;
    }
    .text-white, .text-white-50 {
        color: black !important;
    }
    .stat-card-modern {
        border: 1px solid #eee !important;
    }
}
</style>
@endsection
