@extends('layouts.app')

@section('title', 'Detalles de Venta - CreamosHDV')

@section('content')
<div class="fade-in">
    <div class="mb-4">
        <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card-custom mb-4" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <span><i class="fas fa-receipt"></i> Detalles de la Venta #{{ $venta->id }}</span>
            @if($venta->estado === 'aprobada')
                <span class="badge bg-success">Aprobada</span>
            @elseif($venta->estado === 'pendiente')
                <span class="badge bg-warning text-dark">Pendiente de Aprobación</span>
            @else
                <span class="badge bg-danger">Rechazada</span>
            @endif
        </div>
        <div class="card-body p-4">
            <div class="row g-4 mb-4">
                <!-- Columna Asesor -->
                <div class="col-md-6">
                    <div class="p-3 rounded-4 border h-100" style="background-color: #0a0a0a;">
                        <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                            <i class="fas fa-user me-2"></i>Información del Asesor
                        </h6>
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-circle bg-primary text-white me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                {{ substr($venta->asesor->nombre_completo, 0, 1) }}
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">{{ $venta->asesor->nombre_completo }}</h5>
                                <small class="text-muted">C.C. {{ $venta->asesor->cedula }}</small>
                            </div>
                        </div>
                        <p class="mb-2"><i class="fas fa-map-marker-alt text-muted me-2"></i> {{ $venta->asesor->ciudad }}</p>
                        <a href="https://wa.me/57{{ preg_replace('/[^0-9]/', '', $venta->asesor->whatsapp) }}" 
                           target="_blank" 
                           class="whatsapp-btn btn-sm w-100 mt-2">
                            <i class="fab fa-whatsapp"></i> Contactar por WhatsApp
                        </a>
                    </div>
                </div>

                <!-- Columna Servicio -->
                <div class="col-md-6">
                    <div class="p-3 rounded-4 border h-100" style="background-color: #0a0a0a;">
                        <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                            <i class="fas fa-briefcase me-2"></i>Detalle del Servicio
                        </h6>
                        <h5 class="fw-bold mb-1">{{ $venta->servicio->nombre_servicio }}</h5>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Valor Servicio:</span>
                                <span class="fw-bold fs-5 text-primary">${{ number_format($venta->valor_servicio, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Comisión ({{ $venta->servicio->porcentaje_comision }}%):</span>
                                <span class="fw-bold text-success fs-5">${{ number_format($venta->comision, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banner de Comisión -->
            <div class="rounded-4 p-4 text-center mb-4 border" style="background: #000000; color: white; border-color: rgba(255,255,255,0.1) !important;">
                <p class="mb-1 text-uppercase opacity-75 fw-bold" style="font-size: 0.8rem; letter-spacing: 2px;">Comisión Total a Pagar</p>
                <h1 class="display-4 fw-bold mb-0">${{ number_format($venta->comision, 0, ',', '.') }}</h1>
            </div>

            @if($venta->estado === 'rechazada' && $venta->motivo_rechazo)
                <div class="alert alert-danger border-0 shadow-sm mb-4 rounded-4">
                    <h6 class="fw-bold"><i class="fas fa-exclamation-circle me-2"></i>Motivo del Rechazo:</h6>
                    <p class="mb-0">{{ $venta->motivo_rechazo }}</p>
                </div>
            @endif

            @if($venta->image_url)
                <div class="mb-4">
                    <h6 class="text-white-50 text-uppercase fw-bold mb-3" style="font-size: 0.8rem; letter-spacing: 1.5px;">
                        <i class="fas fa-image me-2 text-primary"></i>Comprobante / Captura de Pantalla
                    </h6>
                    <div class="text-center p-3 border rounded-4" style="background-color: #0d0d0d; border-color: rgba(255,255,255,0.1) !important;">
                        <img src="{{ $venta->image_url }}" alt="Comprobante" class="img-fluid rounded-4 shadow-lg" style="max-height: 500px; border: 1px solid rgba(255,255,255,0.05);">
                    </div>
                </div>
            @else
                <div class="mb-4">
                    <h6 class="text-white-50 text-uppercase fw-bold mb-3" style="font-size: 0.8rem; letter-spacing: 1.5px;">
                        <i class="fas fa-image me-2 text-muted"></i>Comprobante / Captura de Pantalla
                    </h6>
                    <div class="text-center p-4 border border-dashed rounded-4" style="background-color: #050505; border-color: rgba(255,255,255,0.1) !important; border-style: dashed !important;">
                        <i class="fas fa-file-image fa-3x text-muted mb-2 opacity-25"></i>
                        <p class="text-muted mb-0">No se adjuntó comprobante para esta venta</p>
                    </div>
                </div>
            @endif

            <div class="row text-center mb-4 g-2">
                <div class="col-6">
                    <div class="border rounded p-2">
                        <small class="text-muted d-block">Registrado el:</small>
                        <span class="fw-bold">{{ $venta->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border rounded p-2">
                        <small class="text-muted d-block">Última actualización:</small>
                        <span class="fw-bold">{{ $venta->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 justify-content-center pt-3 border-top">
                @if(auth()->user()->role === 'admin' && $venta->estado === 'pendiente')
                    <form action="{{ route('ventas.aprobar', $venta) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fas fa-check me-2"></i> Aprobar Venta
                        </button>
                    </form>
                    <button type="button" 
                            class="btn btn-outline-danger px-4"
                            onclick="rechazarVenta('{{ route('ventas.rechazar', $venta) }}', '{{ $venta->asesor->nombre_completo }}')">
                        <i class="fas fa-times me-2"></i> Rechazar Venta
                    </button>
                @endif

                @if(auth()->user()->role === 'admin' || $venta->estado === 'pendiente')
                    <a href="{{ route('ventas.edit', $venta) }}" class="btn btn-warning-custom px-4">
                        <i class="fas fa-edit me-2"></i> Editar
                    </a>
                @endif

                @if(auth()->user()->role === 'admin')
                    <form action="{{ route('ventas.destroy', $venta) }}" 
                          method="POST" 
                          class="d-inline js-confirm"
                          data-confirm="¿Está seguro de eliminar esta venta permanentemente?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger-custom px-4">
                            <i class="fas fa-trash me-2"></i> Eliminar
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function rechazarVenta(url, asesor) {
    Swal.fire({
        title: 'Rechazar Venta',
        text: '¿Por qué vas a rechazar la venta de ' + asesor + '?',
        input: 'textarea',
        inputPlaceholder: 'Escribe el motivo aquí...',
        showCancelButton: true,
        confirmButtonText: 'Confirmar Rechazo',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc3545',
        background: '#0d0d0d',
        color: '#ffffff',
        showLoaderOnConfirm: true,
        inputValidator: (value) => {
            if (!value) {
                return '¡Debes escribir un motivo!'
            }
        },
        preConfirm: (motivo) => {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            
            const motivoInput = document.createElement('input');
            motivoInput.type = 'hidden';
            motivoInput.name = 'motivo_rechazo';
            motivoInput.value = motivo;
            form.appendChild(motivoInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
