@extends('layouts.app')

@section('title', 'Asesores - CreamosHDV')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-white">
            <i class="fas fa-users"></i> Asesores
        </h1>
        <a href="{{ route('asesores.create') }}" class="btn btn-success-custom">
            <i class="fas fa-plus"></i> Nuevo Asesor
        </a>
    </div>

    <div class="card-custom animate__animated animate__fadeInUp">
        <div class="card-header-custom">
            <i class="fas fa-list"></i> Lista de Asesores
        </div>
        <div class="card-body">
            @if($asesores->count() > 0)
                <div class="table-responsive">
                    <table class="table table-custom js-table w-100" width="100%">
                        <thead>
                            <tr>
                                <th style="width: 5%;">Item</th>
                                <th style="width: 20%;">Nombre Completo</th>
                                <th style="width: 12%;">Cédula</th>
                                <th style="width: 10%;">Banco</th>
                                <th style="width: 10%;">Ciudad</th>
                                <th style="width: 7%;">Ventas</th>
                                <th style="width: 11%;">Comisiones</th>
                                <th style="width: 15%;">WhatsApp</th>
                                <th style="width: 10%;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asesores as $asesor)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $asesor->nombre_completo }}</strong>
                                    </td>
                                    <td>{{ $asesor->cedula }}</td>
                                    <td>
                                        <span class="badge badge-custom badge-{{ strtolower($asesor->banco) }}">
                                            {{ $asesor->banco }}
                                        </span>
                                    </td>
                                    <td>{{ $asesor->ciudad }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $asesor->ventas_count }}</span>
                                    </td>
                                    <td class="text-success fw-bold">
                                        ${{ number_format($asesor->ventas_sum_comision ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <a href="https://wa.me/57{{ preg_replace('/[^0-9]/', '', $asesor->whatsapp) }}" 
                                           target="_blank" 
                                           class="whatsapp-btn">
                                            <i class="fab fa-whatsapp"></i> Chat
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1" role="group">
                                            @if(!$asesor->user_id)
                                                <form action="{{ route('asesores.usuario', $asesor) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="Crear Usuario e Iniciar Habilitado">
                                                        <i class="fas fa-user-check"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('asesores.toggle-usuario', $asesor) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @php
                                                        $isActive = $asesor->user && $asesor->user->is_active;
                                                    @endphp
                                                    <button type="submit" 
                                                            class="btn btn-sm {{ $isActive ? 'btn-success' : 'btn-secondary opacity-50' }} text-white" 
                                                            title="{{ $isActive ? 'Portal Habilitado - Click para Deshabilitar' : 'Portal Deshabilitado - Click para Habilitar' }}">
                                                        <i class="fas fa-user-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('asesores.show', $asesor) }}" 
                                               class="btn btn-sm btn-primary-custom" 
                                               title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('asesores.edit', $asesor) }}" 
                                               class="btn btn-sm btn-warning-custom" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('asesores.destroy', $asesor) }}" 
                                                  method="POST" 
                                                  class="d-inline js-confirm"
                                                  data-confirm="¿Está seguro de eliminar este asesor? This operation cannot be undone.">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger-custom" 
                                                        title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-slash fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No hay asesores registrados</h4>
                    <p class="text-muted">Comienza agregando tu primer asesor</p>
                    <a href="{{ route('asesores.create') }}" class="btn btn-primary-custom mt-3">
                        <i class="fas fa-plus"></i> Registrar Asesor
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
