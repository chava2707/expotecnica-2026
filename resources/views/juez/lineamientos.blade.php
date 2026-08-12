@extends('plantillas.layout-judge')
@section('Title', 'Lineamientos de Evaluación - ExpoTÉCNICA 2026')
@section('JudgeSidebarActive5', 'active')

@section('Main')

    <style>
        .lineamiento-hero {
            background: linear-gradient(135deg, #fff5eb 0%, #fff 100%);
            border: 1px solid #f0d9c0;
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .lineamiento-summary {
            background-color: rgba(230, 126, 34, 0.06);
            border: 1px solid rgba(230, 126, 34, 0.25);
            border-radius: 0.75rem;
        }

        .criterio-card {
            background-color: #fff;
            border-radius: 0.75rem;
            box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);
            border: 1px solid #E2E8F0;
            border-top: 4px solid #e67e22;
            transition: all 0.25s ease;
        }

        .criterio-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(148, 74, 0, 0.12);
        }

        .criterio-badge {
            display: inline-block;
            background-color: #f2f4f6;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.625rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #191c1e;
        }

        .nivel-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nivel-label {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .nivel-desc {
            font-size: 0.875rem;
            color: #564337;
        }

        .protocolo-section {
            background-color: #2d3133;
            color: #eff1f3;
            border-radius: 0.75rem;
            box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);
        }

        .protocolo-item {
            border-left: 3px solid #e67e22;
            padding-left: 16px;
        }

        .protocolo-item h5 {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #e67e22;
            margin-bottom: 4px;
        }

        .protocolo-item p {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0;
        }

        .timeline-step {
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }

        .timeline-number {
            width: 32px;
            height: 32px;
            min-width: 32px;
            border-radius: 50%;
            background-color: #e67e22;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            z-index: 2;
        }

        .timeline-card {
            background-color: #fff;
            padding: 16px;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(44, 62, 80, 0.08);
            border: 1px solid #E2E8F0;
            flex: 1;
            transition: all 0.15s ease;
        }

        .timeline-card:hover {
            background-color: rgba(230, 126, 34, 0.03);
            border-color: #e67e22;
        }

        .timeline-line {
            position: absolute;
            left: 28px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #E2E8F0;
        }

        @media (max-width: 767px) {
            .criterio-card {
                border-top: none;
                border-left: 4px solid #e67e22;
            }

            .timeline-line {
                left: 28px;
            }
        }

        @media (max-width: 575px) {
            .hero-buttons {
                flex-direction: column;
            }

            .hero-buttons .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div style="max-width: 1200px; margin: 0 auto; padding-bottom: 80px;">

        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3 border-bottom pb-4"
            style="border-color: #E2E8F0 !important;">
            <div>
                <h1
                    style="font-family: 'Inter', sans-serif; font-size: clamp(1.5rem, 4vw, 2rem); font-weight: 700; color: #191c1e; margin-bottom: 4px;">
                    Lineamientos y Normativa</h1>
                <p style="font-size: 0.9375rem; color: #564337; margin-bottom: 0;">
                    Guía integral para el proceso de evaluación de ExpoTÉCNICA 2026.</p>
            </div>
        </div>

        {{-- Hero Section --}}
        <section class="mb-4">
            <div class="row g-4">
                <div class="col-12 col-lg-8">
                    <div class="lineamiento-hero p-4">
                        <h2
                            style="font-family: 'Inter', sans-serif; font-size: 1.5rem; font-weight: 700; color: #191c1e; margin-bottom: 12px;">
                            Bienvenidos a ExpoTÉCNICA 2026</h2>
                        <p style="font-size: 0.9375rem; color: #564337; line-height: 1.7; margin-bottom: 16px;">
                            Como evaluadores, su misión es garantizar la objetividad y el rigor técnico que define a nuestra
                            institución. Los proyectos presentados representan el esfuerzo académico de meses; nuestro
                            objetivo
                            es certificar la excelencia y fomentar la innovación a través de una crítica constructiva y
                            técnica.</p>
                        <div class="d-flex gap-3 hero-buttons">
                            <a href="{{ asset('lineamientos-expotecnica-2026.pdf') }}"
                                download class="btn d-inline-flex align-items-center gap-2 text-decoration-none"
                                style="background-color: #e67e22; color: #fff; padding: 10px 20px; border-radius: 0.5rem; font-weight: 700; font-size: 0.875rem; transition: all 0.2s;">
                                <i class="bi bi-download"></i>
                                Descargar Manual PDF
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="lineamiento-summary p-4 h-100">
                        <h3
                            style="font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: #944a00; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-info-circle"></i>
                            Resumen Rápido
                        </h3>
                        <ul style="list-style: none; padding: 0; margin: 0;" class="d-flex flex-column gap-3">
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-stopwatch" style="color: #e67e22; margin-top: 2px;"></i>
                                <div>
                                    <p style="font-size: 0.875rem; font-weight: 700; color: #191c1e; margin-bottom: 2px;">15
                                        Minutos</p>
                                    <p style="font-size: 0.8125rem; color: #564337; margin-bottom: 0;">Tiempo máximo por
                                        evaluación de mesa.</p>
                                </div>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check-circle" style="color: #e67e22; margin-top: 2px;"></i>
                                <div>
                                    <p style="font-size: 0.875rem; font-weight: 700; color: #191c1e; margin-bottom: 2px;">
                                        Escala 0 - 3</p>
                                    <p style="font-size: 0.8125rem; color: #564337; margin-bottom: 0;">Gradación de
                                        cumplimiento por criterio.</p>
                                </div>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-lock" style="color: #e67e22; margin-top: 2px;"></i>
                                <div>
                                    <p style="font-size: 0.875rem; font-weight: 700; color: #191c1e; margin-bottom: 2px;">
                                        Cierre Digital</p>
                                    <p style="font-size: 0.8125rem; color: #564337; margin-bottom: 0;">Obligatorio antes de
                                        salir del stand.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- Criterios de Evaluación --}}
        <section class="mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="d-inline-block rounded-circle"
                    style="width: 4px; height: 4px; background-color: #e67e22;"></span>
                <h3
                    style="font-family: 'Inter', sans-serif; font-size: 1.25rem; font-weight: 600; color: #191c1e; margin-bottom: 0;">
                    Criterios de Evaluación</h3>
            </div>

            <div class="row g-4">
                {{-- Calidad Técnica --}}
                <div class="col-12 col-md-4">
                    <div class="criterio-card p-4 h-100">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <i class="bi bi-architecture" style="font-size: 2rem; color: #e67e22;"></i>
                            <span class="criterio-badge">40%</span>
                        </div>
                        <h4
                            style="font-family: 'Inter', sans-serif; font-size: 1.125rem; font-weight: 600; color: #191c1e; margin-bottom: 8px;">
                            Calidad Técnica</h4>
                        <p style="font-size: 0.875rem; color: #564337; margin-bottom: 16px;">Solidez en el diseño, uso de
                            estándares industriales y acabado del prototipo físico o software.</p>
                        <div class="d-flex flex-column gap-2 p-3" style="background-color: #f7f9fb; border-radius: 0.5rem;">
                            <div class="nivel-item">
                                <span class="nivel-label" style="color: #191c1e;">Nivel 3:</span>
                                <span class="nivel-desc">Impecable / Pro</span>
                            </div>
                            <div class="nivel-item">
                                <span class="nivel-label" style="color: #191c1e;">Nivel 2:</span>
                                <span class="nivel-desc">Funcional / Sólido</span>
                            </div>
                            <div class="nivel-item">
                                <span class="nivel-label" style="color: #191c1e;">Nivel 1:</span>
                                <span class="nivel-desc">Básico / Mejorable</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Innovación --}}
                <div class="col-12 col-md-4">
                    <div class="criterio-card p-4 h-100">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <i class="bi bi-lightbulb" style="font-size: 2rem; color: #e67e22;"></i>
                            <span class="criterio-badge">30%</span>
                        </div>
                        <h4
                            style="font-family: 'Inter', sans-serif; font-size: 1.125rem; font-weight: 600; color: #191c1e; margin-bottom: 8px;">
                            Innovación</h4>
                        <p style="font-size: 0.875rem; color: #564337; margin-bottom: 16px;">Originalidad de la propuesta,
                            solución creativa a problemas reales y factibilidad de mercado.</p>
                        <div class="d-flex flex-column gap-2 p-3" style="background-color: #f7f9fb; border-radius: 0.5rem;">
                            <div class="nivel-item">
                                <span class="nivel-label" style="color: #191c1e;">Nivel 3:</span>
                                <span class="nivel-desc">Disruptivo</span>
                            </div>
                            <div class="nivel-item">
                                <span class="nivel-label" style="color: #191c1e;">Nivel 2:</span>
                                <span class="nivel-desc">Adaptación Original</span>
                            </div>
                            <div class="nivel-item">
                                <span class="nivel-label" style="color: #191c1e;">Nivel 1:</span>
                                <span class="nivel-desc">Conocido / Iterativo</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Defensa Oral --}}
                <div class="col-12 col-md-4">
                    <div class="criterio-card p-4 h-100">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <i class="bi bi-megaphone" style="font-size: 2rem; color: #e67e22;"></i>
                            <span class="criterio-badge">30%</span>
                        </div>
                        <h4
                            style="font-family: 'Inter', sans-serif; font-size: 1.125rem; font-weight: 600; color: #191c1e; margin-bottom: 8px;">
                            Defensa Oral</h4>
                        <p style="font-size: 0.875rem; color: #564337; margin-bottom: 16px;">Dominio de conceptos, respuesta
                            a preguntas técnicas y claridad comunicativa del equipo.</p>
                        <div class="d-flex flex-column gap-2 p-3" style="background-color: #f7f9fb; border-radius: 0.5rem;">
                            <div class="nivel-item">
                                <span class="nivel-label" style="color: #191c1e;">Nivel 3:</span>
                                <span class="nivel-desc">Dominio Total</span>
                            </div>
                            <div class="nivel-item">
                                <span class="nivel-label" style="color: #191c1e;">Nivel 2:</span>
                                <span class="nivel-desc">Seguro / Preciso</span>
                            </div>
                            <div class="nivel-item">
                                <span class="nivel-label" style="color: #191c1e;">Nivel 1:</span>
                                <span class="nivel-desc">Dudoso / Parcial</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Protocolos de Seguridad --}}
        <section class="mb-4">
            <div class="protocolo-section p-4">
                <div class="row g-4 align-items-center">
                    <div class="col-12 col-lg-8">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-exclamation-triangle-fill" style="color: #ffdad6; font-size: 1.5rem;"></i>
                            <h3
                                style="font-family: 'Inter', sans-serif; font-size: 1.125rem; font-weight: 600; color: #eff1f3; margin-bottom: 0;">
                                Protocolos de Seguridad Obligatorios</h3>
                        </div>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <div class="protocolo-item">
                                    <h5>Proyectos Eléctricos</h5>
                                    <p>Uso obligatorio de fusibles, aislamiento de conductores y señalización de alta
                                        tensión.</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="protocolo-item">
                                    <h5>Proyectos Mecánicos</h5>
                                    <p>Resguardos en partes móviles, estabilidad de estructuras y uso de EPP por
                                        estudiantes.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="d-flex align-items-center justify-content-center"
                            style="width: 100%; height: 160px; background-color: #3d4143; border-radius: 0.5rem; overflow: hidden;">
                            <div class="text-center">
                                <i class="bi bi-shield-exclamation"
                                    style="font-size: 3rem; color: #e67e22; display: block; margin-bottom: 8px;"></i>
                                <p style="font-size: 0.75rem; color: rgba(255,255,255,0.6); margin-bottom: 0;">Seguridad
                                    primero</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Guía de Procedimiento --}}
        <section class="mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="d-inline-block rounded-circle"
                    style="width: 4px; height: 4px; background-color: #e67e22;"></span>
                <h3
                    style="font-family: 'Inter', sans-serif; font-size: 1.25rem; font-weight: 600; color: #191c1e; margin-bottom: 0;">
                    Guía de Procedimiento para Jueces</h3>
            </div>

            <div class="d-flex flex-column gap-3 position-relative" style="padding-left: 16px;">
                <div class="timeline-line"></div>

                {{-- Step 1 --}}
                <div class="timeline-step">
                    <div class="timeline-number">1</div>
                    <div class="timeline-card">
                        <h5
                            style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: #191c1e; margin-bottom: 4px;">
                            Arribo y Presentación</h5>
                        <p style="font-size: 0.875rem; color: #564337; margin-bottom: 0;">Saludar al equipo, verificar el
                            número de proyecto y solicitar la documentación técnica impresa.</p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="timeline-step">
                    <div class="timeline-number">2</div>
                    <div class="timeline-card">
                        <h5
                            style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: #191c1e; margin-bottom: 4px;">
                            Demostración Técnica</h5>
                        <p style="font-size: 0.875rem; color: #564337; margin-bottom: 0;">Observar el funcionamiento del
                            prototipo en tiempo real. No intervenir hasta la sesión de preguntas.</p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="timeline-step">
                    <div class="timeline-number">3</div>
                    <div class="timeline-card">
                        <h5
                            style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: #191c1e; margin-bottom: 4px;">
                            Interrogatorio</h5>
                        <p style="font-size: 0.875rem; color: #564337; margin-bottom: 0;">Realizar 3 preguntas clave sobre
                            la arquitectura del proyecto, dificultades y soluciones aplicadas.</p>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="timeline-step">
                    <div class="timeline-number">4</div>
                    <div class="timeline-card">
                        <h5
                            style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: #191c1e; margin-bottom: 4px;">
                            Cierre en Sistema</h5>
                        <p style="font-size: 0.875rem; color: #564337; margin-bottom: 0;">Completar la rúbrica digital,
                            agregar feedback detallado y enviar la calificación inmediatamente.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Consideraciones para la Evaluación --}}
        <section class="mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="d-inline-block rounded-circle"
                    style="width: 4px; height: 4px; background-color: #e67e22;"></span>
                <h3
                    style="font-family: 'Inter', sans-serif; font-size: 1.25rem; font-weight: 600; color: #191c1e; margin-bottom: 0;">
                    Consideraciones para la Evaluación</h3>
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-start gap-3 p-3 pb-4 position-relative"
                        style="background-color: #fff; border-radius: 0.5rem; border: 1px solid #E2E8F0;">
                        <i class="bi bi-journal-text" style="color: #e67e22; font-size: 1.25rem; margin-top: 2px;"></i>
                        <div>
                            <p style="font-size: 0.875rem; font-weight: 600; color: #191c1e; margin-bottom: 2px;">Bitácora
                                de Investigación</p>
                            <p style="font-size: 0.8125rem; color: #564337; margin-bottom: 0;">Actividades realizadas a lo
                                largo del proceso de investigación e incluidas en la bitácora.</p>
                        </div>

                        <!-- Etiqueta en esquina inferior izquierda -->
                        <span class="position-absolute bottom-0 start-0 m-2 badge"
                            style="background-color: #e28c0a; color: #f9fdfd; font-size: 0.6875rem; font-weight: 500;">
                            <i class="bi bi-check me-1"></i>Exclusivo para Steam
                        </span>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-start gap-3 p-3"
                        style="background-color: #fff; border-radius: 0.5rem; border: 1px solid #E2E8F0;">
                        <i class="bi bi-search" style="color: #e67e22; font-size: 1.25rem; margin-top: 2px;"></i>
                        <div>
                            <p style="font-size: 0.875rem; font-weight: 600; color: #191c1e; margin-bottom: 2px;">Exactitud
                                de la
                                Investigación</p>
                            <p style="font-size: 0.8125rem; color: #564337; margin-bottom: 0;">Detalle y exactitud de la
                                investigación según lo documentado en la bitácora.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-start gap-3 p-3"
                        style="background-color: #fff; border-radius: 0.5rem; border: 1px solid #E2E8F0;">
                        <i class="bi bi-clock-history" style="color: #e67e22; font-size: 1.25rem; margin-top: 2px;"></i>
                        <div>
                            <p style="font-size: 0.875rem; font-weight: 600; color: #191c1e; margin-bottom: 2px;">Formato de
                                Exposición</p>
                            <p style="font-size: 0.8125rem; color: #564337; margin-bottom: 0;">Exposición del proyecto en 15
                                minutos, seguidos por una sesión de preguntas de 15 minutos.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-start gap-3 p-3"
                        style="background-color: #fff; border-radius: 0.5rem; border: 1px solid #E2E8F0;">
                        <i class="bi bi-cash" style="color: #e67e22; font-size: 1.25rem; margin-top: 2px;"></i>
                        <div>
                            <p style="font-size: 0.875rem; font-weight: 600; color: #191c1e; margin-bottom: 2px;">Costos de
                                Proyecto</p>
                            <p style="font-size: 0.8125rem; color: #564337; margin-bottom: 0;">En esta etapa de no existe la
                                evaluacion de los costos de proyecto.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-start gap-3 p-3"
                        style="background-color: #fff; border-radius: 0.5rem; border: 1px solid #E2E8F0;">
                        <i class="bi bi-emoji-smile" style="color: #e67e22; font-size: 1.25rem; margin-top: 2px;"></i>
                        <div>
                            <p style="font-size: 0.875rem; font-weight: 600; color: #191c1e; margin-bottom: 2px;">Trato y
                                Ambiente</p>
                            <p style="font-size: 0.8125rem; color: #564337; margin-bottom: 0;">Trato amable, respetuoso y
                                paciente. Desarrollar un ambiente de confianza con objetividad.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-start gap-3 p-3"
                        style="background-color: #fff; border-radius: 0.5rem; border: 1px solid #E2E8F0;">
                        <i class="bi bi-people" style="color: #e67e22; font-size: 1.25rem; margin-top: 2px;"></i>
                        <div>
                            <p style="font-size: 0.875rem; font-weight: 600; color: #191c1e; margin-bottom: 2px;">
                                Participación
                                Equitativa</p>
                            <p style="font-size: 0.8125rem; color: #564337; margin-bottom: 0;">Propiciar la participación de
                                todos los integrantes del equipo durante la evaluación.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-start gap-3 p-3"
                        style="background-color: #fff; border-radius: 0.5rem; border: 1px solid #E2E8F0;">
                        <i class="bi bi-lightbulb" style="color: #e67e22; font-size: 1.25rem; margin-top: 2px;"></i>
                        <div>
                            <p style="font-size: 0.875rem; font-weight: 600; color: #191c1e; margin-bottom: 2px;">
                                Retroalimentación Constructiva</p>
                            <p style="font-size: 0.8125rem; color: #564337; margin-bottom: 0;">Considerar el esfuerzo y la
                                calidad del trabajo de secundaria. Brindar recomendaciones para fortalecer el proyecto.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Pautas Operativas --}}
        <section class="mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="d-inline-block rounded-circle"
                    style="width: 4px; height: 4px; background-color: #e67e22;"></span>
                <h3
                    style="font-family: 'Inter', sans-serif; font-size: 1.25rem; font-weight: 600; color: #191c1e; margin-bottom: 0;">
                    Pautas Operativas</h3>
            </div>

            <div class="row g-3">
                {{-- Antes de visitar --}}
                <div class="col-12 col-md-4">
                    <div class="p-4 h-100"
                        style="background-color: #fff; border-radius: 0.75rem; border: 1px solid #E2E8F0;">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle"
                                style="width: 36px; height: 36px; background-color: rgba(230, 126, 34, 0.1); flex-shrink: 0;">
                                <i class="bi bi-clock" style="color: #e67e22; font-size: 1rem;"></i>
                            </div>
                            <h4
                                style="font-family: 'Inter', sans-serif; font-size: 0.9375rem; font-weight: 600; color: #191c1e; margin-bottom: 0;">
                                Antes de Visitar</h4>
                        </div>
                        <ul style="list-style: none; padding: 0; margin: 0;" class="d-flex flex-column gap-2">
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check2" style="color: #e67e22; margin-top: 2px;"></i>
                                <span style="font-size: 0.8125rem; color: #564337;">Familiarizarse con el formulario de
                                    evaluación.</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check2" style="color: #e67e22; margin-top: 2px;"></i>
                                <span style="font-size: 0.8125rem; color: #564337;">Revisar la lista de proyectos por
                                    valorar.</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check2" style="color: #e67e22; margin-top: 2px;"></i>
                                <span style="font-size: 0.8125rem; color: #564337;">Asegurar que el celular esté en modo
                                    silencioso.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Durante la evaluación --}}
                <div class="col-12 col-md-4">
                    <div class="p-4 h-100"
                        style="background-color: #fff; border-radius: 0.75rem; border: 1px solid #E2E8F0;">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle"
                                style="width: 36px; height: 36px; background-color: rgba(230, 126, 34, 0.1); flex-shrink: 0;">
                                <i class="bi bi-clipboard-check" style="color: #e67e22; font-size: 1rem;"></i>
                            </div>
                            <h4
                                style="font-family: 'Inter', sans-serif; font-size: 0.9375rem; font-weight: 600; color: #191c1e; margin-bottom: 0;">
                                Durante la Evaluación</h4>
                        </div>
                        <ul style="list-style: none; padding: 0; margin: 0;" class="d-flex flex-column gap-2">
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check2" style="color: #e67e22; margin-top: 2px;"></i>
                                <span style="font-size: 0.8125rem; color: #564337;">Evaluar dominio verbal y calidad del
                                    contenido.</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check2" style="color: #e67e22; margin-top: 2px;"></i>
                                <span style="font-size: 0.8125rem; color: #564337;">Valorar resultados y respuestas de los
                                    estudiantes.</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check2" style="color: #e67e22; margin-top: 2px;"></i>
                                <span style="font-size: 0.8125rem; color: #564337;">Ser riguroso pero agradable en el
                                    discurso.</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check2" style="color: #e67e22; margin-top: 2px;"></i>
                                <span style="font-size: 0.8125rem; color: #564337;">Usar la sección de observaciones para
                                    feedback.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Al finalizar --}}
                <div class="col-12 col-md-4">
                    <div class="p-4 h-100"
                        style="background-color: #fff; border-radius: 0.75rem; border: 1px solid #E2E8F0;">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle"
                                style="width: 36px; height: 36px; background-color: rgba(230, 126, 34, 0.1); flex-shrink: 0;">
                                <i class="bi bi-send" style="color: #e67e22; font-size: 1rem;"></i>
                            </div>
                            <h4
                                style="font-family: 'Inter', sans-serif; font-size: 0.9375rem; font-weight: 600; color: #191c1e; margin-bottom: 0;">
                                Al Finalizar</h4>
                        </div>
                        <ul style="list-style: none; padding: 0; margin: 0;" class="d-flex flex-column gap-2">
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check2" style="color: #e67e22; margin-top: 2px;"></i>
                                <span style="font-size: 0.8125rem; color: #564337;">Brindar recomendaciones para fortalecer
                                    el proyecto.</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check2" style="color: #e67e22; margin-top: 2px;"></i>
                                <span style="font-size: 0.8125rem; color: #564337;">Invitar a seguir participando en ferias
                                    educativas.</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check2" style="color: #e67e22; margin-top: 2px;"></i>
                                <span style="font-size: 0.8125rem; color: #564337;">Verificar que el formulario esté
                                    completo
                                    antes de enviar.</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-check2" style="color: #e67e22; margin-top: 2px;"></i>
                                <span style="font-size: 0.8125rem; color: #564337;">Firmar el formulario; sin firma es
                                    inválido.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- Perfil del Juez --}}
        <section class="mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="d-inline-block rounded-circle"
                    style="width: 4px; height: 4px; background-color: #e67e22;"></span>
                <h3
                    style="font-family: 'Inter', sans-serif; font-size: 1.25rem; font-weight: 600; color: #191c1e; margin-bottom: 0;">
                    Perfil del Juez</h3>
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex align-items-start gap-3 p-3"
                        style="background-color: #fff; border-radius: 0.5rem; border: 1px solid #E2E8F0;">
                        <i class="bi bi-mortarboard" style="color: #e67e22; font-size: 1.25rem; margin-top: 2px;"></i>
                        <p style="font-size: 0.8125rem; color: #564337; margin-bottom: 0;">Graduado universitario en función
                            de los proyectos a evaluar.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex align-items-start gap-3 p-3"
                        style="background-color: #fff; border-radius: 0.5rem; border: 1px solid #E2E8F0;">
                        <i class="bi bi-book" style="color: #e67e22; font-size: 1.25rem; margin-top: 2px;"></i>
                        <p style="font-size: 0.8125rem; color: #564337; margin-bottom: 0;">Amplios conocimientos o dominio
                            del
                            tema por juzgar.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex align-items-start gap-3 p-3"
                        style="background-color: #fff; border-radius: 0.5rem; border: 1px solid #E2E8F0;">
                        <i class="bi bi-briefcase" style="color: #e67e22; font-size: 1.25rem; margin-top: 2px;"></i>
                        <p style="font-size: 0.8125rem; color: #564337; margin-bottom: 0;">Experiencia en construcción y
                            producción de nuevo conocimiento.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex align-items-start gap-3 p-3"
                        style="background-color: #fff; border-radius: 0.5rem; border: 1px solid #E2E8F0;">
                        <i class="bi bi-heart" style="color: #e67e22; font-size: 1.25rem; margin-top: 2px;"></i>
                        <p style="font-size: 0.8125rem; color: #564337; margin-bottom: 0;">Paciente, con empatía por los
                            estudiantes.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex align-items-start gap-3 p-3"
                        style="background-color: #fff; border-radius: 0.5rem; border: 1px solid #E2E8F0;">
                        <i class="bi bi-chat-dots" style="color: #e67e22; font-size: 1.25rem; margin-top: 2px;"></i>
                        <p style="font-size: 0.8125rem; color: #564337; margin-bottom: 0;">Buen comunicador, capaz de
                            escuchar
                            activamente.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex align-items-start gap-3 p-3"
                        style="background-color: #fff; border-radius: 0.5rem; border: 1px solid #E2E8F0;">
                        <i class="bi bi-eye" style="color: #e67e22; font-size: 1.25rem; margin-top: 2px;"></i>
                        <p style="font-size: 0.8125rem; color: #564337; margin-bottom: 0;">Visión objetiva y sensibilidad
                            subjetiva en la valoración.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="pt-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3"
            style="border-top: 1px solid #E2E8F0;">
            <div>
                <p style="font-size: 0.875rem; color: #564337; margin-bottom: 2px;">© 2026 ExpoTÉCNICA - Comité de
                    Evaluación Técnica</p>
                <p
                    style="font-size: 0.625rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: #897365; margin-bottom: 0;">
                    Versión del Sistema 4.2.1-stable</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ asset('lineamientos-expotecnica-2026.pdf') }}" download
                    class="btn d-inline-flex align-items-center gap-2 text-decoration-none"
                    style="background-color: #d1e4fb; color: #091d2e; padding: 8px 16px; border-radius: 0.5rem; font-weight: 700; font-size: 0.8125rem; transition: all 0.2s;">
                    <i class="bi bi-file-earmark-text"></i>
                    Normativa Completa (PDF)
                </a>
            </div>
        </footer>

    </div>

@endsection