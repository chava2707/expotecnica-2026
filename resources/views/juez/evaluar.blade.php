@extends('plantillas.layout-judge')

@section('Title', 'Evaluar Proyecto')
@section('JudgeSidebarActive2', 'active')

@php
    $user = Auth::user();
    $equipo = $proyecto->personasAsignadas->pluck('usuario.name')->filter()->implode(', ') ?: 'Sin asignar';
    $respuestas = $respuestasExistentes ?? [];
    $comentarios = $comentariosExistentes ?? [];
    $yaEvaluado = $calificacionExistente !== null;

    $totalPreguntas = 0;
    foreach ($apartados as $apartado) {
        $totalPreguntas += $apartado->preguntas->count();
    }
    $maxPosible = 0;
    foreach ($apartados as $apartado) {
        foreach ($apartado->preguntas as $pregunta) {
            $maxPosible += $pregunta->Maxima_Calificacion;
        }
    }

    $formBloqueado = $bloqueado ?? false;
    $solicitudPendienteActiva = $solicitudPendiente ?? false;
    $solicitudAprobadaActiva = $solicitudAprobada ?? false;
@endphp

@section('Styles')
    <style>
        .eval-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }

        @media(min-width:1024px) {
            .eval-grid {
                grid-template-columns: 1fr 380px;
            }
        }

        .project-id-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(44, 62, 80, .08);
            border: 1px solid #E2E8F0;
        }

        .project-id-card__accent {
            height: 6px;
            background: linear-gradient(90deg, #944a00, #e67e22);
        }

        .rubric-section {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(44, 62, 80, .08);
            border: 1px solid #E2E8F0;
            margin-bottom: 20px;
        }

        .rubric-section__header {
            background: #2d3133;
            padding: 14px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .rubric-section__header h4 {
            color: #fff;
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
        }

        .rubric-section__badge {
            background: #944a00;
            color: #fff;
            padding: 3px 10px;
            border-radius: 8px;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .question-block {
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 24px;
            transition: border-color .2s;
            margin-bottom: 16px;
        }

        .question-block:last-child {
            margin-bottom: 0;
        }

        .question-block:hover {
            border-color: #944a00;
        }

        .question-block__label {
            font-size: 1rem;
            font-weight: 600;
            color: #191c1e;
            margin-bottom: 4px;
            display: flex;
            justify-content: space-between;
            align-items: baseline;
        }

        .question-block__desc {
            font-size: .875rem;
            color: #564337;
            margin-bottom: 16px;
        }

        .question-block__score {
            font-size: 1.25rem;
            font-weight: 700;
            color: #944a00;
        }

        .score-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
            gap: 8px;
        }

        .score-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 12px 8px;
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            background: #fff;
            cursor: pointer;
            transition: all .2s;
            min-height: 60px;
            text-decoration: none;
            color: #191c1e;
        }

        .score-btn:hover {
            background: #f2f4f6;
            border-color: #944a00;
        }

        .score-btn.active {
            background: rgba(148, 74, 0, .1);
            border: 2px solid #944a00;
            color: #944a00;
        }

        .score-btn__value {
            font-size: 1.125rem;
            font-weight: 700;
            line-height: 1;
        }

        .score-btn__label {
            font-size: .6rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .04em;
            margin-top: 4px;
            text-align: center;
            line-height: 1.2;
        }

        .obs-textarea {
            width: 100%;
            min-height: 120px;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 14px;
            font-size: .875rem;
            color: #191c1e;
            resize: none;
            transition: border-color .2s, box-shadow .2s;
            font-family: 'Inter', sans-serif;
            background: #fff;
        }

        .obs-textarea:focus {
            outline: none;
            border-color: #944a00;
            box-shadow: 0 0 0 3px rgba(148, 74, 0, .12);
        }

        .obs-textarea::placeholder {
            color: #897365;
        }

        .sticky-sidebar {
            position: sticky;
            top: 24px;
        }

        .score-summary {
            background: #2d3133;
            color: #fff;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 12px rgba(44, 62, 80, .12);
            overflow: hidden;
            position: relative;
        }

        .score-summary__label {
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #897365;
            margin-bottom: 8px;
        }

        .score-summary__total {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1;
            color: #fff;
        }

        .score-summary__max {
            font-size: 1rem;
            color: #897365;
            margin-left: 4px;
        }

        .score-bar-group {
            margin-bottom: 12px;
        }

        .score-bar-group:last-child {
            margin-bottom: 0;
        }

        .score-bar-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }

        .score-bar-row span {
            font-size: .875rem;
            color: #b5c8df;
        }

        .score-bar-row strong {
            font-weight: 700;
            color: #fff;
        }

        .score-bar-track {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, .1);
            border-radius: 3px;
            overflow: hidden;
        }

        .score-bar-fill {
            height: 100%;
            background: #e67e22;
            border-radius: 3px;
            transition: width .5s ease;
        }

        .btn-action {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: .75rem;
            letter-spacing: .05em;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-action--save {
            background: #f2f4f6;
            color: #564337;
            border: 1px solid #E2E8F0;
        }

        .btn-action--save:hover {
            background: #e6e8ea;
        }

        .btn-action--finish {
            background: #e67e22;
            color: #fff;
        }

        .btn-action--finish:hover {
            background: #944a00;
            transform: translateY(-1px);
        }

        .btn-action--finish:active {
            transform: scale(.98);
        }

        .info-card {
            background: #e6e8ea;
            border-radius: 12px;
            padding: 16px;
            border: 1px solid #E2E8F0;
            margin-top: 16px;
        }

        .info-card__icon {
            color: #944a00;
            margin-right: 8px;
        }

        .info-card__title {
            font-size: .75rem;
            font-weight: 600;
            color: #944a00;
            margin-bottom: 4px;
        }

        .info-card__text {
            font-size: .8125rem;
            color: #564337;
            line-height: 1.5;
            margin: 0;
        }

        .progress-wrap {
            height: 8px;
            background: #E2E8F0;
            border-radius: 30px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #944a00;
            border-radius: 30px;
            transition: width .4s ease;
        }

        .progress-label {
            font-size: .75rem;
            color: #564337;
            margin-top: 6px;
        }

        .autosave-status {
            font-size: .75rem;
            color: #897365;
            text-align: center;
            margin-top: 12px;
            min-height: 18px;
            font-weight: 600;
        }

        .autosave-status.autosave-ok {
            color: #006d37;
        }

        .autosave-status.autosave-error {
            color: #ba1a1a;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .8125rem;
            font-weight: 600;
            color: #564337;
            text-decoration: none;
            margin-bottom: 16px;
            transition: color .15s;
        }

        .back-link:hover {
            color: #944a00;
        }

        @media(max-width:1023px) {
            .sticky-sidebar {
                position: static;
            }

            .score-summary {
                margin-bottom: 16px;
            }
        }

        body.dark-mode .project-id-card,
        body.dark-mode .rubric-section,
        body.dark-mode .question-block,
        body.dark-mode .obs-textarea,
        body.dark-mode .info-card {
            background: #2d3133;
            border-color: #3d4143;
        }

        body.dark-mode .project-id-card {
            box-shadow: 0 4px 12px rgba(0, 0, 0, .3);
        }

        body.dark-mode .rubric-section {
            box-shadow: 0 4px 12px rgba(0, 0, 0, .3);
        }

        body.dark-mode .question-block {
            border-color: #3d4143;
        }

        body.dark-mode .question-block:hover {
            border-color: rgba(148, 74, 0, .5);
        }

        body.dark-mode .question-block__label {
            color: #e8eaec;
        }

        body.dark-mode .question-block__desc {
            color: #9aa0a6;
        }

        body.dark-mode .score-btn {
            background: #1a1d1f;
            border-color: #3d4143;
            color: #e8eaec;
        }

        body.dark-mode .score-btn:hover {
            background: #3d4143;
            border-color: #944a00;
        }

        body.dark-mode .score-btn.active {
            background: rgba(148, 74, 0, .2);
            border-color: #ffb783;
            color: #ffb783;
        }

        body.dark-mode .obs-textarea {
            background: #1a1d1f;
            border-color: #3d4143;
            color: #e8eaec;
        }

        body.dark-mode .obs-textarea:focus {
            border-color: #ffb783;
            box-shadow: 0 0 0 3px rgba(148, 74, 0, .25);
        }

        body.dark-mode .info-card {
            background: #1a1d1f;
            border-color: #3d4143;
        }

        body.dark-mode .info-card__text {
            color: #9aa0a6;
        }

        body.dark-mode .progress-wrap {
            background: #3d4143;
        }

        body.dark-mode .progress-label {
            color: #9aa0a6;
        }

        body.dark-mode .back-link {
            color: #b5b8bb;
        }

        body.dark-mode .btn-action--save {
            background: #3d4143;
            color: #b5b8bb;
            border-color: #4d5153;
        }

        body.dark-mode .btn-action--save:hover {
            background: #4d5153;
        }

        .locked-overlay {
            position: relative;
        }

        .locked-overlay::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, .7);
            border-radius: 12px;
            pointer-events: none;
            z-index: 10;
        }

        body.dark-mode .locked-overlay::after {
            background: rgba(0, 0, 0, .4);
        }

        .locked-banner {
            background: #fff3e0;
            border: 1px solid #ffcc80;
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 20px;
        }

        .locked-banner__icon {
            color: #e65100;
            font-size: 1.5rem;
            margin-right: 12px;
        }

        .locked-banner__title {
            font-size: 1rem;
            font-weight: 700;
            color: #bf360c;
            margin-bottom: 4px;
        }

        .locked-banner__text {
            font-size: .875rem;
            color: #5d4037;
            margin-bottom: 12px;
        }

        .btn-solicitar {
            height: 44px;
            border: none;
            border-radius: 10px;
            padding: 0 24px;
            font-weight: 700;
            font-size: .8125rem;
            letter-spacing: .03em;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-solicitar--primary {
            background: #e65100;
            color: #fff;
        }

        .btn-solicitar--primary:hover {
            background: #bf360c;
            transform: translateY(-1px);
        }

        .btn-solicitar--pending {
            background: #ff9800;
            color: #fff;
            cursor: default;
        }

        .btn-solicitar--approved {
            background: #2e7d32;
            color: #fff;
            cursor: default;
        }

        body.dark-mode .locked-banner {
            background: #1a1d1f;
            border-color: #5d4037;
        }

        body.dark-mode .locked-banner__title {
            color: #ffab91;
        }

        body.dark-mode .locked-banner__text {
            color: #b5b8bb;
        }
    </style>
@endsection

@section('Main')

    <a href="{{ route('juez.dashboard') }}" class="back-link">
        <i class="bi bi-arrow-left"></i> Volver a la rubrica
    </a>

    @if($formBloqueado && !$solicitudAprobadaActiva)
        <div class="locked-banner">
            <div class="d-flex align-items-start">
                <i class="bi bi-lock-fill locked-banner__icon"></i>
                <div class="flex-grow-1">
                    <p class="locked-banner__title">Evaluación Bloqueada</p>
                    <p class="locked-banner__text">Esta evaluación ya fue enviada y no puede editarse. Si necesita realizar
                        cambios, solicite autorización al administrador.</p>
                    @if($solicitudPendienteActiva)
                        <button type="button" class="btn-solicitar btn-solicitar--pending" disabled>
                            <i class="bi bi-clock-history"></i> Solicitud Pendiente
                        </button>
                    @else
                        <button type="button" class="btn-solicitar btn-solicitar--primary" data-bs-toggle="modal"
                            data-bs-target="#modalSolicitud">
                            <i class="bi bi-send"></i> Solicitar Edición
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if($solicitudAprobadaActiva && $formBloqueado)
        <div class="locked-banner" style="background:#e8f5e9;border-color:#a5d6a7;">
            <div class="d-flex align-items-start">
                <i class="bi bi-check-circle-fill" style="color:#2e7d32;font-size:1.5rem;margin-right:12px;"></i>
                <div class="flex-grow-1">
                    <p style="font-size:1rem;font-weight:700;color:#1b5e20;margin-bottom:4px;">Edición Autorizada</p>
                    <p style="font-size:.875rem;color:#33691e;margin-bottom:0;">El administrador ha aprobado su solicitud. Puede
                        editar y volver a enviar la evaluación.</p>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('juez.evaluar.guardar', ['proyecto' => $proyecto->ID_Proyecto, 'rubrica' => $rubrica->ID_Rubrica]) }}" method="POST" id="evalForm"
        @if($formBloqueado && !$solicitudAprobadaActiva) style="pointer-events:none;opacity:.6;" @endif>
        @csrf
        <input type="hidden" name="ID_Proyecto" value="{{ $proyecto->ID_Proyecto }}">
        <input type="hidden" name="ID_Rubrica" value="{{ $rubrica->ID_Rubrica }}">

        <div class="eval-grid">

            {{-- ========== COLUMNA PRINCIPAL ========== --}}
            <div class="eval-main-col">

                {{-- Tarjeta de Identificación del Proyecto --}}
                <div class="project-id-card mb-4">
                    <div class="project-id-card__accent"></div>
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                            <div>
                                <span
                                    class="rubric-section__badge mb-2 d-inline-block">{{ $proyecto->categoria->Nombre }}</span>
                                <h2 style="font-size:1.5rem;font-weight:700;color:#191c1e;margin:0 0 8px 0;">
                                    {{ $proyecto->Nombre }}
                                </h2>
                                <p style="font-size:.875rem;color:#564337;margin:0;">{{ $proyecto->Descripcion }}</p>
                                <div class="d-flex gap-4 mt-3 flex-wrap">
                                    <div class="d-flex align-items-center gap-2" style="color:#564337;">
                                        <i class="bi bi-people-fill" style="font-size:.9rem;"></i>
                                        <span style="font-size:.8125rem;font-weight:600;">{{ $equipo }}</span>
                                    </div>
                                </div>
                                @if($proyecto->Archivo_PDF)
                                    <a href="{{ route('proyectos.trabajo', $proyecto->ID_Proyecto) }}"
                                       class="btn d-inline-flex align-items-center gap-2 mt-3"
                                       data-no-transition
                                       style="height:44px;background:#944a00;color:#fff;font-weight:700;font-size:.75rem;letter-spacing:.05em;text-transform:uppercase;border-radius:10px;padding:0 18px;text-decoration:none;transition:all .2s;"
                                       onmouseover="this.style.background='#e67e22'" onmouseout="this.style.background='#944a00'">
                                        <i class="bi bi-file-earmark-pdf-fill"></i> Descargar Trabajo Escrito
                                    </a>
                                @endif
                            </div>
                            @if($yaEvaluado)
                                <span class="rubric-section__badge" style="background:#006d37;">Evaluado</span>
                            @endif
                        </div>

                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span style="font-size:.75rem;font-weight:600;color:#564337;">Progreso de Evaluación</span>
                                <span style="font-size:.875rem;font-weight:700;color:#944a00;">
                                    <span id="progressText">0%</span>
                                    <span id="progressCount" style="font-weight:600;color:#897365;font-size:.75rem;">(0 / {{ $totalPreguntas }} indicadores)</span>
                                </span>
                            </div>
                            <div class="progress-wrap">
                                <div class="progress-fill" id="progressBar" style="width:0%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Secciones de la Rúbrica --}}
                @forelse($apartados as $apartado)
                    <div class="rubric-section">
                        <div class="rubric-section__header">
                            <h4>{{ $loop->iteration }}. {{ $apartado->Titulo }}</h4>
                            <span class="rubric-section__badge">
                                {{ $apartado->preguntas->count() }} criterio{{ $apartado->preguntas->count() > 1 ? 's' : '' }}
                            </span>
                        </div>
                        <div class="p-4">
                            @foreach($apartado->preguntas as $pregunta)
                                @php
                                    $valor = $respuestas[$pregunta->ID_Pregunta] ?? null;
                                    $comentario = $comentarios[$pregunta->ID_Pregunta] ?? '';
                                @endphp
                                <div class="question-block" data-id="{{ $pregunta->ID_Pregunta }}"
                                    data-max="{{ $pregunta->Maxima_Calificacion }}">
                                    <input type="hidden" name="pregunta_{{ $pregunta->ID_Pregunta }}"
                                        id="input-score-{{ $pregunta->ID_Pregunta }}" value="{{ $valor ?? '' }}">
                                    <div class="question-block__label">
                                        <span>{{ $pregunta->Pregunta }}</span>
                                        <span class="question-block__score" id="score-display-{{ $pregunta->ID_Pregunta }}">
                                            {{ $valor !== null ? $valor : '0' }} / {{ $pregunta->Maxima_Calificacion }}
                                        </span>
                                    </div>

                                    <div class="score-buttons" id="score-group-{{ $pregunta->ID_Pregunta }}">
                                        @for($i = 0; $i <= $pregunta->Maxima_Calificacion; $i++)
                                            <button type="button" class="score-btn {{ $valor !== null && intval($valor) === $i ? 'active' : '' }}"
                                                data-question="{{ $pregunta->ID_Pregunta }}" data-value="{{ $i }}"
                                                onclick="selectScore({{ $pregunta->ID_Pregunta }}, {{ $i }}, this)">
                                                <span class="score-btn__value">{{ $i }}</span>
                                                <span class="score-btn__label">
                                                    @if($i == 0) Insuficiente
                                                    @elseif($i == 1) Básico
                                                    @elseif($i == $pregunta->Maxima_Calificacion) Destacado
                                                    @elseif($i == $pregunta->Maxima_Calificacion - 1) Satisfactorio
                                                    @else En Proceso
                                                    @endif
                                                </span>
                                            </button>
                                        @endfor
                                    </div>

                                    <textarea class="obs-textarea mt-3" name="comentario_{{ $pregunta->ID_Pregunta }}"
                                        placeholder="Observaciones sobre este criterio (opcional)...">{{ $comentario }}</textarea>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="alert alert-warning text-center my-4">
                        No se encontraron apartados para esta rúbrica y categoría.
                    </div>
                @endforelse

                {{-- Acciones (Móvil) --}}
                <div class="d-lg-none d-flex flex-column gap-2 mt-4">
                    <button type="button" class="btn-action btn-action--save" onclick="saveBorrador(true)">
                        <i class="bi bi-save"></i> Guardar Borrador
                    </button>
                    <button type="submit" class="btn-action btn-action--finish">
                        <i class="bi bi-check-circle-fill"></i> Finalizar Evaluación
                    </button>
                </div>
            </div>

            {{-- ========== SIDEBAR STICKY ========== --}}
            <div class="eval-side-col">
                <div class="sticky-sidebar">

                    {{-- Score Summary Card --}}
                    <div class="score-summary">
                        <div class="score-summary__label">Puntaje Acumulado</div>
                        <div class="d-flex align-items-baseline mb-4">
                            <span class="score-summary__total" id="totalScore">0.0</span>
                            <span class="score-summary__max">/ {{ $maxPosible }}</span>
                        </div>

                        @foreach($apartados as $apartado)

                            <div class="apartado-card">

                                @foreach($apartado->preguntas as $pregunta)

                                @endforeach

                            </div>

                        @endforeach

                        <div class="mt-4 d-flex flex-column gap-2">
                            <button type="button" class="btn-action btn-action--save"
                                onclick="saveBorrador(true)">
                                <i class="bi bi-save"></i> Guardar Borrador
                            </button>
                            <button type="submit" class="btn-action btn-action--finish">
                                <i class="bi bi-check-circle-fill"></i> Finalizar Evaluación
                            </button>
                        </div>
                        <div class="autosave-status" id="autosave-status"></div>
                    </div>

                    {{-- Info Card --}}
                    <div class="info-card">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-info-circle-fill info-card__icon"></i>
                            <span class="info-card__title">Nota del Sistema</span>
                        </div>
                        <p class="info-card__text">
                            Seleccione un valor para cada criterio. Las evaluaciones se guardan automáticamente. Puede
                            retomar la evaluación desde cualquier dispositivo vinculado.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @if($formBloqueado && !$solicitudAprobadaActiva && !$solicitudPendienteActiva)
        <div class="modal fade" id="modalSolicitud" tabindex="-1" aria-labelledby="modalSolicitudLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 8px 32px rgba(0,0,0,.15);">
                    <div class="modal-header" style="background:#2d3133;border-radius:16px 16px 0 0;padding:16px 24px;">
                        <h5 class="modal-title" id="modalSolicitudLabel" style="color:#fff;font-weight:600;font-size:1rem;">
                            <i class="bi bi-send" style="margin-right:8px;"></i> Solicitar Edición
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('juez.solicitar.edicion', $calificacionExistente->ID_Calificaciones) }}"
                        method="POST">
                        @csrf
                        <div class="modal-body" style="padding:24px;">
                            <p style="font-size:.875rem;color:#564337;margin-bottom:16px;">
                                Explique al administrador por qué necesita modificar esta evaluación:
                            </p>
                            <textarea name="motivo" class="obs-textarea" style="min-height:100px;"
                                placeholder="Motivo de la solicitud..." required></textarea>
                        </div>
                        <div class="modal-footer" style="border-top:1px solid #E2E8F0;padding:16px 24px;">
                            <button type="button" class="btn-action btn-action--save" style="width:auto;height:40px;"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn-solicitar btn-solicitar--primary" style="height:40px;">
                                <i class="bi bi-send"></i> Enviar Solicitud
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('Scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @php
        // Re-generamos la data de preguntas a partir de los $apartados YA FILTRADOS.
        // Esto asegura al 100% que JS solo evalúe los criterios visibles.
        $preguntasFiltradas = $apartados->flatMap(function ($apartado) {
            return $apartado->preguntas->map(function ($pregunta) use ($apartado) {
                return [
                    'id' => $pregunta->ID_Pregunta,
                    'apartado_id' => $apartado->ID_Apartado,
                    'max' => $pregunta->Maxima_Calificacion,
                ];
            });
        });

        $totalPreguntasReal = $preguntasFiltradas->count();
        $maxPosibleReal = $preguntasFiltradas->sum('max');
    @endphp

    <script>
        (function () {
            // Usamos únicamente las preguntas filtradas de la rúbrica actual
            const preguntas = @json($preguntasFiltradas);
            const maxPosible = {{ $maxPosibleReal }};
            const totalPreguntas = {{ $totalPreguntasReal }};
            const borradorUrl = @json(route('juez.evaluar.borrador', ['proyecto' => $proyecto->ID_Proyecto, 'rubrica' => $rubrica->ID_Rubrica]));
            const formBloqueado = @json((bool) ($formBloqueado && !$solicitudAprobadaActiva));

            let autosaveTimer = null;

            function setAutosaveStatus(text, state) {
                const el = document.getElementById('autosave-status');
                if (!el) return;
                el.textContent = text;
                el.classList.remove('autosave-ok', 'autosave-error');
                if (state === 'ok') el.classList.add('autosave-ok');
                if (state === 'error') el.classList.add('autosave-error');
            }

            async function saveBorrador(showFeedback) {
                if (formBloqueado) return;

                const form = document.getElementById('evalForm');
                if (!form) return;

                setAutosaveStatus('Guardando…', '');

                try {
                    const resp = await fetch(borradorUrl, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });

                    const data = await resp.json();

                    if (data.success) {
                        setAutosaveStatus('Guardado automáticamente ✓', 'ok');
                        if (showFeedback) alert('Borrador guardado correctamente.');
                    } else {
                        setAutosaveStatus('No se pudo guardar: ' + (data.message || 'error'), 'error');
                        if (showFeedback) alert(data.message || 'No se pudo guardar el borrador.');
                    }
                } catch (e) {
                    setAutosaveStatus('Error de conexión al guardar', 'error');
                    if (showFeedback) alert('No se pudo guardar el borrador. Verifique su conexión.');
                }
            }

            function scheduleAutosave() {
                if (formBloqueado) return;
                clearTimeout(autosaveTimer);
                setAutosaveStatus('Guardando…', '');
                autosaveTimer = setTimeout(function () {
                    saveBorrador(false);
                }, 700);
            }

            window.saveBorrador = saveBorrador;

            window.selectScore = function (preguntaId, value, btn) {
                const group = document.getElementById('score-group-' + preguntaId);
                if (group) {
                    group.querySelectorAll('.score-btn').forEach(b => b.classList.remove('active'));
                }
                btn.classList.add('active');

                const display = document.getElementById('score-display-' + preguntaId);
                const block = btn.closest('.question-block');
                const max = block ? parseInt(block.dataset.max) : 5;
                if (display) display.textContent = value + ' / ' + max;

                const hiddenInput = document.getElementById('input-score-' + preguntaId);
                if (hiddenInput) hiddenInput.value = value;

                updateAllScores();
                scheduleAutosave();
            };

            function updateAllScores() {
                let total = 0;
                let respondidas = 0;
                const sectionScores = {};

                preguntas.forEach(p => {
                    if (!sectionScores[p.apartado_id]) {
                        sectionScores[p.apartado_id] = { score: 0, max: 0, count: 0, answered: 0 };
                    }
                    sectionScores[p.apartado_id].max += p.max;
                    sectionScores[p.apartado_id].count++;

                    const group = document.getElementById('score-group-' + p.id);
                    if (!group) return;

                    const active = group.querySelector('.score-btn.active');
                    if (active) {
                        const val = parseInt(active.dataset.value);
                        sectionScores[p.apartado_id].score += val;
                        sectionScores[p.apartado_id].answered++;
                        total += val;
                        respondidas++;
                    }
                });

                const totalScoreEl = document.getElementById('totalScore');
                const progressTextEl = document.getElementById('progressText');
                const progressBarEl = document.getElementById('progressBar');

                if (totalScoreEl) totalScoreEl.textContent = total;
                const porcentaje = totalPreguntas > 0 ? Math.round(respondidas / totalPreguntas * 100) : 0;
                if (progressTextEl) progressTextEl.textContent = porcentaje + '%';
                const progressCountEl = document.getElementById('progressCount');
                if (progressCountEl) progressCountEl.textContent = '(' + respondidas + ' / ' + totalPreguntas + ' indicadores)';
                if (progressBarEl) progressBarEl.style.width = porcentaje + '%';

                Object.keys(sectionScores).forEach(id => {
                    const s = sectionScores[id];
                    const scoreEl = document.getElementById('section-score-' + id);
                    const barEl = document.getElementById('section-bar-' + id);
                    if (scoreEl) scoreEl.textContent = s.score;
                    if (barEl) barEl.style.width = (s.max > 0 ? (s.score / s.max * 100) : 0) + '%';
                });
            }

            updateAllScores();

            const form = document.getElementById('evalForm');
            let finalizando = false;
            if (form) {
                form.addEventListener('submit', function (e) {
                    let allAnswered = true;

                    preguntas.forEach(p => {
                        const input = document.getElementById('input-score-' + p.id);
                        const block = document.querySelector('.question-block[data-id="' + p.id + '"]');

                        // Verifica si el criterio actual en pantalla fue respondido
                        if (!input || input.value === '' || input.value === null) {
                            allAnswered = false;
                            if (block) { block.style.borderColor = '#ba1a1a'; }
                        } else {
                            if (block) { block.style.borderColor = '#E2E8F0'; }
                        }
                    });

                    if (!allAnswered) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Evaluación incompleta',
                            text: 'Debe calificar todos los criterios antes de finalizar la evaluación.',
                            icon: 'warning',
                            confirmButtonColor: '#944a00',
                            confirmButtonText: 'Entendido',
                            customClass: {
                                popup: 'rounded-4'
                            }
                        });
                        return;
                    }

                    e.preventDefault();

                    Swal.fire({
                        title: '¿Finalizar evaluación?',
                        text: 'Esta acción no se puede deshacer.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#006d37',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Sí, finalizar',
                        cancelButtonText: 'Cancelar',
                        customClass: {
                            popup: 'rounded-4'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            clearTimeout(autosaveTimer);
                            finalizando = true;
                            form.submit();
                        }
                    });
                });
            }

            // Guardar borrador al escribir observaciones
            document.querySelectorAll('.obs-textarea').forEach(function (ta) {
                ta.addEventListener('input', scheduleAutosave);
            });

            // Guardar borrador al salir de la página (navegación/cerrar pestaña)
            window.addEventListener('beforeunload', function () {
                if (autosaveTimer) {
                    clearTimeout(autosaveTimer);
                }
                if (!formBloqueado && form && !finalizando) {
                    navigator.sendBeacon(borradorUrl, new FormData(form));
                }
            });
        })();
    </script>
@endsection