@extends('layouts.app')

@section('title', 'Recuperar Contraseña - CreamosHDV')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="col-md-5 col-lg-4">
        <div class="text-center mb-4">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="CreamosHDV" style="max-height: 80px; filter: brightness(0) invert(1);">
            </a>
        </div>
        
        <div class="card bg-dark text-white border-secondary shadow-lg" style="border-radius: 15px; border: 1px solid rgba(255,255,255,0.1);">
            <div class="card-header border-bottom border-secondary text-center py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-lock-open me-2 text-primary"></i> Recuperar Acceso</h5>
            </div>

            <div class="card-body p-4">
                @if (session('status'))
                    <div class="alert alert-success d-flex align-items-center mb-4" role="alert" style="border-radius: 10px;">
                        <i class="fas fa-check-circle me-2 fs-4"></i>
                        <div>{{ session('status') }}</div>
                    </div>
                @endif

                <p class="text-white-50 text-center mb-4" style="font-size: 0.9rem;">
                    Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                </p>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label text-white-50 ms-1">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white-50">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input id="email" type="email" 
                                   class="form-control bg-dark text-white border-secondary @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   placeholder="ejemplo@correo.com">
                            
                            @error('email')
                                <span class="invalid-feedback d-block ms-1 mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm" style="background: linear-gradient(45deg, #2563eb, #3b82f6); border: none;">
                            <i class="fas fa-paper-plane me-2"></i> Enviar Enlace de Recuperación
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-decoration-none text-white-50 hover-text-white transition-all">
                            <i class="fas fa-arrow-left me-1"></i> Volver al Inicio de Sesión
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="text-center mt-4 text-muted small">
            &copy; {{ date('Y') }} Creamos Hojas de Vida
        </div>
    </div>
</div>

<style>
    .hover-text-white:hover {
        color: white !important;
    }
    .form-control:focus {
        background-color: #0d0d0d !important;
        color: white !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25) !important;
    }
    /* Aseguramos que el autocompletado del navegador no ponga fondo blanco */
    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus, 
    input:-webkit-autofill:active{
        -webkit-box-shadow: 0 0 0 30px #1a1d21 inset !important;
        -webkit-text-fill-color: white !important;
        transition: background-color 5000s ease-in-out 0s;
    }
</style>
@endsection
