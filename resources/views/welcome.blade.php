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
    <nav class="navbar navbar-expand-lg landing-navbar">
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
            <div class="row align-items-center">
                <div class="col-lg-10 col-xl-8 py-5">
                    <div class="hero-badge">Expertos en Selección de Personal</div>
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
                    <!-- Service 1: Foto -->
                    <div class="col-md-4">
                        <div class="service-card-light h-100 p-4 rounded-4" style="background: #f8f9fa;">
                            <div class="service-icon mb-3 text-dark fs-2"><i class="fas fa-camera"></i></div>
                            <h3 class="text-dark fw-bold h4">Foto Profesional</h3>
                            <p class="text-muted">Retoque digital y optimización para hojas de vida y plataformas como LinkedIn.</p>
                            <div class="service-price text-dark fw-bold fs-4">$15.500</div>
                        </div>
                    </div>
                    <!-- Service 2: Sencilla -->
                    <div class="col-md-4">
                        <div class="service-card-light h-100 p-4 rounded-4" style="background: #f8f9fa;">
                            <div class="service-icon mb-3 text-dark fs-2"><i class="fas fa-file-lines"></i></div>
                            <h3 class="text-dark fw-bold h4">Hoja Diseño Básico</h3>
                            <p class="text-muted">Hoja de vida sencilla y limpia, ideal para perfiles operativos y administrativos.</p>
                            <div class="service-price text-dark fw-bold fs-4">$7.500</div>
                        </div>
                    </div>
                    <!-- Service 3: Profesional -->
                    <div class="col-md-4">
                        <div class="service-card-light h-100 p-4 rounded-4" style="background: #f8f9fa;">
                            <div class="service-icon mb-3 text-dark fs-2"><i class="fas fa-crown"></i></div>
                            <h3 class="text-dark fw-bold h4">Hoja Diseño Premium</h3>
                            <p class="text-muted">Impacto visual garantizado con diseños modernos y estructurados para resaltar.</p>
                            <div class="service-price text-dark fw-bold fs-4">$15.000</div>
                        </div>
                    </div>
                    <!-- Service 4: Traducción -->
                    <div class="col-md-4">
                        <div class="service-card-light h-100 p-4 rounded-4" style="background: #f8f9fa;">
                            <div class="service-icon mb-3 text-dark fs-2"><i class="fas fa-language"></i></div>
                            <h3 class="text-dark fw-bold h4">Traducción</h3>
                            <p class="text-muted">Traducción profesional (Inglés-Español) adaptada a términos laborales técnicos.</p>
                            <div class="service-price text-dark fw-bold fs-4">$25.000</div>
                        </div>
                    </div>
                    <!-- Service 5: Carta -->
                    <div class="col-md-4">
                        <div class="service-card-light h-100 p-4 rounded-4" style="background: #f8f9fa;">
                            <div class="service-icon mb-3 text-dark fs-2"><i class="fas fa-envelope-open-text"></i></div>
                            <h3 class="text-dark fw-bold h4">Carta de Presentación</h3>
                            <p class="text-muted">El complemento perfecto para explicar por qué eres el candidato ideal.</p>
                            <div class="service-price text-dark fw-bold fs-4">$6.000</div>
                        </div>
                    </div>
                    <!-- Service 6: Pack -->
                    <div class="col-md-4">
                        <div class="service-card-light h-100 p-4 rounded-4 bg-dark text-white">
                            <div class="service-icon mb-3 text-white fs-2"><i class="fas fa-box"></i></div>
                            <h3 class="text-white fw-bold h4">Paquete Completo</h3>
                            <p class="text-white-50">Todo lo anterior por un precio especial. La solución definitiva para tu perfil.</p>
                            <div class="service-price text-white fw-bold fs-4">$20.000</div>
                        </div>
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
