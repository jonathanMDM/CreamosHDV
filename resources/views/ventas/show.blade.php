@extends('layouts.app')

@section('title', 'Detalles de Venta - CreamosHDV')

@section('content')
<div>
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
                <div class="col-md-4">
                    <div class="p-3 rounded-4 border h-100" style="background-color: #0a0a0a;">
                        @if($venta->asesor)
                            @if(auth()->user()->role === 'admin')
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
                                <a href="https://wa.me/57{{ preg_replace('/[^0-9]/', '', $venta->asesor->whatsapp) }}?text=VENTA%20CONFIRMADA" 
                                   target="_blank" 
                                   class="whatsapp-btn btn-sm w-100 mt-2">
                                    <i class="fab fa-whatsapp"></i> Contactar por WhatsApp
                                </a>
                            @else
                                <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                                    <i class="fas fa-headset me-2"></i>Soporte Administrativo
                                </h6>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-circle bg-dark text-white me-3" style="width: 50px; height: 50px; font-size: 1.2rem; border: 1px solid rgba(255,255,255,0.1);">
                                        CH
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold">Creamos Hojas de Vida</h5>
                                        <small class="text-muted">Administrador</small>
                                    </div>
                                </div>
                                <p class="mb-2 small text-white-50"><i class="fas fa-info-circle me-2"></i>Pulsa el botón de abajo para informar de tu venta.</p>
                                @php
                                    $msg = "*VENTA INGRESADA*\n";
                                    $msg .= "Nombre del Cliente: " . ($venta->nombre_cliente ?? 'N/A') . "\n";
                                    $msg .= "Teléfono del cliente: " . ($venta->telefono_cliente ?? 'N/A') . "\n";
                                    $msg .= "Servicio: " . $venta->servicio->nombre_servicio . "\n";
                                    $msg .= "Valor total: $" . number_format($venta->valor_servicio, 0, ',', '.') . "\n";
                                    $msg .= "Pago recibido: " . ($venta->tipo_pago === 'pago_total' ? '100%' : '50%') . "\n";
                                    $msg .= "Nombre del Asesor: " . $venta->asesor->nombre_completo;
                                    $waUrl = "https://wa.me/573005038368?text=" . urlencode($msg);
                                @endphp
                                <a href="{{ $waUrl }}" 
                                   target="_blank" 
                                   class="whatsapp-btn btn-sm w-100 mt-2">
                                    <i class="fab fa-whatsapp"></i> Reportar Venta al Admin
                                </a>
                            @endif
                        @else
                            <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                                <i class="fas fa-store me-2"></i>Venta Directa
                            </h6>
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-circle bg-success text-white me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                    <i class="fas fa-cash-register"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Venta Directa</h5>
                                    <small class="text-muted">Sin asesor asignado</small>
                                </div>
                            </div>
                            <p class="mb-2 small text-white-50"><i class="fas fa-info-circle me-2"></i>Esta venta fue registrada directamente por el administrador.</p>
                        @endif
                    </div>
                </div>

                <!-- Columna Cliente -->
                <div class="col-md-4">
                    <div class="p-3 rounded-4 border h-100" style="background-color: #0a0a0a;">
                        <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
                            <i class="fas fa-user-tag me-2"></i>Información del Cliente
                        </h6>
                        <div class="mb-3">
                            <h5 class="fw-bold mb-1">{{ $venta->nombre_cliente ?? 'No registrado' }}</h5>
                            <p class="mb-2 text-white-50"><i class="fas fa-phone me-2"></i> {{ $venta->telefono_cliente ?? 'No registrado' }}</p>
                            
                            @if($venta->telefono_cliente)
                                @php
                                    $hora = date('H');
                                    $saludo = 'buen día';
                                    if ($hora >= 12 && $hora < 18) {
                                        $saludo = 'buenas tardes';
                                    } elseif ($hora >= 18) {
                                        $saludo = 'buenas noches';
                                    }
                                    
                                    $mensaje = "Hola {$venta->nombre_cliente}, {$saludo}\n" .
                                               "Te habla Sara, del equipo de diseño y creación.\n\n" .
                                               ($venta->asesor ? "El asesor {$venta->asesor->nombre_completo} nos indicó que adquiriste el servicio de {$venta->servicio->nombre_servicio}.\n" : "Adquiriste el servicio de {$venta->servicio->nombre_servicio}.\n") .
                                               "¿Nos confirmas si la información es correcta para continuar?";
                                @endphp
                                <a href="https://wa.me/57{{ preg_replace('/[^0-9]/', '', $venta->telefono_cliente) }}?text={{ urlencode($mensaje) }}" 
                                   target="_blank" 
                                   class="btn btn-outline-success btn-sm w-100 mt-2"
                                   style="border-radius: 10px; border-color: #25d366; color: #25d366;">
                                    <i class="fab fa-whatsapp me-2"></i> Contactar Cliente
                                </a>
                            @endif
                        </div>
                        <div class="mt-4 pt-2 border-top border-secondary border-opacity-25">
                            <small class="text-muted d-block text-uppercase" style="font-size: 0.65rem;">Estado de Pago:</small>
                            <span class="badge {{ $venta->tipo_pago === 'pago_total' ? 'bg-success' : 'bg-info text-dark' }} mt-1">
                                {{ $venta->tipo_pago === 'pago_total' ? 'Pago Completo (100%)' : 'Abono (50%)' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Columna Servicio -->
                <div class="col-md-4">
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
                <div class="rejection-box">
                    <h6><i class="fas fa-exclamation-circle me-2"></i>Motivo del Rechazo:</h6>
                    <div class="rejection-content">
                        {{ $venta->motivo_rechazo }}
                    </div>
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

            <div class="d-flex flex-wrap gap-3 mb-4 no-hover-animation" style="overflow: hidden;">
                <div style="flex: 1; min-width: 250px;" class="no-hover-animation">
                    <div class="p-3 rounded-4 no-hover-animation" style="background-color: #0d0d0d; border: 1px solid rgba(255,255,255,0.1) !important; text-align: center;">
                        <small class="text-white-50 d-block text-uppercase mb-1" style="font-size: 0.7rem; letter-spacing: 1px; pointer-events: none;">
                            <i class="fas fa-calendar-check me-1"></i> Registrado el
                        </small>
                        <span class="fw-bold fs-5" style="pointer-events: none;">{{ $venta->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                <div style="flex: 1; min-width: 250px;" class="no-hover-animation">
                    <div class="p-3 rounded-4 no-hover-animation" style="background-color: #0d0d0d; border: 1px solid rgba(255,255,255,0.1) !important; text-align: center;">
                        <small class="text-white-50 d-block text-uppercase mb-1" style="font-size: 0.7rem; letter-spacing: 1px; pointer-events: none;">
                            <i class="fas fa-clock-rotate-left me-1"></i> Última actualización
                        </small>
                        <span class="fw-bold fs-5" style="pointer-events: none;">{{ $venta->updated_at->format('d/m/Y H:i') }}</span>
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
                            onclick="rechazarVenta('{{ route('ventas.rechazar', $venta) }}', '{{ $venta->asesor ? $venta->asesor->nombre_completo : 'Venta Directa' }}')">
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
        html: `
            <p style="margin-bottom: 1rem; color: #fff;">¿Por qué vas a rechazar la venta${asesor !== 'Venta Directa' ? ' de <strong>' + asesor + '</strong>' : ''}?</p>
            <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem; flex-wrap: wrap; justify-content: center;">
                <button type="button" class="btn btn-sm btn-outline-warning quick-reason" data-reason="No adjuntó comprobante">
                    <i class="fas fa-image"></i> No adjuntó comprobante
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger quick-reason" data-reason="Comprobante falso">
                    <i class="fas fa-exclamation-triangle"></i> Comprobante falso
                </button>
            </div>
        `,
        input: 'textarea',
        inputPlaceholder: 'O escribe un motivo personalizado...',
        inputAttributes: {
            'aria-label': 'Motivo de rechazo'
        },
        showCancelButton: true,
        confirmButtonText: 'Confirmar Rechazo',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc3545',
        background: '#0d0d0d', // Mantengo el fondo oscuro específico de esta vista
        color: '#ffffff',
        showLoaderOnConfirm: true,
        didOpen: () => {
            const quickReasonButtons = document.querySelectorAll('.quick-reason');
            const textarea = Swal.getInput();
            
            quickReasonButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const reason = this.getAttribute('data-reason');
                    textarea.value = reason;
                    quickReasonButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        },
        inputValidator: (value) => {
            if (!value) {
                return '¡Debes escribir un motivo o seleccionar una opción!';
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
        },
        allowOutsideClick: () => !Swal.isLoading()
    });
}
</script>
@endpush
