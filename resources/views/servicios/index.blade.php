@extends('layouts.app')

@section('title', 'Servicios - CreamosHDV')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-white">
            <i class="fas fa-briefcase"></i> Servicios
        </h1>
        <a href="{{ route('servicios.create') }}" class="btn btn-success-custom">
            <i class="fas fa-plus"></i> Nuevo Servicio
        </a>
    </div>

    <div class="card-custom">
        <div class="card-header-custom">
            <i class="fas fa-list"></i> Lista de Servicios
        </div>
        <div class="card-body">
            @if($servicios->count() > 0)
                <div class="row g-4">
                    @foreach($servicios as $servicio)
                        <div class="col-md-6 col-lg-4">
                            <div class="card-custom h-100 position-relative">
                                <div class="position-absolute top-0 start-0 m-2">
                                    <span class="badge bg-secondary opacity-50">{{ $loop->iteration }}</span>
                                </div>
                                <div class="card-body text-center">
                                    <i class="fas fa-file-alt fa-4x text-primary mb-3"></i>
                                    <h4>{{ $servicio->nombre_servicio }}</h4>
                                    
                                    <div class="my-3">
                                        <h3 class="text-success mb-0">
                                            ${{ number_format($servicio->valor, 0, ',', '.') }}
                                        </h3>
                                        <small class="text-muted">Valor del Servicio</small>
                                    </div>

                                    <div class="mb-3">
                                        <span class="badge bg-warning text-dark" style="font-size: 1rem;">
                                            {{ $servicio->porcentaje_comision }}% Comisión
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted">
                                            <i class="fas fa-shopping-cart"></i> 
                                            {{ $servicio->ventas_count }} ventas realizadas
                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-dollar-sign"></i> 
                                            ${{ number_format($servicio->ventas_sum_valor_servicio ?? 0, 0, ',', '.') }} generados
                                        </small>
                                    </div>


                                    <div class="d-flex flex-column gap-2">
                                        <a href="{{ route('servicios.show', $servicio) }}" 
                                           class="btn btn-primary-custom btn-sm">
                                            <i class="fas fa-eye"></i> Ver Detalles
                                        </a>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('servicios.edit', $servicio) }}" 
                                               class="btn btn-warning-custom btn-sm flex-fill">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <form action="{{ route('servicios.destroy', $servicio) }}" 
                                                  method="POST" 
                                                  class="flex-fill js-confirm"
                                                  data-confirm="¿Está seguro de eliminar este servicio?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger-custom btn-sm w-100">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-briefcase fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No hay servicios registrados</h4>
                    <p class="text-muted">Comienza agregando tu primer servicio</p>
                    <a href="{{ route('servicios.create') }}" class="btn btn-primary-custom mt-3">
                        <i class="fas fa-plus"></i> Crear Servicio
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
