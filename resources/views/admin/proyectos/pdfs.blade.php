@extends('plantillas.layout-admin')

@section('Title', 'Evaluaciones PDF - Admin')
@section('AdminSidebarActive2', 'active')

@section('Main')

  <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3 border-bottom pb-4" style="border-color: #E2E8F0 !important;">
    <div style="max-width: 560px;">
      <div class="mb-2">
        <span class="badge d-inline-flex align-items-center gap-1 rounded-pill px-3 py-2" style="background-color: #eceef0; color: #4e6073; font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase;">
          <i class="bi bi-file-earmark-pdf-fill" style="font-size: 0.75rem;"></i>
          Evaluaciones del proyecto
        </span>
      </div>
      <h1 style="font-family: 'Inter', sans-serif; font-size: clamp(1.75rem, 4vw, 2.5rem); font-weight: 700; color: #191c1e; margin-bottom: 8px;">
        {{ $proyecto->Nombre }}
      </h1>
      <p style="font-size: 0.9375rem; color: #564337; margin-bottom: 0;">
        Documentos PDF de las calificaciones registradas por cada juez.
      </p>
    </div>

    <a href="{{ route('admin.proyectos') }}" class="btn d-inline-flex align-items-center justify-content-center gap-2 px-3 px-sm-4 text-decoration-none" style="height: 48px; background-color: #fff; color: #944a00; font-weight: 600; font-size: 0.875rem; border-radius: 0.5rem; border: 1px solid #944a00; transition: all 0.2s;">
      <i class="bi bi-arrow-left"></i> Volver a Proyectos
    </a>
  </div>

  <div class="mb-3 d-flex flex-wrap gap-2">
    <span class="badge px-2 py-1" style="background-color: #944a00; color: #fff; font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; border-radius: 0.25rem;">
      {{ $proyecto->categoria->Nombre ?? 'Sin categoría' }}
    </span>
  </div>

  @forelse($proyecto->calificaciones as $calificacion)
    <div class="card border-0 mb-3 overflow-hidden" style="background-color: #fff; border: 1px solid #E2E8F0 !important; border-radius: 0.75rem;">
      <div class="p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div class="d-flex align-items-center gap-3" style="min-width: 0;">
          <div class="judge-avatar" style="background-color: #ffb783; color: #301400; width: 44px; height: 44px; font-size: 1rem;">
            <i class="bi bi-person-fill"></i>
          </div>
          <div style="min-width: 0;">
            <div style="font-weight: 700; font-size: 1rem; color: #191c1e;" class="text-truncate">
              {{ $calificacion->usuario->persona->Nombre ?? '' }}
              {{ $calificacion->usuario->persona->Apellido_1 ?? '' }}
              {{ $calificacion->usuario->persona->Apellido_2 ?? '' }}
              @if(!$calificacion->usuario?->persona)
                {{ $calificacion->usuario->name ?? 'Juez eliminado' }}
              @endif
            </div>
            <div style="font-size: 0.8125rem; color: #4e6073;">
              {{ $calificacion->rubrica->Nombre ?? 'Rúbrica' }}
            </div>
          </div>
        </div>

        <div class="d-flex align-items-center gap-3 flex-shrink-0">
          <div class="text-md-end">
            <div style="font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">Nota final</div>
            <div style="font-weight: 700; font-size: 1.25rem; color: #191c1e;">{{ number_format($calificacion->Nota_Final, 2) }}</div>
          </div>
          <div class="text-md-end">
            <div style="font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">Estado</div>
            <span class="badge px-2 py-1" style="background-color: {{ $calificacion->Estado === 'Completado' ? '#e7f7ee' : '#eceef0' }}; color: {{ $calificacion->Estado === 'Completado' ? '#006d37' : '#4e6073' }}; font-size: 0.6875rem; font-weight: 600; border-radius: 0.25rem;">
              {{ $calificacion->Estado ?? 'Pendiente' }}
            </span>
          </div>
          @if($calificacion->ruta_pdf)
            <a href="{{ route('admin.proyectos.pdf', [$proyecto->ID_Proyecto, $calificacion->ID_Calificaciones]) }}" target="_blank"
               class="btn d-inline-flex align-items-center justify-content-center gap-2 text-decoration-none" style="height: 42px; background-color: #944a00; color: #fff; font-weight: 600; font-size: 0.8125rem; border-radius: 0.5rem; border: none;">
              <i class="bi bi-file-earmark-pdf"></i> Ver PDF
            </a>
          @else
            <span class="btn d-inline-flex align-items-center justify-content-center gap-2" style="height: 42px; background-color: #eceef0; color: #8a939c; font-weight: 600; font-size: 0.8125rem; border-radius: 0.5rem; border: none; pointer-events: none;">
              <i class="bi bi-file-earmark-pdf"></i> Sin PDF
            </span>
          @endif
        </div>
      </div>
    </div>
  @empty
    <div class="col-12 text-center py-5">
      <i class="bi bi-inbox" style="font-size: 3rem; color: #d8dadc;"></i>
      <p class="mt-3" style="color: #564337;">Este proyecto aún no tiene evaluaciones registradas.</p>
    </div>
  @endforelse

@endsection
