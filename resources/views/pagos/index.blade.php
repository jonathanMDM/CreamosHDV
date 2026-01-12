@extends('layouts.app')

@section('title', 'Gestión de Pagos - CreamosHDV')

@section('content')
<div class="fade-in">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="text-white mb-1">
                Gestión de Pagos {{ $añoActual }}
            </h1>
            <p class="text-white-50 mb-0">Administración de comisiones semanales y bonos mensuales</p>
        </div>
        <div>
            <button type="button" class="btn btn-success-custom btn-lg" onclick="actualizarTodosPagos()">
                <i class="fas fa-sync-alt"></i> Actualizar Todos los Pagos
            </button>
        </div>
    </div>

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabs para separar Semanal de Mensual -->
    <ul class="nav nav-pills custom-pills mb-4" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-semanal-tab" data-bs-toggle="pill" data-bs-target="#pills-semanal" type="button" role="tab">
                <i class="fas fa-calendar-week"></i> Pagos Semanales (Domingos)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-mensual-tab" data-bs-toggle="pill" data-bs-target="#pills-mensual" type="button" role="tab">
                <i class="fas fa-calendar-alt"></i> Bonos Mensuales (Fin de Mes)
            </button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <!-- TAB SEMANAL -->
        <div class="tab-pane fade show active" id="pills-semanal" role="tabpanel">
            <div class="alert alert-info alert-custom mb-4">
                <h5 style="font-size: 1.1rem;"><i class="fas fa-info-circle"></i> Información de Pagos Semanales</h5>
                <p class="mb-0" style="font-size: 0.95rem;">Se generan cada domingo. <strong>Solo incluyen las comisiones acumuladas de la semana.</strong> Los bonos por rendimiento se calculan y pagan al final del mes en la pestaña correspondiente.</p>
            </div>

            <div class="card-custom fade-in">
                <div class="card-header-custom">
                    <i class="fas fa-calendar-alt"></i> Semanas del Año
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th>Semana</th>
                                    <th>Rango de Fechas</th>
                                    <th>Fecha de Pago (Domingo)</th>
                                    <th>Estado Semana</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($semanas as $semana)
                                    @php
                                        $pagosSemana = $pagos->get($semana['numero'], collect());
                                        $totalPagos = $pagosSemana->count();
                                        $pagosPendientes = $pagosSemana->where('pagado', false)->count();
                                        $pagosPagados = $pagosSemana->where('pagado', true)->count();
                                    @endphp
                                    <tr>
                                        <td><strong>Semana {{ $semana['numero'] }}</strong></td>
                                        <td>{{ $semana['inicio']->translatedFormat('d M') }} - {{ $semana['fin']->translatedFormat('d M') }}</td>
                                        <td>
                                            <span class="badge bg-success">
                                                <i class="fas fa-calendar-day"></i> {{ $semana['fin']->translatedFormat('d/m/Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($totalPagos > 0)
                                                <span class="badge bg-info">{{ $totalPagos }} pagos gen.</span>
                                                @if($pagosPendientes > 0)
                                                    <span class="badge bg-warning text-dark">{{ $pagosPendientes }} pendientes</span>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">Sin generar</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                @if($totalPagos == 0)
                                                    <form action="{{ route('pagos.generar') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="semana" value="{{ $semana['numero'] }}">
                                                        <input type="hidden" name="año" value="{{ $añoActual }}">
                                                        <button type="submit" class="btn btn-sm btn-primary-custom" title="Generar pagos">
                                                            <i class="fas fa-plus"></i>
                                                            <span class="d-none d-md-inline ms-1">Generar</span>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-info-custom" data-bs-toggle="collapse" data-bs-target="#semana{{ $semana['numero'] }}" title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                        <span class="d-none d-md-inline ms-1">Detalles</span>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @if($totalPagos > 0)
                                        <tr class="collapse" id="semana{{ $semana['numero'] }}">
                                            <td colspan="5" class="p-4" style="background-color: #0f0f0f; border: 1px solid rgba(255,255,255,0.05);">
                                                <div class="card-custom p-3 shadow-none border-0">
                                                    <h6 class="fw-bold mb-3">Detalle de Pagos - Semana {{ $semana['numero'] }}</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-hover mb-0" style="min-width: 600px;">
                                                        <thead style="background-color: #0a0a0a; color: white;">
                                                            <tr>
                                                                <th class="text-start" style="width: 30%;">Asesor</th>
                                                                <th class="text-center" style="width: 10%;">Ventas</th>
                                                                <th class="text-end" style="width: 15%;">Comisiones</th>
                                                                <th class="text-end" style="width: 15%;">Total a Pagar</th>
                                                                <th class="text-center" style="width: 15%;">Estado</th>
                                                                <th class="text-center" style="width: 15%;">Acción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($pagosSemana as $pago)
                                                                <tr>
                                                                    <td class="text-start align-middle">
                                                                        <strong>{{ $pago->asesor->nombre_completo }}</strong>
                                                                    </td>
                                                                    <td class="text-center align-middle">
                                                                        <span class="badge bg-secondary">{{ $pago->cantidad_ventas }}</span>
                                                                    </td>
                                                                    <td class="text-end align-middle">
                                                                        <span class="text-success fw-bold">${{ number_format($pago->total_comisiones, 0, ',', '.') }}</span>
                                                                    </td>
                                                                    <td class="text-end align-middle">
                                                                        <span class="text-primary fw-bold">${{ number_format($pago->total_pagar, 0, ',', '.') }}</span>
                                                                    </td>
                                                                    <td class="text-center align-middle">
                                                                        @if($pago->pagado)
                                                                            <span class="badge bg-success">PAGADO</span>
                                                                        @else
                                                                            <span class="badge bg-warning text-dark">PENDIENTE</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center align-middle">
                                                                        @if($pago->pagado)
                                                                            <div class="d-flex gap-1 justify-content-center">
                                                                                <a href="{{ route('pagos.comprobante', $pago->id) }}" class="btn btn-xs btn-outline-info" title="Ver Factura">
                                                                                    <i class="fas fa-file-invoice-dollar"></i> Factura
                                                                                </a>
                                                                                <form action="{{ route('pagos.marcar-no-pagado', $pago->id) }}" method="POST" class="js-confirm" data-confirm="¿Deshacer pago?">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn btn-xs btn-outline-danger">Deshacer</button>
                                                                                </form>
                                                                            </div>
                                                                        @else
                                                                            <form action="{{ route('pagos.marcar-pagado', $pago->id) }}" method="POST">
                                                                                @csrf
                                                                                <button type="submit" class="btn btn-xs btn-success">
                                                                                    <i class="fas fa-check"></i> Pagar
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot style="border-top: 2px solid rgba(255,255,255,0.1);">
                                                            <tr>
                                                                <th class="text-end" colspan="2">TOTALES:</th>
                                                                <th class="text-end text-success">${{ number_format($pagosSemana->sum('total_comisiones'), 0, ',', '.') }}</th>
                                                                <th class="text-end text-primary">${{ number_format($pagosSemana->sum('total_pagar'), 0, ',', '.') }}</th>
                                                                <th colspan="2"></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB MENSUAL -->
        <div class="tab-pane fade" id="pills-mensual" role="tabpanel">
            <div class="alert alert-warning alert-custom mb-4">
                <h5 style="font-size: 1.1rem;"><i class="fas fa-gift"></i> Información de Bonos Mensuales</h5>
                <p class="mb-0" style="font-size: 0.95rem;">Se consolidan al finalizar cada mes. Son pagos adicionales o premios acumulados por el rendimiento total mensual.</p>
            </div>

            <div class="card-custom fade-in">
                <div class="card-header-custom bg-purple">
                    <i class="fas fa-award"></i> Consolidado Mensual
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th>Mes</th>
                                    <th>Cierre de Mes</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $meses = [
                                        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                                        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                                        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                                    ];
                                @endphp
                                @foreach($meses as $num => $nombre)
                                    @php
                                        $pagosMes = $bonosMensuales->get($num, collect());
                                        $totalPagos = $pagosMes->count();
                                        $pendientes = $pagosMes->where('pagado', false)->count();
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $nombre }} {{ $añoActual }}</strong></td>
                                        <td>Fin de {{ $nombre }}</td>
                                        <td>
                                            @if($totalPagos > 0)
                                                <span class="badge bg-purple">{{ $totalPagos }} bonos gen.</span>
                                                @if($pendientes > 0)
                                                    <span class="badge bg-warning text-dark">{{ $pendientes }} pendientes</span>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">Sin generar</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                @if($totalPagos == 0)
                                                    <form action="{{ route('pagos.generar-mensual') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="mes" value="{{ $num }}">
                                                        <input type="hidden" name="año" value="{{ $añoActual }}">
                                                        <button type="submit" class="btn btn-sm btn-primary-custom" title="Procesar mes">
                                                            <i class="fas fa-magic"></i>
                                                            <span class="d-none d-md-inline ms-1">Procesar</span>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-info-custom" data-bs-toggle="collapse" data-bs-target="#mes{{ $num }}" title="Ver bonos">
                                                        <i class="fas fa-eye"></i>
                                                        <span class="d-none d-md-inline ms-1">Ver</span>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @if($totalPagos > 0)
                                        <tr class="collapse" id="mes{{ $num }}">
                                            <td colspan="4" class="p-4" style="background-color: #0f0f0f; border: 1px solid rgba(255,255,255,0.05);">
                                                <div class="card-custom p-3 shadow-none border-0">
                                                    <h6 class="fw-bold mb-3 text-purple">Detalle de Bonos Mensuales - {{ $nombre }}</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-hover mb-0" style="min-width: 800px;">
                                                        <thead style="background-color: #0a0a0a; color: white;">
                                                            <tr>
                                                                <th class="text-start" style="width: 25%;">Asesor</th>
                                                                <th class="text-center" style="width: 10%;">Ventas Mes</th>
                                                                <th class="text-end" style="width: 15%;">Comisiones Art.</th>
                                                                <th class="text-end" style="width: 15%;">Bono (5% Ventas)</th>
                                                                <th class="text-end" style="width: 15%;">Total Mes</th>
                                                                <th class="text-center" style="width: 10%;">Estado</th>
                                                                <th class="text-center" style="width: 10%;">Acción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($pagosMes as $pago)
                                                                <tr>
                                                                    <td class="text-start align-middle">
                                                                        <strong>{{ $pago->asesor->nombre_completo }}</strong>
                                                                    </td>
                                                                    <td class="text-center align-middle">
                                                                        <span class="badge bg-info">{{ $pago->cantidad_ventas }}</span>
                                                                    </td>
                                                                    <td class="text-end align-middle">
                                                                        <span class="text-muted">${{ number_format($pago->total_comisiones, 0, ',', '.') }}</span>
                                                                    </td>
                                                                    <td class="text-end align-middle">
                                                                        <span class="text-success fw-bold">${{ number_format($pago->bonificacion, 0, ',', '.') }}</span>
                                                                    </td>
                                                                    <td class="text-end align-middle">
                                                                        <span class="text-primary fw-bold">${{ number_format($pago->total_pagar, 0, ',', '.') }}</span>
                                                                    </td>
                                                                    <td class="text-center align-middle">
                                                                        @if($pago->pagado)
                                                                            <span class="badge bg-success">PAGADO</span>
                                                                        @else
                                                                            <span class="badge bg-warning text-dark">PENDIENTE</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center align-middle">
                                                                        @if($pago->pagado)
                                                                            <div class="d-flex gap-1 justify-content-center">
                                                                                <a href="{{ route('pagos.comprobante', $pago->id) }}" class="btn btn-xs btn-outline-info">
                                                                                    <i class="fas fa-file-invoice-dollar"></i> Factura
                                                                                </a>
                                                                                <form action="{{ route('pagos.marcar-no-pagado', $pago->id) }}" method="POST" class="js-confirm" data-confirm="¿Deshacer pago mensual?">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn btn-xs btn-outline-danger">Deshacer</button>
                                                                                </form>
                                                                            </div>
                                                                        @else
                                                                            <form action="{{ route('pagos.marcar-pagado', $pago->id) }}" method="POST">
                                                                                @csrf
                                                                                <button type="submit" class="btn btn-xs btn-success">
                                                                                    <i class="fas fa-check"></i> Pagar Bono
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot style="border-top: 2px solid rgba(255,255,255,0.1);">
                                                            <tr>
                                                                <th class="text-end" colspan="3">TOTALES BONOS:</th>
                                                                <th class="text-end text-success">${{ number_format($pagosMes->sum('bonificacion'), 0, ',', '.') }}</th>
                                                                <th class="text-end text-primary">${{ number_format($pagosMes->sum('total_pagar'), 0, ',', '.') }}</th>
                                                                <th colspan="2"></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-pills .nav-link {
        background: rgba(255,255,255,0.05);
        color: white;
        margin-right: 10px;
        border-radius: 12px;
        padding: 12px 25px;
        font-weight: 600;
        border: 1px solid rgba(255,255,255,0.1);
        transition: none;
    }
    .custom-pills .nav-link.active {
        background: #ffffff !important;
        color: #000000 !important;
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        border-color: transparent;
    }
    .bg-purple { background: #6b21a8 !important; color: white; }
    .text-purple { color: #a855f7; }
    .btn-xs { padding: .25rem .5rem; font-size: .75rem; border-radius: .2rem; }
</style>

<script>
function actualizarTodosPagos() {
    Swal.fire({
        title: '¿Actualizar todos los pagos?',
        html: 'Esto actualizará:<br><br>' +
              '<strong>✓ Todas las semanas del año {{ $añoActual }}</strong><br>' +
              '<strong>✓ Todos los bonos mensuales del año {{ $añoActual }}</strong><br><br>' +
              '<small class="text-muted">Los pagos ya realizados no se modificarán</small>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-sync-alt"></i> Sí, actualizar todo',
        cancelButtonText: 'Cancelar',
        background: '#0d0d0d',
        color: '#ffffff'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Actualizando...',
                html: 'Por favor espera mientras se procesan todos los pagos',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                background: '#0d0d0d',
                color: '#ffffff'
            });
            
            // Enviar petición al servidor
            fetch('{{ route("pagos.actualizar-todos") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    año: {{ $añoActual }}
                })
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: '¡Actualización completada!',
                    html: data.message,
                    confirmButtonColor: '#10b981',
                    background: '#0d0d0d',
                    color: '#ffffff'
                }).then(() => {
                    window.location.reload();
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al actualizar los pagos',
                    confirmButtonColor: '#ef4444',
                    background: '#0d0d0d',
                    color: '#ffffff'
                });
            });
        }
    });
}
</script>
@endsection
