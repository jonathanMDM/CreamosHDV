@extends('layouts.app')

@section('title', 'Cambiar Contraseña - CreamosHDV')

@section('content')
<div class="fade-in">
    <div class="card-custom" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header-custom">
            <i class="fas fa-key"></i> Cambiar Contraseña
        </div>
        <div class="card-body">
            <div class="alert alert-warning mb-4">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Cambio de contraseña obligatorio</strong><br>
                Por seguridad, debes cambiar tu contraseña temporal antes de continuar.
            </div>

            <form method="POST" action="{{ route('password.update.first') }}">
                @csrf

                <div class="mb-4">
                    <label for="current_password" class="form-label">
                        <i class="fas fa-lock"></i> Contraseña Actual
                    </label>
                    <div class="input-group">
                        <input id="current_password" type="password" 
                               class="form-control form-control-custom @error('current_password') is-invalid @enderror" 
                               name="current_password" required
                               style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                        <button class="btn btn-outline-light" type="button" onclick="togglePasswordVisibility('current_password', this)" 
                                style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-color: rgba(255,255,255,0.1); background: rgba(255,255,255,0.05);">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">
                        <i class="fas fa-key"></i> Nueva Contraseña
                    </label>
                    <div class="input-group">
                        <input id="password" type="password" 
                               class="form-control form-control-custom @error('password') is-invalid @enderror" 
                               name="password" required
                               style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                        <button class="btn btn-outline-light" type="button" onclick="togglePasswordVisibility('password', this)" 
                                style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-color: rgba(255,255,255,0.1); background: rgba(255,255,255,0.05);">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <small class="text-muted">Mínimo 8 caracteres</small>
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">
                        <i class="fas fa-check-circle"></i> Confirmar Nueva Contraseña
                    </label>
                    <div class="input-group">
                        <input id="password_confirmation" type="password" 
                               class="form-control form-control-custom" 
                               name="password_confirmation" required
                               style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                        <button class="btn btn-outline-light" type="button" onclick="togglePasswordVisibility('password_confirmation', this)" 
                                style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-color: rgba(255,255,255,0.1); background: rgba(255,255,255,0.05);">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="fas fa-save"></i> Cambiar Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection
