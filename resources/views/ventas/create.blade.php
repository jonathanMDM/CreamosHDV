@extends('layouts.app')

@section('title', 'Registrar Venta - CreamosHDV')

@section('content')
<div class="fade-in">
    <div class="mb-4">
        <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card-custom" style="max-width: 700px; margin: 0 auto;">
        <div class="card-header-custom">
            <i class="fas fa-cart-plus"></i> Registrar Nueva Venta
        </div>
        <div class="card-body">
            <form action="{{ route('ventas.store') }}" method="POST" id="ventaForm" enctype="multipart/form-data">
                @csrf

                @if($myAsesor)
                    <input type="hidden" name="asesor_id" value="{{ $myAsesor->id }}">
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-user"></i> Asesor
                        </label>
                        <div class="form-control form-control-custom bg-light">
                            {{ $myAsesor->nombre_completo }}
                        </div>
                    </div>
                @else
                    <div class="mb-4">
                        <label for="asesor_id" class="form-label">
                            <i class="fas fa-user"></i> Seleccionar Asesor *
                        </label>
                        <select class="form-control form-control-custom @error('asesor_id') is-invalid @enderror" 
                                id="asesor_id" 
                                name="asesor_id" 
                                required>
                            <option value="">-- Seleccione un asesor --</option>
                            @foreach($asesores as $asesor)
                                <option value="{{ $asesor->id }}" {{ old('asesor_id') == $asesor->id ? 'selected' : '' }}>
                                    {{ $asesor->nombre_completo }} - {{ $asesor->cedula }}
                                </option>
                            @endforeach
                        </select>
                        @error('asesor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="nombre_cliente" class="form-label">
                                <i class="fas fa-user-tag"></i> Nombre del Cliente *
                            </label>
                            <input type="text" 
                                   class="form-control form-control-custom @error('nombre_cliente') is-invalid @enderror" 
                                   id="nombre_cliente" 
                                   name="nombre_cliente" 
                                   value="{{ old('nombre_cliente') }}"
                                   placeholder="Ej: Juan Pérez"
                                   required>
                            @error('nombre_cliente')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="telefono_cliente" class="form-label">
                                <i class="fas fa-phone"></i> Teléfono del Cliente *
                            </label>
                            <input type="text" 
                                   class="form-control form-control-custom @error('telefono_cliente') is-invalid @enderror" 
                                   id="telefono_cliente" 
                                   name="telefono_cliente" 
                                   value="{{ old('telefono_cliente') }}"
                                   placeholder="Ej: 3001234567"
                                   required>
                            @error('telefono_cliente')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="servicio_id" class="form-label">
                        <i class="fas fa-briefcase"></i> Seleccionar Servicio *
                    </label>
                    <select class="form-control form-control-custom @error('servicio_id') is-invalid @enderror" 
                            id="servicio_id" 
                            name="servicio_id" 
                            required>
                        <option value="">-- Seleccione un servicio --</option>
                        @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id }}" 
                                    data-valor="{{ $servicio->valor }}"
                                    data-comision="{{ $servicio->porcentaje_comision }}"
                                    {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                                {{ $servicio->nombre_servicio }} - ${{ number_format($servicio->valor, 0, ',', '.') }} ({{ $servicio->porcentaje_comision }}% comisión)
                            </option>
                        @endforeach
                    </select>
                    @error('servicio_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="fecha_venta" class="form-label">
                        <i class="fas fa-calendar-alt"></i> Fecha de la Venta *
                    </label>
                    <input type="date" 
                           class="form-control form-control-custom @error('fecha_venta') is-invalid @enderror" 
                           id="fecha_venta" 
                           name="fecha_venta" 
                           value="{{ old('fecha_venta', date('Y-m-d')) }}"
                           max="{{ date('Y-m-d') }}"
                           required>
                    <div class="form-text text-white-50" style="font-size: 0.75rem;">Selecciona la fecha en que se realizó la venta</div>
                    @error('fecha_venta')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="tipo_pago" class="form-label">
                        <i class="fas fa-money-bill-wave"></i> Tipo de Pago *
                    </label>
                    <select class="form-control form-control-custom @error('tipo_pago') is-invalid @enderror" 
                            id="tipo_pago" 
                            name="tipo_pago" 
                            required>
                        <option value="pago_total" {{ old('tipo_pago') == 'pago_total' ? 'selected' : '' }}>Pago Total (100%)</option>
                        <option value="pago_50" {{ old('tipo_pago') == 'pago_50' ? 'selected' : '' }}>Pago 50%</option>
                    </select>
                    @error('tipo_pago')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="comprobante" class="form-label">
                        <i class="fas fa-image"></i> Subir Comprobante / Captura (Opcional)
                    </label>
                    <input type="file" class="form-control form-control-custom @error('comprobante') is-invalid @enderror" 
                           id="comprobante" 
                           name="comprobante" 
                           accept="image/*">
                    <div class="form-text text-white-50" style="font-size: 0.75rem;">Formatos permitidos: JPG, PNG, WebP. Máximo 5MB.</div>
                    @error('comprobante')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="resumen" class="card-custom p-3 mb-4" style="display: none; background-color: #0d0d0d; border: 1px solid rgba(255,255,255,0.1);">
                    <h5 class="mb-3"><i class="fas fa-calculator"></i> Resumen de la Venta</h5>
                    <div class="row g-3">
                        <div class="col-md-6 border-end border-secondary border-opacity-25">
                            <p class="mb-0 text-white-50 small">Valor del Servicio:</p>
                            <span class="fs-3 fw-bold text-white" id="valorServicio">$0</span>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0 text-white-50 small">Comisión del Asesor:</p>
                            <span class="fs-3 fw-bold text-success" id="comisionAsesor">$0</span>
                            <small class="text-muted d-block" id="porcentajeComision" style="font-size: 0.75rem;"></small>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-save"></i> Registrar Venta
                    </button>
                    <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function actualizarResumen() {
    const servicioSelect = document.getElementById('servicio_id');
    const tipoPagoSelect = document.getElementById('tipo_pago');
    const selectedOption = servicioSelect.options[servicioSelect.selectedIndex];
    
    const valorOriginal = parseFloat(selectedOption.dataset.valor || 0);
    const comisionPorcentaje = parseFloat(selectedOption.dataset.comision || 0);
    const tipoPago = tipoPagoSelect.value;
    
    if (valorOriginal > 0) {
        let valorServicio = valorOriginal;
        let comision = (valorOriginal * comisionPorcentaje) / 100;
        
        if (tipoPago === 'pago_50') {
            valorServicio = valorOriginal / 2;
            comision = comision / 2;
        }
        
        document.getElementById('valorServicio').textContent = '$' + valorServicio.toLocaleString('es-CO');
        document.getElementById('comisionAsesor').textContent = '$' + comision.toLocaleString('es-CO');
        document.getElementById('porcentajeComision').textContent = '(' + comisionPorcentaje + '% del valor cobrado)';
        document.getElementById('resumen').style.display = 'block';
    } else {
        document.getElementById('resumen').style.display = 'none';
    }
}

document.getElementById('servicio_id').addEventListener('change', actualizarResumen);
document.getElementById('tipo_pago').addEventListener('change', actualizarResumen);
</script>
@endpush
@endsection
