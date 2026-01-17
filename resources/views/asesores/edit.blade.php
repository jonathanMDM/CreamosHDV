@extends('layouts.app')

@section('title', 'Editar Asesor - CreamosHDV')

@section('content')
<div class="fade-in">
    <div class="mb-4">
        <a href="{{ route('asesores.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card-custom">
        <div class="card-header-custom">
            <i class="fas fa-user-edit"></i> Editar Asesor
        </div>
        <div class="card-body">
            <form action="{{ route('asesores.update', $asesor) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre_completo" class="form-label">
                            <i class="fas fa-user"></i> Nombre Completo *
                        </label>
                        <input type="text" 
                               class="form-control form-control-custom @error('nombre_completo') is-invalid @enderror" 
                               id="nombre_completo" 
                               name="nombre_completo" 
                               value="{{ old('nombre_completo', $asesor->nombre_completo) }}" 
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
                               value="{{ old('cedula', $asesor->cedula) }}" 
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
                        @php
                            $predefinedBancos = ['Nequi', 'Bancolombia', 'Daviplata', 'Nu'];
                            $isOtro = !in_array($asesor->banco, $predefinedBancos) && $asesor->banco != 'Otros';
                            $currentBanco = $isOtro ? 'Otros' : $asesor->banco;
                            $bancoNombreOtro = $isOtro ? $asesor->banco : '';
                        @endphp
                        <select class="form-control form-control-custom @error('banco') is-invalid @enderror" 
                                id="banco" 
                                name="banco" 
                                required 
                                onchange="toggleBancoOtro(this.value)">
                            <option value="">Seleccione un banco</option>
                            <option value="Nequi" {{ old('banco', $currentBanco) == 'Nequi' ? 'selected' : '' }}>Nequi</option>
                            <option value="Bancolombia" {{ old('banco', $currentBanco) == 'Bancolombia' ? 'selected' : '' }}>Bancolombia</option>
                            <option value="Daviplata" {{ old('banco', $currentBanco) == 'Daviplata' ? 'selected' : '' }}>Daviplata</option>
                            <option value="Nu" {{ old('banco', $currentBanco) == 'Nu' ? 'selected' : '' }}>Nu</option>
                            <option value="Otros" {{ old('banco', $currentBanco) == 'Otros' ? 'selected' : '' }}>Otros</option>
                        </select>
                        @error('banco')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div id="div_banco_otro" class="mt-3 slide-down" style="display: {{ old('banco', $currentBanco) == 'Otros' ? 'block' : 'none' }};">
                            <label for="banco_nombre_otro" class="form-label">
                                <i class="fas fa-plus-circle"></i> ¿Cuál banco? *
                            </label>
                            <input type="text" 
                                   class="form-control form-control-custom @error('banco_nombre_otro') is-invalid @enderror" 
                                   id="banco_nombre_otro" 
                                   name="banco_nombre_otro" 
                                   value="{{ old('banco_nombre_otro', $bancoNombreOtro) }}"
                                   placeholder="Nombre del banco">
                            @error('banco_nombre_otro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="numero_cuenta" class="form-label">
                            <i class="fas fa-credit-card"></i> Número de Cuenta *
                        </label>
                        <input type="text" 
                               class="form-control form-control-custom @error('numero_cuenta') is-invalid @enderror" 
                               id="numero_cuenta" 
                               name="numero_cuenta" 
                               value="{{ old('numero_cuenta', $asesor->numero_cuenta) }}" 
                               required>
                        @error('numero_cuenta')
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
                               value="{{ old('whatsapp', $asesor->whatsapp) }}" 
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
                               value="{{ old('ciudad', $asesor->ciudad) }}" 
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
                               value="{{ old('email', $asesor->email) }}" 
                               placeholder="ejempl@correo.com"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-save"></i> Actualizar Asesor
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

// Inicializar al cargar
document.addEventListener('DOMContentLoaded', function() {
    toggleBancoOtro(document.getElementById('banco').value);
});
</script>
@endsection
