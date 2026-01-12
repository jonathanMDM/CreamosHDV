<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { padding: 20px; border: 1px solid #eee; border-radius: 8px; max-width: 600px; margin: 0 auto; }
        .header { background-color: #0d6efd; color: white; padding: 15px; border-radius: 8px 8px 0 0; text-align: center; }
        .content { padding: 20px; }
        .footer { font-size: 12px; color: #777; text-align: center; margin-top: 20px; border-top: 1px solid #eee; padding-top: 10px; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #0d6efd; color: white; text-decoration: none; border-radius: 5px; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>¡Pago Realizado!</h2>
        </div>
        <div class="content">
            <p>Hola <strong>{{ $asesor->nombre_completo }}</strong>,</p>
            
            <p>Te informamos que se ha generado un nuevo pago a tu cuenta.</p>
            
            <p><strong>Detalles del pago:</strong></p>
            <ul>
                @if($pago->tipo == 'semanal')
                    <li><strong>Concepto:</strong> Comisiones Semana {{ $pago->semana }} - {{ $pago->año }}</li>
                @else
                    <li><strong>Concepto:</strong> Bono Mensual - {{ \Carbon\Carbon::create()->month($pago->mes)->translatedFormat('F') }} {{ $pago->año }}</li>
                @endif
                <li><strong>Valor Pagado:</strong> ${{ number_format($pago->total_pagar, 0, ',', '.') }}</li>
                <li><strong>Fecha de Pago:</strong> {{ $pago->fecha_pago ? \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') : date('d/m/Y') }}</li>
            </ul>

            <p>Adjunto encontrarás el soporte detallado en formato PDF.</p>
            
            <p>Gracias por tu excelente trabajo.</p>
        </div>
        <div class="footer">
            <p>Creamos Hojas de Vida - Sistema de Gestión</p>
            <p>Este es un correo automático, por favor no responder.</p>
        </div>
    </div>
</body>
</html>
