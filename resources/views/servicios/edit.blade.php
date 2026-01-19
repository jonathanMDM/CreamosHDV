@extends('layouts.app')

@section('title', 'Editar Servicio - CreamosHDV')

@section('content')
<div class="fade-in">
    <div class="mb-4">
        <a href="{{ route('servicios.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card-custom" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header-custom">
            <i class="fas fa-edit"></i> Editar Servicio
        </div>
        <div class="card-body">
            <form action="{{ route('servicios.update', $servicio) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre_servicio" class="form-label">
                        <i class="fas fa-file-alt"></i> Nombre del Servicio *
                    </label>
                    <input type="text" 
                           class="form-control form-control-custom @error('nombre_servicio') is-invalid @enderror" 
                           id="nombre_servicio" 
                           name="nombre_servicio" 
                           value="{{ old('nombre_servicio', $servicio->nombre_servicio) }}" 
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
                           value="{{ old('icono', $servicio->icono) }}" 
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
                              rows="3">{{ old('descripcion', $servicio->descripcion) }}</textarea>
                    <small class="text-white-50">Este texto aparecerá debajo del título en la página principal</small>
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
                           value="{{ old('valor', $servicio->valor) }}" 
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
                           value="{{ old('porcentaje_comision', $servicio->porcentaje_comision) }}" 
                           step="0.01"
                           min="0"
                           max="100"
                           required>
                    @error('porcentaje_comision')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-white-50">Ingrese el porcentaje (0-100)</small>
                </div>

                <div class="mb-3">
                    <label for="orden" class="form-label">
                        <i class="fas fa-sort-numeric-down"></i> Orden de Visualización
                    </label>
                    <input type="number" 
                           class="form-control form-control-custom @error('orden') is-invalid @enderror" 
                           id="orden" 
                           name="orden" 
                           value="{{ old('orden', $servicio->orden) }}" 
                           min="0"
                           required>
                    <small class="text-white-50">Los servicios se muestran de menor a mayor (0, 1, 2...)</small>
                    @error('orden')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="form-check form-switch custom-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="visible_en_landing" 
                                   name="visible_en_landing" 
                                   value="1"
                                   {{ old('visible_en_landing', $servicio->visible_en_landing) ? 'checked' : '' }}>
                            <label class="form-check-label text-white fw-bold mb-1" for="visible_en_landing">
                                <i class="fas fa-desktop me-1"></i> Página Principal
                            </label>
                            <p class="text-white-50 mb-0" style="font-size: 0.75rem;">Visibilidad en la Landing Page externa</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch custom-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="visible_para_asesores" 
                                   name="visible_para_asesores" 
                                   value="1"
                                   {{ old('visible_para_asesores', $servicio->visible_para_asesores) ? 'checked' : '' }}>
                            <label class="form-check-label text-white fw-bold mb-1" for="visible_para_asesores">
                                <i class="fas fa-users-cog me-1"></i> Panel de Asesores
                            </label>
                            <p class="text-white-50 mb-0" style="font-size: 0.75rem;">Disponibilidad interna para registros</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-save"></i> Actualizar Servicio
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
