@extends('plantillas.layout-auth')

@section('Title', 'Acceso Jueces - ExpoTÉCNICA 2026')

@section('Content')
<main class="relative z-10 w-100 px-3" style="max-width: 1200px; margin: 0 auto;">
    <div class="d-flex flex-column align-items-center">

        {{-- Back to Home --}}
        <a href="/" class="d-inline-flex align-items-center gap-1 text-decoration-none mb-3"
           style="font-size: 0.8125rem; font-weight: 500; color: #564337; transition: color 0.15s ease;"
           onmouseover="this.style.color='#944a00'" onmouseout="this.style.color='#564337'">
            <i class="bi bi-arrow-left" style="font-size: 0.875rem;"></i>
            Volver al inicio
        </a>

        {{-- Welcome & Branding --}}
        <header class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center p-3 bg-white rounded-xl mb-3"
                 style="box-shadow: 0px 2px 8px rgba(44,62,80,0.06); border: 1px solid #E2E8F0;">
                <img src="{{ asset('imagenes/Web-Covao-Nocturno.webp') }}" alt="COVAO Nocturno"
                     style="height: 40px; width: auto; object-fit: contain; display: block;">
                <span style="width: 1px; height: 40px; background-color: #E2E8F0; margin: 0 14px;"></span>
                <img src="{{ asset('imagenes/icono.png') }}" alt="ExpoTÉCNICA 2026"
                     style="height: 48px; width: auto; object-fit: contain; display: block;">
            </div>
            <h1 style="font-family: 'Inter', sans-serif; font-size: clamp(1.75rem, 5vw, 2rem); font-weight: 700; color: #191c1e; letter-spacing: -0.02em;">
                ExpoTÉCNICA 2026
            </h1>
            <p style="font-size: 1rem; line-height: 1.6; color: #564337; max-width: 500px; margin: 8px auto 0;">
                Portal de Evaluación de Proyectos. Inicie sesión para acceder a las rúbricas y criterios de calificación técnica.
            </p>
        </header>

        {{-- Login Card --}}
        <section class="w-100 auth-card bg-white rounded-xl overflow-hidden" style="max-width: 440px; border: 1px solid #E2E8F0;">
            <div class="p-3 p-md-4">
                <form action="/login" method="POST" class="d-flex flex-column gap-3">
                    @csrf

                    {{-- Success / Error Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success py-2 px-3 mb-0" style="font-size: 0.8125rem;">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger py-2 px-3 mb-0" style="font-size: 0.8125rem;">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    {{-- Identity Input --}}
                    <div class="d-flex flex-column gap-1">
                        <label for="judge_id" class="form-label" style="font-size: 0.6875rem; font-weight: 600; color: #564337; text-transform: uppercase; letter-spacing: 0.05em;">
                            Correo Electrónico o ID de Juez
                        </label>
                        <div class="position-relative">
                            <input type="text" class="form-control" id="email" name="email"
                                   placeholder="juez.apellido@expo.edu" required
                                   value="{{ old('email') }}"
                                   style="padding-left: 48px; height: 48px; border: 1px solid #E2E8F0; border-radius: 0.5rem; background-color: #fff; font-size: 0.9375rem; color: #191c1e;">
                            <i class="bi bi-person-badge input-icon"></i>
                        </div>
                    </div>

                    {{-- Password Input --}}
                    <div class="d-flex flex-column gap-1">
                        <label for="password" class="form-label" style="font-size: 0.6875rem; font-weight: 600; color: #564337; text-transform: uppercase; letter-spacing: 0.05em;">
                            Contraseña
                        </label>
                        <div class="position-relative">
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="••••••••••••" required
                                   style="padding-left: 48px; height: 48px; border: 1px solid #E2E8F0; border-radius: 0.5rem; background-color: #fff; font-size: 0.9375rem; color: #191c1e;">
                            <i class="bi bi-lock input-icon"></i>
                        </div>
                    </div>

                    {{-- CTA Button --}}
                    <button type="submit" class="btn btn-login text-white d-inline-flex align-items-center justify-content-center gap-2 mt-1"
                            style="height: 48px; font-weight: 600; font-size: 0.8125rem; letter-spacing: 0.05em; text-transform: uppercase; border-radius: 0.5rem; border: none;">
                        Acceder al Portal
                        <i class="bi bi-box-arrow-in-right" style="font-size: 1rem;"></i>
                    </button>

                    {{-- Secondary Links --}}
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 pt-1">
                        <a href="#" class="text-decoration-none d-inline-flex align-items-center gap-1 link-primary-custom"
                           style="font-size: 0.6875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                </form>
            </div>

            {{-- Context Footer --}}
            <footer class="d-flex align-items-start gap-2 p-3" style="background-color: #f2f4f6; border-top: 1px solid #E2E8F0;">
                <i class="bi bi-info-circle-fill flex-shrink-0 mt-1" style="font-size: 0.875rem; color: #4e6073; background-color: #36485b; color: #fff; padding: 4px; border-radius: 4px;"></i>
                <p style="font-size: 0.75rem; line-height: 1.6; color: #526478; margin-bottom: 0;">
                    Este sistema está diseñado para garantizar la precisión, transparencia y objetividad en la evaluación de la excelencia técnica académica.
                </p>
            </footer>
        </section>

        {{-- Decorative Footer --}}
        <div class="d-flex align-items-center gap-2 mt-4 mb-3" style="color: rgba(86,67,55,0.5);">
            <div style="height: 1px; width: 48px; background-color: #dcc1b1;"></div>
            <span style="font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase;">Dedicación al Rigor Técnico</span>
            <div style="height: 1px; width: 48px; background-color: #dcc1b1;"></div>
        </div>

    </div>
</main>
@endsection
