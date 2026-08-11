@extends('plantillas.layout-judge')
@section('Title', 'Dashboard del Juez - ExpoTÉCNICA 2026')
@section('JudgeSidebarActive', 'active')

@section('Main')

  <style>
    .metric-card-judge {
      background-color: #fff;
      border-radius: 0.75rem;
      padding: 20px;
      box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);
      border: 1px solid #E2E8F0;
      transition: all 0.25s ease;
    }

    .metric-card-judge:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(44, 62, 80, 0.1);
    }

    .metric-icon-circle {
      width: 52px;
      height: 52px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .metric-icon-circle i {
      font-size: 1.5rem;
    }

    .progress-bar-custom {
      height: 8px;
      border-radius: 9999px;
      background-color: #e6e8ea;
      overflow: hidden;
    }

    .progress-bar-fill {
      height: 100%;
      border-radius: 9999px;
      transition: width 1s ease;
    }

    .project-card {
      background-color: #fff;
      border-radius: 0.75rem;
      box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);
      border: 1px solid #E2E8F0;
      overflow: hidden;
      transition: all 0.25s ease;
    }

    .project-card:hover {
      border-color: #e67e22;
      box-shadow: 0 8px 24px rgba(148, 74, 0, 0.12);
    }

    .project-card-img {
      width: 100%;
      height: 160px;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .project-card:hover .project-card-img {
      transform: scale(1.05);
    }

    .category-label {
      font-size: 0.6875rem;
      font-weight: 700;
      letter-spacing: 0.05em;
      text-transform: uppercase;
    }

    .btn-evaluar {
      background-color: #e67e22;
      color: #fff;
      border: none;
      height: 48px;
      font-weight: 700;
      font-size: 0.75rem;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      border-radius: 0.5rem;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 0 20px;
      transition: all 0.2s ease;
    }

    .btn-evaluar:hover {
      background-color: #944a00;
      color: #fff;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(230, 126, 34, 0.4);
    }

    .widget-card {
      background-color: #fff;
      border-radius: 0.75rem;
      box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);
      border: 1px solid #E2E8F0;
      overflow: hidden;
    }

    .progress-hero {
      background-color: #e67e22;
      color: #fff;
      border-radius: 0.75rem;
      box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);
      overflow: hidden;
      position: relative;
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

      0%,
      100% {
        opacity: 1;
      }

      50% {
        opacity: 0.4;
      }
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

    .status-badge.pending {
      background-color: #e0e3e5;
      color: #564337;
    }

    .status-badge.partial {
      background-color: #fff3e0;
      color: #944a00;
    }

    .project-card-completed {
      opacity: 0.6;
    }

    .project-card-completed .project-card-img {
      filter: grayscale(100%);
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

    @media (min-width: 768px) {
      .project-card .d-flex.flex-column.flex-md-row>div:first-child {
        flex: 0 0 33.33% !important;
        max-width: 33.33% !important;
        width: auto !important;
      }
    }

    @media (min-width: 1200px) {
      .project-card .project-meta-row .btn-evaluar {
        height: 52px;
        font-size: 0.8125rem;
        padding: 0 24px;
        gap: 10px;
      }
    }

    @media (max-width: 991px) {
      .project-card .project-meta-row {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 12px;
      }

      .project-card .project-meta-row .btn-evaluar {
        width: 100%;
        justify-content: center;
      }
    }

    @media (max-width: 575px) {
      .metric-card-judge {
        padding: 16px;
      }

      .metric-icon-circle {
        width: 44px;
        height: 44px;
      }

      .metric-icon-circle i {
        font-size: 1.25rem;
      }

      .project-card .project-meta-row .btn-evaluar {
        width: 100%;
        justify-content: center;
        height: 44px;
        font-size: 0.6875rem;
        padding: 0 16px;
      }

      .project-card .p-3 {
        padding: 0.75rem !important;
      }
    }

    @media (max-width: 374px) {
      .project-card .project-meta-row .btn-evaluar {
        height: 40px;
        font-size: 0.625rem;
        padding: 0 12px;
        letter-spacing: 0.025em;
      }
    }
  </style>

  @php
    // Obtener todas las rúbricas para validar cuáles aplican a cada proyecto
    $todasLasRubricas = \App\Models\Rubrica::all();

    if (isset($proyectos) && count($proyectos) > 0) {
      $completadosContador = 0;
      $pendientesContador = 0;

      foreach ($proyectos as $p) {
        $idCat = $p->ID_Categoria
          ?? $p->categoria_id
          ?? ($p->categoria->ID_Categoria ?? $p->categoria->id_categoria ?? $p->categoria->id ?? null);

        // Filtrar sólo las rúbricas que realmente aplican a la categoría de este proyecto
        $rubricasAplicables = $todasLasRubricas->filter(function ($r) use ($idCat) {
          $esEscrito = str_contains(mb_strtolower($r->Nombre ?? ''), 'escrito');
          if ($esEscrito) {
            return \App\Models\Apartado::where('ID_Rubrica', $r->ID_Rubrica ?? $r->id)
              ->when($idCat, fn($q) => $q->where('ID_Categoria', $idCat))
              ->exists();
          }
          return true;
        });

        $totalR = $rubricasAplicables->count();

        // Filtrar las rúbricas pendientes conservando sólo las que aplican
        if (isset($p->rubricasPendientes) && $p->rubricasPendientes instanceof \Illuminate\Support\Collection) {
          $pendientesAplicables = $p->rubricasPendientes->filter(function ($r) use ($rubricasAplicables) {
            return $rubricasAplicables->contains('ID_Rubrica', $r->ID_Rubrica ?? $r->id);
          });
        } else {
          $pendientesAplicables = collect();
        }

        $evaluadasCount = max(0, $totalR - $pendientesAplicables->count());
        $isCompletado = ($totalR > 0) && ($pendientesAplicables->count() === 0);
        $isEnProceso = !$isCompletado && ($evaluadasCount > 0);

        if ($isCompletado) {
          $completadosContador++;
        } else {
          $pendientesContador++;
        }

        // Asignar los valores calculados al objeto de proyecto
        $p->calc_totalRubricas = $totalR;
        $p->calc_rubricasEvaluadas = $evaluadasCount;
        $p->calc_rubricasPendientes = $pendientesAplicables;
        $p->calc_completado = $isCompletado;
        $p->calc_enProceso = $isEnProceso;
      }

      $totalAsignadosCalc = count($proyectos);
      $completadosCalc = $completadosContador;
      $pendientesCalc = $pendientesContador;
      $porcentajeGlobalCalc = $totalAsignadosCalc > 0 ? round(($completadosCalc / $totalAsignadosCalc) * 100) : 0;
    } else {
      $totalAsignadosCalc = $totalAsignados ?? 0;
      $completadosCalc = $completados ?? 0;
      $pendientesCalc = $proyectosPendientes ?? 0;
      $porcentajeGlobalCalc = $porcentajeGlobal ?? 0;
    }
  @endphp

  <div style="max-width: 1200px; margin: 0 auto; padding-bottom: 80px;">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3 border-bottom pb-4"
      style="border-color: #E2E8F0 !important;">
      <div style="max-width: 560px;">
        <h1
          style="font-family: 'Inter', sans-serif; font-size: clamp(1.5rem, 4vw, 2rem); font-weight: 700; color: #191c1e; margin-bottom: 4px;">
          Bienvenido, {{ Auth::user()->name ?? 'Juez' }}
        </h1>
        <p style="font-size: 0.9375rem; color: #564337; margin-bottom: 0;">
          Hoy es el gran día. Tienes <strong style="color: #944a00;">{{ $pendientesCalc }}
            proyectos</strong> pendientes de revisión técnica.
        </p>
      </div>
      <div class="d-none d-md-flex align-items-center gap-2"
        style="background-color: #fff; padding: 10px 16px; border-radius: 0.75rem; box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08); border: 1px solid #E2E8F0;">
        <i class="bi bi-calendar-event" style="color: #944a00; font-size: 1.125rem;"></i>
        <span style="font-size: 0.875rem; font-weight: 600; color: #191c1e;">{{ now()->format('d \\d\\e F, Y') }}</span>
      </div>
    </div>

    {{-- Metrics --}}
    <section class="row g-3 mb-4">
      {{-- Total Asignados --}}
      <div class="col-12 col-sm-4">
        <div class="metric-card-judge d-flex align-items-center gap-3">
          <div class="metric-icon-circle" style="background-color: #e6e8ea; color: #944a00;">
            <i class="bi bi-clipboard2-data"></i>
          </div>
          <div>
            <p
              style="font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073; margin-bottom: 2px;">
              Asignados</p>
            <h3
              style="font-family: 'Inter', sans-serif; font-size: 1.5rem; font-weight: 700; color: #191c1e; margin-bottom: 0;">
              {{ $totalAsignadosCalc }}
            </h3>
          </div>
        </div>
      </div>
      {{-- Completados --}}
      <div class="col-12 col-sm-4">
        <div class="metric-card-judge d-flex align-items-center gap-3">
          <div class="metric-icon-circle" style="background-color: rgba(41, 175, 97, 0.12); color: #006d37;">
            <i class="bi bi-check-circle"></i>
          </div>
          <div>
            <p
              style="font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073; margin-bottom: 2px;">
              Completados</p>
            <h3
              style="font-family: 'Inter', sans-serif; font-size: 1.5rem; font-weight: 700; color: #191c1e; margin-bottom: 0;">
              {{ $completadosCalc }}
            </h3>
          </div>
        </div>
      </div>
      {{-- Pendientes --}}
      <div class="col-12 col-sm-4">
        <div class="metric-card-judge d-flex align-items-center gap-3">
          <div class="metric-icon-circle" style="background-color: rgba(148, 74, 0, 0.1); color: #944a00;">
            <i class="bi bi-hourglass-split"></i>
          </div>
          <div>
            <p
              style="font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073; margin-bottom: 2px;">
              Pendientes</p>
            <h3
              style="font-family: 'Inter', sans-serif; font-size: 1.5rem; font-weight: 700; color: #944a00; margin-bottom: 0;">
              {{ $pendientesCalc }}
            </h3>
          </div>
        </div>
      </div>
    </section>

    {{-- Main Grid --}}
    <div class="row g-4">

      {{-- Left Column: Projects to Evaluate --}}
      <div class="col-12 col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h2
            style="font-family: 'Inter', sans-serif; font-size: 1.25rem; font-weight: 600; color: #191c1e; margin-bottom: 0;">
            Proyectos por Evaluar</h2>
          <div class="d-flex gap-2">
            <button class="btn p-2 rounded-circle"
              style="background-color: #f2f4f6; color: #564337; border: none; transition: background-color 0.15s;"
              onmouseover="this.style.backgroundColor='#e6e8ea'" onmouseout="this.style.backgroundColor='#f2f4f6'">
              <i class="bi bi-funnel" style="font-size: 1rem;"></i>
            </button>
            <button class="btn p-2 rounded-circle"
              style="background-color: #f2f4f6; color: #564337; border: none; transition: background-color 0.15s;"
              onmouseover="this.style.backgroundColor='#e6e8ea'" onmouseout="this.style.backgroundColor='#f2f4f6'">
              <i class="bi bi-search" style="font-size: 1rem;"></i>
            </button>
          </div>
        </div>

        <div class="d-flex flex-column gap-6">
          @forelse($proyectos as $proyecto)
            @php
              $evaluado = $proyecto->calc_completado ?? $proyecto->completado;
              $enProceso = $proyecto->calc_enProceso ?? (!$evaluado && $proyecto->rubricasEvaluadas > 0);
              $totalRubricas = $proyecto->calc_totalRubricas ?? $proyecto->totalRubricas;
              $rubricasEvaluadas = $proyecto->calc_rubricasEvaluadas ?? $proyecto->rubricasEvaluadas;
              $rubricasPendientes = $proyecto->calc_rubricasPendientes ?? $proyecto->rubricasPendientes;
            @endphp
            <div class="project-card {{ $evaluado ? 'project-card-completed' : '' }}">
              <div class="d-flex flex-column flex-md-row">
                {{-- Image --}}
                <div style="width: 100%; min-width: 0; max-width: 100%; flex-shrink: 0; overflow: hidden;" class="col-md-4">
                  @if($proyecto->Imagen)
                    <img src="{{ asset('storage/' . $proyecto->Imagen) }}" alt="{{ $proyecto->Nombre }}"
                      class="project-card-img"
                      style="width: 100%; height: 100%; min-height: 160px; max-height: 200px; object-fit: cover;">
                  @else
                    <div class="d-flex align-items-center justify-content-center"
                      style="width: 100%; height: 160px; background-color: #f2f4f6;">
                      <i class="bi bi-image" style="font-size: 2rem; color: #d8dadc;"></i>
                    </div>
                  @endif
                </div>

                {{-- Content --}}
                <div class="p-3 p-md-4 flex-grow-1 d-flex flex-column justify-content-between">
                  <div>
                    <div class="d-flex justify-content-between align-items-start">
                      <div>
                        <p class="category-label mb-1" style="color: {{ $evaluado ? '#4e6073' : '#944a00' }};">
                          {{ $proyecto->categoria->Nombre ?? 'SIN CATEGORÍA' }}
                        </p>
                        <h3
                          style="font-family: 'Inter', sans-serif; font-size: 1.125rem; font-weight: 600; color: #191c1e; margin-bottom: 4px;">
                          {{ $proyecto->Nombre }}
                        </h3>
                        <p
                          style="font-size: 0.875rem; color: #564337; margin-bottom: 0; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">
                          {{ $proyecto->Descripcion ?? 'Sin descripción disponible.' }}
                        </p>
                      </div>
                      @if($evaluado)
                        <span class="status-badge completed">
                          <i class="bi bi-check-circle me-1"></i> Completado
                        </span>
                      @elseif($enProceso)
                        <span class="status-badge partial">
                          <i class="bi bi-hourglass-split me-1"></i> En proceso
                        </span>
                      @else
                        <span class="status-badge pending">Pendiente</span>
                      @endif
                    </div>
                  </div>

                  <div class="d-flex align-items-center justify-content-between mt-3 project-meta-row">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                      <div class="d-flex align-items-center gap-1" style="font-size: 0.875rem; color: #564337;">
                        <i class="bi bi-people" style="font-size: 0.875rem;"></i>
                        <span>{{ $proyecto->personasAsignadas->pluck('usuario.name')->filter()->implode(', ') ?: 'Sin equipo' }}</span>
                      </div>
                      <div class="d-flex align-items-center gap-1" style="font-size: 0.875rem; color: #564337;">
                        <i class="bi bi-layout-text-window-reverse" style="font-size: 0.875rem;"></i>
                        <span>{{ $rubricasEvaluadas }} / {{ $totalRubricas }} rúbricas</span>
                      </div>
                    </div>

                    <a href="{{ route('juez.rubricas', $proyecto->ID_Proyecto) }}" class="btn-evaluar text-decoration-none">

                      @if($evaluado)
                        Ver evaluaciones
                      @elseif($enProceso)
                        Continuar evaluación
                      @else
                        Evaluar proyecto
                      @endif

                      <i class="bi bi-arrow-right"></i>

                    </a>
                  </div>

                  @if(!$evaluado && isset($rubricasPendientes) && $rubricasPendientes->count() > 0)
                    <div class="mt-2" style="font-size: 0.75rem; color: #897365;">
                      <i class="bi bi-exclamation-circle me-1"></i>
                      Falta: {{ $rubricasPendientes->map(fn($r) => $r->Nombre ?? $r->nombre ?? '')->filter()->implode(', ') }}
                    </div>
                  @endif
                </div>
              </div>
            </div>
          @empty
            <div class="widget-card p-5 text-center">
              <i class="bi bi-clipboard2-check"
                style="font-size: 2.5rem; color: #d8dadc; display: block; margin-bottom: 12px;"></i>
              <p style="font-size: 1rem; font-weight: 600; color: #564337; margin-bottom: 4px;">No tienes
                proyectos asignados</p>
              <p style="font-size: 0.875rem; color: #897365; margin-bottom: 0;">Contacta al administrador para
                recibir asignaciones.</p>
            </div>
          @endforelse
        </div>
      </div>

      {{-- Right Column: Sidebar Widgets --}}
      <div class="col-12 col-lg-4 d-flex flex-column gap-4">

        {{-- Global Progress --}}
        <div class="progress-hero p-4">
          <div style="position: relative; z-index: 1;">
            <p
              style="font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; opacity: 0.8; margin-bottom: 4px;">
              Progreso Global</p>
            <h3
              style="font-family: 'Inter', sans-serif; font-size: 1.5rem; font-weight: 700; color: #fff; margin-bottom: 12px;">
              {{ $porcentajeGlobalCalc }}% Finalizado
            </h3>
            <div class="progress-bar-custom" style="background-color: rgba(255,255,255,0.2);">
              <div class="progress-bar-fill" style="background-color: #fff; width: {{ $porcentajeGlobalCalc }}%;"></div>
            </div>
            <p
              style="font-size: 0.75rem; color: rgba(255,255,255,0.7); margin-top: 12px; font-style: italic; margin-bottom: 0;">
              Mantienes un ritmo excelente según el promedio del evento.
            </p>
          </div>
          <i class="bi bi-bar-chart-line-fill"
            style="position: absolute; bottom: -8px; right: 8px; font-size: 6rem; opacity: 0.1;"></i>
        </div>

      </div>
    </div>
  </div>

@endsection