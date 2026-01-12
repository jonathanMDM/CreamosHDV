@extends('layouts.app')

@section('title', 'Ventas - CreamosHDV')

@section('content')
<div class="fade-in">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="text-white mb-1">
                <i class="fas fa-shopping-cart"></i> Ventas
            </h1>
            <p class="text-white-50 mb-0">Gestión de registros por semana</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('ventas.create') }}" class="btn btn-success-custom">
                <i class="fas fa-plus"></i> Nueva Venta
            </a>
        </div>
    </div>

    <!-- Navegador de Semanas -->
    <div class="card-custom mb-4 fade-in">
        <div class="card-body py-2 px-2">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <a href="{{ route('ventas.index', ['semana' => $semanaActual - 1, 'año' => $añoActual]) }}" 
                   class="btn btn-outline-light btn-sm {{ $semanaActual <= 1 ? 'disabled' : '' }}" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                    <i class="fas fa-chevron-left"></i><span class="d-none d-md-inline"> Semana Anterior</span>
                </a>
                
                <div class="text-center flex-grow-1">
                    <h6 class="mb-0 fw-bold" style="font-size: 0.9rem;">Semana {{ $semanaActual }} - {{ $añoActual }}</h6>
                    <small class="text-muted text-capitalize" style="font-size: 0.7rem;">
                        {{ $inicio->translatedFormat('d M') }} al {{ $fin->translatedFormat('d M, Y') }}
                    </small>
                </div>

                <a href="{{ route('ventas.index', ['semana' => $semanaActual + 1, 'año' => $añoActual]) }}" 
                   class="btn btn-outline-light btn-sm {{ $semanaActual >= 52 ? 'disabled' : '' }}" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                    <span class="d-none d-md-inline">Semana Siguiente </span><i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="card-custom fade-in">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list"></i> Registro de Ventas</span>
            <span class="badge bg-white text-dark">{{ $ventas->count() }} Resultados</span>
        </div>
        <div class="card-body">
            @if($ventas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-custom js-table w-100" width="100%">
                        <thead>
                            <tr>
                                <th style="width: 5%;">Item</th>
                                <th style="width: 20%;">Asesor</th>
                                <th style="width: 25%;">Servicio</th>
                                <th style="width: 12%;">Valor Servicio</th>
                                <th style="width: 12%;">Comisión</th>
                                <th style="width: 15%;">Fecha</th>
                                <th style="width: 10%;">Estado</th>
                                <th class="no-sort" style="width: 11%;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ventas as $venta)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary text-white me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">
                                                {{ substr($venta->asesor->nombre_completo, 0, 1) }}
                                            </div>
                                            {{ $venta->asesor->nombre_completo }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-info"><i class="fas fa-file-alt"></i></span>
                                        {{ $venta->servicio->nombre_servicio }}
                                    </td>
                                    <td class="fw-bold">
                                        ${{ number_format($venta->valor_servicio, 0, ',', '.') }}
                                        @if($venta->tipo_pago === 'pago_50')
                                            <span class="badge bg-info d-block mt-1" style="font-size: 0.65rem;">PAGO 50%</span>
                                        @else
                                            <span class="badge bg-secondary d-block mt-1" style="font-size: 0.65rem;">TOTAL</span>
                                        @endif
                                    </td>
                                    <td class="text-success fw-bold">
                                        ${{ number_format($venta->comision, 0, ',', '.') }}
                                        <small class="text-muted d-block" style="font-size: 0.7rem;">
                                            ({{ $venta->servicio->porcentaje_comision }}%)
                                        </small>
                                    </td>
                                    <td>
                                        {{ $venta->created_at->format('d/m/Y') }}
                                        <small class="text-muted d-block" style="font-size: 0.7rem;">
                                            {{ $venta->created_at->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($venta->estado === 'aprobada')
                                            <span class="badge bg-success">Aprobada</span>
                                        @elseif($venta->estado === 'pendiente')
                                            <span class="badge bg-warning text-dark">Pendiente</span>
                                        @else
                                            <span class="badge bg-danger" 
                                                  data-bs-toggle="tooltip" 
                                                  data-bs-placement="top" 
                                                  title="Motivo: {{ $venta->motivo_rechazo ?? 'No especificado' }}">
                                                Rechazada
                                            </span>
                                            @if($venta->motivo_rechazo)
                                                <small class="text-danger d-block mt-1" style="font-size: 0.7rem; max-width: 120px;">
                                                    {{ Str::limit($venta->motivo_rechazo, 40) }}
                                                </small>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            @if(auth()->user()->role === 'admin' && $venta->estado === 'pendiente')
                                                <form action="{{ route('ventas.aprobar', $venta) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Aprobar">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Rechazar"
                                                        onclick="rechazarVenta('{{ route('ventas.rechazar', $venta) }}', '{{ $venta->asesor->nombre_completo }}')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                            <a href="{{ route('ventas.show', $venta) }}" 
                                               class="btn btn-sm btn-primary-custom" 
                                                title="Ver detalles">
                                                 <i class="fas fa-eye"></i>
                                             </a>
                                            <a href="{{ route('ventas.edit', $venta) }}" 
                                               class="btn btn-sm btn-warning-custom" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('ventas.destroy', $venta) }}" 
                                                  method="POST" 
                                                  class="d-inline js-confirm"
                                                  data-confirm="¿Está seguro de eliminar esta venta?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger-custom" 
                                                        title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-active">
                                <th colspan="3" class="text-end">TOTALES SEMANA:</th>
                                <th>${{ number_format($ventas->where('estado', '!=', 'rechazada')->sum('valor_servicio'), 0, ',', '.') }}</th>
                                <th class="text-success">${{ number_format($ventas->where('estado', '!=', 'rechazada')->sum('comision'), 0, ',', '.') }}</th>
                                <th colspan="3"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-4x text-muted mb-3 opacity-20"></i>
                    <h4 class="text-muted">No hay ventas en esta semana</h4>
                    <p class="text-muted">Navega a otras semanas o registra una nueva venta</p>
                    <a href="{{ route('ventas.create') }}" class="btn btn-primary-custom mt-3">
                        <i class="fas fa-plus"></i> Registrar Venta
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<form id="rechazo-form" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="motivo_rechazo" id="rechazo-motivo-input">
</form>

@push('scripts')
<script>
function rechazarVenta(url, asesor) {
    Swal.fire({
        title: 'Rechazar Venta',
        text: '¿Por qué vas a rechazar la venta de ' + asesor + '?',
        input: 'textarea',
        inputPlaceholder: 'Escribe el motivo aquí...',
        inputAttributes: {
            'aria-label': 'Motivo de rechazo'
        },
        showCancelButton: true,
        confirmButtonText: 'Confirmar Rechazo',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc3545',
        showLoaderOnConfirm: true,
        inputValidator: (value) => {
            if (!value) {
                return '¡Debes escribir un motivo!'
            }
        },
        preConfirm: (motivo) => {
            const form = document.getElementById('rechazo-form');
            form.action = url;
            document.getElementById('rechazo-motivo-input').value = motivo;
            form.submit();
        },
        allowOutsideClick: () => !Swal.isLoading()
    });
}
</script>
@endpush
