@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4 animate__animated animate__fadeIn">
        <div class="col-12">
            <h2 class="fw-bold text-white mb-2">
                <i class="fas fa-book-reader me-2 text-primary"></i>Manuales de Usuario
            </h2>
            <p class="text-white-50">Documentación oficial y guías de uso para Creamos Hojas de Vida.</p>
        </div>
    </div>

    <div class="row animate__animated animate__fadeInUp">
        <div class="col-md-3 mb-4">
            <div class="list-group list-group-custom sticky-top" style="top: 2rem;">
                <a href="#manual-asesor" class="list-group-item list-group-item-action active" data-bs-toggle="list" role="tab">
                    <i class="fas fa-user-tie me-2"></i> Manual del Asesor
                </a>
                @if(auth()->user()->role === 'admin')
                <a href="#manual-admin" class="list-group-item list-group-item-action" data-bs-toggle="list" role="tab">
                    <i class="fas fa-user-shield me-2"></i> Manual del Admin
                </a>
                @endif
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content" id="nav-tabContent">
                
                <!-- MANUAL DEL ASESOR -->
                <div class="tab-pane fade show active" id="manual-asesor" role="tabpanel">
                    <div class="card card-custom border-0 shadow-lg">
                        <div class="card-body p-5">
                            <span class="badge bg-primary mb-3">Rol: Asesor</span>
                            <h1 class="card-title fw-bold mb-4">Guía para Asesores</h1>
                            
                            <hr class="border-secondary opacity-25">

                            <div class="manual-section mb-5">
                                <h3 class="text-primary fw-bold mb-3"><i class="fas fa-hand-point-right me-2"></i>1. Primeros Pasos</h3>
                                <p>Bienvenido al equipo. En tu <strong>Dashboard (Inicio)</strong> encontrarás un resumen rápido de tu rendimiento:</p>
                                <ul class="list-unstyled text-white-50 ms-3">
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Tus ventas aprobadas del mes.</li>
                                    <li class="mb-2"><i class="fas fa-dollar-sign text-warning me-2"></i> Tus comisiones acumuladas.</li>
                                    <li class="mb-2"><i class="fas fa-history text-info me-2"></i> Tus ventas recientes.</li>
                                </ul>
                            </div>

                            <div class="manual-section mb-5">
                                <h3 class="text-primary fw-bold mb-3"><i class="fas fa-cart-plus me-2"></i>2. ¿Cómo Registrar una Venta?</h3>
                                <div class="alert alert-info alert-custom border-0 text-dark">
                                    <i class="fas fa-info-circle me-2"></i> <strong>Importante:</strong> Debes registrar cada venta para recibir tu comisión.
                                </div>
                                <ol class="text-white-50">
                                    <li class="mb-3">Ve al menú <strong>"Ventas" > "Nueva Venta"</strong>.</li>
                                    <li class="mb-3">Completa los datos del cliente (Nombre y WhatsApp).</li>
                                    <li class="mb-3">Selecciona el servicio vendido y el tipo de pago.</li>
                                    <li class="mb-3">
                                        <strong class="text-white">📅 Fecha de la Venta (NUEVO):</strong>
                                        <br>Por defecto es hoy. Si vendiste ayer o la semana pasada, ¡cámbiala aquí! El sistema sabrá a qué semana corresponde.
                                    </li>
                                    <li class="mb-3">Sube el comprobante de pago (Captura).</li>
                                </ol>
                            </div>

                            <div class="manual-section mb-5">
                                <h3 class="text-primary fw-bold mb-3"><i class="fas fa-traffic-light me-2"></i>3. Estados de tus Ventas</h3>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="p-3 rounded bg-dark border border-warning border-opacity-25 text-center">
                                            <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                            <h5 class="fw-bold text-white">Pendiente</h5>
                                            <small class="text-white-50">En revisión por el admin.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 rounded bg-dark border border-success border-opacity-25 text-center">
                                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                            <h5 class="fw-bold text-white">Aprobada</h5>
                                            <small class="text-white-50">Comisión sumada a tu pago.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 rounded bg-dark border border-danger border-opacity-25 text-center">
                                            <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                                            <h5 class="fw-bold text-white">Rechazada</h5>
                                            <small class="text-white-50">Revisa el motivo y corrige.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="manual-section">
                                <h3 class="text-primary fw-bold mb-3"><i class="fas fa-wallet me-2"></i>4. Tus Pagos</h3>
                                <p>Ve a la sección <strong>"Pagos"</strong> para ver tu corte semanal.</p>
                                <p class="text-white-50">Cuando el administrador te pague, verás el estado <span class="badge bg-success">PAGADO</span> y podrás descargar tu comprobante.</p>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- MANUAL DEL ADMINISTRADOR -->
                @if(auth()->user()->role === 'admin')
                <div class="tab-pane fade" id="manual-admin" role="tabpanel">
                    <div class="card card-custom border-0 shadow-lg">
                        <div class="card-body p-5">
                            <span class="badge bg-danger mb-3">Rol: Administrador</span>
                            <h1 class="card-title fw-bold mb-4">Panel de Control</h1>

                            <hr class="border-secondary opacity-25">

                            <div class="manual-section mb-5">
                                <h3 class="text-danger fw-bold mb-3"><i class="fas fa-chart-line me-2"></i>1. Dashboard</h3>
                                <p>Tus estadísticas <strong>SOLO cuentan ventas aprobadas</strong>. Las pendientes no influyen en los números para mantener la contabilidad real.</p>
                            </div>

                            <div class="manual-section mb-5">
                                <h3 class="text-danger fw-bold mb-3"><i class="fas fa-tasks me-2"></i>2. Gestión de Ventas</h3>
                                
                                <h5 class="text-white mt-4 mb-2">✅ Aprobar Venta</h5>
                                <p class="text-white-50">Verifica la información y el comprobante. Al aprobar, la comisión se suma automáticamente a la deuda semanal con el asesor.</p>

                                <h5 class="text-white mt-4 mb-2">❌ Rechazar Venta (NUEVO)</h5>
                                <p class="text-white-50">Usa los botones rápidos para agilizar el proceso:</p>
                                <div class="d-flex gap-2 mb-3">
                                    <button class="btn btn-sm btn-outline-warning">📷 No adjuntó comprobante</button>
                                    <button class="btn btn-sm btn-outline-danger">⚠️ Comprobante falso</button>
                                </div>
                                <p class="text-white-50">El asesor recibirá una notificación con el motivo exacto.</p>
                            </div>

                            <div class="manual-section">
                                <h3 class="text-danger fw-bold mb-3"><i class="fas fa-money-bill-wave me-2"></i>3. Pagos y Finanzas</h3>
                                <p>En la sección "Pagos" ves el acumulado semanal de cada asesor.</p>
                                <ul class="text-white-50">
                                    <li><strong>Factura:</strong> Genera un PDF detallado.</li>
                                    <li><strong>Pagar:</strong> Marca la semana como saldada.</li>
                                    <li><strong>Deshacer:</strong> Si te equivocaste, revierte el estado de pago.</li>
                                    <li><strong>Bonos:</strong> Se gestionan igual, en su propia tabla inferior.</li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

<style>
.manual-section {
    background: rgba(255, 255, 255, 0.02);
    padding: 2rem;
    border-radius: 1rem;
    border: 1px solid rgba(255, 255, 255, 0.05);
}
.list-group-custom .list-group-item {
    background-color: #0d0d0d;
    border-color: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.7);
    transition: all 0.3s ease;
}
.list-group-custom .list-group-item:hover {
    background-color: #1a1a1a;
    color: white;
}
.list-group-custom .list-group-item.active {
    background-color: var(--primary) !important;
    border-color: var(--primary) !important;
    color: white !important;
}
.alert-custom {
    background-color: rgba(13, 202, 240, 0.1);
    border: 1px solid rgba(13, 202, 240, 0.2);
    color: #4dd4ac !important;
}
</style>
@endsection
