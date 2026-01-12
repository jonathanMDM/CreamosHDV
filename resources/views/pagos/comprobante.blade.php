@extends('layouts.app')

@section('title', 'Comprobante de Pago - CreamosHDV')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-3 no-print">
            <a href="{{ route('pagos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-outline-light">
                    <i class="fas fa-print"></i> Imprimir
                </button>
                
                @php
                    $nombreArchivo = "Comprobante_" . str_replace(' ', '_', $pago->asesor->nombre_completo) . "_" . ($pago->tipo == 'semanal' ? 'Semana_'.$pago->semana : 'Bono_'.($pago->mes)) . ".pdf";
                    $urlWa = "https://wa.me/" . preg_replace('/[^0-9]/', '', $pago->asesor->whatsapp);
                @endphp

                <button onclick="enviarPDFWhatsApp('{{ $urlWa }}', '{{ $nombreArchivo }}')" class="btn btn-success-custom">
                    <i class="fab fa-whatsapp"></i> Enviar PDF por WhatsApp
                </button>
            </div>
        </div>

        <!-- Factura Content -->
        <div id="factura-container">
            <div class="card-custom bg-white text-dark" id="factura" style="padding: 3rem;">
                <div class="row mb-5">
                    <div class="col-6 text-start">
                        <img src="{{ asset('images/logo.png') }}" alt="CreamosHDV Logo" style="height: 100px;">
                    </div>
                    <div class="col-6 text-end">
                        <h4 class="fw-bold mb-0">COMPROBANTE DE PAGO</h4>
                        <p class="text-muted">#{{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}</p>
                        <p class="mb-0"><strong>Fecha Emisión:</strong> {{ Carbon\Carbon::now()->format('d/m/Y') }}</p>
                    </div>
                </div>

                <hr>

                <div class="row my-4">
                    <div class="col-7">
                        <h6 class="text-muted text-uppercase small fw-bold">PAGADO A:</h6>
                        <h5 class="fw-bold mb-1">{{ $pago->asesor->nombre_completo }}</h5>
                        <p class="mb-1 text-muted small"><strong>Cargo:</strong> Asesor Comercial</p>
                        <p class="mb-0 text-muted small">C.C. {{ $pago->asesor->cedula }}</p>
                        <p class="mb-0 text-muted small"><i class="fab fa-whatsapp"></i> {{ $pago->asesor->whatsapp }}</p>
                    </div>
                    <div class="col-5 text-end">
                        <h6 class="text-muted text-uppercase small fw-bold">DATOS DE PAGO:</h6>
                        <p class="mb-0 small"><strong>Banco:</strong> {{ $pago->asesor->banco }}</p>
                        <p class="mb-0 small"><strong>Cuenta:</strong> {{ $pago->asesor->numero_cuenta }}</p>
                        @if($pago->tipo == 'semanal')
                            <p class="mb-0 small"><strong>Periodo:</strong> Semana {{ $pago->semana }} ({{ $pago->año }})</p>
                        @else
                            @php $meses = [1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre']; @endphp
                            <p class="mb-0 small"><strong>Mes:</strong> {{ $meses[$pago->mes] }} {{ $pago->año }}</p>
                        @endif
                    </div>
                </div>

                <div class="my-5">
                    <h6 class="fw-bold border-bottom pb-2 mb-3">LISTADO DE VENTAS Y PAGOS INDIVIDUALES</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr class="small text-uppercase">
                                    <th class="p-2">Fecha Venta</th>
                                    <th class="p-2">Servicio / Concepto</th>
                                    <th class="p-2 text-end">Monto Pagado al Asesor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ventas as $venta)
                                    @php
                                        // Calcular cuánto se le pagó por esta venta en específica según el tipo de comprobante
                                        $pagoIndividual = ($pago->tipo == 'semanal') ? $venta->comision : ($venta->valor_servicio * 0.05);
                                    @endphp
                                    <tr class="small">
                                        <td class="p-2">{{ $venta->created_at->format('d/m/Y') }}</td>
                                        <td class="p-2">
                                            @if($venta->servicio)
                                                {{ $venta->servicio->nombre_servicio }}
                                            @else
                                                Servicio Registrado
                                            @endif
                                            <span class="text-muted small">
                                                (@if($pago->tipo == 'semanal') Comisión fija @else Bono 5% s/vta @endif)
                                            </span>
                                        </td>
                                        <td class="p-2 text-end fw-bold">
                                            ${{ number_format($pagoIndividual, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                @if($pago->tipo == 'mensual')
                                    <tr class="bg-light text-end">
                                        <th colspan="2" class="p-2 small">Total Bono Mensual Acumulado:</th>
                                        <th class="p-2 small">${{ number_format($pago->bonificacion, 0, ',', '.') }}</th>
                                    </tr>
                                @else
                                    <tr class="bg-light text-end">
                                        <th colspan="2" class="p-2 small">Total Comisiones de la Semana:</th>
                                        <th class="p-2 small">${{ number_format($pago->total_comisiones, 0, ',', '.') }}</th>
                                    </tr>
                                @endif
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="row align-items-center mt-5 pt-3">
                    <div class="col-7">
                        <div class="border p-3 bg-light rounded" style="font-size: 0.75rem;">
                            <p class="mb-1 text-muted"><strong>Información del Pago:</strong></p>
                            @if($pago->tipo == 'semanal')
                                <p class="mb-0">Este comprobante detalla el total ganado por comisiones de ventas durante la semana {{ $pago->semana }}.</p>
                            @else
                                <p class="mb-0">Este comprobante detalla el incentivo del 5% otorgado por el volumen mensual de sus ventas.</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-5 text-end">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td class="text-end p-1 h5 mb-0">TOTAL A COBRAR:</td>
                                <td class="text-end p-1 h4 fw-bold text-primary mb-0">${{ number_format($pago->total_pagar, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-5 pt-4 text-center border-top">
                    <div class="d-flex justify-content-center gap-4 mb-3">
                        <a href="https://www.facebook.com/share/14TAas7pNfc/?mibextid=wwXIfr" target="_blank" class="text-decoration-none text-dark small">
                            <i class="fab fa-facebook text-primary me-1"></i> Facebook
                        </a>
                        <a href="https://www.tiktok.com/@creamostuhojadevida" target="_blank" class="text-decoration-none text-dark small">
                            <i class="fab fa-tiktok text-dark me-1"></i> TikTok
                        </a>
                        <a href="mailto:creamoshojasdevida@gmail.com" class="text-decoration-none text-dark small">
                            <i class="fas fa-envelope text-danger me-1"></i> creamoshojasdevida@gmail.com
                        </a>
                    </div>
                    <p class="text-muted small mb-0">Comprobante generado automáticamente por el sistema <strong>creamos hojas de vida</strong></p>
                    <p class="text-muted small fw-bold">🚀 Gestión Administrativa creamos hojas de vida</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #factura * {
        color: #000000 !important;
    }
    #factura .text-muted {
        color: #666666 !important;
    }
    #factura .text-primary {
        color: #0d6efd !important;
    }
    #factura .text-success {
        color: #198754 !important;
    }
    #factura .bg-light {
        background-color: #f8f9fa !important;
    }
    #factura .table-light {
        background-color: #f8f9fa !important;
    }
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; padding: 0 !important; }
        #factura-container { box-shadow: none !important; border: none !important; }
        .card-custom { box-shadow: none !important; border: 1px solid #eee !important; width: 100% !important; margin: 0 !important; padding: 25px !important; }
        .container-fluid { padding: 0 !important; }
    }
    #factura {
        border-radius: 0;
        border: none;
        background-color: white !important;
    }
    #factura-container {
        background: white !important;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    }
    .table-sm td, .table-sm th { font-size: 0.8rem; }
</style>

<script>
    function enviarPDFWhatsApp(urlWa, nombreArchivo) {
        const element = document.getElementById('factura');
        
        const opt = {
            margin:       [10, 5, 10, 5],
            filename:     nombreArchivo,
            image:        { type: 'jpeg', quality: 1 },
            html2canvas:  { scale: 3, useCORS: true, letterRendering: true },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        Swal.fire({
            title: 'Generando PDF...',
            html: 'Preparando comprobante para enviar<br><small class="text-muted">El PDF se descargará automáticamente</small>',
            allowOutsideClick: false,
            background: '#0d0d0d',
            color: '#ffffff',
            didOpen: () => { Swal.showLoading(); }
        });

        // Generar y descargar el PDF
        html2pdf().set(opt).from(element).save().then(() => {
            // Esperar un momento para que el PDF se descargue
            setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: '¡PDF Generado!',
                    html: 'El archivo <strong>' + nombreArchivo + '</strong> se ha descargado.<br><br>' +
                          '<small class="text-muted">Ahora se abrirá WhatsApp. Por favor adjunta el PDF descargado usando el botón de clip (📎) en el chat.</small>',
                    confirmButtonText: 'Abrir WhatsApp',
                    confirmButtonColor: '#25D366',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    background: '#0d0d0d',
                    color: '#ffffff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.open(urlWa, '_blank');
                    }
                });
            }, 1000);
        });
    }
</script>
@endsection
