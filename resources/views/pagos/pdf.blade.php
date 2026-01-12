<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Comprobante de Pago</title>
    <style>
        @page { margin: 30px 40px; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 14px; line-height: 1.4; }
        
        /* Layout Helpers */
        .w-100 { width: 100%; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .text-blue { color: #0d6efd; }
        .text-muted { color: #777; }
        .text-uppercase { text-transform: uppercase; }
        
        /* Header */
        table.header-table { width: 100%; margin-bottom: 40px; }
        .logo-img { max-height: 80px; }
        .comprobante-title { font-size: 24px; font-weight: 800; text-transform: uppercase; margin: 0; line-height: 1; }
        .comprobante-subtitle { font-size: 14px; color: #555; margin-top: 5px; }
        .comprobante-number { font-size: 18px; color: #777; margin: 5px 0 15px 0; }
        
        /* Info Section */
        table.info-table { width: 100%; margin-bottom: 30px; border-top: 1px solid #eee; padding-top: 20px; }
        .info-label { font-size: 12px; text-transform: uppercase; color: #888; font-weight: bold; margin-bottom: 5px; display: block; }
        .info-name { font-size: 20px; font-weight: bold; margin: 0; }
        .info-detail { margin: 2px 0; font-size: 13px; }
        
        /* Items Table */
        .section-title { font-size: 14px; font-weight: 800; text-transform: uppercase; margin-bottom: 15px; }
        table.items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table.items-table th { background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 12px; text-align: left; font-size: 12px; text-transform: uppercase; font-weight: 700; }
        table.items-table td { border: 1px solid #dee2e6; padding: 12px; font-size: 13px; }
        table.items-table td.monto { font-weight: bold; text-align: right; }
        
        /* Footer/Totals */
        table.footer-table { width: 100%; margin-top: 20px; }
        .note-box { background-color: #f8f9fa; padding: 15px; border-radius: 5px; font-size: 12px; color: #555; }
        .total-label { font-size: 14px; font-weight: 700; text-transform: uppercase; text-align: right; padding-right: 15px; }
        .total-amount { font-size: 20px; font-weight: 800; color: #0d6efd; text-align: right; }
        
        .footer-legal { margin-top: 50px; border-top: 1px solid #eee; padding-top: 15px; text-align: center; font-size: 10px; color: #aaa; }
    </style>
</head>
<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td width="50%">
                <img src="{{ public_path('images/logo.png') }}" class="logo-img">
            </td>
            <td width="50%" class="text-right" style="vertical-align: top;">
                <h1 class="comprobante-title">Comprobante de<br>Pago</h1>
                <p class="comprobante-number">#{{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p class="text-muted text-bold">Fecha Emisión: {{ date('d/m/Y') }}</p>
            </td>
        </tr>
    </table>

    <!-- Info Section -->
    <table class="info-table">
        <tr>
            <td width="60%" style="vertical-align: top;">
                <span class="info-label">Pagado A:</span>
                <h2 class="info-name">{{ $pago->asesor->nombre_completo }}</h2>
                <p class="info-detail"><span class="text-muted">Cargo:</span> Asesor Comercial</p>
                <p class="info-detail"><span class="text-muted">C.C.</span> {{ $pago->asesor->cedula }}</p>
                <p class="info-detail" style="margin-top: 5px;">
                    <span class="text-muted">Tel:</span> {{ $pago->asesor->whatsapp }}
                </p>
            </td>
            <td width="40%" class="text-right" style="vertical-align: top;">
                <span class="info-label" style="text-align: right;">Datos de Pago:</span>
                <p class="info-detail"><strong>Banco:</strong> {{ $pago->asesor->banco ?? 'Nequi' }}</p>
                <p class="info-detail"><strong>Cuenta:</strong> {{ $pago->asesor->numero_cuenta ?? $pago->asesor->whatsapp }}</p>
                <p class="info-detail">
                    <strong>Periodo:</strong> 
                    @if($pago->tipo == 'semanal')
                        Semana {{ $pago->semana }} ({{ $pago->año }})
                    @else
                        {{ \Carbon\Carbon::create()->month($pago->mes)->translatedFormat('F') }} {{ $pago->año }}
                    @endif
                </p>
            </td>
        </tr>
    </table>

    <!-- Ventas Table -->
    <div class="section-title">Listado de Ventas y Pagos Individuales</div>
    
    <table class="items-table">
        <thead>
            <tr>
                <th width="20%">Fecha Venta</th>
                <th width="50%">Servicio / Concepto</th>
                <th width="30%" class="text-right">Monto Pagado al Asesor</th>
            </tr>
        </thead>
        <tbody>
            @if($pago->tipo == 'semanal')
                @foreach($ventas as $venta)
                <tr>
                    <td>{{ $venta->created_at->format('d/m/Y') }}</td>
                    <td>
                        {{ $venta->servicio->nombre_servicio }}
                        <br><span class="text-muted" style="font-size: 11px;">(Cliente: {{ $venta->nombre_cliente ?? 'N/A' }})</span>
                    </td>
                    <td class="monto">${{ number_format($venta->comision, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <!-- Fila Total Tabla -->
                <tr>
                    <td colspan="2" class="text-right text-bold" style="background-color: #f8f9fa;">Total Comisiones de la Semana:</td>
                    <td class="monto" style="background-color: #f8f9fa;">${{ number_format($pago->total_pagar, 0, ',', '.') }}</td>
                </tr>
            @else
                <!-- Caso Mensual (Bonos) -->
                <tr>
                    <td>{{ date('t/m/Y', mktime(0, 0, 0, $pago->mes, 1, $pago->año)) }}</td>
                    <td>Bono por cumplimiento de metas (Más de 10 ventas)</td>
                    <td class="monto">${{ number_format($pago->bonificacion, 0, ',', '.') }}</td>
                </tr>
                 <tr>
                    <td colspan="2" class="text-right text-bold" style="background-color: #f8f9fa;">Total Bono Mensual:</td>
                    <td class="monto" style="background-color: #f8f9fa;">${{ number_format($pago->total_pagar, 0, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Footer Totals -->
    <table class="footer-table">
        <tr>
            <td width="60%" style="vertical-align: top;">
                <div class="note-box">
                    <strong>Información del Pago:</strong><br>
                    Este comprobante detalla el total ganado por comisiones de ventas durante 
                    @if($pago->tipo == 'semanal')
                        la semana {{ $pago->semana }}.
                    @else
                        el mes de {{ \Carbon\Carbon::create()->month($pago->mes)->translatedFormat('F') }}.
                    @endif
                </div>
            </td>
            <td width="40%" style="vertical-align: middle;">
                <table width="100%">
                    <tr>
                        <td class="total-label">TOTAL A COBRAR:</td>
                        <td class="total-amount">${{ number_format($pago->total_pagar, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="footer-legal">
        Creamos Hojas de Vida | Asesoría Digital<br>
        Documento generado automáticamente el {{ date('d/m/Y H:i:s') }}
    </div>

</body>
</html>
