@extends('plantillas.layout-admin')

@section('Title', 'Proyectos - Admin')
@section('AdminSidebarActive2', 'active')

@section('Main')

  <style>
    .card-hover:hover {
      border-color: #944a00 !important;
      box-shadow: 0 12px 24px rgba(44, 62, 80, 0.06);
    }

    .card-hover:hover .img-wrapper img {
      transform: scale(1.05);
    }

    .text-truncate-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      white-space: normal;
    }
  </style>

  <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3 border-bottom pb-4" style="border-color: #E2E8F0 !important;">
    <div style="max-width: 560px;">
      <div class="mb-2">
        <span class="badge d-inline-flex align-items-center gap-1 rounded-pill px-3 py-2" style="background-color: #eceef0; color: #4e6073; font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase;">
          <i class="bi bi-folder-fill" style="font-size: 0.75rem;"></i>
          Administración
        </span>
      </div>
      <h1 style="font-family: 'Inter', sans-serif; font-size: clamp(1.75rem, 4vw, 2.5rem); font-weight: 700; color: #191c1e; margin-bottom: 8px;">
        Catálogo de Proyectos
      </h1>
      <p style="font-size: 0.9375rem; color: #564337; margin-bottom: 0;">
        Gestión y asignación de evaluaciones técnicas para ExpoTÉCNICA 2026.
      </p>
    </div>

    <a href="{{ route('proyectos.crear') }}" class="btn d-inline-flex align-items-center justify-content-center gap-2 px-3 px-sm-4 text-decoration-none" style="height: 48px; background-color: #944a00; color: #fff; font-weight: 600; font-size: 0.875rem; border-radius: 0.5rem; box-shadow: 0px 4px 12px rgba(44,62,80,0.08); border: none; transition: all 0.2s;">
      <i class="bi bi-plus-lg"></i> Nuevo Proyecto
    </a>
  </div>

  <div class="row g-4">
    {{-- Alerta de error desde el controlador --}}
    @if (session('error'))
      <div class="col-12 mb-3">
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <i class="bi bi-exclamation-triangle-fill me-2"></i>
          <div>{{ session('error') }}</div>
        </div>
      </div>
    @endif

    @forelse($proyectos as $proyecto)
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card h-100 border-0 card-hover overflow-hidden d-flex flex-column" style="background-color: #fff; border: 1px solid #E2E8F0 !important; border-radius: 0.75rem; transition: all 0.25s ease;">

          @if($proyecto->Imagen)
            <div class="img-wrapper position-relative" style="height: 200px; overflow: hidden;">
              <img src="{{ asset('storage/' . $proyecto->Imagen) }}" alt="{{ $proyecto->Nombre }}" class="w-100 h-100" style="object-fit: cover; transition: transform 0.5s ease;">
            </div>
          @endif

          <div class="p-4 d-flex flex-column flex-grow-1">
            <div class="mb-3">
              <span class="badge px-2 py-1" style="background-color: #944a00; color: #fff; font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; border-radius: 0.25rem;">
                {{ $proyecto->categoria->Nombre ?? 'Sin categoría' }}
              </span>
            </div>
            <h3 class="text-truncate" style="font-family: 'Inter', sans-serif; font-size: 1.25rem; font-weight: 700; color: #191c1e; margin-bottom: 0.5rem;">
              {{ $proyecto->Nombre }}
            </h3>
            <p class="text-truncate-2" style="font-size: 0.875rem; line-height: 1.6; color: #564337; margin-bottom: 1.5rem;">
              {{ $proyecto->Descripcion }}
            </p>

            <div class="mt-auto pt-3" style="border-top: 1px solid #E2E8F0;">

              <!-- BOTÓN OPTIMIZADO: Ahora es el link real a las asignaciones -->
              <a href="{{ route('asignaciones.index', $proyecto->ID_Proyecto) }}" class="btn w-100 d-inline-flex align-items-center justify-content-center gap-2 mb-2 text-decoration-none" style="height: 40px; background-color: #fff; color: #944a00; font-weight: 600; font-size: 0.875rem; border-radius: 0.5rem; border: 1px solid #944a00; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#944a00'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='#fff'; this.style.color='#944a00';">
                <i class="bi bi-person-plus-fill"></i> Asignar Participantes
              </a>

              <a href="{{ route('admin.proyectos.pdfs', $proyecto->ID_Proyecto) }}" class="btn w-100 d-inline-flex align-items-center justify-content-center gap-2 mb-2 text-decoration-none" style="height: 40px; background-color: #fff; color: #ba1a1a; font-weight: 600; font-size: 0.875rem; border-radius: 0.5rem; border: 1px solid #ba1a1a; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#ba1a1a'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='#fff'; this.style.color='#ba1a1a';">
                <i class="bi bi-file-earmark-pdf"></i> Ver Evaluaciones (PDF)
              </a>

              <div class="row g-2">
                <div class="col-6">
                  <a href="{{ route('proyectos.edit', $proyecto->ID_Proyecto) }}" class="btn w-100 d-inline-flex align-items-center justify-content-center gap-2 text-decoration-none" style="height: 38px; background-color: transparent; color: #4e6073; font-weight: 600; font-size: 0.8125rem; border-radius: 0.5rem; border: 1px solid #E2E8F0; transition: all 0.2s;">
                    <i class="bi bi-pencil"></i> Editar
                  </a>
                </div>

                <div class="col-6">
                  <!-- AQUÍ ESTÁ EL CAMBIO: Se agregó "form-eliminar" y se quitó el onclick del botón -->
                  <form action="{{ route('proyectos.destroy', $proyecto->ID_Proyecto) }}" method="POST" class="d-inline w-100 form-eliminar">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn w-100 d-inline-flex align-items-center justify-content-center gap-2" style="height: 38px; background-color: #fff1f0; color: #dc3545; font-weight: 600; font-size: 0.8125rem; border-radius: 0.5rem; border: 1px solid #ffcdd2; transition: all 0.2s;">
                      <i class="bi bi-trash"></i> Eliminar
                    </button>
                  </form>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12 text-center py-5">
        <i class="bi bi-inbox" style="font-size: 3rem; color: #d8dadc;"></i>
        <p class="mt-3" style="color: #564337;">No hay proyectos registrados aún.</p>
      </div>
    @endforelse
  </div>

  {{-- Script de SweetAlert2 --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {

      // 1. Modal de Confirmación al Eliminar Proyecto
      const formsEliminar = document.querySelectorAll('.form-eliminar');
      formsEliminar.forEach(form => {
        form.addEventListener('submit', function (e) {
          e.preventDefault();

          Swal.fire({
            title: '¿Eliminar proyecto?',
            text: "Esta acción no se puede deshacer y borrará la información relacionada.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#944a00',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
              popup: 'rounded-4'
            }
          }).then((result) => {
            if (result.isConfirmed) {
              this.submit();
            }
          });
        });
      });

      // 2. Notificación Toast cuando hay mensaje de éxito
      @if(session('success'))
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3500,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
          }
        });

        Toast.fire({
          icon: 'success',
          title: "{{ session('success') }}"
        });
      @endif

      });
  </script>

@endsection
