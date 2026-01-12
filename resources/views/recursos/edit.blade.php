@extends('layouts.app')

@section('title', 'Editar Recurso - CreamosHDV')

@section('content')
<div class="row justify-content-center fade-in">
    <div class="col-md-8">
        <div class="card-custom">
            <div class="card-header-custom">
                <i class="fas fa-edit"></i> Editar Recurso
            </div>
            <div class="card-body">
                <form action="{{ route('recursos.update', $recurso) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">Nombre del Recurso</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre', $recurso->nombre) }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <input type="text" class="form-control @error('categoria') is-invalid @enderror" 
                                   id="categoria" name="categoria" value="{{ old('categoria', $recurso->categoria) }}">
                            @error('categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="url" class="form-label">Link (URL)</label>
                        <input type="url" class="form-control @error('url') is-invalid @enderror" 
                               id="url" name="url" value="{{ old('url', $recurso->url) }}" required>
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="form-label">Descripción (Opcional)</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $recurso->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('recursos.index') }}" class="btn btn-secondary-custom">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                        <button type="submit" class="btn btn-success-custom">
                            <i class="fas fa-save"></i> Actualizar Recurso
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
