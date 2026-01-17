@extends('layouts.app')

@section('title', 'Dashboard - CreamosHDV')

@section('content')
<div class="fade-in">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="text-white mb-2">
            <i class="fas fa-chart-line"></i> Dashboard
        </h1>
        <p class="text-white-50 mb-0">Resumen general del negocio</p>
    </div>

    <!-- Statistics Cards - Grid Mejorado -->
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="stat-card-modern stat-card-blue">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalAsesores }}</h3>
                    <p>Asesores Activos</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card-modern stat-card-green">
                <div class="stat-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalServicios }}</h3>
                    <p>Servicios Disponibles</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card-modern stat-card-purple">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalVentas }}</h3>
                    <p>Ventas de la Semana</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="stat-card-modern stat-card-orange">
                <div class="stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-content">
                    @if(auth()->user()->role === 'admin')
                        <h3>${{ number_format($totalIngresos, 0, ',', '.') }}</h3>
                        <p>Ingresos de la Semana</p>
                    @else
                        <h3>${{ number_format($totalComisiones, 0, ',', '.') }}</h3>
                        <p>Comisiones de la Semana</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Comisiones Destacadas (Solo Admin) -->
    @if(auth()->user()->role === 'admin')
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card-modern card-gradient-success">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="text-white mb-1">
                            <i class="fas fa-percentage"></i> Comisiones de la Semana
                        </h5>
                        <h2 class="text-white mb-0">${{ number_format($totalComisiones, 0, ',', '.') }}</h2>
                        <small class="text-white-50">Total acumulado desde el lunes</small>
                    </div>
                    <div class="stat-icon-large">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Contenido Principal -->
    <div class="row g-4">
        <!-- Ventas Recientes -->
        <div class="col-12">
            <div class="card-modern">
                <div class="card-header-modern">
                    <h5 class="mb-0">
                        <i class="fas fa-history"></i> Ventas Recientes
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($ventasRecientes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-custom table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Asesor</th>
                                        <th>Servicio</th>
                                        <th>Valor</th>
                                        <th>Comisión</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ventasRecientes as $venta)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($venta->asesor)
                                                        <div class="avatar-circle bg-primary text-white me-2">
                                                            {{ substr($venta->asesor->nombre_completo, 0, 1) }}
                                                        </div>
                                                        <strong>{{ $venta->asesor->nombre_completo }}</strong>
                                                    @else
                                                        <div class="avatar-circle bg-success text-white me-2">
                                                            <i class="fas fa-store"></i>
                                                        </div>
                                                        <strong>Venta Directa</strong>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ $venta->servicio->nombre_servicio }}</td>
                                            <td class="fw-bold">${{ number_format($venta->valor_servicio, 0, ',', '.') }}</td>
                                            <td>
                                                @php
                                                    $statusClass = 'badge-status-' . $venta->estado;
                                                @endphp
                                                <span class="badge {{ $statusClass }} py-2 px-3" style="font-size: 0.9rem;">
                                                    ${{ number_format($venta->comision, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('ventas.show', $venta) }}" class="btn btn-outline-light btn-sm rounded-pill px-3" style="font-size: 0.7rem; border-color: rgba(255,255,255,0.1);">
                                                    <i class="fas fa-eye me-1"></i> Ver
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay ventas registradas</p>
                            <a href="{{ route('ventas.create') }}" class="btn btn-primary-custom btn-sm">
                                <i class="fas fa-plus"></i> Registrar Primera Venta
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Asesores (Solo Admin) -->
        @if(auth()->user()->role === 'admin')
        <div class="col-12">
            <div class="card-modern">
                <div class="card-header-modern">
                    <h5 class="mb-0">
                        <i class="fas fa-trophy"></i> Top Asesores (Semana)
                    </h5>
                </div>
                <div class="card-body">
                    @if($topAsesores->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($topAsesores as $index => $asesor)
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex align-items-center">
                                        <div class="rank-badge rank-{{ $index + 1 }} me-3">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $asesor->nombre_completo }}</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-shopping-cart"></i> {{ $asesor->ventas_count }} ventas
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <div class="badge badge-success-modern">
                                                ${{ number_format($asesor->ventas_sum_comision ?? 0, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay asesores registrados</p>
                            <a href="{{ route('asesores.create') }}" class="btn btn-primary-custom btn-sm">
                                <i class="fas fa-plus"></i> Registrar Asesor
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Acciones Rápidas (Solo Admin) -->
    @if(auth()->user()->role === 'admin')
    <div class="row g-3 mt-4">
        <div class="col-12">
            <h5 class="text-white mb-3">
                <i class="fas fa-bolt"></i> Acciones Rápidas
            </h5>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('asesores.create') }}" class="quick-action-card">
                <div class="quick-action-icon bg-primary">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h6>Registrar Asesor</h6>
                <p class="text-muted mb-0">Agregar nuevo asesor al sistema</p>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('servicios.create') }}" class="quick-action-card">
                <div class="quick-action-icon bg-success">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h6>Crear Servicio</h6>
                <p class="text-muted mb-0">Agregar nuevo servicio</p>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('ventas.create') }}" class="quick-action-card">
                <div class="quick-action-icon bg-info">
                    <i class="fas fa-cart-plus"></i>
                </div>
                <h6>Registrar Venta</h6>
                <p class="text-muted mb-0">Nueva venta de servicio</p>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('pagos.index') }}" class="quick-action-card">
                <div class="quick-action-icon bg-warning">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h6>Gestionar Pagos</h6>
                <p class="text-muted mb-0">Ver pagos semanales</p>
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
