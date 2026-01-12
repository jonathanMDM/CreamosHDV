<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Comprobante de Pago</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { width: 100%; border-bottom: 2px solid #ddd; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { float: left; width: 50%; }
        .info-factura { float: right; width: 40%; text-align: right; }
        .row { width: 100%; clear: both; margin-bottom: 20px; }
        .col-half { width: 48%; float: left; }
        .col-right { float: right; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 12px; }
        .table th { background-color: #f8f9fa; font-weight: bold; }
        .text-end { text-align: right; }
        .total-box { background-color: #f8f9fa; border: 1px solid #ddd; padding: 15px; margin-top: 20px; text-align: right; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #777; border-top: 1px solid #eee; padding-top: 10px; }
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>
    <div class="header clearfix">
        <div class="logo">
            <!-- Como DomPDF a veces falla con imágenes externas, usaremos texto si no carga, o ruta absoluta -->
            <h1 style="color: #0d6efd;">CREAMOS HDV</h1>
            <p style="margin:0; font-size:12px;">Nit: 901.234.567-8</p>
        </div>
        <div class="info-factura">
            <h3 style="margin:0;">COMPROBANTE DE PAGO</h3>
            <p style="margin:5px 0; color: #777;">#{{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p style="margin:0; font-size:12px;"><strong>Fecha:</strong> {{ date('d/m/Y') }}</p>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-half">
            <h5 style="margin-bottom: 5px; text-transform: uppercase; color: #777;">Pagado A:</h5>
            <h4 style="margin: 0;">{{ $pago->asesor->nombre_completo }}</h4>
            <p style="margin: 2px 0; font-size: 12px;">C.C. {{ $pago->asesor->cedula }}</p>
            <p style="margin: 2px 0; font-size: 12px;">{{ $pago->asesor->email }}</p>
            <p style="margin: 2px 0; font-size: 12px;">{{ $pago->asesor->whatsapp }}</p>
        </div>
        <div class="col-half col-right text-end">
            <h5 style="margin-bottom: 5px; text-transform: uppercase; color: #777;">Detalle del Periodo:</h5>
            @if($pago->tipo == 'semanal')
                <h4 style="margin: 0;">Semana {{ $pago->semana }}</h4>
                <p style="margin: 2px 0; font-size: 12px;">Año: {{ $pago->año }}</p>
            @else
                <h4 style="margin: 0;">Bono Mensual</h4>
                <p style="margin: 2px 0; font-size: 12px;">Mes: {{ \Carbon\Carbon::create()->month($pago->mes)->translatedFormat('F') }} {{ $pago->año }}</p>
            @endif
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Fecha Venta</th>
                <th>Cliente</th>
                <th>Servicio</th>
                <th class="text-end">Valor Venta</th>
                <th class="text-end">Comisión</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
            <tr>
                <td>{{ $venta->created_at->format('d/m/Y') }}</td>
                <td>{{ $venta->nombre_cliente ?? 'N/A' }}</td>
                <td>{{ $venta->servicio->nombre_servicio }}</td>
                <td class="text-end">${{ number_format($venta->valor_servicio, 0, ',', '.') }}</td>
                <td class="text-end" style="font-weight: bold;">${{ number_format($venta->comision, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        <table style="width: 100%; border: none;">
            @if($pago->tipo == 'semanal')
            <tr>
                <td style="border: none; text-align: right; padding: 5px;">Total Ventas:</td>
                <td style="border: none; text-align: right; padding: 5px; width: 120px;">{{ $pago->cantidad_ventas }}</td>
            </tr>
            <tr>
                <td style="border: none; text-align: right; padding: 5px;"><strong>Total a Pagar:</strong></td>
                <td style="border: none; text-align: right; padding: 5px; font-size: 16px; font-weight: bold; color: #0d6efd;">${{ number_format($pago->total_pagar, 0, ',', '.') }}</td>
            </tr>
            @else
            <tr>
                <td style="border: none; text-align: right; padding: 5px;">Total Ventas (≥10):</td>
                <td style="border: none; text-align: right; padding: 5px; width: 120px;">{{ $pago->cantidad_ventas }}</td>
            </tr>
            <tr>
                <td style="border: none; text-align: right; padding: 5px;">Total Comisiones Base:</td>
                <td style="border: none; text-align: right; padding: 5px;">${{ number_format($pago->total_comisiones, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="border: none; text-align: right; padding: 5px;"><strong>Bono Incentivo (5%):</strong></td>
                <td style="border: none; text-align: right; padding: 5px; font-size: 16px; font-weight: bold; color: #0d6efd;">${{ number_format($pago->bonificacion, 0, ',', '.') }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="footer">
        <p>Documento generado electrónicamente por Creamos Hojas de Vida</p>
        <p>Visítanos en creamoshdv.com</p>
    </div>
</body>
</html>
