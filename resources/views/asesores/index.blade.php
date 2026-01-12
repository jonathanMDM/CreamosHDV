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

    <div class="card-custom fade-in">
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
                                            
                                            <!-- Botón Cambio de Clave -->
                                            @if($asesor->user_id)
                                            <button type="button" class="btn btn-sm btn-info text-white" 
                                                    onclick="openChangePasswordModal({{ $asesor->id }}, '{{ addslashes($asesor->nombre_completo) }}')"
                                                    title="Restablecer Contraseña">
                                                <i class="fas fa-key"></i>
                                            </button>
                                            @endif

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
<!-- Modal Único de Cambio de Clave (Optimizado) -->
<div class="modal fade" id="universalPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: #1a1d21; color: white; border: 1px solid #333;">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title" id="universalModalTitle">
                    <i class="fas fa-key text-info me-2"></i>Nueva Clave
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="universalPasswordForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body text-start">
                    <div class="alert alert-info py-2" style="font-size: 0.9rem;">
                        <i class="fas fa-info-circle"></i> Escribe la nueva clave y cópiala antes de guardar.
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Nueva Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="password" id="univNewPass" class="form-control bg-dark text-white border-secondary" required minlength="6" placeholder="Mínimo 6 caracteres">
                            <button type="button" class="btn btn-outline-secondary" onclick="toggleUniversalPass()">
                                <i class="fas fa-eye" id="univIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" id="univConfPass" class="form-control bg-dark text-white border-secondary" required minlength="6" placeholder="Repite la contraseña">
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Clave
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openChangePasswordModal(id, nombre) {
        // Establecer la acción del formulario dinámicamente
        const form = document.getElementById('universalPasswordForm');
        // Asegurarse de quitar cualquier ID previo de la URL si se reutiliza
        let baseUrl = "{{ route('asesores.index') }}"; 
        // Construir la ruta manualmente para evitar problemas de JS string
        form.action = baseUrl + "/" + id + "/cambiar-clave";
        
        // Actualizar título
        document.getElementById('universalModalTitle').innerHTML = `<i class="fas fa-key text-info me-2"></i>Nueva Clave para: ${nombre}`;

        // Limpiar campos
        document.getElementById('univNewPass').value = '';
        document.getElementById('univConfPass').value = '';

        // Resetear visibilidad password
        const x = document.getElementById("univNewPass");
        const y = document.getElementById("univConfPass");
        const icon = document.getElementById("univIcon");
        x.type = "password";
        y.type = "password";
        icon.className = "fas fa-eye";

        // Mostrar modal usando Bootstrap 5
        const modalEl = document.getElementById('universalPasswordModal');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }

    function toggleUniversalPass() {
        const x = document.getElementById("univNewPass");
        const y = document.getElementById("univConfPass");
        const icon = document.getElementById("univIcon");
        if (x.type === "password") {
            x.type = "text";
            y.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            x.type = "password";
            y.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>

@endsection
