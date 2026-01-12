<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CreamosHDV - Sistema de Gestión')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    
    <!-- Google Fonts - Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- AOS - Animate On Scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- html2pdf for PDF generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    
    <style>
        /* Sidebar Styles */
        .sidebar-custom {
            width: 260px;
            background: #1a1d21;
            min-height: 100vh;
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1040;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-custom.collapsed {
            width: 70px;
        }
        
        .sidebar-header {
            padding: 1.5rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            min-height: 100px;
        }
        
        .sidebar-logo {
            max-width: 180px;
            height: auto;
            max-height: 60px;
            object-fit: contain;
            transition: all 0.3s ease;
        }
        
        .sidebar-custom.collapsed .sidebar-header {
            flex-direction: column;
            gap: 10px;
            padding: 1rem 0.5rem;
        }
        
        .sidebar-custom.collapsed .sidebar-logo {
            max-width: 50px;
            max-height: 40px;
        }
        
        .sidebar-toggle {
            padding: 0.5rem;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }
        
        .sidebar-toggle:hover {
            transform: scale(1.1);
        }
        
        .sidebar-nav {
            padding: 1rem 0;
            margin: 0;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-nav .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 1rem 1.5rem;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 15px;
            white-space: nowrap;
        }
        
        .sidebar-nav .nav-link:hover {
            background: rgba(59, 130, 246, 0.1);
            color: white;
            border-left-color: #3b82f6;
        }
        
        .sidebar-nav .nav-link.active {
            background: rgba(59, 130, 246, 0.2);
            color: white;
            border-left-color: #3b82f6;
            font-weight: 600;
        }
        
        .sidebar-nav .nav-link i {
            width: 24px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        .sidebar-custom.collapsed .nav-text {
            display: none;
        }
        
        .sidebar-custom.collapsed .sidebar-nav .nav-link {
            justify-content: center;
            padding: 1rem 0.5rem;
        }
        
        /* Sidebar overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1010;
            pointer-events: none;
        }
        
        .sidebar-overlay.show {
            display: block;
            pointer-events: auto;
        }
        
        /* Main content with sidebar */
        .main-content {
            margin-left: 280px;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-custom.collapsed ~ .main-content {
            margin-left: 70px;
        }
        
        /* Navbar adjustments */
        .navbar-custom {
            z-index: 1030;
            width: 100%;
        }
        
        /* Mobile responsive */
        @media (max-width: 991px) {
            .sidebar-custom {
                transform: translateX(-100%);
            }
            
            .sidebar-custom.show {
                transform: translateX(0);
            }
            
            .sidebar-overlay.show {
                display: block;
            }
            
            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 10px;
            }

            .navbar-custom {
                margin: 0 0 1rem 0 !important;
                border-radius: 0 !important;
            }

            .card-modern, .card-custom {
                border-radius: 12px;
            }
        }
        
        body {
            overflow-x: hidden;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar-custom" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="d-block">
                <img src="{{ asset('images/logo.png') }}" alt="CreamosHDV Logo" class="sidebar-logo">
            </a>
            <button class="btn btn-link text-white sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <ul class="nav flex-column sidebar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            @if(auth()->user()->role === 'admin')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('asesores.*') ? 'active' : '' }}" href="{{ route('asesores.index') }}">
                    <i class="fas fa-users"></i>
                    <span class="nav-text">Asesores</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('servicios.*') ? 'active' : '' }}" href="{{ route('servicios.index') }}">
                    <i class="fas fa-briefcase"></i>
                    <span class="nav-text">Servicios</span>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('ventas.*') ? 'active' : '' }}" href="{{ route('ventas.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="nav-text">Ventas</span>
                </a>
            </li>
            @if(auth()->user()->role === 'admin')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pagos.*') ? 'active' : '' }}" href="{{ route('pagos.index') }}">
                    <i class="fas fa-money-bill-wave"></i>
                    <span class="nav-text">Pagos</span>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('recursos.*') ? 'active' : '' }}" href="{{ route('recursos.index') }}">
                    <i class="fas fa-folder-open"></i>
                    <span class="nav-text">Recursos</span>
                </a>
            </li>
            
            <li class="nav-item mt-auto">
                <a class="nav-link" href="https://wa.me/573145781261" target="_blank">
                    <i class="fas fa-headset"></i>
                    <span class="nav-text">Soporte</span>
                </a>
            </li>
            
            <li class="nav-item d-lg-none">
                <hr class="mx-3" style="border-color: rgba(255,255,255,0.1)">
            </li>

            <li class="nav-item d-lg-none">
                <a class="nav-link text-danger" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="nav-text">Cerrar Sesión</span>
                </a>
                <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-4 rounded-4" style="margin-top: 10px;">
            <div class="container-fluid">
                <button class="navbar-toggler d-lg-none" type="button" onclick="toggleSidebar()">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <!-- Nombre del usuario visible en móvil (Nombre Completo) -->
                <div class="d-flex align-items-center d-lg-none ms-auto text-white pe-2">
                    <small class="me-2 opacity-75">Hola,</small>
                    <span class="fw-bold" style="font-size: 0.85rem;">{{ Auth::user()->name }}</span>
                </div>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-2"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2 text-danger"></i> Cerrar Sesión
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @if(session('success'))
            <div class="alert alert-success alert-custom alert-dismissible fade show fade-in" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-custom alert-dismissible fade show fade-in" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')

        <!-- Footer -->
        <div class="mt-auto text-center border-top pt-4 pb-2" style="border-color: rgba(255,255,255,0.1) !important; font-size: 0.85rem; color: rgba(255, 255, 255, 0.7);">
            <p class="mb-1">
                &copy; {{ date('Y') }} Creamos hojas de vida. Todos los derechos reservados.
            </p>
            <p class="mb-0">
                Desarrollado por <a href="https://outdeveloper.com/" target="_blank" class="text-decoration-none fw-bold" style="color: #3b82f6;">OutDeveloper</a>
            </p>
        </div>
    </div>

    <!-- JQuery (Required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toast config
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            @if(session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success') }}"
                });
            @endif

            @if(session('error'))
                Toast.fire({
                    icon: 'error',
                    title: "{{ session('error') }}"
                });
            @endif

            // Interceptar botones con onclick confirm
            document.querySelectorAll('button[onclick*="confirm"]').forEach(button => {
                const message = button.getAttribute('onclick').match(/confirm\(['"](.+?)['"]\)/);
                if (message) {
                    button.removeAttribute('onclick');
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const form = this.closest('form');
                        Swal.fire({
                            title: '¿Confirmar acción?',
                            text: message[1],
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, continuar',
                            cancelButtonText: 'Cancelar',
                            background: '#1a1d21',
                            color: '#ffffff'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (form) form.submit();
                                else if (this.tagName === 'A') window.location.href = this.href;
                            }
                        });
                    });
                }
            });

            // Interceptar formularios con onsubmit confirm
            document.querySelectorAll('form[onsubmit*="confirm"]').forEach(form => {
                const message = form.getAttribute('onsubmit').match(/confirm\(['"](.+?)['"]\)/);
                if (message) {
                    form.removeAttribute('onsubmit');
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: '¿Confirmar acción?',
                            text: message[1],
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, continuar',
                            cancelButtonText: 'Cancelar',
                            background: '#1a1d21',
                            color: '#ffffff'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    });
                }
            });

            // Interceptar formularios con clase .js-confirm
            document.querySelectorAll('form.js-confirm').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const message = this.getAttribute('data-confirm') || '¿Está seguro de realizar esta acción?';
                    Swal.fire({
                        title: '¿Confirmar acción?',
                        text: message,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, continuar',
                        cancelButtonText: 'Cancelar',
                        background: '#1a1d21',
                        color: '#ffffff'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
            /* 
            AOS.init({
                duration: 800,
                once: true
            });
            */

            // Inicializar DataTables globalmente para tablas con clase .js-table
            $('.js-table').DataTable({
                responsive: true,
                searching: false,
                paging: false,
                info: false,
                autoWidth: false,
                width: '100%',
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                order: []
            });
            
        });

        // Sidebar toggle function (definida fuera para disponibilidad inmediata)
        window.toggleSidebar = function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            if (!sidebar || !overlay) return;

            // Check if mobile
            if (window.innerWidth <= 991) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            } else {
                sidebar.classList.toggle('collapsed');
            }
        };
    </script>
    
    @if(auth()->check() && auth()->user()->role === 'asesor')
        @php
            $waMessage = "VENTA INGRESADA\n";
            $waMessage .= "Nombre del Cliente: \n";
            $waMessage .= "Teléfono del cliente: \n";
            $waMessage .= "Servicio: \n";
            $waMessage .= "Valor total: \n";
            $waMessage .= "Pago recibido: (especifica si es 50% o 100%)\n";
            $waMessage .= "Comprobante: adjuntar comprobante \n";
            $waMessage .= "Nombre del Asesor: " . auth()->user()->name;
            $waUrl = "https://wa.me/573005038368?text=" . urlencode($waMessage);
        @endphp
        <a href="{{ $waUrl }}" class="whatsapp-float shadow-lg" target="_blank" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 30px; border-radius: 50%;">
            <i class="fab fa-whatsapp"></i>
        </a>
    @endif

    @stack('scripts')
</body>
</html>
