@extends('layouts.app')

@section('title', 'Recursos - CreamosHDV')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-white">
            <i class="fas fa-folder-open"></i> Recursos
        </h1>
        <a href="{{ route('recursos.create') }}" class="btn btn-success-custom">
            <i class="fas fa-plus"></i> Nuevo Recurso
        </a>
    </div>

    <div class="card-custom fade-in">
        <div class="card-header-custom">
            <i class="fas fa-list"></i> Lista de Recursos
        </div>
        <div class="card-body">
            @if($recursos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-custom js-table w-100" width="100%">
                        <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 20%;">Nombre</th>
                                <th style="width: 15%;">Categoría</th>
                                <th style="width: 40%;">Descripción</th>
                                <th style="width: 20%;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recursos as $recurso)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <strong id="nombre-{{ $recurso->id }}">{{ $recurso->nombre }}</strong>
                                            <button class="btn btn-sm btn-outline-secondary ms-2 py-0" 
                                                    onclick="copyToClipboard('{{ $recurso->nombre }}', this)" 
                                                    title="Copiar nombre">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $recurso->categoria ?? 'Sin categoría' }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ Str::limit($recurso->descripcion, 50) }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ $recurso->url }}" target="_blank" class="btn btn-sm btn-info text-white" title="Abrir Link">
                                                <i class="fas fa-external-link-alt"></i> Ver
                                            </a>
                                            <a href="{{ route('recursos.edit', $recurso) }}" class="btn btn-sm btn-warning-custom" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('recursos.destroy', $recurso) }}" method="POST" class="d-inline js-confirm" data-confirm="¿Está seguro de eliminar este recurso?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger-custom" title="Eliminar">
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
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No hay recursos registrados todavía.</p>
                    <a href="{{ route('recursos.create') }}" class="btn btn-primary-custom">
                        <i class="fas fa-plus"></i> Agregar mi primer recurso
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyToClipboard(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i>';
            btn.classList.replace('btn-outline-light', 'btn-success');
            
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.classList.replace('btn-success', 'btn-outline-light');
            }, 2000);

            // Toast notification using SweetAlert2 if available
            if (window.Toast) {
                Toast.fire({
                    icon: 'success',
                    title: '¡Copiado!'
                });
            }
        });
    }
</script>
@endpush
@endsection
