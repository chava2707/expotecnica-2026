@extends('plantillas.layout-admin')
@section('Title', 'Resultados - ExpoTÉCNICA 2026')
@section('AdminSidebarActiveResultados', 'active')

@section('Styles')
<style>
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

    .widget-card {
        background-color: #fff;
        border-radius: 0.75rem;
        box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);
        border: 1px solid #E2E8F0;
        overflow: hidden;
    }

    .cat-tab {
        padding: 10px 20px;
        border-radius: 9999px;
        border: 1px solid #E2E8F0;
        font-size: 0.8125rem;
        font-weight: 600;
        background-color: #fff;
        color: #564337;
        cursor: pointer;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .cat-tab:hover {
        background-color: #e6e8ea;
    }
    .cat-tab.active {
        background-color: #944a00;
        border-color: #944a00;
        color: #fff;
        box-shadow: 0 2px 8px rgba(148, 74, 0, 0.25);
    }

    .cat-content {
        display: none;
    }
    .cat-content.active {
        display: block;
    }

    .podium-card {
        border-radius: 0.75rem;
        padding: 24px;
        text-align: center;
        transition: all 0.25s ease;
    }
    .podium-card:hover {
        transform: translateY(-4px);
    }
    .podium-card.gold {
        background: linear-gradient(135deg, #ffd700 0%, #f5a623 100%);
        color: #502600;
        box-shadow: 0 8px 24px rgba(255, 215, 0, 0.3);
        padding: 32px 24px;
    }
    .podium-card.silver {
        background: linear-gradient(135deg, #e0e3e5 0%, #b0b4b8 100%);
        color: #191c1e;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    }
    .podium-card.bronze {
        background: linear-gradient(135deg, #cd7f32 0%, #a0522d 100%);
        color: #fff;
        box-shadow: 0 4px 16px rgba(205, 127, 50, 0.25);
    }

    .rank-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-weight: 700;
        font-size: 0.8125rem;
        flex-shrink: 0;
    }
    .rank-badge.gold { background-color: #fff3cd; color: #856404; }
    .rank-badge.silver { background-color: #e2e3e5; color: #383d41; }
    .rank-badge.bronze { background-color: #fde8d0; color: #7c4a1e; }
    .rank-badge.normal { background-color: #e6e8ea; color: #4e6073; }

    .score-bar {
        height: 8px;
        border-radius: 9999px;
        background-color: #e6e8ea;
        overflow: hidden;
    }
    .score-bar-fill {
        height: 100%;
        border-radius: 9999px;
        transition: width 0.6s ease;
    }

    .table-resultados thead th {
        background-color: #2d3133;
        color: #eff1f3;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 14px 20px;
        border-bottom: 1px solid #E2E8F0;
    }
    .table-resultados tbody td {
        padding: 14px 20px;
        border-bottom: 1px solid #E2E8F0;
        vertical-align: middle;
        font-size: 0.875rem;
    }
    .table-resultados tbody tr:hover {
        background-color: #f2f4f6;
    }

    .podium-medal {
        font-size: 1.5rem;
    }

    .badge-pending {
        background-color: #e6e8ea;
        color: #564337;
        padding: 2px 10px;
        border-radius: 9999px;
        font-size: 0.6875rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    .badge-complete {
        background-color: #e6f9ee;
        color: #006d37;
        padding: 2px 10px;
        border-radius: 9999px;
        font-size: 0.6875rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .winner-crown {
        font-size: 2rem;
        display: block;
        margin-bottom: 4px;
    }
</style>
@endsection

@section('Main')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3 border-bottom pb-4" style="border-color: #E2E8F0 !important;">
    <div style="max-width: 560px;">
        <div class="mb-2">
            <span class="badge d-inline-flex align-items-center gap-1 rounded-pill px-3 py-2" style="background-color: #eceef0; color: #4e6073; font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase;">
                <i class="bi bi-bar-chart-fill" style="font-size: 0.75rem;"></i>
                Resultados
            </span>
        </div>
        <h1 style="font-family: 'Inter', sans-serif; font-size: clamp(1.75rem, 4vw, 2.5rem); font-weight: 700; color: #191c1e; margin-bottom: 8px;">
            Resultados Finales
        </h1>
        <p style="font-size: 0.9375rem; color: #564337; margin-bottom: 0;">
            Cuadro de honor y puntajes finales por categoría. Basado en evaluaciones validadas por el comité rector.
        </p>
    </div>
</div>

@if(session('success'))
    <div class="alert d-flex align-items-center gap-2 mb-4" role="alert" style="background-color: #e6f9ee; color: #003a1a; border: 1px solid #29af61; border-radius: 0.5rem; padding: 12px 16px; font-size: 0.875rem; font-weight: 500;">
        <i class="bi bi-check-circle-fill" style="color: #006d37;"></i>
        {{ session('success') }}
    </div>
@endif

@if($resultadosPorCategoria->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-bar-chart" style="font-size: 3rem; color: #d8dadc;"></i>
        <p class="mt-3" style="font-size: 1rem; color: #564337;">No hay categorías registradas. Los resultados aparecerán aquí una vez que se creen categorías y proyectos.</p>
    </div>
@else

<section class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="metric-card primary">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="metric-label">Proyectos Evaluados</span>
                <i class="bi bi-check2-square" style="color: #944a00; font-size: 1.25rem;"></i>
            </div>
            <div class="d-flex align-items-end gap-2">
                <span class="metric-value">{{ $totalEvaluados }}</span>
                <span style="font-size: 0.875rem; color: #564337;">de {{ $totalProyectos }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="metric-card tertiary">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="metric-label">Jueces Evaluando</span>
                <i class="bi bi-person-check" style="color: #006d37; font-size: 1.25rem;"></i>
            </div>
            <div class="d-flex align-items-end gap-2">
                <span class="metric-value" style="color: #006d37;">{{ $totalJuecesActivos }}</span>
                <span style="font-size: 0.875rem; color: #564337;">activos</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="metric-card secondary">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="metric-label">Categorías</span>
                <i class="bi bi-tags" style="color: #4e6073; font-size: 1.25rem;"></i>
            </div>
            <div class="d-flex align-items-end gap-2">
                <span class="metric-value">{{ count($resultadosPorCategoria) }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="metric-card error">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="metric-label">Sin Evaluar</span>
                <i class="bi bi-hourglass-split" style="color: #ba1a1a; font-size: 1.25rem;"></i>
            </div>
            <div class="d-flex align-items-end gap-2">
                <span class="metric-value" style="color: #ba1a1a;">{{ $totalProyectos - $totalEvaluados }}</span>
                <span style="font-size: 0.875rem; color: #564337;">pendientes</span>
            </div>
        </div>
    </div>
</section>

<div class="d-flex gap-2 mb-4 overflow-auto pb-2" id="categoryTabs">
    @foreach($resultadosPorCategoria as $cat)
        <button class="cat-tab {{ $loop->index === $categoriaActiva ? 'active' : '' }}"
                data-cat="{{ $loop->index }}"
                onclick="switchCategoria({{ $loop->index }})">
            <i class="bi bi-folder me-1"></i> {{ $cat['nombre'] }}
        </button>
    @endforeach
</div>

@foreach($resultadosPorCategoria as $cat)
    <div class="cat-content {{ $loop->index === $categoriaActiva ? 'active' : '' }}" data-cat-index="{{ $loop->index }}">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
            <div>
                <h5 style="font-weight: 700; color: #191c1e; margin-bottom: 2px;">
                    {{ $cat['nombre'] }}
                </h5>
                @if($cat['descripcion'])
                    <p style="font-size: 0.8125rem; color: #564337; margin-bottom: 0;">{{ $cat['descripcion'] }}</p>
                @endif
            </div>
            <div class="d-flex gap-3">
                <span style="font-size: 0.75rem; color: #4e6073;">
                    <strong>{{ $cat['evaluadosCount'] }}</strong> evaluados
                </span>
                @if($cat['promedioCategoria'])
                    <span style="font-size: 0.75rem; color: #006d37;">
                        Promedio: <strong>{{ $cat['promedioCategoria'] }}</strong>
                    </span>
                @endif
            </div>
        </div>

        @if($cat['top3']->isNotEmpty())
            <div class="row g-3 mb-4 align-items-end">
                @php $top3 = $cat['top3']; @endphp

                @if($top3->count() >= 2)
                    <div class="col-12 col-md-4 order-2 order-md-1">
                        <div class="podium-card silver">
                            <span class="podium-medal">🥈</span>
                            <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">2º Lugar</div>
                            <div style="font-weight: 700; font-size: 1.125rem;">{{ $top3[1]->nombre }}</div>
                            <div style="font-size: 1.5rem; font-weight: 800; margin-top: 8px;">{{ $top3[1]->promedio }}</div>
                        </div>
                    </div>
                @endif

                @if($top3->count() >= 1)
                    <div class="col-12 col-md-4 order-1 order-md-2" style="margin-top: 0;">
                        <div class="podium-card gold">
                            <span class="winner-crown">👑</span>
                            <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">¡Ganador!</div>
                            <div style="font-weight: 700; font-size: 1.25rem;">{{ $top3[0]->nombre }}</div>
                            <div style="font-size: 2rem; font-weight: 800; margin-top: 8px;">{{ $top3[0]->promedio }}</div>
                        </div>
                    </div>
                @endif

                @if($top3->count() >= 3)
                    <div class="col-12 col-md-4 order-3">
                        <div class="podium-card bronze">
                            <span class="podium-medal">🥉</span>
                            <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">3º Lugar</div>
                            <div style="font-weight: 700; font-size: 1.125rem;">{{ $top3[2]->nombre }}</div>
                            <div style="font-size: 1.5rem; font-weight: 800; margin-top: 8px;">{{ $top3[2]->promedio }}</div>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="text-center py-4" style="color: #897365;">
                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                <p class="mt-2" style="font-size: 0.875rem;">No hay proyectos evaluados en esta categoría todavía.</p>
            </div>
        @endif

        <div class="widget-card">
            <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center" style="border-color: #E2E8F0 !important;">
                <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #4e6073;">
                    Ranking Completo
                </span>
                <span style="font-size: 0.75rem; color: #897365;">
                    {{ $cat['ranking']->count() }} proyectos
                </span>
            </div>
            <div class="table-responsive">
                <table class="table table-resultados mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Proyecto</th>
                            <th class="text-center">Jueces</th>
                            <th class="text-center">Nota Máxima</th>
                            <th class="text-end">Promedio</th>
                            <th style="width: 120px;" class="d-none d-md-table-cell">Desempeño</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cat['ranking'] as $index => $proy)
                            <tr>
                                <td>
                                    @php $rankClass = ($index < 3 && $proy->promedio) ? (['gold', 'silver', 'bronze'][$index] ?? 'normal') : 'normal'; @endphp
                                    <span class="rank-badge {{ $rankClass }}">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #191c1e;">{{ $proy->nombre }}</div>
                                    <div style="font-size: 0.75rem; color: #897365;">
                                        ID: EX-{{ str_pad($proy->id, 4, '0', STR_PAD_LEFT) }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($proy->totalJueces > 0)
                                        <span class="badge-complete">{{ $proy->totalJueces }} juez{{ $proy->totalJueces !== 1 ? 'es' : '' }}</span>
                                    @else
                                        <span class="badge-pending">Sin evaluar</span>
                                    @endif
                                </td>
                                <td class="text-center" style="font-weight: 600;">
                                    {{ $proy->maxima ?? '—' }}
                                </td>
                                <td class="text-end">
                                    @if($proy->promedio)
                                        <span style="font-weight: 700; font-size: 1rem; color: #191c1e;">{{ number_format($proy->promedio, 2) }}</span>
                                    @else
                                        <span style="color: #897365;">—</span>
                                    @endif
                                </td>
                                <td class="d-none d-md-table-cell">
                                    @if($proy->promedio)
                                        <div class="score-bar">
                                            @php
                                                $pct = min(100, ($proy->promedio / 100) * 100);
                                                $color = $pct >= 80 ? '#006d37' : ($pct >= 60 ? '#e67e22' : '#ba1a1a');
                                            @endphp
                                            <div class="score-bar-fill" style="width: {{ $pct }}%; background-color: {{ $color }};"></div>
                                        </div>
                                    @else
                                        <div class="score-bar"><div class="score-bar-fill" style="width: 0%; background-color: #e6e8ea;"></div></div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4" style="color: #897365;">
                                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                    <p class="mt-2" style="font-size: 0.875rem;">No hay proyectos en esta categoría.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endforeach

    <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center" style="border-color: #E2E8F0 !important;">
        <p style="font-size: 0.75rem; color: #897365; margin-bottom: 0;">
            <i class="bi bi-info-circle me-1"></i>
            Los puntajes mostrados corresponden al promedio de todas las evaluaciones realizadas por los jueces asignados.
        </p>
        <span style="font-size: 0.75rem; color: #897365;">
            ExpoTÉCNICA 2026
        </span>
    </div>

    <script>
        function switchCategoria(index) {
            document.querySelectorAll('.cat-tab').forEach(function(t) { t.classList.remove('active'); });
            document.querySelectorAll('.cat-content').forEach(function(c) { c.classList.remove('active'); });

            var tabs = document.querySelectorAll('.cat-tab');
            var contents = document.querySelectorAll('.cat-content');

            if (tabs[index]) tabs[index].classList.add('active');
            if (contents[index]) contents[index].classList.add('active');
        }
    </script>

@endif

@endsection
