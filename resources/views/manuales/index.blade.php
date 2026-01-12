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
                                <p>Bienvenido al equipo. En tu menú lateral izquierdo encontrarás acceso directo a tus herramientas principales:</p>
                                <ul class="list-unstyled text-white-50 ms-3">
                                    <li class="mb-2"><i class="fas fa-home me-2"></i> <strong>Dashboard:</strong> Resumen de tu rendimiento.</li>
                                    <li class="mb-2"><i class="fas fa-shopping-cart me-2"></i> <strong>Ventas:</strong> Donde registras y sigues tus ventas.</li>
                                    <li class="mb-2"><i class="fas fa-headset me-2"></i> <strong>Soporte:</strong> Contacto directo para ayuda técnica.</li>
                                </ul>
                                <p class="mt-3 text-white-50">En el <strong>Dashboard</strong> verás:</p>
                                <ul class="list-unstyled text-white-50 ms-3">
                                    <li class="mb-1"><i class="fas fa-check text-success me-2"></i> Tus ventas aprobadas.</li>
                                    <li class="mb-1"><i class="fas fa-dollar-sign text-warning me-2"></i> Comisiones acumuladas.</li>
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
                                <p class="text-white-50 mb-4">Después de registrar una venta, esta pasará por tres posibles estados. Aquí te explicamos qué significa cada uno:</p>
                                
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="p-3 rounded bg-dark border border-warning border-opacity-25 h-100">
                                            <div class="text-center mb-3">
                                                <i class="fas fa-clock fa-2x text-warning"></i>
                                                <h5 class="fw-bold text-white mt-2">Pendiente</h5>
                                            </div>
                                            <p class="small text-white-50">
                                                Tu venta se registró, pero el administrador aún está verificando el comprobante de pago.
                                            </p>
                                            <ul class="small text-white-50 mb-0 ps-3">
                                                <li>El dinero <strong>aún no</strong> se suma a tu saldo.</li>
                                                <li>Debes esperar la revisión.</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 rounded bg-dark border border-success border-opacity-25 h-100">
                                            <div class="text-center mb-3">
                                                <i class="fas fa-check-circle fa-2x text-success"></i>
                                                <h5 class="fw-bold text-white mt-2">Aprobada</h5>
                                            </div>
                                            <p class="small text-white-50">
                                                ¡Todo está correcto! El administrador validó el pago.
                                            </p>
                                            <ul class="small text-white-50 mb-0 ps-3">
                                                <li>La comisión <strong>ya es tuya</strong>.</li>
                                                <li>Entrará en el pago de este domingo.</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 rounded bg-dark border border-danger border-opacity-25 h-100">
                                            <div class="text-center mb-3">
                                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                                                <h5 class="fw-bold text-white mt-2">Rechazada</h5>
                                            </div>
                                            <p class="small text-white-50">
                                                Hubo un problema. Para solucionarlo:
                                            </p>
                                            <ol class="small text-white-50 mb-0 ps-3">
                                                <li>Haz clic en el botón <strong>"Ver"</strong>.</li>
                                                <li>Lee el motivo (ej: "Foto borrosa").</li>
                                                <li>Vuelve a subir la venta corregida.</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="manual-section text-white-50">
                                <h3 class="text-primary fw-bold mb-3"><i class="fas fa-wallet me-2"></i>4. Pagos y Comisiones</h3>
                                <div class="alert alert-custom border-0 text-white">
                                    <i class="fas fa-calendar-check me-2"></i> <strong>Política de Pagos:</strong>
                                </div>
                                <ul class="list-unstyled mt-3">
                                    <li class="mb-3">
                                        <strong class="text-white d-block"><i class="fas fa-calendar-week me-2 text-primary"></i> Pagos Semanales:</strong>
                                        El corte se realiza cada <strong>Domingo</strong>. Se pagan todas las comisiones de las ventas aprobadas durante esa semana.
                                    </li>
                                    <li class="mb-3">
                                        <strong class="text-white d-block"><i class="fas fa-star me-2 text-warning"></i> Bono Mensual (5%):</strong>
                                        Si cumples las metas, el bono extra del 5% se liquida y paga a <strong>fin de mes</strong>.
                                    </li>
                                    <li>
                                        <strong class="text-white d-block"><i class="fas fa-envelope me-2 text-info"></i> Comprobantes de Pago:</strong>
                                        Una vez realizado el pago, el comprobante y el detalle se enviarán automáticamente al <strong>correo electrónico</strong> que registraste con el administrador.
                                    </li>
                                </ul>
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
                                <h3 class="text-danger fw-bold mb-3"><i class="fas fa-chart-line me-2"></i>1. Dashboard (Panel Principal)</h3>
                                <p class="text-white-50">Es tu centro de control. Aquí ves la salud financiera del negocio en tiempo real.</p>
                                <ul class="list-unstyled text-white-50 ms-3">
                                    <li class="mb-2"><strong>Ingresos Totales:</strong> Suma de dinero de ventas <em>aprobadas</em> (dinero real en caja).</li>
                                    <li class="mb-2"><strong>Comisiones a Pagar:</strong> Total que debes a los asesores por esas ventas.</li>
                                    <li class="mb-2"><strong>Top Asesores:</strong> Ranking de rendimiento para incentivos.</li>
                                </ul>
                                <div class="alert alert-danger border-0 text-white bg-opacity-10 py-2">
                                    <small><i class="fas fa-exclamation-circle me-1"></i> Las ventas "Pendientes" <strong>NO</strong> suman aquí hasta que las apruebes.</small>
                                </div>
                            </div>

                            <div class="manual-section mb-5">
                                <h3 class="text-danger fw-bold mb-3"><i class="fas fa-users me-2"></i>2. Gestión de Asesores</h3>
                                <p class="text-white-50">Administra a tu equipo de ventas. Puedes:</p>
                                <ul class="text-white-50">
                                    <li class="mb-2"><strong>Nuevo Asesor:</strong> Registra sus datos básicos (Nombre, Cédula, Teléfono, Correo).</li>
                                    <li class="mb-2"><strong>Crear Usuario:</strong> Una vez creado el asesor, haz clic en el botón <i class="fas fa-user-plus text-success"></i> para generarle acceso al sistema.</li>
                                    <li class="mb-2"><strong>Editar/Desactivar:</strong> Si un asesor se retira, puedes desactivar su acceso sin borrar su historial de ventas.</li>
                                </ul>
                            </div>

                            <div class="manual-section mb-5">
                                <h3 class="text-danger fw-bold mb-3"><i class="fas fa-briefcase me-2"></i>3. Gestión de Servicios</h3>
                                <p class="text-white-50">Configura qué vendes y cuánto pagas por ello.</p>
                                <ul class="text-white-50">
                                    <li><strong>Precio:</strong> Lo que paga el cliente final.</li>
                                    <li><strong>Comisión (%):</strong> El porcentaje exacto que ganará el asesor por venta.</li>
                                    <li><em>Ejemplo: Si un servicio vale $100.000 y la comisión es 10%, el asesor gana $10.000 automáticamente.</em></li>
                                </ul>
                            </div>

                            <div class="manual-section mb-5">
                                <h3 class="text-danger fw-bold mb-3"><i class="fas fa-check-double me-2"></i>4. Control de Ventas</h3>
                                <p class="text-white-50">Tu tarea diaria principal: Validar el ingreso de dinero.</p>
                                
                                <div class="row g-3 mt-2">
                                    <div class="col-md-6">
                                        <div class="p-3 border border-success border-opacity-25 rounded bg-dark">
                                            <h6 class="text-success fw-bold"><i class="fas fa-check me-2"></i>Aprobar</h6>
                                            <small class="text-white-50">Verifica que el comprobante sea real y el monto correcto. Al aprobar, el sistema calcula la comisión y la agenda para pagar el domingo.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 border border-danger border-opacity-25 rounded bg-dark">
                                            <h6 class="text-danger fw-bold"><i class="fas fa-times me-2"></i>Rechazar</h6>
                                            <small class="text-white-50">Si algo está mal (foto borrosa, valor incompleto). Usa los <strong>botones rápidos</strong> para notificar al asesor instantáneamente.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="manual-section mb-5">
                                <h3 class="text-danger fw-bold mb-3"><i class="fas fa-money-bill-wave me-2"></i>5. Pagos y Finanzas</h3>
                                <p class="text-white-50">El sistema hace la contabilidad por ti. Hay dos cortes:</p>
                                
                                <h5 class="text-white mt-3"><i class="fas fa-calendar-week me-2 text-warning"></i>Corte Semanal (Domingos)</h5>
                                <p class="text-white-50">En la tabla "Pagos Semanales":</p>
                                <ul class="text-white-50 small">
                                    <li>El sistema suma todas las ventas aprobadas de la semana.</li>
                                    <li><strong>Botón Factura:</strong> Descarga un PDF con el detalle venta por venta (para transparencia con el asesor).</li>
                                    <li><strong>Botón Pagar:</strong> Marca la deuda como saldada y archiva la semana.</li>
                                </ul>

                                <h5 class="text-white mt-3"><i class="fas fa-star me-2 text-warning"></i>Bonos Mensuales</h5>
                                <p class="text-white-50 small">Al final de la página, verás la tabla de Bonos. Si activas premios por meta, aquí aparecerá el 5% extra a pagar a fin de mes.</p>
                            </div>

                            <div class="manual-section">
                                <h3 class="text-danger fw-bold mb-3"><i class="fas fa-folder-open me-2"></i>6. Recursos (Archivos)</h3>
                                <p class="text-white-50">Sube material de apoyo para tus asesores (Imágenes de publicidad, guiones de venta, PDFs informativos). Ellos podrán descargarlos desde su perfil.</p>
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
