@extends('plantillas.layout-admin')

@section('Title', 'Nueva Categoría')

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
            "outline-variant": "#dcc1b1",
            "on-surface": "#191c1e",
            "on-background": "#191c1e",
            "secondary-container": "#cfe2f9",
            "background": "#f7f9fb",
            "on-surface-variant": "#564337",
            "primary-container": "#e67e22",
            "surface-container": "#eceef0",
            "surface-container-high": "#e6e8ea",
            "surface-container-low": "#f2f4f6",
            "surface-container-highest": "#e0e3e5",
            "surface-container-lowest": "#ffffff",
            "primary": "#944a00",
            "secondary": "#4e6073",
            "error": "#ba1a1a",
            "tertiary": "#006d37",
            "outline": "#897365",
          },
          spacing: {
            "lg": "24px", "sm": "12px", "md": "16px", "base": "8px", "xs": "4px", "xl": "40px"
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
  </style>

  <div class="flex-1 overflow-y-auto p-md md:p-lg lg:p-xl">
    <div class="max-w-[800px] mx-auto w-full">

      <!-- Breadcrumbs -->
      <nav class="flex items-center gap-xs mb-md text-on-surface-variant">
        <a class="text-[12px] font-semibold hover:text-primary transition-colors" style="text-decoration: none;" href="{{ route('categorias.index') }}">Categorías</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-[12px] font-semibold text-on-surface">Nueva Categoría</span>
      </nav>

      <!-- Errores de Validación -->
      @if ($errors->any())
        <div class="bg-error bg-opacity-10 border border-error text-error p-4 rounded-lg mb-4">
          <ul class="mb-0 pl-4">
            @foreach ($errors->all() as $error)
              <li class="text-[14px]">{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Form Card -->
      <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant overflow-hidden">
        <div class="h-1 w-full bg-gradient-to-r from-primary via-primary-container to-secondary"></div>

        <div class="p-lg md:p-xl">
          <div class="flex items-start justify-between mb-xl">
            <div>
              <h2 class="text-[24px] font-bold text-on-surface mb-xs">Detalles de la Categoría</h2>
              <p class="text-[14px] text-on-surface-variant">Complete los campos técnicos para definir el área de competencia.</p>
            </div>
            <div class="hidden sm:block">
              <div class="bg-surface-container-high p-md rounded-lg border border-outline-variant">
                <span class="material-symbols-outlined text-primary text-[32px]">architecture</span>
              </div>
            </div>
          </div>

          <form id="categoriaForm" action="{{ route('categorias.store') }}" method="POST" class="space-y-lg">
            @csrf

            <!-- Field: Nombre de la Categoría -->
            <div class="space-y-xs">
              <label class="text-[12px] font-semibold text-on-surface flex items-center gap-xs" for="nombre">
                Nombre de la Categoría <span class="text-error">*</span>
              </label>
              <div class="relative">
                <input class="w-full h-12 bg-surface px-md rounded-lg border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary transition-all text-[16px] placeholder:text-outline" id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder="Ej: Innovación en Inteligencia Artificial" type="text" required />
              </div>
              <p class="text-[11px] text-on-surface-variant font-medium uppercase tracking-tighter">Identificador único para el proceso de calificación</p>
            </div>

            <!-- Field: Descripción -->
            <div class="space-y-xs mt-4">
              <label class="text-[12px] font-semibold text-on-surface flex items-center gap-xs" for="descripcion">
                Descripción <span class="text-error">*</span>
              </label>
              <textarea class="w-full min-h-[120px] bg-surface p-md rounded-lg border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary transition-all text-[14px] placeholder:text-outline" id="descripcion" name="descripcion" placeholder="Describa el alcance, criterios generales y objetivos técnicos de esta categoría..." rows="6" required>{{ old('descripcion') }}</textarea>

              <div class="flex justify-between items-center mt-xs">
                <p class="text-[11px] text-on-surface-variant font-medium uppercase tracking-tighter">Proporcione contexto detallado para los jueces</p>
                <span id="charCount" class="text-[12px] font-semibold text-outline">0 / 500</span>
              </div>
            </div>

            <!-- Visual Separator & Actions -->
            <div class="mt-6 pt-md border-t border-outline-variant flex flex-col md:flex-row justify-between items-center gap-md">
              <div class="flex items-center gap-sm text-on-surface-variant">
                <span class="material-symbols-outlined text-[20px]">info</span>
                <p class="text-[14px] italic">Los cambios se aplicarán a todas las rúbricas asociadas.</p>
              </div>

              <div class="flex items-center gap-sm w-full md:w-auto">
                <a href="{{ route('categorias.index') }}" class="flex-1 md:flex-none px-xl h-12 rounded-lg border border-secondary text-secondary text-[12px] font-bold flex items-center justify-center hover:bg-surface-container-high transition-all" style="text-decoration: none;">
                  Cancelar
                </a>
                <button id="submitBtn" class="flex-1 md:flex-none px-xl h-12 rounded-lg bg-primary text-white text-[12px] font-bold hover:shadow-lg hover:opacity-90 active:scale-[0.98] transition-all" type="submit">
                  Guardar Categoría
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Guidance Card -->
      <div class="mt-lg p-lg bg-surface-container-high rounded-xl border border-outline-variant flex gap-md items-start">
        <span class="material-symbols-outlined text-tertiary">lightbulb</span>
        <div>
          <h4 class="text-[12px] font-bold text-on-surface mb-xs uppercase">Consejo de Configuración</h4>
          <p class="text-[14px] text-on-surface-variant">Asegúrese de que el nombre de la categoría sea lo suficientemente descriptivo para aparecer correctamente en los certificados finales de los estudiantes.</p>
        </div>
      </div>

    </div>
  </div>

  <script>
    const textarea = document.getElementById('descripcion');
    const counter = document.getElementById('charCount');

    function updateCounter() {
      const count = textarea.value.length;
      counter.textContent = `${count} / 500`;
      if (count > 450) {
        counter.classList.add('text-error');
        counter.classList.remove('text-outline');
      } else {
        counter.classList.remove('text-error');
        counter.classList.add('text-outline');
      }
    }

    if (textarea && counter) {
      updateCounter();
      textarea.addEventListener('input', updateCounter);
    }

    const form = document.getElementById('categoriaForm');
    const submitBtn = document.getElementById('submitBtn');

    form?.addEventListener('submit', () => {
      submitBtn.textContent = 'Procesando...';
      submitBtn.style.opacity = '0.7';
    });
  </script>

@endsection
