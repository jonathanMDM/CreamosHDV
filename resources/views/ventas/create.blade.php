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
                    <div class="form-text text-muted">Formatos permitidos: JPG, PNG, WebP. Máximo 5MB.</div>
                    @error('comprobante')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="resumen" class="alert alert-info" style="display: none;">
                    <h5><i class="fas fa-calculator"></i> Resumen de la Venta</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Valor del Servicio:</strong><br>
                                <span class="fs-4 text-primary" id="valorServicio">$0</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Comisión del Asesor:</strong><br>
                                <span class="fs-4 text-success" id="comisionAsesor">$0</span>
                                <small class="text-muted d-block" id="porcentajeComision"></small>
                            </p>
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
