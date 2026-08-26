@extends('plantillas.layout-auth')

@section('Title', 'Recuperar Contraseña - ExpoTÉCNICA 2026')

@section('Content')
<main class="relative z-10 w-100 px-3" style="max-width: 1200px; margin: 0 auto;">
    <div class="d-flex flex-column align-items-center">

        <a href="/login" class="d-inline-flex align-items-center gap-1 text-decoration-none mb-3"
           style="font-size: 0.8125rem; font-weight: 500; color: #564337; transition: color 0.15s ease;"
           onmouseover="this.style.color='#944a00'" onmouseout="this.style.color='#564337'">
            <i class="bi bi-arrow-left" style="font-size: 0.875rem;"></i>
            Volver al login
        </a>

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
                Recuperar Contraseña
            </h1>
            <p style="font-size: 1rem; line-height: 1.6; color: #564337; max-width: 500px; margin: 8px auto 0;">
                Ingrese su correo electrónico y le enviaremos un enlace para restablecer su contraseña.
            </p>
        </header>

        <section class="w-100 auth-card bg-white rounded-xl overflow-hidden" style="max-width: 440px; border: 1px solid #E2E8F0;">
            <div class="p-3 p-md-4">
                <form action="{{ route('password.email') }}" method="POST" class="d-flex flex-column gap-3">
                    @csrf

                    @if(session('status'))
                        <div class="alert alert-success py-2 px-3 mb-0" style="font-size: 0.8125rem;">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger py-2 px-3 mb-0" style="font-size: 0.8125rem;">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="d-flex flex-column gap-1">
                        <label for="email" class="form-label" style="font-size: 0.6875rem; font-weight: 600; color: #564337; text-transform: uppercase; letter-spacing: 0.05em;">
                            Correo Electrónico
                        </label>
                        <div class="position-relative">
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="juez.apellido@expo.edu" required
                                   value="{{ old('email') }}"
                                   style="padding-left: 48px; height: 48px; border: 1px solid #E2E8F0; border-radius: 0.5rem; background-color: #fff; font-size: 0.9375rem; color: #191c1e;">
                            <i class="bi bi-envelope input-icon"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login text-white d-inline-flex align-items-center justify-content-center gap-2 mt-1"
                            style="height: 48px; font-weight: 600; font-size: 0.8125rem; letter-spacing: 0.05em; text-transform: uppercase; border-radius: 0.5rem; border: none;">
                        Enviar Enlace
                        <i class="bi bi-send" style="font-size: 1rem;"></i>
                    </button>
                </form>
            </div>

            <footer class="d-flex align-items-start gap-2 p-3" style="background-color: #f2f4f6; border-top: 1px solid #E2E8F0;">
                <i class="bi bi-info-circle-fill flex-shrink-0 mt-1" style="font-size: 0.875rem; color: #4e6073; background-color: #36485b; color: #fff; padding: 4px; border-radius: 4px;"></i>
                <p style="font-size: 0.75rem; line-height: 1.6; color: #526478; margin-bottom: 0;">
                    El enlace de recuperación expirará en 60 minutos. Si no recibió el correo, revise su bandeja de spam.
                </p>
            </footer>
        </section>

        <div class="d-flex align-items-center gap-2 mt-4 mb-3" style="color: rgba(86,67,55,0.5);">
            <div style="height: 1px; width: 48px; background-color: #dcc1b1;"></div>
            <span style="font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase;">Dedicación al Rigor Técnico</span>
            <div style="height: 1px; width: 48px; background-color: #dcc1b1;"></div>
        </div>

    </div>
</main>
@endsection
