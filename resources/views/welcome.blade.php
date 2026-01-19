<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creamos tu Hoja de Vida - Diseño Profesional y Moderno</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Google Fonts: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}?v=2.1" rel="stylesheet">

    <style>
        body {
            background-color: #000000;
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
        }
        .btn-premium {
            background: #ffffff;
            color: #000000;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .btn-premium:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 255, 255, 0.1);
            color: #000000;
        }
        .nav-link-landing {
            color: rgba(0, 0, 0, 0.7) !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .nav-link-landing:hover {
            color: #000000 !important;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg landing-navbar">
        <div class="container px-4 px-lg-0">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" height="40" class="me-2" style="filter: brightness(0) invert(1);">
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="background: rgba(255,255,255,0.1);">
                <i class="fas fa-bars text-white"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link nav-link-landing px-3" href="#servicios">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-landing px-3" href="#expertos">Expertos</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-landing px-3" href="#nosotros">Nosotros</a></li>
                </ul>
                <div class="d-flex gap-3 mt-3 mt-lg-0">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-premium">Ir al Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-premium">Iniciar Sesión</a>
                        @endauth
                    @endif

                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container h-100">
            <div class="row align-items-center">
                <div class="col-lg-10 col-xl-8 py-5">
                    <h1 class="hero-title">Diseñamos tu<br>Futuro Profesional</h1>
                    <p class="hero-subtitle">Consigue el empleo que mereces con una hoja de vida de alto impacto. Creamos perfiles ganadores que destacan en cualquier proceso de selección.</p>
                    <div class="d-flex gap-3">
                        <a href="#servicios" class="btn-premium">Ver Planes</a>
                        <a href="https://wa.me/573136214224" target="_blank" class="btn btn-outline-light px-4 py-2" style="border-radius: 12px; font-weight: 600;">Asesoría Gratis</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Info Block + Services Combined -->
    <section class="container my-5" id="servicios">
        <div class="info-block p-5">
            <!-- Top Section: Impulsemos tu carrera -->
            <div class="d-flex flex-column flex-lg-row align-items-center gap-5 mb-5 border-bottom pb-5">
                <div class="col-lg-7">
                    <h2 class="text-dark fw-bold display-5 mb-3">Impulsemos tu carrera juntos</h2>
                    <p class="fs-5 text-muted mb-4">La primera impresión es fundamental en cualquier proceso de selección. Por eso, nos dedicamos a transformar perfiles tradicionales en presentaciones de alto impacto.</p>
                    <div class="row g-4 mt-2">
                        <div class="col-6 col-md-4">
                            <h4 class="fw-bold mb-1 text-dark">+1000</h4>
                            <p class="text-muted small">Hojas de vida creadas</p>
                        </div>
                        <div class="col-6 col-md-4">
                            <h4 class="fw-bold mb-1 text-dark">98%</h4>
                            <p class="text-muted small">Tasa de éxito</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 text-center">
                    <a href="https://wa.me/573005038368" target="_blank" class="btn btn-dark btn-lg px-5 py-3 rounded-pill fw-bold">Empieza Ahora</a>
                </div>
            </div>

            <!-- Bottom Section: Services Grid -->
            <div>
                <div class="mb-5">
                    <span class="text-uppercase fw-bold ls-2 d-block mb-2 text-muted">Nuestros Productos</span>
                    <h2 class="display-5 fw-bold text-dark">Servicios que ofrecemos</h2>
                </div>
                
                <div class="row g-4">
                    @foreach($servicios as $servicio)
                    <div class="col-md-6 col-lg-4">
                        @php
                            $isPack = stripos($servicio->nombre_servicio, 'Paquete') !== false || stripos($servicio->nombre_servicio, 'Pack') !== false;
                            $whatsappMessage = "Hola, estoy interesado en el servicio: " . $servicio->nombre_servicio;
                        @endphp
                        <div class="service-card-light h-100 p-4 rounded-4 {{ $isPack ? 'bg-dark text-white shadow-lg' : 'bg-light' }} d-flex flex-column" style="{{ $isPack ? '' : 'background: #f8f9fa;' }}">
                            <div class="flex-grow-1">
                                <div class="service-icon mb-3 {{ $isPack ? 'text-white' : 'text-dark' }} fs-2">
                                    <i class="{{ $servicio->icono ?? 'fas fa-file-invoice' }}"></i>
                                </div>
                                <h3 class="{{ $isPack ? 'text-white' : 'text-dark' }} fw-bold h4">{{ $servicio->nombre_servicio }}</h3>
                                <p class="{{ $isPack ? 'text-white-50' : 'text-muted' }}">{{ $servicio->descripcion }}</p>
                                <div class="service-price {{ $isPack ? 'text-white' : 'text-dark' }} fw-bold fs-4 mb-4">${{ number_format($servicio->valor, 0, ',', '.') }}</div>
                            </div>
                            
                            <a href="https://wa.me/573005038368?text={{ urlencode($whatsappMessage) }}" 
                               target="_blank" 
                               class="btn-whatsapp-card">
                                <i class="fab fa-whatsapp fs-5"></i> 
                                Comprar ahora
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Nosotros Section -->
    <section id="nosotros" class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 order-lg-2">
                <img src="{{ asset('images/about.png') }}" alt="Sobre Nosotros" class="img-fluid rounded-4 shadow-lg" onerror="this.src='https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'">
            </div>
            <div class="col-lg-6 order-lg-1">
                <span class="text-white-50 text-uppercase fw-bold d-block mb-3">Sobre Nosotros</span>
                <h2 class="display-5 fw-bold mb-4">Transformamos tu perfil profesional</h2>
                
                <p class="text-white-50 fs-5 mb-4">
                    <strong class="text-white">Creamos Hojas de Vida</strong> es un emprendimiento enfocado en ayudar a las personas a mejorar su perfil profesional y aumentar sus oportunidades laborales.
                </p>
                
                <p class="text-white-50 fs-5 mb-4">
                    Entendemos que la primera impresión es fundamental en cualquier proceso de selección. Por eso, nos dedicamos a transformar perfiles tradicionales en presentaciones de alto impacto.
                </p>

                <div class="p-4 rounded-4 border border-secondary border-opacity-25 bg-dark">
                    <p class="mb-0 text-white-50">
                        <i class="fas fa-quote-left text-white fs-4 me-2"></i>
                        Trabajamos ofreciendo servicios digitales orientados exclusivamente a personas que están buscando empleo o desean mejorar significativamente su presentación profesional ante el mercado laboral.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Experts Section -->
    <section id="expertos" class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <img src="{{ asset('images/team.jpg') }}" alt="Nuestros Expertos" class="img-fluid rounded-4 shadow-lg">
            </div>
            <div class="col-lg-6">
                <span class="text-white-50 text-uppercase fw-bold d-block mb-3">Equipo de Reclutamiento</span>
                <h2 class="display-5 fw-bold mb-4">Expertos que saben qué buscan las empresas</h2>
                <p class="text-white-50 fs-5 mb-4">Nuestro equipo está compuesto por psicólogos y reclutadores experimentados que entienden los algoritmos de selección y los filtros que aplican las empresas hoy en día.</p>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="fas fa-check"></i></div>
                        <span>Optimización de palabras clave (ATS)</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="fas fa-check"></i></div>
                        <span>Diseños 100% editables y PDF de alta calidad</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="fas fa-check"></i></div>
                        <span>Asesoría personalizada en cada paso</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-landing">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <p class="text-white-50">Líderes en diseño de perfiles profesionales y asesoría laboral en toda Colombia.</p>
                </div>
                <div class="col-lg-2 offset-lg-2">
                    <h5 class="fw-bold mb-4">Enlaces</h5>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2"><a href="#servicios" class="text-decoration-none text-reset">Servicios</a></li>
                        <li class="mb-2"><a href="#expertos" class="text-decoration-none text-reset">Expertos</a></li>
                        <li class="mb-2"><a href="/login" class="text-decoration-none text-reset">Ingresar</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-4">Contacto</h5>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> creamoshojasdevida@gmail.com</li>
                        <li class="mb-2"><i class="fab fa-whatsapp me-2"></i> +57 300 5038368</li>
                    </ul>
                    <div class="d-flex gap-3 mt-4">
                        <a href="https://www.instagram.com/creamos_hojas_de_vida" target="_blank" class="text-white fs-4"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.facebook.com/share/14TAas7pNfc/?mibextid=wwXIfr" target="_blank" class="text-white fs-4"><i class="fab fa-facebook"></i></a>
                        <a href="https://www.tiktok.com/@creamostuhojadevida" target="_blank" class="text-white fs-4"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-5 border-secondary opacity-25">
            <div class="text-center text-white-50 small">
                <p class="mb-1">&copy; {{ date('Y') }} Creamos tu Hoja de Vida. Todos los derechos reservados.</p>
                <p class="mb-3">Desarrollado por <a href="https://outdeveloper.com" target="_blank" class="text-white text-decoration-none fw-bold">OutDeveloper</a></p>
                @if(config('app.env') !== 'production')
                <div class="mt-2">
                    <span class="badge bg-warning text-dark">Ambiente de Desarrollo (Staging)</span>
                </div>
                @endif
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
