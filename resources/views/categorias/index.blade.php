@extends('plantillas.layout-admin')

@section('Title', 'Gestión de Categorías')

@section('Main')

  {{-- Carga de Tailwind y fuentes requeridas por el diseño generado --}}
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "outline-variant": "#dcc1b1",
            "on-surface": "#191c1e",
            "on-background": "#191c1e",
            "secondary-container": "#cfe2f9",
            "background": "#f7f9fb",
            "on-surface-variant": "#564337",
            "primary-container": "#e67e22",
            "surface-container": "#eceef0",
            "surface-container-low": "#f2f4f6",
            "surface-container-highest": "#e0e3e5",
            "surface-container-lowest": "#ffffff",
            "primary": "#944a00",
            "error": "#ba1a1a",
            "error-container": "#ffdad6",
            "on-error": "#ffffff",
            "tertiary-fixed-dim": "#61de8a",
          },
          spacing: {
            "lg": "24px", "sm": "12px", "md": "16px", "base": "8px", "xs": "4px", "xl": "40px", "container-max": "1200px"
          }
        }
      }
    }
  </script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f7f9fb;
    }

    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
      display: inline-block;
      vertical-align: middle;
    }

    .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
  </style>

  <div class="p-md md:p-lg max-w-container-max mx-auto w-full flex-1">

    {{-- Mensajes de Éxito originales (puedes dejarlos o quitarlos ya que ahora sale el Toast de SweetAlert) --}}
    @if(session('success'))
      <div class="bg-tertiary-fixed-dim bg-opacity-20 border border-tertiary-fixed-dim text-on-surface p-4 rounded-lg mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-green-700">check_circle</span>
        {{ session('success') }}
      </div>
    @endif

    {{-- NUEVO: Mensajes de Error --}}
    @if(session('error'))
      <div class="bg-error-container border border-error text-error p-4 rounded-lg mb-4 flex items-center gap-2 font-medium shadow-sm">
        <span class="material-symbols-outlined">warning</span>
        {{ session('error') }}
      </div>
    @endif

    {{-- Cabecera de la sección --}}
    <div class="flex flex-wrap items-center justify-between gap-md mb-lg">
      <div>
        <h2 class="text-[24px] font-bold text-primary mb-1">Gestión de Categorías</h2>
        <nav class="flex items-center text-[12px] font-semibold text-on-surface-variant">
          <a class="hover:text-primary transition-colors" href="#">Admin</a>
          <span class="material-symbols-outlined text-[16px] mx-xs">chevron_right</span>
          <span class="text-on-surface">Categorías</span>
        </nav>
      </div>
      <div class="flex gap-md items-center">
        <div class="flex items-center gap-xs px-md py-xs bg-surface-container-high rounded-full">
          <span class="text-[12px] font-semibold">Total:</span>
          <span class="text-[12px] font-semibold text-primary">{{ $categorias->count() }} Categorías</span>
        </div>
        <a href="{{ route('categorias.create') }}" class="bg-primary-container text-white hover:opacity-90 px-md py-base rounded-lg flex items-center gap-xs transition-all h-12 font-bold shadow-sm" style="background-color: #e67e22; text-decoration: none;">
          <span class="material-symbols-outlined text-white">add</span>
          <span class="hidden sm:inline text-white">Nueva Categoría</span>
        </a>
      </div>
    </div>

    {{-- Contenedor Principal (Grid o Empty State) --}}
    @if($categorias->isEmpty())
      <!-- Empty State -->
      <div class="flex flex-col items-center justify-center py-xl px-lg bg-surface-container-lowest rounded-xl border-2 border-dashed border-outline-variant text-center">
        <div class="w-20 h-20 bg-surface-container rounded-full flex items-center justify-center mb-md text-outline">
          <span class="material-symbols-outlined text-[48px]" style="font-variation-settings: 'wght' 300;">category</span>
        </div>
        <h3 class="text-[24px] font-bold text-on-surface mb-xs">No hay categorías registradas</h3>
        <p class="text-[14px] text-on-surface-variant max-w-sm mb-lg">
          Comienza creando la primera categoría para organizar los proyectos de la ExpoTÉCNICA 2026.
        </p>
        <a href="{{ route('categorias.create') }}" class="bg-primary text-white px-lg py-md rounded-lg font-bold flex items-center gap-sm hover:opacity-90 transition-all" style="text-decoration: none;">
          <span class="material-symbols-outlined text-white">add</span>
          Configurar Primera Categoría
        </a>
      </div>
    @else
      <!-- Bento Grid of Categories -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-md">

        @foreach($categorias as $categoria)
          <!-- Category Card -->
          <div class="group bg-surface-container-lowest border border-outline-variant rounded-xl p-md flex flex-col justify-between hover:shadow-md transition-all duration-300 relative overflow-hidden" style="min-height: 200px;">
            <div class="absolute top-0 left-0 w-1 h-full bg-primary-container"></div>

            <div class="flex justify-between items-start mb-sm">
              <span class="text-[12px] font-bold text-primary bg-primary-container bg-opacity-20 px-sm py-xs rounded uppercase tracking-tighter">
                ID: {{ $categoria->ID_Categoria }}
              </span>

              {{-- Acciones (Editar y Eliminar) --}}
              <div class="flex gap-xs opacity-0 group-hover:opacity-100 transition-opacity">
                <a href="{{ route('categorias.edit', $categoria->ID_Categoria) }}" class="p-xs hover:bg-surface-container-high rounded text-on-surface-variant transition-colors" title="Editar">
                  <span class="material-symbols-outlined text-[20px]">edit</span>
                </a>

                <!-- AQUÍ ESTÁ EL CAMBIO: Se agregó "form-eliminar" y se quitó el onsubmit manual -->
                <form action="{{ route('categorias.destroy', $categoria->ID_Categoria) }}" method="POST" class="m-0 p-0 form-eliminar">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="p-xs hover:bg-error-container hover:text-error rounded text-on-surface-variant transition-colors bg-transparent border-0" title="Eliminar">
                    <span class="material-symbols-outlined text-[20px]">delete</span>
                  </button>
                </form>
              </div>
            </div>

            <div class="mb-4">
              <h4 class="text-[20px] font-bold text-on-surface mb-xs">{{ $categoria->Nombre }}</h4>
              <p class="text-[14px] text-on-surface-variant line-clamp-2">
                {{ $categoria->Descripcion }}
              </p>
            </div>

            <div class="mt-auto pt-md border-t border-outline-variant flex items-center justify-between">
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-on-surface-variant text-[18px]">folder_open</span>
                <span class="text-[12px] font-bold text-on-surface-variant">
                  {{ $categoria->proyectos ? $categoria->proyectos->count() : 0 }} Proyectos
                </span>
              </div>
            </div>
          </div>
        @endforeach

        <!-- New Category CTA Card -->
        <a href="{{ route('categorias.create') }}" class="border-2 border-dashed border-outline-variant rounded-xl p-md flex flex-col items-center justify-center gap-sm group hover:border-primary-container hover:bg-surface-container transition-all" style="min-height: 200px; text-decoration: none;">
          <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant group-hover:bg-primary-container transition-colors">
            <span class="material-symbols-outlined text-[28px] group-hover:text-white transition-colors">add_circle</span>
          </div>
          <span class="text-[12px] font-bold text-on-surface-variant group-hover:text-primary transition-colors">Añadir Nueva Categoría</span>
        </a>

      </div>
    @endif
  </div>

  <script>
    // Animación sutil de las tarjetas
    document.querySelectorAll('.group').forEach(card => {
      card.addEventListener('mouseenter', () => {
        card.style.transform = 'translateY(-4px)';
      });
      card.addEventListener('mouseleave', () => {
        card.style.transform = 'translateY(0)';
      });
    });
  </script>

  {{-- Script de SweetAlert2 --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {

      // 1. Modal de Confirmación al Eliminar Categoría
      const formsEliminar = document.querySelectorAll('.form-eliminar');
      formsEliminar.forEach(form => {
        form.addEventListener('submit', function (e) {
          e.preventDefault();

          Swal.fire({
            title: '¿Eliminar categoría?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#944a00',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
              popup: 'rounded-xl' // Usando diseño redondeado estilo Tailwind
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
