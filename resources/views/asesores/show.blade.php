@extends('layouts.app')

@section('title', 'Detalles del Asesor - CreamosHDV')

@section('content')
<div class="fade-in">
    <div class="mb-4">
        <a href="{{ route('asesores.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="row g-4">
        <!-- Información del Asesor -->
        <div class="col-lg-4">
            <div class="card-custom">
                <div class="card-header-custom">
                    <i class="fas fa-user"></i> Información del Asesor
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-circle fa-5x text-primary"></i>
                        <h4 class="mt-3 mb-0">{{ $asesor->nombre_completo }}</h4>
                        <p class="text-muted">Asesor</p>
                    </div>

                    <div class="mb-3">
                        <strong><i class="fas fa-id-card"></i> Cédula:</strong>
                        <p class="mb-0">{{ $asesor->cedula }}</p>
                    </div>

                    <div class="mb-3">
                        <strong><i class="fas fa-university"></i> Banco:</strong>
                        <p class="mb-0">
                            <span class="badge badge-custom badge-{{ strtolower($asesor->banco) }}">
                                {{ $asesor->banco }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <strong><i class="fas fa-credit-card"></i> Número de Cuenta:</strong>
                        <p class="mb-0">{{ $asesor->numero_cuenta }}</p>
                    </div>

                    <div class="mb-3">
                        <strong><i class="fas fa-map-marker-alt"></i> Ciudad:</strong>
                        <p class="mb-0">{{ $asesor->ciudad }}</p>
                    </div>

                    <div class="mb-3">
                        <strong><i class="fas fa-calendar"></i> Fecha de Registro:</strong>
                        <p class="mb-0">
                            {{ $asesor->created_at ? $asesor->created_at->format('d/m/Y H:i') : 'No disponible' }}
                        </p>
                    </div>


                    <div class="d-flex flex-column gap-2 mt-4">
                        <a href="https://wa.me/57{{ preg_replace('/[^0-9]/', '', $asesor->whatsapp) }}" 
                           target="_blank" 
                           class="whatsapp-btn text-center">
                            <i class="fab fa-whatsapp"></i> Contactar por WhatsApp
                        </a>
                        <a href="{{ route('asesores.edit', $asesor) }}" class="btn btn-warning-custom text-center">
                            <i class="fas fa-edit"></i> Editar Información
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas y Ventas -->
        <div class="col-lg-8">
            <!-- Estadísticas -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="fas fa-shopping-cart fa-2x text-info mb-2"></i>
                        <h3>{{ $asesor->ventas->count() }}</h3>
                        <p>Total Ventas</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="fas fa-dollar-sign fa-2x text-warning mb-2"></i>
                        <h3>${{ number_format($asesor->ventas->sum('valor_servicio'), 0, ',', '.') }}</h3>
                        <p>Ingresos Generados</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="fas fa-percentage fa-2x text-success mb-2"></i>
                        <h3>${{ number_format($asesor->ventas->sum('comision'), 0, ',', '.') }}</h3>
                        <p>Comisiones</p>
                    </div>
                </div>
            </div>

            <!-- Historial de Ventas -->
            <div class="card-custom">
                <div class="card-header-custom">
                    <i class="fas fa-history"></i> Historial de Ventas
                </div>
                <div class="card-body">
                    @if($asesor->ventas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-custom">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Servicio</th>
                                        <th>Valor</th>
                                        <th>Comisión</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($asesor->ventas as $venta)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $venta->servicio->nombre_servicio }}</td>
                                            <td>${{ number_format($venta->valor_servicio, 0, ',', '.') }}</td>
                                            <td class="text-success fw-bold">
                                                ${{ number_format($venta->comision, 0, ',', '.') }}
                                            </td>
                                            <td>{{ $venta->created_at ? $venta->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay ventas registradas</h5>
                            <p class="text-muted">Este asesor aún no ha realizado ventas</p>
                            <a href="{{ route('ventas.create') }}" class="btn btn-primary-custom mt-3">
                                <i class="fas fa-plus"></i> Registrar Venta
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
