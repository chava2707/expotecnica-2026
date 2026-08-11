@extends('plantillas.layout-judge')
@section('Title', 'Configuración - ExpoTÉCNICA 2026')
@section('JudgeSidebarActive4', 'active')

@section('Main')
<div style="max-width: 1200px; margin: 0 auto; padding-bottom: 80px;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3 border-bottom pb-4" style="border-color: #E2E8F0 !important;">
        <div>
            <h1 style="font-family: 'Inter', sans-serif; font-size: clamp(1.5rem, 4vw, 2rem); font-weight: 700; color: #191c1e; margin-bottom: 4px;">Configuración</h1>
            <p style="font-size: 0.9375rem; color: #564337; margin-bottom: 0;">Administra tu perfil y preferencias de visualización.</p>
        </div>
    </div>

    {{-- Font Size Section --}}
    <div class="config-card mb-4">
        <div class="config-card__header">
            <div class="config-card__icon">
                <i class="bi bi-fonts"></i>
            </div>
            <div>
                <h3 class="config-card__title">Tamaño de Fuente</h3>
                <p class="config-card__desc">Ajusta el tamaño del texto para mayor comodidad al leer.</p>
            </div>
        </div>
        <div class="config-card__body">
            <div class="font-size-options">
                <button class="font-size-btn" data-size="normal" onclick="setFontSize('normal')">
                    <span class="font-size-btn__label">Normal</span>
                    <span class="font-size-btn__preview">Aa</span>
                </button>
                <button class="font-size-btn" data-size="large" onclick="setFontSize('large')">
                    <span class="font-size-btn__label">Grande</span>
                    <span class="font-size-btn__preview" style="font-size: 1.1rem;">Aa</span>
                </button>
                <button class="font-size-btn" data-size="xlarge" onclick="setFontSize('xlarge')">
                    <span class="font-size-btn__label">Extra Grande</span>
                    <span class="font-size-btn__preview" style="font-size: 1.3rem;">Aa</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Dark Mode Section --}}
    <div class="config-card mb-4">
        <div class="config-card__header">
            <div class="config-card__icon">
                <i class="bi bi-moon-stars-fill"></i>
            </div>
            <div>
                <h3 class="config-card__title">Modo Oscuro</h3>
                <p class="config-card__desc">Reduce la fatiga visual en ambientes con poca luz.</p>
            </div>
        </div>
        <div class="config-card__body">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="dark-mode-preview" id="darkModePreview">
                        <i class="bi bi-sun-fill" id="darkModeIcon"></i>
                    </div>
                    <div>
                        <p class="mb-0" style="font-size: 0.875rem; font-weight: 600; color: #191c1e;" id="darkModeLabel">Modo Claro</p>
                        <p class="mb-0" style="font-size: 0.75rem; color: #897365;" id="darkModeDesc">Tema actual: Claro</p>
                    </div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="darkModeToggle" onchange="toggleDarkMode()">
                    <span class="toggle-switch__slider"></span>
                </label>
            </div>
        </div>
    </div>

    {{-- Profile Section Placeholder --}}
    <div class="config-card mb-4">
        <div class="config-card__header">
            <div class="config-card__icon">
                <i class="bi bi-person-fill"></i>
            </div>
            <div>
                <h3 class="config-card__title">Perfil de Usuario</h3>
                <p class="config-card__desc">Gestiona tu información personal.</p>
            </div>
        </div>
        <div class="config-card__body text-center py-4">
            <i class="bi bi-gear" style="font-size: 2rem; color: #d8dadc; display: block; margin-bottom: 8px;"></i>
            <p style="font-size: 0.875rem; color: #897365; margin-bottom: 0;">Próximamente podrás editar tu perfil desde aquí.</p>
        </div>
    </div>

    {{-- Change Password Section --}}
    <div class="config-card">
        <div class="config-card__header">
            <div class="config-card__icon">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <div>
                <h3 class="config-card__title">Cambiar Contraseña</h3>
                <p class="config-card__desc">Actualiza tu contraseña de acceso al portal.</p>
            </div>
        </div>
        <div class="config-card__body">
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-3" style="background-color: rgba(41,175,97,0.1); border: 1px solid rgba(41,175,97,0.3); color: #1a7a3a; border-radius: 0.5rem; padding: 12px 16px; font-size: 0.875rem;">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('juez.configuracion.password') }}" method="POST" id="passwordForm">
                @csrf
                <div class="mb-3">
                    <label for="current_password" class="form-label" style="font-size: 0.8125rem; font-weight: 600; color: #564337; margin-bottom: 6px;">Contraseña Actual</label>
                    <div class="position-relative">
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required autocomplete="current-password" style="height: 44px; border-radius: 0.5rem; font-size: 0.875rem;">
                        <button type="button" class="btn position-absolute top-50 end-0 translate-middle-y me-2 p-0 border-0" onclick="togglePasswordVisibility('current_password', this)" style="color: #897365;">
                            <i class="bi bi-eye"></i>
                        </button>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label" style="font-size: 0.8125rem; font-weight: 600; color: #564337; margin-bottom: 6px;">Nueva Contraseña</label>
                    <div class="position-relative">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password" style="height: 44px; border-radius: 0.5rem; font-size: 0.875rem;">
                        <button type="button" class="btn position-absolute top-50 end-0 translate-middle-y me-2 p-0 border-0" onclick="togglePasswordVisibility('password', this)" style="color: #897365;">
                            <i class="bi bi-eye"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <p class="mt-1 mb-0" style="font-size: 0.75rem; color: #897365;">Mínimo 8 caracteres.</p>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label" style="font-size: 0.8125rem; font-weight: 600; color: #564337; margin-bottom: 6px;">Confirmar Nueva Contraseña</label>
                    <div class="position-relative">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" style="height: 44px; border-radius: 0.5rem; font-size: 0.875rem;">
                        <button type="button" class="btn position-absolute top-50 end-0 translate-middle-y me-2 p-0 border-0" onclick="togglePasswordVisibility('password_confirmation', this)" style="color: #897365;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-save-password" style="width: 100%;">
                    <i class="bi bi-shield-check"></i>
                    Actualizar Contraseña
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .config-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 0.75rem;
        overflow: hidden;
        transition: all 0.25s ease;
    }
    .config-card:hover {
        border-color: rgba(148, 74, 0, 0.25);
        box-shadow: 0 4px 16px rgba(148, 74, 0, 0.08);
    }
    .config-card__header {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px 24px;
        border-bottom: 1px solid #f0f2f4;
    }
    .config-card__icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f7f9fb;
        border-radius: 0.5rem;
        color: #944a00;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    .config-card__title {
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: #191c1e;
        margin: 0 0 2px 0;
    }
    .config-card__desc {
        font-size: 0.8125rem;
        color: #897365;
        margin: 0;
    }
    .config-card__body {
        padding: 20px 24px;
    }

    /* Font Size Buttons */
    .font-size-options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }
    .font-size-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 16px 12px;
        background: #f7f9fb;
        border: 2px solid #E2E8F0;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .font-size-btn:hover {
        border-color: #944a00;
        background: #fff;
    }
    .font-size-btn.active {
        border-color: #944a00;
        background: rgba(148, 74, 0, 0.08);
    }
    .font-size-btn__label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #564337;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .font-size-btn.active .font-size-btn__label {
        color: #944a00;
    }
    .font-size-btn__preview {
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        color: #191c1e;
    }
    .font-size-btn.active .font-size-btn__preview {
        color: #944a00;
    }

    /* Dark Mode Preview */
    .dark-mode-preview {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f7f9fb;
        border-radius: 0.5rem;
        color: #944a00;
        font-size: 1.25rem;
        transition: all 0.3s ease;
    }
    body.dark-mode .dark-mode-preview {
        background: #2d3133;
        color: #ffdcc5;
    }

    /* Toggle Switch */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 28px;
        flex-shrink: 0;
    }
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .toggle-switch__slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #d8dadc;
        border-radius: 28px;
        transition: 0.3s;
    }
    .toggle-switch__slider::before {
        content: "";
        position: absolute;
        height: 22px;
        width: 22px;
        left: 3px;
        bottom: 3px;
        background-color: #fff;
        border-radius: 50%;
        transition: 0.3s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.15);
    }
    .toggle-switch input:checked + .toggle-switch__slider {
        background-color: #944a00;
    }
    .toggle-switch input:checked + .toggle-switch__slider::before {
        transform: translateX(24px);
    }

    /* Dark Mode Overrides */
    body.dark-mode {
        background-color: #1a1d1f !important;
    }
    body.dark-mode .config-card {
        background: #2d3133;
        border-color: #3d4143;
    }
    body.dark-mode .config-card:hover {
        border-color: rgba(148, 74, 0, 0.4);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
    }
    body.dark-mode .config-card__header {
        border-color: #3d4143;
    }
    body.dark-mode .config-card__icon {
        background: #1a1d1f;
    }
    body.dark-mode .config-card__title {
        color: #e8eaec;
    }
    body.dark-mode .config-card__desc {
        color: #9aa0a6;
    }
    body.dark-mode .font-size-btn {
        background: #1a1d1f;
        border-color: #3d4143;
    }
    body.dark-mode .font-size-btn:hover {
        background: #2d3133;
    }
    body.dark-mode .font-size-btn.active {
        background: rgba(148, 74, 0, 0.15);
        border-color: #944a00;
    }
    body.dark-mode .font-size-btn__label {
        color: #9aa0a6;
    }
    body.dark-mode .font-size-btn.active .font-size-btn__label {
        color: #ffb783;
    }
    body.dark-mode .font-size-btn__preview {
        color: #e8eaec;
    }
    body.dark-mode .font-size-btn.active .font-size-btn__preview {
        color: #ffb783;
    }
    body.dark-mode .config-card__body p[style*="color: #191c1e"],
    body.dark-mode .config-card__body p[style*="color:#191c1e"] {
        color: #e8eaec !important;
    }
    body.dark-mode h1[style*="color: #191c1e"],
    body.dark-mode h1[style*="color:#191c1e"] {
        color: #e8eaec !important;
    }

    /* Font Size Classes */
    body.font-large {
        font-size: 18px;
    }
    body.font-large .sidebar-nav-link,
    body.font-large .nav-item {
        font-size: 0.9rem !important;
    }
    body.font-large .config-card__title {
        font-size: 1.1rem;
    }
    body.font-large .config-card__desc {
        font-size: 0.9rem;
    }
    body.font-large .config-card__body {
        font-size: 1rem;
    }

    body.font-xlarge {
        font-size: 20px;
    }
    body.font-xlarge .sidebar-nav-link,
    body.font-xlarge .nav-item {
        font-size: 1rem !important;
    }
    body.font-xlarge .config-card__title {
        font-size: 1.25rem;
    }
    body.font-xlarge .config-card__desc {
        font-size: 1rem;
    }
    body.font-xlarge .config-card__body {
        font-size: 1.1rem;
    }
    body.font-xlarge .font-size-btn__preview {
        font-size: 1.5rem !important;
    }

    @media (max-width: 575.98px) {
        .font-size-options {
            grid-template-columns: 1fr;
        }
        .font-size-btn {
            flex-direction: row;
            justify-content: center;
            gap: 12px;
            padding: 14px 16px;
        }
    }

    /* Password form */
    .btn-save-password {
        width: 100%;
        background-color: #944a00;
        color: #fff;
        border: none;
        height: 48px;
        font-weight: 700;
        font-size: 0.8125rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .btn-save-password:hover {
        background-color: #7a3c00;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(148, 74, 0, 0.3);
    }

    /* Alert success */
    .alert-success {
        position: relative;
    }
    .alert-success::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background-color: #29af61;
        border-radius: 4px 0 0 4px;
    }

    /* Dark mode for password form */
    body.dark-mode .config-card .form-control {
        background-color: #1a1d1f;
        border-color: #3d4143;
        color: #e8eaec;
    }
    body.dark-mode .config-card .form-control:focus {
        border-color: #944a00;
        box-shadow: 0 0 0 0.2rem rgba(148, 74, 0, 0.25);
        background-color: #2d3133;
        color: #e8eaec;
    }
    body.dark-mode .config-card .form-label {
        color: #b5b8bb !important;
    }
    body.dark-mode .config-card .form-text,
    body.dark-mode .config-card .mt-1 {
        color: #7a7e82 !important;
    }
    body.dark-mode .btn-save-password {
        background-color: #e67e22;
    }
    body.dark-mode .btn-save-password:hover {
        background-color: #ffb783;
        color: #1a1d1f;
    }
    body.dark-mode .alert-success {
        background-color: rgba(41,175,97,0.15) !important;
        border-color: rgba(41,175,97,0.4) !important;
        color: #6dd49e !important;
    }
</style>
@endsection

@section('Styles')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Load saved font size
        const savedFontSize = localStorage.getItem('fontSize') || 'normal';
        setFontSize(savedFontSize, false);

        // Load saved dark mode
        const savedDarkMode = localStorage.getItem('darkMode') === 'true';
        const toggle = document.getElementById('darkModeToggle');
        if (savedDarkMode) {
            toggle.checked = true;
            applyDarkMode(true);
        }
    });

    function setFontSize(size, save = true) {
        document.body.classList.remove('font-large', 'font-xlarge');

        if (size === 'large') {
            document.body.classList.add('font-large');
        } else if (size === 'xlarge') {
            document.body.classList.add('font-xlarge');
        }

        // Update active button
        document.querySelectorAll('.font-size-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.size === size) {
                btn.classList.add('active');
            }
        });

        if (save) {
            localStorage.setItem('fontSize', size);
        }
    }

    function toggleDarkMode() {
        const isDark = document.getElementById('darkModeToggle').checked;
        applyDarkMode(isDark);
        localStorage.setItem('darkMode', isDark);
    }

    function applyDarkMode(isDark) {
        const icon = document.getElementById('darkModeIcon');
        const label = document.getElementById('darkModeLabel');
        const desc = document.getElementById('darkModeDesc');

        if (isDark) {
            document.body.classList.add('dark-mode');
            icon.className = 'bi bi-moon-stars-fill';
            label.textContent = 'Modo Oscuro';
            desc.textContent = 'Tema actual: Oscuro';
        } else {
            document.body.classList.remove('dark-mode');
            icon.className = 'bi bi-sun-fill';
            label.textContent = 'Modo Claro';
            desc.textContent = 'Tema actual: Claro';
        }
    }

    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>
@endsection
