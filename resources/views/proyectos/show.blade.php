@extends('plantillas.layout')

@section('Title', $proyecto->Nombre . ' - ExpoTÉCNICA 2026')

@section('Main')

<style>
    .detail-hero {
        position: relative;
        height: 420px;
        overflow: hidden;
    }
    .detail-hero__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .detail-hero__gradient {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.25) 40%, rgba(0,0,0,0.05) 70%, transparent 100%);
    }
    .detail-hero__placeholder {
        background: linear-gradient(135deg, #eceef0 0%, #d8dadc 100%);
    }
    .detail-hero__content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 32px;
        z-index: 2;
    }
    .detail-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 9999px;
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
        margin-bottom: 20px;
    }
    .detail-back:hover {
        background: rgba(255,255,255,0.22);
        color: #fff;
    }
    .detail-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        background: rgba(148, 74, 0, 0.85);
        backdrop-filter: blur(8px);
        border-radius: 9999px;
        font-family: 'Inter', sans-serif;
        font-size: 0.625rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #fff;
        margin-bottom: 12px;
    }
    .detail-title {
        font-family: 'Inter', sans-serif;
        font-size: clamp(1.75rem, 4vw, 2.5rem);
        font-weight: 700;
        color: #fff;
        margin: 0;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }

    /* Info cards */
    .info-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 0.75rem;
        padding: 24px;
        transition: all 0.25s ease;
        height: 100%;
    }
    .info-card:hover {
        border-color: rgba(148, 74, 0, 0.3);
        box-shadow: 0 4px 16px rgba(148, 74, 0, 0.08);
    }
    .info-card__icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        font-size: 1.25rem;
        margin-bottom: 14px;
    }
    .info-card__label {
        font-family: 'Inter', sans-serif;
        font-size: 0.6875rem;
        font-weight: 600;
        color: #897365;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 4px;
    }
    .info-card__value {
        font-family: 'Inter', sans-serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: #191c1e;
        margin: 0;
    }

    /* Description block */
    .desc-block {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 0.75rem;
        padding: 28px;
    }
    .desc-block__title {
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: #191c1e;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .desc-block__text {
        font-size: 0.9375rem;
        line-height: 1.7;
        color: #564337;
        margin: 0;
    }

    /* Participants */
    .participant-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        background: #f7f9fb;
        border: 1px solid #E2E8F0;
        border-radius: 9999px;
        font-family: 'Inter', sans-serif;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #191c1e;
        transition: all 0.2s ease;
    }
    .participant-chip:hover {
        border-color: #944a00;
        background: rgba(148, 74, 0, 0.04);
    }
    .participant-chip__avatar {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #944a00;
        color: #fff;
        font-size: 0.6875rem;
        font-weight: 700;
    }

    @media (min-width: 768px) {
        .detail-hero {
            height: 480px;
        }
        .detail-hero__content {
            padding: 40px;
        }
    }
    @media (max-width: 575.98px) {
        main {
            padding-bottom: 70px;
        }
    }
</style>

{{-- Hero --}}
<section class="detail-hero">
    @if($proyecto->Imagen)
        <img src="{{ asset('storage/' . $proyecto->Imagen) }}" alt="{{ $proyecto->Nombre }}" class="detail-hero__img">
    @else
        <div class="detail-hero__placeholder w-100 h-100 d-flex align-items-center justify-content-center">
            <i class="bi bi-lightbulb" style="font-size: 5rem; color: #944a00; opacity: 0.15;"></i>
        </div>
    @endif
    <div class="detail-hero__gradient"></div>
    <div class="detail-hero__content">
        <div class="container" style="max-width: 1200px;">
            <a href="/" class="detail-back">
                <i class="bi bi-arrow-left"></i> Volver al inicio
            </a>
            @if($proyecto->categoria)
                <div class="detail-badge">
                    <i class="bi bi-tag-fill" style="font-size: 0.625rem;"></i>
                    {{ $proyecto->categoria->Nombre }}
                </div>
            @endif
            <h1 class="detail-title">{{ $proyecto->Nombre }}</h1>
        </div>
    </div>
</section>

{{-- Content --}}
<section class="py-5" style="background-color: #f7f9fb;">
    <div class="container" style="max-width: 1200px;">

        {{-- Stats row --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="info-card">
                    <div class="info-card__icon" style="background-color: rgba(148,74,0,0.08); color: #944a00;">
                        <i class="bi bi-folder-fill"></i>
                    </div>
                    <p class="info-card__label">Categoría</p>
                    <p class="info-card__value" style="font-size: 1.125rem;">{{ $proyecto->categoria->Nombre ?? '—' }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="info-card">
                    <div class="info-card__icon" style="background-color: rgba(78,96,115,0.08); color: #4e6073;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <p class="info-card__label">Participantes</p>
                    <p class="info-card__value">{{ $proyecto->personasAsignadas->count() }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="info-card">
                    <div class="info-card__icon" style="background-color: rgba(0,109,55,0.08); color: #006d37;">
                        <i class="bi bi-clipboard2-check-fill"></i>
                    </div>
                    <p class="info-card__label">Evaluaciones</p>
                    <p class="info-card__value">{{ $proyecto->calificaciones->count() }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="info-card">
                    <div class="info-card__icon" style="background-color: rgba(230,126,34,0.12); color: #e67e22;">
                        <i class="bi bi-hash"></i>
                    </div>
                    <p class="info-card__label">ID Proyecto</p>
                    <p class="info-card__value" style="font-size: 1.125rem;">#{{ $proyecto->ID_Proyecto }}</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Description --}}
            <div class="col-lg-8">
                <div class="desc-block h-100">
                    <h3 class="desc-block__title">
                        <i class="bi bi-journal-text" style="color: #944a00;"></i>
                        Descripción del Proyecto
                    </h3>
                    <p class="desc-block__text">
                        {{ $proyecto->Descripcion ?? 'Este proyecto aún no tiene una descripción detallada.' }}
                    </p>
                </div>
            </div>

            {{-- Participants --}}
            <div class="col-lg-4">
                <div class="desc-block h-100">
                    <h3 class="desc-block__title">
                        <i class="bi bi-people" style="color: #944a00;"></i>
                        Participantes
                    </h3>
                    @if($proyecto->personasAsignadas->count() > 0)
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($proyecto->personasAsignadas as $asignada)
                                @php
                                    $persona = $asignada->usuario->persona ?? null;
                                    $nombre = $persona ? $persona->Nombre : ($asignada->usuario->name ?? 'Usuario');
                                    $apellido = $persona ? $persona->Apellido_1 : '';
                                    $iniciales = strtoupper(substr($nombre, 0, 1)) . strtoupper(substr($apellido, 0, 1));
                                @endphp
                                <div class="participant-chip">
                                    <div class="participant-chip__avatar">{{ $iniciales }}</div>
                                    <span>{{ $nombre }} {{ $apellido }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="font-size: 0.875rem; color: #897365; margin: 0;">
                            Aún no hay participantes asignados a este proyecto.
                        </p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
