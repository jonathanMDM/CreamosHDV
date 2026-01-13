<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creamos tu Hoja de Vida - Diseño Profesional y Moderno</title>

    <!-- Google Fonts: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

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
            color: rgba(255, 255, 255, 0.7) !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .nav-link-landing:hover {
            color: #ffffff !important;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg landing-navbar pt-4">
        <div class="container px-4 px-lg-0">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" height="40" class="me-2" style="filter: brightness(0) invert(1);">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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
            <div class="row min-vh-100 align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0 py-5">
                    <h1 class="hero-title pt-5 pt-lg-0">Diseñamos tu<br>Futuro Profesional</h1>
                    <p class="hero-subtitle">Consigue el empleo que mereces con una hoja de vida de alto impacto. Creamos perfiles ganadores que destacan en cualquier proceso de selección.</p>
                    <div class="d-flex gap-3">
                        <a href="#servicios" class="btn-premium">Ver Planes</a>
                        <a href="https://wa.me/573136214224" target="_blank" class="btn btn-outline-light px-4 py-2 border-radius-12" style="border-radius: 12px; font-weight: 600;">Asesoría Gratis</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image-container fade-in shadow-lg">
                        <img src="{{ asset('images/hero.png') }}" alt="Expert Resume Design" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Info Block "Let's grow together" -->
    <section class="container my-5">
        <div class="info-block d-flex flex-column flex-lg-row align-items-center gap-5">
            <div class="col-lg-7">
                <h2>Impulsemos tu carrera juntos</h2>
                <p class="fs-5 text-muted mb-4">No solo hacemos hojas de vida, construimos tu marca personal para que las empresas te busquen a ti. Nuestro enfoque combina diseño premium y estrategia de selección.</p>
                <div class="row g-4 mt-2">
                    <div class="col-6 col-md-4">
                        <h4 class="fw-bold mb-1">+1000</h4>
                        <p class="text-muted small">Hojas de vida creadas</p>
                    </div>
                    <div class="col-6 col-md-4">
                        <h4 class="fw-bold mb-1">98%</h4>
                        <p class="text-muted small">Tasa de éxito</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 text-center">
                <a href="#servicios" class="btn btn-dark btn-lg px-5 py-3 rounded-pill fw-bold">Empieza Ahora</a>
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section id="servicios" class="py-5">
        <div class="container py-5">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div>
                    <span class="text-white-50 text-uppercase fw-bold ls-2 d-block mb-2">Servicios Premium</span>
                    <h2 class="display-4 fw-bold">Nuestras Soluciones</h2>
                </div>
            </div>
            
            <div class="row g-4">
                <!-- Service 1: Foto -->
                <div class="col-md-4">
                    <div class="service-card-landing">
                        <div class="service-icon"><i class="fas fa-camera"></i></div>
                        <h3>Foto Profesional</h3>
                        <p class="text-white-50">Retoque digital y optimización para hojas de vida y plataformas como LinkedIn.</p>
                        <div class="service-price">$15.500</div>
                    </div>
                </div>
                <!-- Service 2: Sencilla -->
                <div class="col-md-4">
                    <div class="service-card-landing">
                        <div class="service-icon"><i class="fas fa-file-lines"></i></div>
                        <h3>Diseño Básico</h3>
                        <p class="text-white-50">Hoja de vida sencilla y limpia, ideal para perfiles operativos y administrativos.</p>
                        <div class="service-price">$7.500</div>
                    </div>
                </div>
                <!-- Service 3: Profesional -->
                <div class="col-md-4">
                    <div class="service-card-landing">
                        <div class="service-icon"><i class="fas fa-crown"></i></div>
                        <h3>Diseño Premium</h3>
                        <p class="text-white-50">Impacto visual garantizado con diseños modernos y estructurados para resaltar.</p>
                        <div class="service-price">$15.000</div>
                    </div>
                </div>
                <!-- Service 4: Traducción -->
                <div class="col-md-4">
                    <div class="service-card-landing">
                        <div class="service-icon"><i class="fas fa-language"></i></div>
                        <h3>Traducción</h3>
                        <p class="text-white-50">Traducción profesional (Inglés-Español) adaptada a términos laborales técnicos.</p>
                        <div class="service-price">$25.000</div>
                    </div>
                </div>
                <!-- Service 5: Carta -->
                <div class="col-md-4">
                    <div class="service-card-landing">
                        <div class="service-icon"><i class="fas fa-envelope-open-text"></i></div>
                        <h3>Carta de Presentación</h3>
                        <p class="text-white-50">El complemento perfecto para explicar por qué eres el candidato ideal.</p>
                        <div class="service-price">$6.000</div>
                    </div>
                </div>
                <!-- Service 6: Pack -->
                <div class="col-md-4">
                    <div class="service-card-landing" style="border: 1px solid rgba(255, 255, 255, 0.3); background: linear-gradient(135deg, #0d0d0d 0%, #1a1a1a 100%);">
                        <div class="service-icon bg-white text-dark"><i class="fas fa-box"></i></div>
                        <h3>Paquete Completo</h3>
                        <p class="text-white-50">Todo lo anterior por un precio especial. La solución definitiva para tu perfil.</p>
                        <div class="service-price">$20.000</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Experts Section -->
    <section id="expertos" class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <img src="{{ asset('images/team.png') }}" alt="Nuestros Expertos" class="img-fluid rounded-4 shadow-lg">
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
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" height="40" class="mb-4" style="filter: brightness(0) invert(1);">
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
                        <li class="mb-2"><i class="fab fa-whatsapp me-2"></i> +57 313 621 4224</li>
                    </ul>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="text-white fs-4"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white fs-4"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white fs-4"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-5 border-secondary opacity-25">
            <div class="text-center text-white-50 small">
                &copy; {{ date('Y') }} Creamos tu Hoja de Vida. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
