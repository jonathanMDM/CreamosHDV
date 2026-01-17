@extends('layouts.app')

@section('title', 'Crear Asesor - CreamosHDV')

{{-- Updated: 2026-01-16 20:58 - Fixed form layout --}}

@section('content')
<div>
    <div class="mb-4">
        <a href="{{ route('asesores.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card-custom">
        <div class="card-header-custom">
            <i class="fas fa-user-plus"></i> Registrar Nuevo Asesor
        </div>
        <div class="card-body">
            <form action="{{ route('asesores.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre_completo" class="form-label">
                            <i class="fas fa-user"></i> Nombre Completo *
                        </label>
                        <input type="text" 
                               class="form-control form-control-custom @error('nombre_completo') is-invalid @enderror" 
                               id="nombre_completo" 
                               name="nombre_completo" 
                               value="{{ old('nombre_completo') }}" 
                               required>
                        @error('nombre_completo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="cedula" class="form-label">
                            <i class="fas fa-id-card"></i> Cédula *
                        </label>
                        <input type="text" 
                               class="form-control form-control-custom @error('cedula') is-invalid @enderror" 
                               id="cedula" 
                               name="cedula" 
                               value="{{ old('cedula') }}" 
                               required>
                        @error('cedula')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="banco" class="form-label">
                            <i class="fas fa-university"></i> Banco *
                        </label>
                        <select class="form-control form-control-custom @error('banco') is-invalid @enderror" 
                                id="banco" 
                                name="banco" 
                                required 
                                onchange="toggleBancoOtro(this.value)">
                            <option value="">Seleccione un banco</option>
                            <option value="Nequi" {{ old('banco') == 'Nequi' ? 'selected' : '' }}>Nequi</option>
                            <option value="Bancolombia" {{ old('banco') == 'Bancolombia' ? 'selected' : '' }}>Bancolombia</option>
                            <option value="Daviplata" {{ old('banco') == 'Daviplata' ? 'selected' : '' }}>Daviplata</option>
                            <option value="Nu" {{ old('banco') == 'Nu' ? 'selected' : '' }}>Nu</option>
                            <option value="Otros" {{ old('banco') == 'Otros' ? 'selected' : '' }}>Otros</option>
                        </select>
                        @error('banco')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="numero_cuenta" class="form-label">
                            <i class="fas fa-credit-card"></i> Número de Cuenta *
                        </label>
                        <input type="text" 
                               class="form-control form-control-custom @error('numero_cuenta') is-invalid @enderror" 
                               id="numero_cuenta" 
                               name="numero_cuenta" 
                               value="{{ old('numero_cuenta') }}" 
                               required>
                        @error('numero_cuenta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row" id="div_banco_otro" style="display: {{ old('banco') == 'Otros' ? 'block' : 'none' }};">
                    <div class="col-md-12 mb-3">
                        <label for="banco_nombre_otro" class="form-label">
                            <i class="fas fa-plus-circle"></i> ¿Cuál banco? *
                        </label>
                        <input type="text" 
                               class="form-control form-control-custom @error('banco_nombre_otro') is-invalid @enderror" 
                               id="banco_nombre_otro" 
                               name="banco_nombre_otro" 
                               value="{{ old('banco_nombre_otro') }}"
                               placeholder="Nombre del banco">
                        @error('banco_nombre_otro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="whatsapp" class="form-label">
                            <i class="fab fa-whatsapp"></i> WhatsApp *
                        </label>
                        <input type="text" 
                               class="form-control form-control-custom @error('whatsapp') is-invalid @enderror" 
                               id="whatsapp" 
                               name="whatsapp" 
                               value="{{ old('whatsapp') }}" 
                               placeholder="3001234567"
                               required>
                        @error('whatsapp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Ingrese el número sin espacios ni guiones</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="ciudad" class="form-label">
                            <i class="fas fa-map-marker-alt"></i> Ciudad *
                        </label>
                        <input type="text" 
                               class="form-control form-control-custom @error('ciudad') is-invalid @enderror" 
                               id="ciudad" 
                               name="ciudad" 
                               value="{{ old('ciudad') }}" 
                               required>
                        @error('ciudad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Correo Electrónico (Para iniciar sesión) *
                        </label>
                        <input type="email" 
                               class="form-control form-control-custom @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="ejempl@correo.com"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="alert alert-info border-0 mt-2 py-2" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; font-size: 0.9rem;">
                            <i class="fas fa-info-circle me-1"></i> El asesor usará este correo para entrar. Su contraseña inicial será su número de <strong>Cédula</strong>.
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-save"></i> Guardar Asesor
                    </button>
                    <a href="{{ route('asesores.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleBancoOtro(val) {
    const div = document.getElementById('div_banco_otro');
    const input = document.getElementById('banco_nombre_otro');
    if (val === 'Otros') {
        div.style.display = 'block';
        input.setAttribute('required', 'required');
    } else {
        div.style.display = 'none';
        input.removeAttribute('required');
    }
}
</script>
@endsection
