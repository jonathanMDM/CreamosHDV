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
                        <select class="form-control form-control-custom @error('banco') is-invalid @enderror" 
                                id="banco" 
                                name="banco" 
                                required>
                            <option value="">Seleccione un banco</option>
                            <option value="Nequi" {{ old('banco', $asesor->banco) == 'Nequi' ? 'selected' : '' }}>Nequi</option>
                            <option value="Bancolombia" {{ old('banco', $asesor->banco) == 'Bancolombia' ? 'selected' : '' }}>Bancolombia</option>
                            <option value="Daviplata" {{ old('banco', $asesor->banco) == 'Daviplata' ? 'selected' : '' }}>Daviplata</option>
                            <option value="Nu" {{ old('banco', $asesor->banco) == 'Nu' ? 'selected' : '' }}>Nu</option>
                            <option value="Otros" {{ old('banco', $asesor->banco) == 'Otros' ? 'selected' : '' }}>Otros</option>
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
@endsection
