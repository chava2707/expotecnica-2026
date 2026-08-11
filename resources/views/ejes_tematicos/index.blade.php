@extends('plantillas.layout-admin')

@section('Title', 'Ejes Temáticos - Admin')
@section('AdminSidebarActiveEjes', 'active') {{-- Ajusta este nombre según tu layout --}}

@section('Main')

  <style>
    .card-hover:hover {
      border-color: #944a00 !important;
      box-shadow: 0 12px 24px rgba(44, 62, 80, 0.06);
    }

    .text-truncate-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      white-space: normal;
    }
  </style>

  {{-- Alertas de error --}}
  @if($errors->any())
    <div class="alert alert-danger d-flex align-items-center gap-2 mb-4" style="background-color: #fce8e6; border-color: #fad2cf; color: #c5221f; border-radius: 0.5rem;">
      <i class="bi bi-exclamation-triangle-fill"></i>
      <div>
        <ul class="mb-0 ps-3">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif

  {{-- Encabezado de la página --}}
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3 border-bottom pb-4" style="border-color: #E2E8F0 !important;">
    <div style="max-width: 560px;">
      <div class="mb-2">
        <span class="badge d-inline-flex align-items-center gap-1 rounded-pill px-3 py-2" style="background-color: #eceef0; color: #4e6073; font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase;">
          <i class="bi bi-diagram-3-fill" style="font-size: 0.75rem;"></i>
          Administración
        </span>
      </div>
      <h1 style="font-family: 'Inter', sans-serif; font-size: clamp(1.75rem, 4vw, 2.5rem); font-weight: 700; color: #191c1e; margin-bottom: 8px;">
        Ejes Temáticos
      </h1>
      <p style="font-size: 0.9375rem; color: #564337; margin-bottom: 0;">
        Gestión y definición de las áreas técnicas de evaluación para ExpoTÉCNICA 2026.
      </p>
    </div>

    <a href="{{ route('ejes.create') }}" class="btn d-inline-flex align-items-center justify-content-center gap-2 px-3 px-sm-4 text-decoration-none" style="height: 48px; background-color: #944a00; color: #fff; font-weight: 600; font-size: 0.875rem; border-radius: 0.5rem; box-shadow: 0px 4px 12px rgba(44,62,80,0.08); border: none; transition: all 0.2s;">
      <i class="bi bi-plus-lg"></i> Nuevo Eje
    </a>
  </div>

  {{-- Cuadrícula de Ejes Temáticos --}}
  <div class="row g-4">
    @forelse($ejes as $eje)
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card h-100 border-0 card-hover d-flex flex-column" style="background-color: #fff; border: 1px solid #E2E8F0 !important; border-radius: 0.75rem; transition: all 0.25s ease;">

          <div class="p-4 d-flex flex-column flex-grow-1">
            <div class="d-flex justify-content-between align-items-start mb-3">
              {{-- Categoría del Eje --}}
              <span class="badge px-2 py-1" style="background-color: #cfe2f9; color: #091d2e; font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; border-radius: 0.25rem;">
                {{ $eje->categoria->Nombre ?? 'Sin categoría' }}
              </span>

              {{-- Icono representativo --}}
              <div class="d-flex align-items-center justify-content-center rounded" style="width: 32px; height: 32px; background-color: rgba(148, 74, 0, 0.1); color: #944a00;">
                <i class="bi bi-bookmark-fill"></i>
              </div>
            </div>

            <h3 class="text-truncate" style="font-family: 'Inter', sans-serif; font-size: 1.25rem; font-weight: 700; color: #191c1e; margin-bottom: 0.5rem;" title="{{ $eje->Nombre }}">
              {{ $eje->Nombre }}
            </h3>

            <p class="text-truncate-2" style="font-size: 0.875rem; line-height: 1.6; color: #564337; margin-bottom: 1.5rem;" title="{{ $eje->Descripcion }}">
              {{ $eje->Descripcion ?: 'No se ha proporcionado una descripción para este eje temático.' }}
            </p>

            <div class="mt-auto pt-3" style="border-top: 1px solid #E2E8F0;">

              {{-- Indicador de proyectos vinculados --}}
              <div class="d-flex align-items-center gap-2 mb-3 px-2 py-2 rounded" style="background-color: #f7f9fb; border: 1px solid #eceef0;">
                <i class="bi bi-folder2-open" style="color: #4e6073;"></i>
                <span style="font-size: 0.8125rem; color: #4e6073; font-weight: 600;">
                  Proyectos vinculados: <span style="color: #944a00;">{{ $eje->proyectos()->count() }}</span>
                </span>
              </div>

              {{-- Botones de Acción --}}
              <div class="row g-2">
                <div class="col-6">
                  <a href="{{ route('ejes.edit', $eje->ID_Eje) }}" class="btn w-100 d-inline-flex align-items-center justify-content-center gap-2 text-decoration-none" style="height: 38px; background-color: transparent; color: #4e6073; font-weight: 600; font-size: 0.8125rem; border-radius: 0.5rem; border: 1px solid #E2E8F0; transition: all 0.2s;">
                    <i class="bi bi-pencil"></i> Editar
                  </a>
                </div>

                <div class="col-6">
                  <!-- AQUÍ ESTÁ EL CAMBIO: Se agregó "form-eliminar" y se quitó el onclick del botón -->
                  <form action="{{ route('ejes.destroy', $eje->ID_Eje) }}" method="POST" class="d-inline w-100 form-eliminar">
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
      {{-- Estado Vacío --}}
      <div class="col-12 text-center py-5">
        <i class="bi bi-inbox" style="font-size: 3rem; color: #d8dadc;"></i>
        <h4 class="mt-3" style="color: #191c1e; font-weight: 600;">No hay ejes temáticos</h4>
        <p style="color: #564337;">Aún no se ha registrado ningún eje temático en el sistema.</p>
        <a href="{{ route('ejes.create') }}" class="btn mt-2 px-4 py-2" style="background-color: #944a00; color: #fff; font-weight: 600; border-radius: 0.5rem;">
          Crear el primer eje
        </a>
      </div>
    @endforelse
  </div>

  {{-- Script de SweetAlert2 --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {

      // 1. Modal de Confirmación al Eliminar Eje Temático
      const formsEliminar = document.querySelectorAll('.form-eliminar');
      formsEliminar.forEach(form => {
        form.addEventListener('submit', function (e) {
          e.preventDefault();

          Swal.fire({
            title: '¿Eliminar eje temático?',
            text: "Esta acción no se puede deshacer.",
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
