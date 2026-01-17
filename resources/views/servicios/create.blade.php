@extends('layouts.app')

@section('title', 'Crear Servicio - CreamosHDV')

@section('content')
<div class="fade-in">
    <div class="mb-4">
        <a href="{{ route('servicios.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card-custom" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header-custom">
            <i class="fas fa-plus-circle"></i> Crear Nuevo Servicio
        </div>
        <div class="card-body">
            <form action="{{ route('servicios.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nombre_servicio" class="form-label">
                        <i class="fas fa-file-alt"></i> Nombre del Servicio *
                    </label>
                    <input type="text"
                           class="form-control form-control-custom @error('nombre_servicio') is-invalid @enderror"
                           id="nombre_servicio"
                           name="nombre_servicio"
                           value="{{ old('nombre_servicio') }}"
                           required>
                    @error('nombre_servicio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="icono" class="form-label">
                        <i class="fas fa-icons"></i> Icono FontAwesome
                    </label>
                    <input type="text"
                           class="form-control form-control-custom @error('icono') is-invalid @enderror"
                           id="icono"
                           name="icono"
                           value="{{ old('icono') }}"
                           placeholder="ej: fas fa-camera">
                    <small class="text-white-50">Copia el nombre de las clases desde <a href="https://fontawesome.com/v6/search" target="_blank" class="text-info">FontAwesome</a></small>
                    @error('icono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">
                        <i class="fas fa-align-left"></i> Descripción para la Landing
                    </label>
                    <textarea class="form-control form-control-custom @error('descripcion') is-invalid @enderror" 
                              id="descripcion" 
                              name="descripcion" 
                              rows="3">{{ old('descripcion') }}</textarea>
                    <small class="text-muted text-white-50">Este texto aparecerá debajo del título en la página principal</small>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="valor" class="form-label">
                        <i class="fas fa-dollar-sign"></i> Valor del Servicio *
                    </label>
                    <input type="number" 
                           class="form-control form-control-custom @error('valor') is-invalid @enderror" 
                           id="valor" 
                           name="valor" 
                           value="{{ old('valor') }}" 
                           step="0.01"
                           min="0"
                           required>
                    @error('valor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Ingrese el valor en pesos colombianos</small>
                </div>

                <div class="mb-3">
                    <label for="porcentaje_comision" class="form-label">
                        <i class="fas fa-percentage"></i> Porcentaje de Comisión *
                    </label>
                    <input type="number" 
                           class="form-control form-control-custom @error('porcentaje_comision') is-invalid @enderror" 
                           id="porcentaje_comision" 
                           name="porcentaje_comision" 
                           value="{{ old('porcentaje_comision') }}" 
                           step="0.01"
                           min="0"
                           max="100"
                           required>
                    @error('porcentaje_comision')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Ingrese el porcentaje (0-100)</small>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-save"></i> Guardar Servicio
                    </button>
                    <a href="{{ route('servicios.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
