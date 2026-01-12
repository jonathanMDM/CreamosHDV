@extends('layouts.app')

@section('title', 'Detalles del Servicio - CreamosHDV')

@section('content')
<div class="fade-in">
    <div class="mb-4">
        <a href="{{ route('servicios.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card-custom">
                <div class="card-header-custom">
                    <i class="fas fa-info-circle"></i> Información del Servicio
                </div>
                <div class="card-body text-center">
                    <i class="fas fa-file-alt fa-5x text-primary mb-4"></i>
                    <h3>{{ $servicio->nombre_servicio }}</h3>
                    
                    <div class="my-4">
                        <h2 class="text-success mb-0">
                            ${{ number_format($servicio->valor, 0, ',', '.') }}
                        </h2>
                        <small class="text-muted">Valor del Servicio</small>
                    </div>

                    <div class="mb-4">
                        <span class="badge bg-warning text-dark" style="font-size: 1.2rem; padding: 0.75rem 1.5rem;">
                            {{ $servicio->porcentaje_comision }}% Comisión
                        </span>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('servicios.edit', $servicio) }}" class="btn btn-warning-custom">
                            <i class="fas fa-edit"></i> Editar Servicio
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="stat-card">
                        <i class="fas fa-shopping-cart fa-2x text-info mb-2"></i>
                        <h3>{{ $servicio->ventas->count() }}</h3>
                        <p>Total Ventas</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card">
                        <i class="fas fa-dollar-sign fa-2x text-success mb-2"></i>
                        <h3>${{ number_format($servicio->ventas->sum('valor_servicio'), 0, ',', '.') }}</h3>
                        <p>Ingresos Generados</p>
                    </div>
                </div>
            </div>

            <div class="card-custom">
                <div class="card-header-custom">
                    <i class="fas fa-history"></i> Historial de Ventas
                </div>
                <div class="card-body p-0">
                    @if($servicio->ventas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">Item</th>
                                        <th>Asesor</th>
                                        <th class="text-end">Valor</th>
                                        <th class="text-end">Comisión</th>
                                        <th class="text-center">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($servicio->ventas as $venta)
                                        <tr>
                                            <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                            <td class="align-middle">
                                                <strong>{{ $venta->asesor->nombre_completo }}</strong>
                                            </td>
                                            <td class="text-end align-middle">
                                                ${{ number_format($venta->valor_servicio, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end align-middle">
                                                <span class="text-success fw-bold">
                                                    ${{ number_format($venta->comision, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <small>{{ $venta->created_at->format('d/m/Y H:i') }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay ventas registradas</h5>
                            <p class="text-muted">Este servicio aún no ha sido vendido</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
