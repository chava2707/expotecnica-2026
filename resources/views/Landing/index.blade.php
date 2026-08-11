@extends('plantillas.layout')

@section('Main')

{{-- Hero Section --}}
<section class="position-relative hero-section" style="background-color: #f7f9fb;">
    <div class="technical-grid hero-gradient position-absolute top-0 start-0 w-100 h-100"></div>
    <div class="container d-flex align-items-center position-relative" style="max-width: 1200px; padding-top: 24px; padding-bottom: 24px;">
        <div class="row align-items-center w-100">
            {{-- Texto --}}
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="mb-3">
                    <span class="badge d-inline-flex align-items-center gap-1 rounded-pill px-3 py-2"
                          style="background-color: #ffdcc5; color: #713700; font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; border: 1px solid rgba(148,74,0,0.15);">
                        <i class="bi bi-patch-check-fill" style="font-size: 0.75rem;"></i>
                        Excelencia Académica
                    </span>
                </div>
                <h1 style="font-family: 'Inter', sans-serif; font-size: clamp(1.75rem, 5vw, 3.5rem); font-weight: 700; line-height: 1.15; letter-spacing: -0.02em; color: #191c1e;">
                    Dedicación al <span style="color: #944a00;">Rigor Técnico</span>
                </h1>
                <p class="mt-3" style="font-size: clamp(0.875rem, 2.5vw, 1rem); line-height: 1.6; color: #4e6073; max-width: 480px;">
                    El portal de evaluación de la excelencia académica. Un sistema diseñado para la precisión, objetividad y transparencia en el juzgamiento de proyectos de vanguardia.
                </p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="/login" class="btn d-inline-flex align-items-center gap-2 px-3 px-sm-4"
                       style="height: 48px; background-color: #944a00; color: #fff; font-weight: 600; font-size: 0.875rem; border-radius: 0.5rem; box-shadow: 0px 4px 12px rgba(44,62,80,0.08); border: none; transition: all 0.2s;">
                        Acceso al Portal de Jueces
                        <i class="bi bi-box-arrow-in-right"></i>
                    </a>

                </div>
            </div>
            {{-- Imagen / Mockup --}}
            <div class="col-lg-6 d-none d-lg-block position-relative">
                <div class="position-absolute" style="inset: -16px; background: rgba(148,74,0,0.05); border-radius: 1.5rem; filter: blur(40px); z-index: 0;"></div>
                <div class="position-relative p-3 rounded-xl" style="background-color: #fff; border-radius: 0.75rem; box-shadow: 0px 4px 12px rgba(44,62,80,0.08); border: 1px solid #E2E8F0; z-index: 1;">
                    <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBOvLTYT-CwfR-KFpxsRHsRaLNi-oXTVLoo9FH-gtJCQ90vvcDdfFRr40j2Ytw5AMfjhTUBsK5QxfuXywks23DikMmt0o2Wp2u3roO1SaMbSc9Se-91BM-VW8vfcbXd0k3VETMSaA7_ffyrz5pkZAIT8upAmjjNJaGz8_HNgZQuvVJiYCjf4h17WmAX9bI0uPqEpONfAI4PqIce6iQezGEVbo7HNiz6d06B8Exbl7OqrlZwG-RAJWJvXSnp0Fs7D-kiVaJ7FRKhfjFK"
                         alt="Dashboard de evaluación técnica" class="img-fluid rounded" style="border-radius: 0.5rem;">
                    {{-- Badge flotante --}}
                    <div class="position-absolute d-flex align-items-center gap-3 p-2 rounded"
                         style="bottom: -24px; left: -24px; background: #fff; border-radius: 0.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.12); border: 1px solid #E2E8F0;">
                        <div class="d-flex align-items-center justify-content-center rounded-circle"
                             style="width: 48px; height: 48px; background-color: #29af61; color: #fff;">
                            <i class="bi bi-bar-chart-fill" style="font-size: 1.2rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0" style="font-size: 0.6875rem; font-weight: 600; color: #564337; text-transform: uppercase; letter-spacing: 0.05em;">Estado Global</p>
                            <p class="mb-0" style="font-size: 1.125rem; font-weight: 600; color: #191c1e;">{{ $proyectosEvaluadosPct }}% Evaluados</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Process Section: Tres Pilares de Rigor --}}
<section class="py-5" style="background-color: #fff;" id="proceso">
    <div class="container" style="max-width: 1200px;">
        <div class="text-center mb-5">
            <p style="font-size: 0.6875rem; font-weight: 600; color: #944a00; text-transform: uppercase; letter-spacing: 0.1em;">Metodología de Evaluación</p>
            <h2 style="font-family: 'Inter', sans-serif; font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 700; color: #191c1e;">Tres Pilares de Rigor</h2>
        </div>
        <div class="row g-4">
            {{-- Precisión --}}
            <div class="col-md-4">
                <div class="p-4 h-100 rounded-xl border-0 card-hover"
                     style="border: 1px solid #E2E8F0; border-radius: 0.75rem; transition: all 0.25s ease;">
                    <div class="d-flex align-items-center justify-content-center rounded mb-3"
                         style="width: 56px; height: 56px; background-color: #eceef0; border-radius: 0.5rem;">
                        <i class="bi bi-bullseye" style="font-size: 1.5rem; color: #944a00;"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #191c1e; margin-bottom: 0.5rem;">Precisión</h3>
                    <p style="font-size: 0.9375rem; line-height: 1.6; color: #564337; margin-bottom: 0;">
                        Métricas cuantitativas diseñadas para capturar cada detalle técnico del proyecto, eliminando ambigüedades en la calificación final.
                    </p>
                </div>
            </div>
            {{-- Transparencia --}}
            <div class="col-md-4">
                <div class="p-4 h-100 rounded-xl border-0 card-hover"
                     style="border: 1px solid #E2E8F0; border-radius: 0.75rem; transition: all 0.25s ease;">
                    <div class="d-flex align-items-center justify-content-center rounded mb-3"
                         style="width: 56px; height: 56px; background-color: #eceef0; border-radius: 0.5rem;">
                        <i class="bi bi-eye" style="font-size: 1.5rem; color: #944a00;"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #191c1e; margin-bottom: 0.5rem;">Transparencia</h3>
                    <p style="font-size: 0.9375rem; line-height: 1.6; color: #564337; margin-bottom: 0;">
                        Trazabilidad total de cada evaluación. Los criterios y comentarios son accesibles para garantizar un proceso justo y auditable.
                    </p>
                </div>
            </div>
            {{-- Objetividad --}}
            <div class="col-md-4">
                <div class="p-4 h-100 rounded-xl border-0 card-hover"
                     style="border: 1px solid #E2E8F0; border-radius: 0.75rem; transition: all 0.25s ease;">
                    <div class="d-flex align-items-center justify-content-center rounded mb-3"
                         style="width: 56px; height: 56px; background-color: #eceef0; border-radius: 0.5rem;">
                        <i class="bi bi-balance-scale" style="font-size: 1.5rem; color: #944a00;"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #191c1e; margin-bottom: 0.5rem;">Objetividad</h3>
                    <p style="font-size: 0.9375rem; line-height: 1.6; color: #564337; margin-bottom: 0;">
                        Eliminación de sesgos mediante rúbricas estandarizadas y paneles de jueces expertos con criterios alineados globalmente.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Categories Section --}}
<section class="py-5" style="background-color: #f7f9fb;" id="categorias">
    <div class="container" style="max-width: 1200px;">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
            <div style="max-width: 560px;">
                <p style="font-size: 0.6875rem; font-weight: 600; color: #944a00; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 8px;">Explorar</p>
                <h2 style="font-family: 'Inter', sans-serif; font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 700; color: #191c1e; margin-bottom: 8px;">Categorías a Evaluar</h2>
                <p style="font-size: 0.9375rem; color: #564337; margin-bottom: 0;">Categorías disponibles para la calificación de proyectos en la plataforma.</p>
            </div>
        </div>

        <div class="row g-4">
            @forelse($categorias as $index => $categoria)
                <div class="col-md-4 project-card-col" style="animation-delay: {{ $index * 0.12 }}s;">
                    <div class="project-card position-relative h-100">
                        <div class="project-card__body">
                            <div class="d-flex align-items-center justify-content-center rounded mb-3"
                                 style="width: 56px; height: 56px; background-color: #eceef0; border-radius: 0.5rem;">
                                <i class="bi bi-folder2-open" style="font-size: 1.5rem; color: #944a00;"></i>
                            </div>
                            <h3 class="project-card__title">{{ $categoria->Nombre }}</h3>
                            <p class="project-card__desc">{{ $categoria->Descripcion ?? 'Sin descripción disponible.' }}</p>
                            <div class="project-card__footer">
                                <div class="project-card__footer-item">
                                    <i class="bi bi-folder2" style="font-size: 0.75rem;"></i>
                                    <span>{{ $categoria->proyectos_count }} {{ Str::plural('proyecto', $categoria->proyectos_count) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="project-card__empty-icon">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <p class="mt-3 mb-0" style="font-size: 0.9375rem; font-weight: 500; color: #191c1e;">Aún no hay categorías registradas</p>
                    <p style="font-size: 0.8125rem; color: #564337;">Las categorías aparecerán aquí una vez sean creadas.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-4 py-md-5 position-relative overflow-hidden">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: #2d3133;"></div>
    <div class="container position-relative" style="max-width: 1200px; z-index: 1;">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 gap-md-4 p-3 p-md-4 rounded-xl"
             style="background: rgba(148,74,0,0.1); border: 1px solid rgba(148,74,0,0.3); backdrop-filter: blur(8px); border-radius: 1rem;">
            <div class="text-center text-md-start" style="color: #fff;">
                <h2 style="font-family: 'Inter', sans-serif; font-size: clamp(1.25rem, 4vw, 2rem); font-weight: 700; color: #fff; margin-bottom: 0.5rem;">¿Eres Miembro del Jurado?</h2>
                <p style="font-size: clamp(0.8125rem, 2.5vw, 1rem); line-height: 1.6; color: #b5c8df; max-width: 520px; margin-bottom: 0;">
                    Inicia sesión con tus credenciales institucionales para acceder a los formularios de evaluación y rúbricas asignadas.
                </p>
            </div>
            <a href="/login" class="btn d-inline-flex align-items-center gap-2 px-3 px-sm-4 text-nowrap"
               style="height: 48px; background-color: #fff; color: #944a00; font-weight: 600; font-size: 0.875rem; border-radius: 0.5rem; box-shadow: 0px 4px 12px rgba(44,62,80,0.08); border: none; transition: all 0.2s; white-space: nowrap;">
                Ingresar al Portal
                <i class="bi bi-rocket-takeoff"></i>
            </a>
        </div>
    </div>
</section>

<style>
    .technical-grid {
        background-image: linear-gradient(to right, rgba(148,74,0,0.05) 1px, transparent 1px),
                          linear-gradient(to bottom, rgba(148,74,0,0.05) 1px, transparent 1px);
        background-size: 40px 40px;
    }
    .hero-gradient {
        background: radial-gradient(circle at top right, rgba(230,126,34,0.08), transparent 50%);
    }
    .rounded-xl {
        border-radius: 0.75rem;
    }
    .card-hover:hover {
        border-color: #944a00 !important;
    }

    /* ========== PROJECT CARDS ========== */
    .project-card-col {
        animation: cardFadeUp 0.6s ease both;
    }
    @keyframes cardFadeUp {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .project-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 0.75rem;
        overflow: hidden;
        transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0px 2px 8px rgba(44, 62, 80, 0.04);
        cursor: default;
    }
    .project-card:hover {
        border-color: rgba(148, 74, 0, 0.35);
        box-shadow: 0px 8px 32px rgba(148, 74, 0, 0.12), 0px 2px 8px rgba(44, 62, 80, 0.06);
        transform: translateY(-6px);
    }

    /* Image area */
    .project-card__image-wrap {
        position: relative;
        height: 220px;
        overflow: hidden;
    }
    .project-card__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .project-card:hover .project-card__img {
        transform: scale(1.08);
    }
    .project-card__placeholder {
        background: linear-gradient(135deg, #eceef0 0%, #e0e3e5 100%);
    }

    /* Gradient scrim */
    .project-card__gradient {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.08) 40%, transparent 70%);
        pointer-events: none;
        transition: opacity 0.35s ease;
    }
    .project-card:hover .project-card__gradient {
        opacity: 0.6;
    }

    /* Category badge */
    .project-card__badge {
        position: absolute;
        top: 14px;
        left: 14px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 9999px;
        font-family: 'Inter', sans-serif;
        font-size: 0.625rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #fff;
        z-index: 2;
        transition: all 0.3s ease;
    }
    .project-card:hover .project-card__badge {
        background: rgba(148, 74, 0, 0.85);
        border-color: rgba(148, 74, 0, 0.9);
    }

    /* Hover overlay */
    .project-card__overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(148, 74, 0, 0.7);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        opacity: 0;
        z-index: 3;
        transition: opacity 0.35s ease;
        text-decoration: none;
        color: inherit;
    }
    .project-card:hover .project-card__overlay {
        opacity: 1;
    }
    .project-card__overlay-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        transform: translateY(12px);
        transition: transform 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .project-card:hover .project-card__overlay-content {
        transform: translateY(0);
    }
    .project-card__overlay-icon {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border-radius: 50%;
        color: #944a00;
        font-size: 1.25rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }
    .project-card:hover .project-card__overlay-icon {
        transform: scale(1.1);
    }
    .project-card__overlay-text {
        font-family: 'Inter', sans-serif;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #fff;
        letter-spacing: 0.02em;
    }

    /* Body */
    .project-card__body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .project-card__title {
        font-family: 'Inter', sans-serif;
        font-size: 1.0625rem;
        font-weight: 700;
        color: #191c1e;
        margin: 0;
        line-height: 1.3;
        transition: color 0.25s ease;
    }
    .project-card:hover .project-card__title {
        color: #944a00;
    }
    .project-card__desc {
        font-size: 0.8125rem;
        color: #564337;
        margin: 0;
        line-height: 1.55;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Footer bar */
    .project-card__footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 10px;
        padding-top: 12px;
        border-top: 1px solid #f0f2f4;
    }
    .project-card__footer-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: 'Inter', sans-serif;
        font-size: 0.6875rem;
        font-weight: 600;
        color: #897365;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .project-card__footer-arrow {
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f7f9fb;
        color: #944a00;
        font-size: 0.75rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .project-card:hover .project-card__footer-arrow {
        background: #944a00;
        color: #fff;
        transform: translateX(3px);
    }

    /* Empty state */
    .project-card__empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f7f9fb;
        border: 2px dashed #E2E8F0;
        border-radius: 50%;
        color: #944a00;
        font-size: 2rem;
        opacity: 0.5;
    }

    /* Responsive */
    @media (min-width: 768px) {
        .project-card__image-wrap {
            height: 240px;
        }
    }
    @media (min-width: 992px) {
        .hero-section {
            min-height: 700px;
        }
        .hero-section .container {
            min-height: 700px;
            padding-top: 40px;
            padding-bottom: 40px;
        }
    }
    * {
        box-sizing: border-box;
    }
</style>

@endsection
