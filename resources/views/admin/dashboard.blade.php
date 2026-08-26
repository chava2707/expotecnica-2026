@extends('plantillas.layout-admin')
@section('Title', 'Admin Dashboard - ExpoTÉCNICA 2026')

@section('Main')

<style>
    body { font-family: 'Inter', sans-serif; background-color: #f7f9fb; }

    .sidebar {
        width: 260px;
        background-color: #f2f4f6;
        border-right: 1px solid #E2E8F0;
        transition: transform 0.3s ease;
    }
    .sidebar-nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        border-radius: 0.5rem;
        color: #564337;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.8125rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        transition: all 0.15s ease;
    }
    .sidebar-nav-link:hover {
        background-color: #e6e8ea;
        color: #191c1e;
    }
    .sidebar-nav-link.active {
        background-color: #cfe2f9;
        color: #526478;
    }
    .sidebar-nav-link i {
        font-size: 1.25rem;
    }

    .metric-card {
        background-color: #fff;
        border-radius: 0.75rem;
        padding: 24px;
        box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);
        border-left: 4px solid transparent;
        transition: all 0.25s ease;
    }
    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(44, 62, 80, 0.1);
    }
    .metric-card.primary { border-left-color: #944a00; }
    .metric-card.secondary { border-left-color: #4e6073; }
    .metric-card.tertiary { border-left-color: #006d37; }
    .metric-card.error { border-left-color: #ba1a1a; }

    .metric-label {
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #4e6073;
    }
    .metric-value {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.2;
        letter-spacing: -0.02em;
        color: #191c1e;
    }
    .metric-value.primary { color: #944a00; }
    .metric-value.tertiary { color: #006d37; }
    .metric-value.error { color: #ba1a1a; }

    .progress-bar-custom {
        height: 8px;
        border-radius: 9999px;
        background-color: #e6e8ea;
        overflow: hidden;
    }
    .progress-bar-fill {
        height: 100%;
        border-radius: 9999px;
        transition: width 0.5s ease;
    }
    .progress-bar-fill.primary { background-color: #e67e22; }
    .progress-bar-fill.tertiary { background-color: #29af61; }
    .progress-bar-fill.secondary { background-color: #4e6073; }

    .widget-card {
        background-color: #fff;
        border-radius: 0.75rem;
        box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);
        border: 1px solid #E2E8F0;
        overflow: hidden;
    }

    .category-bar {
        height: 12px;
        border-radius: 9999px;
        background-color: #f2f4f6;
        overflow: hidden;
        display: flex;
    }
    .category-bar-completed {
        background-color: #29af61;
        height: 100%;
    }
    .category-bar-progress {
        background-color: #e67e22;
        height: 100%;
        opacity: 0.5;
    }

    .activity-timeline {
        position: relative;
    }
    .activity-timeline::before {
        content: '';
        position: absolute;
        left: 11px;
        top: 24px;
        bottom: 0;
        width: 2px;
        background-color: #E2E8F0;
    }
    .activity-dot {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }
    .activity-dot i {
        font-size: 0.75rem;
        color: #fff;
    }
    .activity-dot.success { background-color: #29af61; }
    .activity-dot.primary { background-color: #e67e22; }
    .activity-dot.secondary { background-color: #4e6073; }
    .activity-dot.error { background-color: #ba1a1a; }

    .judge-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.75rem;
        flex-shrink: 0;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 0.625rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .status-badge.completed {
        background-color: #29af61;
        color: #fff;
    }
    .status-badge.in-progress {
        background-color: #e0e3e5;
        color: #564337;
    }

    .btn-admin-primary {
        background-color: #944a00;
        color: #fff;
        border: none;
        height: 48px;
        font-weight: 600;
        font-size: 0.875rem;
        border-radius: 0.5rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .btn-admin-primary:hover {
        background-color: #e67e22;
        color: #fff;
        transform: translateY(-1px);
    }

    .table-admin thead {
        background-color: rgba(207, 226, 249, 0.2);
    }
    .table-admin thead th {
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #526478;
        border-bottom: 1px solid #E2E8F0;
        padding: 16px 24px;
    }
    .table-admin tbody td {
        padding: 16px 24px;
        border-bottom: 1px solid #E2E8F0;
        vertical-align: middle;
    }
    .table-admin tbody tr:hover {
        background-color: #e6e8ea;
    }
    .table-admin tbody tr:nth-child(even) {
        background-color: rgba(247, 249, 251, 0.5);
    }

    .fab-btn {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background-color: #e67e22;
        color: #fff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(230, 126, 34, 0.4);
        transition: all 0.2s ease;
        position: relative;
    }
    .fab-btn:hover {
        background-color: #944a00;
        transform: scale(1.05);
        box-shadow: 0 8px 24px rgba(230, 126, 34, 0.5);
    }
    .fab-tooltip {
        position: absolute;
        right: 64px;
        background-color: #2d3133;
        color: #eff1f3;
        padding: 8px 16px;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
    }
    .fab-btn:hover .fab-tooltip {
        opacity: 1;
    }

    .sidebar-user-card {
        border-top: 1px solid #E2E8F0;
        padding-top: 16px;
    }

    .burger-btn {
        display: none;
        position: fixed;
        top: 12px;
        left: 12px;
        z-index: 1030;
        width: 44px;
        height: 44px;
        border-radius: 0.5rem;
        background-color: #fff;
        border: 1px solid #E2E8F0;
        box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);
        color: #2C3E50;
        font-size: 1.25rem;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
    }
    .burger-btn:hover {
        background-color: #FFF3E0;
        color: #E67E22;
    }

    @media (max-width: 767px) {
        .burger-btn {
            display: flex;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1050;
            transform: translateX(-100%);
        }
        .sidebar.show {
            transform: translateX(0);
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0,0,0,0.4);
            z-index: 1040;
        }
        .sidebar-overlay.show {
            display: block;
        }
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #d8dadc;
        border-radius: 10px;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #29af61;
        display: inline-block;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    .empty-state {
        text-align: center;
        padding: 32px 16px;
        color: #4e6073;
    }
    .empty-state i {
        font-size: 2rem;
        margin-bottom: 8px;
        display: block;
    }
</style>

<div class="d-flex" style="height: 100vh; overflow: hidden;">

    <main class="flex-grow-1 d-flex flex-column overflow-hidden">

        <div class="flex-grow-1 overflow-auto custom-scrollbar p-3 p-lg-4" style="background-color: #f7f9fb; padding-top: 60px !important;">

            {{-- Hero Section: Key Metrics --}}
            <section class="row g-3 mb-4" id="metrics-section">
                {{-- Metric Card 1: Proyectos Evaluados --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="metric-card primary">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="metric-label">Proyectos Evaluados</span>
                            <i class="bi bi-check-circle" style="color: #944a00; font-size: 1.25rem;"></i>
                        </div>
                        <div class="d-flex align-items-end gap-2">
                            <span class="metric-value" id="metric-proyectos-pct">{{ $proyectosEvaluadosPct }}%</span>
                        </div>
                        <div class="progress-bar-custom mt-3">
                            <div class="progress-bar-fill primary" id="metric-proyectos-bar" style="width: {{ $proyectosEvaluadosPct }}%;"></div>
                        </div>
                        <p style="font-size: 0.625rem; color: #564337; margin-bottom: 0; margin-top: 12px;">{{ $proyectosConCalificacion ?? $totalProyectos }} de {{ $totalProyectos }} proyectos</p>
                    </div>
                </div>

                {{-- Metric Card 2: Jueces Activos --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="metric-card secondary">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="metric-label">Jueces Activos</span>
                            <i class="bi bi-person-check" style="color: #4e6073; font-size: 1.25rem;"></i>
                        </div>
                        <div class="d-flex align-items-end gap-2">
                            <span class="metric-value" id="metric-jueces">{{ $juecesActivos }}</span>
                            <span style="color: #4e6073; font-size: 0.75rem; font-weight: 600; padding-bottom: 4px;">de {{ $totalJueces }}</span>
                        </div>
                        <p style="font-size: 0.625rem; color: #564337; margin-bottom: 0; margin-top: 12px;">{{ $participacionJueces }}% de participación</p>
                    </div>
                </div>

                {{-- Metric Card 3: Promedio General --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="metric-card tertiary">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="metric-label">Promedio General</span>
                            <i class="bi bi-graph-up" style="color: #006d37; font-size: 1.25rem;"></i>
                        </div>
                        <div class="d-flex align-items-end gap-2">
                            <span class="metric-value tertiary" id="metric-promedio">{{ $promedioGeneral }}</span>
                            <span style="color: #564337; font-size: 0.75rem; font-weight: 600; padding-bottom: 4px;">/100</span>
                        </div>
                        <p style="font-size: 0.625rem; color: #564337; margin-bottom: 0; margin-top: 12px;">Promedio (%) de todas las calificaciones registradas</p>
                    </div>
                </div>

                {{-- Metric Card 4: Evaluaciones Pendientes --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="metric-card error">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="metric-label">Evaluaciones Pendientes</span>
                            <i class="bi bi-clock-history" style="color: #ba1a1a; font-size: 1.25rem;"></i>
                        </div>
                        <div class="d-flex align-items-end gap-2">
                            <span class="metric-value error" id="metric-pendientes">{{ $evaluacionesPendientes }}</span>
                            @if($evaluacionesPendientes > 0)
                            <span style="color: #ba1a1a; font-size: 0.75rem; font-weight: 600; padding-bottom: 4px;" class="d-flex align-items-center gap-1">
                                <i class="bi bi-exclamation-triangle" style="font-size: 0.75rem;"></i> PENDIENTE
                            </span>
                            @endif
                        </div>
                        <p style="font-size: 0.625rem; color: #564337; margin-bottom: 0; margin-top: 12px;">{{ $evaluacionesPendientes }} proyectos sin calificación</p>
                    </div>
                </div>
            </section>

            {{-- Widgets Section --}}
            <section class="row g-4 mb-4">
                {{-- Live Evaluation Status Chart --}}
                <div class="col-12 col-xl-8">
                    <div class="widget-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 style="font-family: 'Inter', sans-serif; font-size: 1.25rem; font-weight: 600; color: #191c1e; margin-bottom: 0;">Estado de Evaluación por Categoría</h2>
                            <div class="d-flex align-items-center gap-2">
                                <span class="pulse-dot"></span>
                                <span style="font-size: 0.75rem; font-weight: 600; color: #29af61;">En Vivo</span>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-3" id="categorias-section">
                            @forelse($categorias as $cat)
                            <div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span style="font-size: 0.875rem; font-weight: 600; color: #191c1e;">{{ $cat['nombre'] }}</span>
                                    <span style="font-size: 0.875rem; font-weight: 600; color: #191c1e;">{{ $cat['porcentaje'] }}%</span>
                                </div>
                                <div class="category-bar">
                                    <div class="category-bar-completed" style="width: {{ $cat['porcentaje'] }}%;"></div>
                                    @if($cat['porcentaje'] < 100)
                                    <div class="category-bar-progress" style="width: {{ min(100 - $cat['porcentaje'], 30) }}%;"></div>
                                    @endif
                                </div>
                                <p style="font-size: 0.625rem; color: #4e6073; margin-top: 4px;">{{ $cat['evaluados'] }} de {{ $cat['total'] }} proyectos evaluados</p>
                            </div>
                            @empty
                            <div class="empty-state">
                                <i class="bi bi-folder-x"></i>
                                <p>No hay categorías registradas</p>
                            </div>
                            @endforelse
                        </div>

                        <div class="mt-4 pt-4 border-top row text-center" style="border-color: #E2E8F0 !important;">
                            <div class="col">
                                <p style="font-size: 0.75rem; font-weight: 600; color: #4e6073; margin-bottom: 4px;">Total Proyectos</p>
                                <p style="font-size: 1.25rem; font-weight: 700; color: #191c1e; margin-bottom: 0;" id="stat-total">{{ number_format($totalProyectos) }}</p>
                            </div>
                            <div class="col">
                                <p style="font-size: 0.75rem; font-weight: 600; color: #4e6073; margin-bottom: 4px;">Calificaciones</p>
                                <p style="font-size: 1.25rem; font-weight: 700; color: #944a00; margin-bottom: 0;" id="stat-calificaciones">{{ number_format($totalEnvios) }}</p>
                            </div>
                            <div class="col">
                                <p style="font-size: 0.75rem; font-weight: 600; color: #4e6073; margin-bottom: 4px;">Pendientes</p>
                                <p style="font-size: 1.25rem; font-weight: 700; color: #ba1a1a; margin-bottom: 0;" id="stat-pendientes-footer">{{ number_format($evaluacionesPendientes) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Recent Activity Feed --}}
                <div class="col-12 col-xl-4">
                    <div class="widget-card p-4 d-flex flex-column" style="height: 100%;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 style="font-family: 'Inter', sans-serif; font-size: 1.25rem; font-weight: 600; color: #191c1e; margin-bottom: 0;">Actividad Reciente</h2>
                            <span class="pulse-dot"></span>
                        </div>

                        <div class="overflow-auto custom-scrollbar activity-timeline flex-grow-1" id="actividad-section" style="max-height: 270px;">
                            @forelse($actividadReciente as $actividad)
                            <div class="d-flex gap-3 pb-4">
                                <div class="activity-dot success">
                                    <i class="bi bi-person-plus-fill"></i>
                                </div>
                                <div>
                                    <p style="font-size: 0.875rem; color: #191c1e; margin-bottom: 4px;">
                                        <strong>{{ $actividad['usuario'] }}</strong> registrado como <strong style="color: #944a00;">{{ $actividad['rol'] }}</strong>.
                                    </p>
                                    <span style="font-size: 0.75rem; color: #4e6073;">{{ $actividad['fecha']->diffForHumans() }}</span>
                                </div>
                            </div>
                            @empty
                            <div class="empty-state">
                                <i class="bi bi-activity"></i>
                                <p>No hay actividad reciente</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>

            {{-- Solicitudes de Edición Pendientes --}}
            <section id="solicitudes-section" style="@if($solicitudesPendientes->count() === 0) display:none; @endif">
            <div class="widget-card mb-4" style="border: 1px solid #ffcc80; background-color: #fff8e1;">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-bell-fill" style="color: #e65100; font-size: 1.25rem;"></i>
                            <h2 style="font-family: 'Inter', sans-serif; font-size: 1.125rem; font-weight: 600; color: #bf360c; margin-bottom: 0;">
                                Solicitudes de Edición Pendientes
                            </h2>
                            <span id="solicitudes-count" style="background:#e65100;color:#fff;padding:2px 10px;border-radius:9999px;font-size:.7rem;font-weight:700;">
                                {{ $solicitudesPendientes->count() }}
                            </span>
                        </div>
                        <a href="{{ route('admin.solicitudes') }}" style="font-size:.8125rem;font-weight:600;color:#e65100;text-decoration:none;">
                            Ver todas <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <div id="solicitudes-list" class="d-flex flex-column gap-2">
                        @foreach($solicitudesPendientes->take(5) as $solicitud)
                        <div class="d-flex align-items-center justify-content-between p-3" style="background:#fff;border-radius:10px;border:1px solid #ffe0b2;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="judge-avatar" style="background-color:#ffcc80;color:#bf360c;">
                                    {{ strtoupper(substr($solicitud->usuario->name ?? 'J', 0, 2)) }}
                                </div>
                                <div>
                                    <p style="font-size:.875rem;font-weight:600;color:#191c1e;margin-bottom:2px;">
                                        {{ $solicitud->usuario->name ?? 'Juez' }}
                                        <span style="font-weight:400;color:#564337;"> solicita editar</span>
                                        <strong style="color:#944a00;">{{ $solicitud->calificacion->proyecto->Nombre ?? 'Proyecto' }}</strong>
                                    </p>
                                    @if($solicitud->Motivo)
                                    <p style="font-size:.75rem;color:#897365;margin-bottom:0;font-style:italic;">
                                        "{{ Str::limit($solicitud->Motivo, 80) }}"
                                    </p>
                                    @endif
                                    <p style="font-size:.6875rem;color:#897365;margin-bottom:0;">
                                        {{ $solicitud->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.solicitudes.aprobar', $solicitud->ID_Solicitud) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="height:34px;padding:0 14px;border:none;border-radius:8px;background:#2e7d32;color:#fff;font-weight:600;font-size:.75rem;cursor:pointer;display:inline-flex;align-items:center;gap:4px;">
                                        <i class="bi bi-check-lg"></i> Aprobar
                                    </button>
                                </form>
                                <form action="{{ route('admin.solicitudes.rechazar', $solicitud->ID_Solicitud) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="height:34px;padding:0 14px;border:none;border-radius:8px;background:#ba1a1a;color:#fff;font-weight:600;font-size:.75rem;cursor:pointer;display:inline-flex;align-items:center;gap:4px;">
                                        <i class="bi bi-x-lg"></i> Rechazar
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            </section>

            {{-- Alertas de Ayuda Pendientes --}}
            <section id="ayudas-section" style="@if($ayudasPendientes->count() === 0) display:none; @endif">
            <div class="widget-card mb-4" style="border: 1px solid #ef9a9a; background-color: #ffebee;">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-headset" style="color: #c62828; font-size: 1.25rem;"></i>
                            <h2 style="font-family: 'Inter', sans-serif; font-size: 1.125rem; font-weight: 600; color: #b71c1c; margin-bottom: 0;">
                                Jueces Solicitando Ayuda
                            </h2>
                            <span id="ayudas-count" style="background:#c62828;color:#fff;padding:2px 10px;border-radius:9999px;font-size:.7rem;font-weight:700;">
                                {{ $ayudasPendientes->count() }}
                            </span>
                        </div>
                        <a href="{{ route('admin.ayudas') }}" style="font-size:.8125rem;font-weight:600;color:#c62828;text-decoration:none;">
                            Ver todas <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <div id="ayudas-list" class="d-flex flex-column gap-2">
                        @foreach($ayudasPendientes->take(5) as $ayuda)
                        <div class="d-flex align-items-center justify-content-between p-3" style="background:#fff;border-radius:10px;border:1px solid #ef9a9a;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="judge-avatar" style="background-color:#ef9a9a;color:#b71c1c;">
                                    {{ strtoupper(substr($ayuda->usuario->name ?? 'J', 0, 2)) }}
                                </div>
                                <div>
                                    <p style="font-size:.875rem;font-weight:600;color:#191c1e;margin-bottom:2px;">
                                        <strong>{{ $ayuda->usuario->name ?? 'Juez' }}</strong>
                                        <span style="font-weight:400;color:#564337;">necesita asistencia</span>
                                    </p>
                                    @if($ayuda->Mensaje)
                                    <p style="font-size:.75rem;color:#897365;margin-bottom:0;font-style:italic;">
                                        "{{ Str::limit($ayuda->Mensaje, 80) }}"
                                    </p>
                                    @endif
                                    <p style="font-size:.6875rem;color:#897365;margin-bottom:0;">
                                        {{ $ayuda->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.ayudas.resolver', $ayuda->ID_Solicitud) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="height:34px;padding:0 14px;border:none;border-radius:8px;background:#2e7d32;color:#fff;font-weight:600;font-size:.75rem;cursor:pointer;display:inline-flex;align-items:center;gap:4px;">
                                        <i class="bi bi-check-lg"></i> Atendida
                                    </button>
                                </form>
                                <form action="{{ route('admin.ayudas.cancelar', $ayuda->ID_Solicitud) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="height:34px;padding:0 14px;border:none;border-radius:8px;background:#78909c;color:#fff;font-weight:600;font-size:.75rem;cursor:pointer;display:inline-flex;align-items:center;gap:4px;">
                                        <i class="bi bi-x-lg"></i> Cancelar
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            </section>

            {{-- Avisos de Impresión Pendientes --}}
            <section id="avisos-section" style="@if($avisosPendientes->count() === 0) display:none; @endif">
            <div class="widget-card mb-4" style="border: 1px solid #ffcc80; background-color: #fff8e1;">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-printer-fill" style="color: #e65100; font-size: 1.25rem;"></i>
                            <h2 style="font-family: 'Inter', sans-serif; font-size: 1.125rem; font-weight: 600; color: #bf360c; margin-bottom: 0;">
                                Documentos Impresos por Recoger
                            </h2>
                            <span id="avisos-count" style="background:#e65100;color:#fff;padding:2px 10px;border-radius:9999px;font-size:.7rem;font-weight:700;">
                                {{ $avisosPendientes->count() }}
                            </span>
                        </div>
                        <a href="{{ route('admin.avisos') }}" style="font-size:.8125rem;font-weight:600;color:#e65100;text-decoration:none;">
                            Ver todas <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <div id="avisos-list" class="d-flex flex-column gap-2">
                        @foreach($avisosPendientes->take(5) as $aviso)
                        <div class="d-flex align-items-center justify-content-between p-3" style="background:#fff;border-radius:10px;border:1px solid #ffe0b2;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="judge-avatar" style="background-color:#ffcc80;color:#bf360c;">
                                    <i class="bi bi-printer-fill"></i>
                                </div>
                                <div>
                                    <p style="font-size:.875rem;font-weight:600;color:#191c1e;margin-bottom:2px;">
                                        <strong style="color:#944a00;">{{ $aviso->correo?->proyecto?->Nombre ?? 'Proyecto' }}</strong>
                                        <span style="font-weight:400;color:#564337;"> listo para recoger</span>
                                    </p>
                                    <p style="font-size:.6875rem;color:#897365;margin-bottom:0;">
                                        {{ $aviso->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <form action="{{ route('admin.avisos.recoger', $aviso->ID_Aviso) }}" method="POST">
                                @csrf
                                <button type="submit" style="height:34px;padding:0 14px;border:none;border-radius:8px;background:#2e7d32;color:#fff;font-weight:600;font-size:.75rem;cursor:pointer;display:inline-flex;align-items:center;gap:4px;">
                                    <i class="bi bi-check-lg"></i> Recogido
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            </section>

            {{-- Judge Management Table --}}
            <section class="widget-card" id="jueces-section">
                <div class="p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <h2 style="font-family: 'Inter', sans-serif; font-size: 1.25rem; font-weight: 600; color: #191c1e; margin-bottom: 4px;">Gestión de Jueces</h2>
                        <p style="font-size: 0.875rem; color: #4e6073; margin-bottom: 0;">Seguimiento en tiempo real del progreso de evaluación por juez asignado.</p>
                    </div>
                    <a href="{{ route('admin.usuarios') }}" class="btn-admin-primary text-decoration-none p-3">
                        <i class="bi bi-plus-lg"></i> Ver Usuarios
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-admin mb-0">
                        <thead>
                            <tr>
                                <th>Juez</th>
                                <th>Rol</th>
                                <th>Proyectos Asignados</th>
                                <th>Progreso</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jueces as $juez)
                            <tr class="juez-row" style="cursor: pointer;" onclick="toggleJudgeDetail({{ $juez['id'] }})">
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="judge-avatar" style="background-color: {{ ['#ffb783','#d1e4fb','#61de8a','#e8d5f5','#f5d5d5'][($juez['id'] % 5)] }}; color: #191c1e;">
                                            {{ strtoupper(substr($juez['nombre'], 0, 2)) }}
                                        </div>
                                        <div>
                                            <strong style="color: #191c1e;">{{ $juez['nombre'] }}</strong>
                                            <i class="bi bi-chevron-down" style="font-size: 12px; color: #897365; margin-left: 4px;" id="chevron-{{ $juez['id'] }}"></i>
                                        </div>
                                    </div>
                                </td>
                                <td style="color: #564337;">{{ $juez['rol'] }}</td>
                                <td style="color: #564337;">{{ $juez['total_asignados'] }} Proyectos</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="progress-bar-custom flex-grow-1" style="min-width: 100px;">
                                            <div class="progress-bar-fill {{ $juez['completado'] ? 'tertiary' : 'primary' }}" style="width: {{ $juez['progreso'] }}%;"></div>
                                        </div>
                                        <span style="font-size: 0.75rem; font-weight: 700; color: {{ $juez['completado'] ? '#006d37' : '#4e6073' }};">{{ $juez['progreso'] }}%</span>
                                    </div>
                                </td>
                                <td>
                                    @if($juez['completado'])
                                        <span class="status-badge completed">Completado</span>
                                    @elseif($juez['total_asignados'] > 0)
                                        <span class="status-badge in-progress">En Progreso</span>
                                    @else
                                        <span class="status-badge" style="background-color: #f2f4f6; color: #4e6073;">Sin Asignar</span>
                                    @endif
                                </td>
                            </tr>
                            {{-- Detalle expandible --}}
                            <tr id="detail-{{ $juez['id'] }}" style="display: none;">
                                <td colspan="5" style="padding: 0; border-bottom: 2px solid #E2E8F0;">
                                    <div style="padding: 16px 24px 20px; background-color: #f9fafb;">
                                        @forelse($juez['proyectos'] as $proy)
                                        <div style="background: #fff; border: 1px solid #E2E8F0; border-radius: 10px; padding: 14px 18px; margin-bottom: 10px;">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <span style="font-size: 0.875rem; font-weight: 700; color: #191c1e;">{{ $proy['nombre'] }}</span>
                                                    <span style="font-size: 0.75rem; color: #897365; margin-left: 8px;">{{ $proy['categoria'] }}</span>
                                                </div>
                                                <div>
                                                    @if($proy['completado'])
                                                        <span class="status-badge completed" style="font-size: 0.5625rem;">Completado</span>
                                                    @else
                                                        <span class="status-badge in-progress" style="font-size: 0.5625rem;">{{ $proy['evaluadas'] }}/{{ $proy['total_rubricas'] }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="d-flex gap-3 flex-wrap">
                                                @foreach($proy['rubricas'] as $rub)
                                                <div style="display: flex; align-items: center; gap: 6px; font-size: 0.75rem;">
                                                    @if($rub['evaluada'] && $rub['estado'] === 'Completado')
                                                        <i class="bi bi-check-circle-fill" style="font-size: 16px; color: #29af61;"></i>
                                                        <span style="font-weight: 600; color: #006d37;">{{ $rub['nombre'] }}</span>
                                                        <span style="color: #897365;">({{ $rub['nota'] }})</span>
                                                    @elseif($rub['evaluada'] && $rub['estado'] === 'Borrador')
                                                        <i class="bi bi-pencil-square" style="font-size: 16px; color: #e67e22;"></i>
                                                        <span style="font-weight: 600; color: #944a00;">{{ $rub['nombre'] }}</span>
                                                        <span style="color: #897365;">(Borrador)</span>
                                                    @else
                                                        <i class="bi bi-circle" style="font-size: 16px; color: #d8dadc;"></i>
                                                        <span style="font-weight: 600; color: #897365;">{{ $rub['nombre'] }}</span>
                                                        <span style="color: #d8dadc;">(Pendiente)</span>
                                                    @endif
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @empty
                                        <div style="text-align: center; color: #897365; font-size: 0.8125rem; padding: 12px;">
                                            No hay proyectos asignados.
                                        </div>
                                        @endforelse
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="bi bi-people"></i>
                                        <p>No hay jueces registrados</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

        </div>

        <button class="fab-btn d-none d-md-flex" style="position: fixed; bottom: 24px; right: 24px;">
            <i class="bi bi-plus-lg"></i>
            <span class="fab-tooltip">Crear Nuevo Evento</span>
        </button>

    </main>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }

    function toggleJudgeDetail(juezId) {
        const detail = document.getElementById('detail-' + juezId);
        const chevron = document.getElementById('chevron-' + juezId);
        if (detail.style.display === 'none') {
            detail.style.display = '';
            if (chevron) { chevron.classList.remove('bi-chevron-down'); chevron.classList.add('bi-chevron-up'); }
        } else {
            detail.style.display = 'none';
            if (chevron) { chevron.classList.remove('bi-chevron-up'); chevron.classList.add('bi-chevron-down'); }
        }
    }

    const API_URL = "{{ route('admin.dashboard.api') }}";

    function formatNumber(n) {
        return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function timeAgo(dateStr) {
        const date = new Date(dateStr);
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);
        if (seconds < 60) return 'Hace unos segundos';
        const minutes = Math.floor(seconds / 60);
        if (minutes < 60) return 'Hace ' + minutes + ' minuto' + (minutes > 1 ? 's' : '');
        const hours = Math.floor(minutes / 60);
        if (hours < 24) return 'Hace ' + hours + ' hora' + (hours > 1 ? 's' : '');
        const days = Math.floor(hours / 24);
        return 'Hace ' + days + ' día' + (days > 1 ? 's' : '');
    }

    const avatarColors = ['#ffb783','#d1e4fb','#61de8a','#e8d5f5','#f5d5d5'];

    function refreshDashboard() {
        fetch(API_URL)
            .then(res => res.json())
            .then(data => {
                document.getElementById('metric-proyectos-pct').textContent = data.proyectosEvaluadosPct + '%';
                document.getElementById('metric-proyectos-bar').style.width = data.proyectosEvaluadosPct + '%';
                document.getElementById('metric-jueces').textContent = data.juecesActivos;
                document.getElementById('metric-promedio').textContent = data.promedioGeneral;
                document.getElementById('metric-pendientes').textContent = data.evaluacionesPendientes;
                document.getElementById('stat-total').textContent = formatNumber(data.totalProyectos);
                document.getElementById('stat-calificaciones').textContent = formatNumber(data.totalEnvios);
                document.getElementById('stat-pendientes-footer').textContent = formatNumber(data.evaluacionesPendientes);

                const catSection = document.getElementById('categorias-section');
                if (data.categorias.length === 0) {
                    catSection.innerHTML = '<div class="empty-state"><i class="bi bi-folder-x"></i><p>No hay categorías registradas</p></div>';
                } else {
                    catSection.innerHTML = data.categorias.map(cat => `
                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <span style="font-size: 0.875rem; font-weight: 600; color: #191c1e;">${cat.nombre}</span>
                                <span style="font-size: 0.875rem; font-weight: 600; color: #191c1e;">${cat.porcentaje}%</span>
                            </div>
                            <div class="category-bar">
                                <div class="category-bar-completed" style="width: ${cat.porcentaje}%;"></div>
                                ${cat.porcentaje < 100 ? `<div class="category-bar-progress" style="width: ${Math.min(100 - cat.porcentaje, 30)}%;"></div>` : ''}
                            </div>
                            <p style="font-size: 0.625rem; color: #4e6073; margin-top: 4px;">${cat.evaluados} de ${cat.total} proyectos evaluados</p>
                        </div>
                    `).join('');
                }

                const actSection = document.getElementById('actividad-section');
                if (data.actividadReciente.length === 0) {
                    actSection.innerHTML = '<div class="empty-state"><i class="bi bi-activity"></i><p>No hay actividad reciente</p></div>';
                } else {
                    actSection.innerHTML = data.actividadReciente.map(a => `
                        <div class="d-flex gap-3 pb-4">
                            <div class="activity-dot success">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <div>
                                <p style="font-size: 0.875rem; color: #191c1e; margin-bottom: 4px;">
                                    <strong>${a.usuario}</strong> registrado como <strong style="color: #944a00;">${a.rol}</strong>.
                                </p>
                                <span style="font-size: 0.75rem; color: #4e6073;">${timeAgo(a.fecha)}</span>
                            </div>
                        </div>
                    `).join('');
                }

                const juecesBody = document.querySelector('#jueces-section tbody');
                if (data.jueces.length === 0) {
                    juecesBody.innerHTML = '<tr><td colspan="5"><div class="empty-state"><i class="bi bi-people"></i><p>No hay jueces registrados</p></div></td></tr>';
                } else {
                    juecesBody.innerHTML = data.jueces.map(j => {
                        const proyectosHtml = (j.proyectos || []).map(p => {
                            const rubricasHtml = p.rubricas.map(r => {
                                if (r.evaluada && r.estado === 'Completado') {
                                    return `<div style="display:flex;align-items:center;gap:6px;font-size:0.75rem;"><i class="bi bi-check-circle-fill" style="font-size:16px;color:#29af61;"></i><span style="font-weight:600;color:#006d37;">${r.nombre}</span><span style="color:#897365;">(${r.nota})</span></div>`;
                                } else if (r.evaluada && r.estado === 'Borrador') {
                                    return `<div style="display:flex;align-items:center;gap:6px;font-size:0.75rem;"><i class="bi bi-pencil-square" style="font-size:16px;color:#e67e22;"></i><span style="font-weight:600;color:#944a00;">${r.nombre}</span><span style="color:#897365;">(Borrador)</span></div>`;
                                } else {
                                    return `<div style="display:flex;align-items:center;gap:6px;font-size:0.75rem;"><i class="bi bi-circle" style="font-size:16px;color:#d8dadc;"></i><span style="font-weight:600;color:#897365;">${r.nombre}</span><span style="color:#d8dadc;">(Pendiente)</span></div>`;
                                }
                            }).join('');

                            return `<div style="background:#fff;border:1px solid #E2E8F0;border-radius:10px;padding:14px 18px;margin-bottom:10px;"><div class="d-flex justify-content-between align-items-center mb-2"><div><span style="font-size:0.875rem;font-weight:700;color:#191c1e;">${p.nombre}</span><span style="font-size:0.75rem;color:#897365;margin-left:8px;">${p.categoria}</span></div><div>${p.completado ? '<span class="status-badge completed" style="font-size:0.5625rem;">Completado</span>' : '<span class="status-badge in-progress" style="font-size:0.5625rem;">' + p.evaluadas + '/' + p.total_rubricas + '</span>'}</div></div><div class="d-flex gap-3 flex-wrap">${rubricasHtml}</div></div>`;
                        }).join('');

                        const detalleHtml = proyectosHtml || '<div style="text-align:center;color:#897365;font-size:0.8125rem;padding:12px;">No hay proyectos asignados.</div>';

                        return `
                        <tr class="juez-row" style="cursor:pointer;" onclick="toggleJudgeDetail(${j.id})">
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="judge-avatar" style="background-color: ${avatarColors[j.id % 5]}; color: #191c1e;">
                                        ${j.nombre.substring(0, 2).toUpperCase()}
                                    </div>
                                    <div>
                                        <strong style="color: #191c1e;">${j.nombre}</strong>
                                        <i class="bi bi-chevron-down" style="font-size:12px;color:#897365;margin-left:4px;" id="chevron-${j.id}"></i>
                                    </div>
                                </div>
                            </td>
                            <td style="color: #564337;">${j.rol}</td>
                            <td style="color: #564337;">${j.total_asignados} Proyectos</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="progress-bar-custom flex-grow-1" style="min-width: 100px;">
                                        <div class="progress-bar-fill ${j.completado ? 'tertiary' : 'primary'}" style="width: ${j.progreso}%;"></div>
                                    </div>
                                    <span style="font-size: 0.75rem; font-weight: 700; color: ${j.completado ? '#006d37' : '#4e6073'};">${j.progreso}%</span>
                                </div>
                            </td>
                            <td>
                                ${j.completado
                                    ? '<span class="status-badge completed">Completado</span>'
                                    : j.total_asignados > 0
                                        ? '<span class="status-badge in-progress">En Progreso</span>'
                                        : '<span class="status-badge" style="background-color: #f2f4f6; color: #4e6073;">Sin Asignar</span>'
                                }
                            </td>
                        </tr>
                        <tr id="detail-${j.id}" style="display:none;"><td colspan="5" style="padding:0;border-bottom:2px solid #E2E8F0;"><div style="padding:16px 24px 20px;background-color:#f9fafb;">${detalleHtml}</div></td></tr>`;
                    }).join('');
                }

                const solicitudesSection = document.getElementById('solicitudes-section');
                const solicitudesList = document.getElementById('solicitudes-list');
                const solicitudesCount = document.getElementById('solicitudes-count');
                if (data.solicitudesPendientesJson.length === 0) {
                    solicitudesSection.style.display = 'none';
                } else {
                    solicitudesSection.style.display = '';
                    solicitudesCount.textContent = data.solicitudesPendientesJson.length;
                    solicitudesList.innerHTML = data.solicitudesPendientesJson.slice(0, 5).map(s => `
                        <div class="d-flex align-items-center justify-content-between p-3" style="background:#fff;border-radius:10px;border:1px solid #ffe0b2;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="judge-avatar" style="background-color:#ffcc80;color:#bf360c;">
                                    ${s.usuario_name ? s.usuario_name.substring(0, 2).toUpperCase() : 'J'}
                                </div>
                                <div>
                                    <p style="font-size:.875rem;font-weight:600;color:#191c1e;margin-bottom:2px;">
                                        ${s.usuario_name || 'Juez'}
                                        <span style="font-weight:400;color:#564337;"> solicita editar</span>
                                        <strong style="color:#944a00;">${s.proyecto_nombre || 'Proyecto'}</strong>
                                    </p>
                                    ${s.motivo ? `<p style="font-size:.75rem;color:#897365;margin-bottom:0;font-style:italic;">"${s.motivo.substring(0, 80)}"</p>` : ''}
                                    <p style="font-size:.6875rem;color:#897365;margin-bottom:0;">${timeAgo(s.created_at)}</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <form action="/admin/solicitudes/${s.id}/aprobar" method="POST">
                                    <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                                    <button type="submit" style="height:34px;padding:0 14px;border:none;border-radius:8px;background:#2e7d32;color:#fff;font-weight:600;font-size:.75rem;cursor:pointer;display:inline-flex;align-items:center;gap:4px;">
                                        <i class="bi bi-check-lg"></i> Aprobar
                                    </button>
                                </form>
                                <form action="/admin/solicitudes/${s.id}/rechazar" method="POST">
                                    <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                                    <button type="submit" style="height:34px;padding:0 14px;border:none;border-radius:8px;background:#ba1a1a;color:#fff;font-weight:600;font-size:.75rem;cursor:pointer;display:inline-flex;align-items:center;gap:4px;">
                                        <i class="bi bi-x-lg"></i> Rechazar
                                    </button>
                                </form>
                            </div>
                        </div>
                    `).join('');
                }

                const ayudasSection = document.getElementById('ayudas-section');
                const ayudasList = document.getElementById('ayudas-list');
                const ayudasCount = document.getElementById('ayudas-count');
                if (data.ayudasPendientesJson.length === 0) {
                    ayudasSection.style.display = 'none';
                } else {
                    ayudasSection.style.display = '';
                    ayudasCount.textContent = data.ayudasPendientesJson.length;
                    ayudasList.innerHTML = data.ayudasPendientesJson.slice(0, 5).map(a => `
                        <div class="d-flex align-items-center justify-content-between p-3" style="background:#fff;border-radius:10px;border:1px solid #ef9a9a;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="judge-avatar" style="background-color:#ef9a9a;color:#b71c1c;">
                                    ${a.usuario_name ? a.usuario_name.substring(0, 2).toUpperCase() : 'J'}
                                </div>
                                <div>
                                    <p style="font-size:.875rem;font-weight:600;color:#191c1e;margin-bottom:2px;">
                                        <strong>${a.usuario_name || 'Juez'}</strong>
                                        <span style="font-weight:400;color:#564337;">necesita asistencia</span>
                                    </p>
                                    ${a.mensaje ? `<p style="font-size:.75rem;color:#897365;margin-bottom:0;font-style:italic;">"${a.mensaje.substring(0, 80)}"</p>` : ''}
                                    <p style="font-size:.6875rem;color:#897365;margin-bottom:0;">${timeAgo(a.created_at)}</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <form action="/admin/ayudas/${a.id}/resolver" method="POST">
                                    <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                                    <button type="submit" style="height:34px;padding:0 14px;border:none;border-radius:8px;background:#2e7d32;color:#fff;font-weight:600;font-size:.75rem;cursor:pointer;display:inline-flex;align-items:center;gap:4px;">
                                        <i class="bi bi-check-lg"></i> Atendida
                                    </button>
                                </form>
                                <form action="/admin/ayudas/${a.id}/cancelar" method="POST">
                                    <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                                    <button type="submit" style="height:34px;padding:0 14px;border:none;border-radius:8px;background:#78909c;color:#fff;font-weight:600;font-size:.75rem;cursor:pointer;display:inline-flex;align-items:center;gap:4px;">
                                        <i class="bi bi-x-lg"></i> Cancelar
                                    </button>
                                </form>
                            </div>
                        </div>
                    `).join('');
                }

                const avisosSection = document.getElementById('avisos-section');
                const avisosList = document.getElementById('avisos-list');
                const avisosCount = document.getElementById('avisos-count');
                if (data.avisosPendientesJson.length === 0) {
                    avisosSection.style.display = 'none';
                } else {
                    avisosSection.style.display = '';
                    avisosCount.textContent = data.avisosPendientesJson.length;
                    avisosList.innerHTML = data.avisosPendientesJson.slice(0, 5).map(a => `
                        <div class="d-flex align-items-center justify-content-between p-3" style="background:#fff;border-radius:10px;border:1px solid #ffe0b2;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="judge-avatar" style="background-color:#ffcc80;color:#bf360c;">
                                    <i class="bi bi-printer-fill"></i>
                                </div>
                                <div>
                                    <p style="font-size:.875rem;font-weight:600;color:#191c1e;margin-bottom:2px;">
                                        <strong style="color:#944a00;">${a.proyecto_nombre}</strong>
                                        <span style="font-weight:400;color:#564337;"> listo para recoger</span>
                                    </p>
                                    <p style="font-size:.6875rem;color:#897365;margin-bottom:0;">${timeAgo(a.created_at)}</p>
                                </div>
                            </div>
                            <form action="/admin/avisos/${a.id}/recoger" method="POST">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                                <button type="submit" style="height:34px;padding:0 14px;border:none;border-radius:8px;background:#2e7d32;color:#fff;font-weight:600;font-size:.75rem;cursor:pointer;display:inline-flex;align-items:center;gap:4px;">
                                    <i class="bi bi-check-lg"></i> Recogido
                                </button>
                            </form>
                        </div>
                    `).join('');
                }
            })
            .catch(err => console.error('Error actualizando dashboard:', err));
    }

    setInterval(refreshDashboard, 30000);

    document.addEventListener('DOMContentLoaded', () => {
        const sidebarLinks = document.querySelectorAll('.sidebar-nav-link');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                if (link.getAttribute('href') === '#') {
                    e.preventDefault();
                    sidebarLinks.forEach(l => l.classList.remove('active'));
                    link.classList.add('active');
                }
            });
        });
    });
</script>

@endsection
