@extends('plantillas.layout-admin')

@section('Title', 'Asignación de Participantes - ' . $proyecto->Nombre)

@section('Main')

  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "brand-primary": "#E67E22",
            "brand-dark-brown": "#8A4F16",
            "brand-secondary": "#2C3E50",
            "brand-tertiary": "#27AE60",
            "brand-neutral": "#F8FAFC",
            "text-main": "#1A1A1A",
            "text-muted": "#666666"
          },
          fontFamily: {
            "sans": ["Inter", "sans-serif"]
          }
        }
      }
    }
  </script>

  <style>
    body {
      background-color: #F8FAFC;
      font-family: 'Inter', sans-serif;
    }

    .interactive-row:hover {
      background-color: #FAFAFA;
    }

    input:focus {
      border-color: #DCC1B1 !important;
      ring-color: #DCC1B1 !important;
    }
  </style>

  <div class="w-full max-w-[1200px] mx-auto p-4 md:p-8">

    <!-- Breadcrumbs & Title -->
    <div class="mb-6">
      <div class="flex items-center gap-1 text-[13px] font-medium text-brand-dark-brown mb-1">
        <a href="{{ route('admin.proyectos') }}" class="hover:underline" style="text-decoration:none; color: #8A4F16;">Proyectos</a>
        <span class="material-symbols-outlined text-[16px] text-gray-400">chevron_right</span>
        <span class="text-gray-500">Asignación de Participantes</span>
      </div>
      <h2 class="text-[26px] font-bold text-text-main tracking-tight">{{ $proyecto->Nombre }}</h2>
      <p class="text-[14px] text-text-muted mt-1">
        Busque y asigne jueces evaluadores y estudiantes presentadores a este proyecto.
      </p>
    </div>

    <!-- Alertas del Servidor -->
    @if(session('success'))
      <div class="bg-emerald-50 text-brand-tertiary border border-emerald-200 p-4 rounded-xl mb-4 text-[14px] font-medium flex items-center gap-2">
        <span class="material-symbols-outlined text-[20px]">check_circle</span>
        {{ session('success') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="bg-red-50 text-red-600 border border-red-200 p-4 rounded-xl mb-4 shadow-sm">
        <ul class="mb-0 pl-4 list-disc">
          @foreach ($errors->all() as $error)
            <li class="text-[14px] font-medium">{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- ==========================================
        MENSAJES DE CUPO MÁXIMO (Tu Solicitud)
      ========================================== -->
    <div class="flex flex-col gap-2 mb-4">
      @if($juecesTitularesContador >= 3)
        <div class="bg-orange-50 border border-[#DCC1B1] text-brand-dark-brown px-4 py-3 rounded-xl text-[13px] font-medium flex items-center gap-2 shadow-sm">
          <span class="material-symbols-outlined text-[18px]">info</span>
          Límite alcanzado: Ya hay 3 jueces titulares asignados a este proyecto.
        </div>
      @endif

      @if($juecesSuplentesContador >= 2)
        <div class="bg-orange-50 border border-[#DCC1B1] text-brand-dark-brown px-4 py-3 rounded-xl text-[13px] font-medium flex items-center gap-2 shadow-sm">
          <span class="material-symbols-outlined text-[18px]">info</span>
          Límite alcanzado: Ya hay 2 jueces suplentes asignados a este proyecto.
        </div>
      @endif
    </div>

    <!-- Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start pb-24">

      <!-- Sección Izquierda: Buscador y Tabla -->
      <div class="lg:col-span-8 flex flex-col gap-4">

        <!-- Input Buscar -->
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
          <label class="block text-[13px] font-bold text-text-main mb-2" for="user-search">Buscar Usuarios</label>
          <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">search</span>
            <input class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 bg-white text-[14px] text-text-main placeholder-gray-400 focus:outline-none transition-colors h-11" id="user-search" placeholder="Nombre, correo o rol..." type="text" />
          </div>
        </div>

        <!-- Tabla Resultados -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
          <div class="p-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-[18px] font-bold text-text-main">Resultados de Búsqueda</h3>
            <span class="text-[12px] font-medium text-text-muted bg-gray-100 px-2.5 py-1 rounded-md">
              <span id="userCount" class="font-bold text-text-main">{{ $usuarios->count() }}</span> encontrados
            </span>
          </div>

          <div class="overflow-y-auto" style="max-height: 520px;">
            <!-- Encabezados Planos -->
            <div class="grid grid-cols-12 gap-4 px-5 py-3 border-b border-gray-100 text-[12px] font-bold text-text-muted bg-white uppercase tracking-wider">
              <div class="col-span-6">Usuario</div>
              <div class="col-span-3">Rol</div>
              <div class="col-span-3 text-right">Acción</div>
            </div>

            <!-- Listado -->
            <div class="flex flex-col" id="userList">
              @foreach($usuarios as $usuario)
                @php
                  $estaAsignado = $asignaciones->contains('ID_Usuario', $usuario->id);
                  $txtRol = strtolower($usuario->rol->Nombre_rol ?? 'sin rol');

                  // Verificar bloqueos individuales por fila
                  $limiteTitularAlcanzado = (!$estaAsignado && in_array($txtRol, ['juez', 'jurado']) && $juecesTitularesContador >= 3);
                  $limiteSuplenteAlcanzado = (!$estaAsignado && in_array($txtRol, ['juez suplente', 'jurado suplente']) && $juecesSuplentesContador >= 2);
                  $filaBloqueada = $limiteTitularAlcanzado || $limiteSuplenteAlcanzado;
                @endphp
                <div class="user-row grid grid-cols-12 gap-4 px-5 py-4 items-center border-b border-gray-50 interactive-row transition-colors {{ $estaAsignado || $filaBloqueada ? 'opacity-50' : '' }}" data-name="{{ strtolower($usuario->name) }}" data-email="{{ strtolower($usuario->email) }}" data-rol="{{ $txtRol }}">

                  <!-- Info Usuario -->
                  <div class="col-span-6 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-semibold text-[14px] border border-gray-200 flex-shrink-0">
                      {{ strtoupper(substr($usuario->name, 0, 2)) }}
                    </div>
                    <div class="truncate">
                      <p class="text-[14px] font-bold text-text-main truncate leading-tight">{{ $usuario->name }}</p>
                      <p class="text-[12px] text-text-muted truncate mt-0.5">{{ $usuario->email }}</p>
                    </div>
                  </div>

                  <!-- Rol Badge -->
                  <div class="col-span-3">
                    <span class="inline-flex items-center px-2.5 py-1 rounded text-[12px] font-medium {{ $txtRol === 'estudiante' ? 'bg-blue-50 text-blue-600' : 'bg-gray-100 text-text-muted' }}">
                      {{ $usuario->rol->Nombre_rol ?? 'Sin Rol' }}
                    </span>
                  </div>

                  <!-- Botón de Acción -->
                  <div class="col-span-3 flex justify-end">
                    @if($estaAsignado)
                      <span class="text-[13px] font-medium text-brand-primary flex items-center gap-1 bg-orange-50 px-3 py-1.5 rounded-lg border border-orange-100">
                        <span class="material-symbols-outlined text-[16px]">check</span>
                        Asignado
                      </span>
                    @elseif($filaBloqueada)
                      <span class="text-[12px] text-text-muted italic flex items-center gap-0.5">
                        <span class="material-symbols-outlined text-[16px]">block</span>
                        Cupo Lleno
                      </span>
                    @else
                      <form action="{{ route('asignaciones.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="ID_Usuario" value="{{ $usuario->id }}">
                        <input type="hidden" name="ID_Proyecto" value="{{ $proyecto->ID_Proyecto }}">
                        <button type="submit" class="h-9 px-4 bg-white border border-[#DCC1B1] text-text-main rounded-lg text-[13px] font-medium hover:bg-gray-50 transition-colors flex items-center gap-1 shadow-sm">
                          <span class="material-symbols-outlined text-[16px] text-text-muted">add</span>
                          Asignar
                        </button>
                      </form>
                    @endif
                  </div>

                </div>
              @endforeach
            </div>
          </div>
        </div>

      </div>

      <!-- Sección Derecha: Participantes Asignados -->
      <div class="lg:col-span-4 sticky top-6">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm flex flex-col overflow-hidden">

          <div class="p-5 border-b border-gray-100 flex items-center gap-3">
            <span class="material-symbols-outlined text-brand-primary text-[24px]">group</span>
            <h3 class="text-[18px] font-bold text-text-main">Participantes Asignados</h3>
          </div>

          <div class="overflow-y-auto p-4 flex flex-col gap-2" style="max-height: 380px;">
            @forelse($asignaciones as $asignacion)
              @php
                $txtRolAsignado = strtolower($asignacion->usuario->rol->Nombre_rol ?? 'sin rol');
              @endphp
              <div class="bg-[#F8FAFC] p-3 rounded-xl border border-gray-100 flex items-center justify-between transition-all">
                <div class="flex items-center gap-3 truncate">
                  <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-text-muted font-bold text-xs border border-gray-200 flex-shrink-0">
                    {{ strtoupper(substr($asignacion->usuario->name, 0, 2)) }}
                  </div>
                  <div class="truncate">
                    <p class="text-[13px] font-bold text-text-main truncate leading-tight">{{ $asignacion->usuario->name }}</p>
                    <p class="text-[11px] text-text-muted mt-0.5">
                      {{ $asignacion->usuario->rol->Nombre_rol ?? 'Sin Rol' }}
                    </p>
                  </div>
                </div>

                <form action="{{ route('asignaciones.destroy', $asignacion->ID_PersonaAsignada) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-lg text-text-muted hover:bg-gray-200 transition-colors" title="Remover">
                    <span class="material-symbols-outlined text-[16px]">close</span>
                  </button>
                </form>
              </div>
            @empty
              <div class="text-center py-8 text-text-muted text-[13px]">
                No hay participantes asignados aún.
              </div>
            @endforelse
          </div>

          <!-- Footer Resumen -->
          <div class="p-5 border-t border-gray-100 bg-white">
            <div class="flex justify-between items-center mb-4 text-[13px]">
              <span class="text-text-muted font-medium">Total Asignados:</span>
              <span class="text-text-main font-bold text-[18px]">{{ $asignaciones->count() }}</span>
            </div>
            <a href="{{ route('admin.proyectos') }}" class="w-full h-11 bg-brand-dark-brown text-white rounded-lg text-[14px] font-bold hover:opacity-95 transition-all shadow-sm flex items-center justify-center gap-1.5" style="text-decoration: none;">
              <span class="material-symbols-outlined text-[18px]">check_circle</span>
              Finalizar Asignación
            </a>
          </div>

        </div>
      </div>

    </div>
  </div>

  <!-- Buscador JS -->
  <script>
    document.getElementById('user-search').addEventListener('input', function (e) {
      const searchTerm = e.target.value.toLowerCase();
      const rows = document.querySelectorAll('.user-row');
      let count = 0;

      rows.forEach(row => {
        const name = row.getAttribute('data-name');
        const email = row.getAttribute('data-email');
        const rol = row.getAttribute('data-rol');

        if (name.includes(searchTerm) || email.includes(searchTerm) || rol.includes(searchTerm)) {
          row.style.display = '';
          count++;
        } else {
          row.style.display = 'none';
        }
      });

      document.getElementById('userCount').textContent = count;
    });
  </script>

@endsection
