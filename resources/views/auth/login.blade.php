<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CreamosHDV</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    
    <!-- Google reCAPTCHA v3 -->
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
</head>
<body>
    <div class="login-container">
        <div class="login-card fade-in">
            <div class="login-header">
                <img src="{{ asset('images/logo.png') }}" alt="CreamosHDV Logo" class="img-fluid mb-2" style="max-height: 80px;">
            </div>
            <div class="login-body">
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf
                    
                    <!-- Campo oculto para el token de reCAPTCHA -->
                    <input type="hidden" name="recaptcha_token" id="recaptchaToken">

                    <div class="mb-4">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Correo Electrónico
                        </label>
                        <input id="email" type="email" 
                               class="form-control form-control-custom @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i> Contraseña
                        </label>
                        <div style="position: relative;">
                            <input id="password" type="password" 
                                   class="form-control form-control-custom @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password"
                                   style="padding-right: 3rem;">
                            <button type="button" id="togglePassword" 
                                    style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; padding: 0.5rem; transition: color 0.3s;">
                                <i class="fas fa-eye" style="font-size: 1.1rem;"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary-custom" id="submitBtn">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </button>
                    </div>
                </form>

                @if (Route::has('password.request'))
                    <div class="text-center mt-3">
                        <a class="text-muted text-decoration-none small" href="{{ route('password.request') }}" style="font-size: 0.9rem;">
                            <i class="fas fa-key me-1"></i> ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                @endif


            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            if (togglePassword) {
                // Hover effect
                togglePassword.addEventListener('mouseenter', function() {
                    this.style.color = '#3b82f6';
                });
                
                togglePassword.addEventListener('mouseleave', function() {
                    this.style.color = '#94a3b8';
                });
                
                // Toggle functionality
                togglePassword.addEventListener('click', function() {
                    const password = document.getElementById('password');
                    const icon = this.querySelector('i');
                    if (password.type === 'password') {
                        password.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        password.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            }

            // reCAPTCHA v3 form submission
            const loginForm = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');

            if (loginForm && submitBtn) {
                loginForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Disable button and show loading state
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Iniciando...';
                    
                    if (typeof grecaptcha !== 'undefined') {
                        grecaptcha.ready(function() {
                            try {
                                grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'login'}).then(function(token) {
                                    const recaptchaInput = document.getElementById('recaptchaToken');
                                    if (recaptchaInput) {
                                        recaptchaInput.value = token;
                                    }
                                    loginForm.submit();
                                }).catch(function(error) {
                                    console.error('reCAPTCHA error:', error);
                                    // Fallback if recaptcha fails to execute
                                    loginForm.submit();
                                });
                            } catch (err) {
                                console.error('reCAPTCHA execution error:', err);
                                loginForm.submit();
                            }
                        });
                    } else {
                        // If grecaptcha script is not loaded, just submit
                        console.warn('reCAPTCHA not loaded');
                        loginForm.submit();
                    }
                });
            }
        });
    </script>
</body>
</html>
