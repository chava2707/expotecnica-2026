@extends('plantillas.layout-admin')

@section('Title', 'Editar Eje Temático - Admin')
@section('AdminSidebarActiveEjes', 'active')

@section('Main')

  <style>
    .form-control-custom:focus {
      border-color: #944a00;
      box-shadow: 0 0 0 0.25rem rgba(148, 74, 0, 0.25);
    }

    .custom-shadow {
      box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);
    }

    .icon-grid-item {
      height: 56px;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1px solid #dcc1b1;
      border-radius: 0.5rem;
      background-color: transparent;
      color: #564337;
      transition: all 0.2s ease;
      cursor: pointer;
    }

    .icon-grid-item:hover {
      background-color: rgba(148, 74, 0, 0.05);
      border-color: #944a00;
    }

    .icon-grid-item.active {
      background-color: rgba(148, 74, 0, 0.1);
      border-color: #944a00;
      color: #944a00;
      border-width: 2px;
    }
  </style>

  <div class="container-fluid px-0" style="max-width: 800px; margin: 0 auto;">

    <!-- Encabezado -->
    <div class="mb-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size: 0.875rem; font-weight: 600;">
          <li class="breadcrumb-item"><a href="{{ route('ejes.index') }}"
              style="color: #564337; text-decoration: none;">Ejes Temáticos</a></li>
          <li class="breadcrumb-item active" aria-current="page" style="color: #191c1e;">Editar</li>
        </ol>
      </nav>
      <h1
        style="font-family: 'Inter', sans-serif; font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 700; color: #191c1e;">
        Editar Eje Temático
      </h1>
      <p style="font-size: 0.9375rem; color: #564337; margin-top: 0.25rem;">
        Modificando información del eje: <strong>{{ $eje->Nombre }}</strong>
      </p>
    </div>

    <!-- Tarjeta del Formulario -->
    <div class="card custom-shadow border-0" style="border-radius: 0.75rem; overflow: hidden; background-color: #fff;">
      <form action="{{ route('ejes.update', $eje->ID_Eje) }}" method="POST" id="ejeTematicoForm">
        @csrf
        @method('PUT')

        <div class="card-body p-4 p-md-5">

          <!-- Nombre del Eje -->
          <div class="mb-4">
            <label for="Nombre" class="form-label"
              style="font-size: 0.75rem; font-weight: 600; color: #564337; text-transform: uppercase; letter-spacing: 0.05em;">
              Nombre del Eje Temático
            </label>
            <input type="text" class="form-control form-control-custom @error('Nombre') is-invalid @enderror" id="Nombre"
              name="Nombre" value="{{ old('Nombre', $eje->Nombre) }}" placeholder="Ej: Innovación en Energías Renovables"
              style="height: 48px; border-radius: 0.5rem; border-color: #dcc1b1;">
            @error('Nombre')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Selector de Categoría (Opcional si tu BD lo requiere) -->
          <div class="mb-4">
            <label for="ID_Categoria" class="form-label"
              style="font-size: 0.75rem; font-weight: 600; color: #564337; text-transform: uppercase; letter-spacing: 0.05em;">
              Categoría Asociada
            </label>
            <select class="form-select form-control-custom @error('ID_Categoria') is-invalid @enderror" id="ID_Categoria"
              name="ID_Categoria" style="height: 48px; border-radius: 0.5rem; border-color: #dcc1b1;">
              <option value="">Seleccione una categoría...</option>
              @foreach($categorias as $categoria)
                <option value="{{ $categoria->ID_Categoria }}" {{ old('ID_Categoria', $eje->ID_Categoria) == $categoria->ID_Categoria ? 'selected' : '' }}>
                  {{ $categoria->Nombre }}
                </option>
              @endforeach
            </select>
            @error('ID_Categoria')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Descripción -->
          <div class="mb-4">
            <label for="Descripcion" class="form-label"
              style="font-size: 0.75rem; font-weight: 600; color: #564337; text-transform: uppercase; letter-spacing: 0.05em;">
              Descripción del Eje
            </label>
            <textarea class="form-control form-control-custom @error('Descripcion') is-invalid @enderror" id="Descripcion"
              name="Descripcion" rows="5"
              placeholder="Describe los alcances y criterios generales de este eje temático..."
              style="border-radius: 0.5rem; border-color: #dcc1b1; resize: none;">{{ old('Descripcion', $eje->Descripcion) }}</textarea>
            @error('Descripcion')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Selector de Icono -->

        </div>

        <!-- Footer Actions -->
        <div class="card-footer px-4 py-3 bg-light d-flex justify-content-end gap-3"
          style="border-top: 1px solid #E2E8F0;">
          <a href="{{ route('ejes.index') }}" class="btn d-inline-flex align-items-center justify-content-center"
            style="height: 48px; border: 1px solid #4e6073; color: #4e6073; font-weight: 600; font-size: 0.875rem; border-radius: 0.5rem; transition: all 0.2s;">
            Cancelar
          </a>
          <button type="submit" id="btnGuardar" class="btn d-inline-flex align-items-center justify-content-center gap-2"
            style="height: 48px; background-color: #944a00; color: #fff; font-weight: 600; font-size: 0.875rem; border-radius: 0.5rem; border: none; transition: all 0.2s;">
            Actualizar Cambios
          </button>
        </div>
      </form>
    </div>

    <!-- Info Box -->
    <div class="mt-4 p-3 rounded"
      style="background-color: #fff3cd; border: 1px solid #ffe69c; display: flex; gap: 1rem; align-items: flex-start;">
      <i class="bi bi-exclamation-triangle-fill" style="color: #664d03; font-size: 1.25rem;"></i>
      <div>
        <h4
          style="font-size: 0.75rem; font-weight: 600; color: #664d03; margin-bottom: 0.25rem; text-transform: uppercase;">
          Atención al editar</h4>
        <p style="font-size: 0.875rem; color: #664d03; margin-bottom: 0; opacity: 0.9;">
          Estás modificando un eje que podría tener <strong>{{ $eje->proyectos()->count() ?? 0 }} proyectos</strong>
          asociados. Los cambios se reflejarán de inmediato.
        </p>
      </div>
    </div>
  </div>

  <script>
    function selectIcon(element, iconName) {
      // Remover clase activa de todos los iconos
      const items = document.querySelectorAll('.icon-grid-item');
      items.forEach(item => item.classList.remove('active'));

      // Agregar clase activa al seleccionado
      element.classList.add('active');

      // Actualizar el valor del input oculto
      document.getElementById('iconoSeleccionado').value = iconName;
    }

    // Feedback visual al guardar
    document.getElementById('ejeTematicoForm').addEventListener('submit', function () {
      const btn = document.getElementById('btnGuardar');
      btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Actualizando...';
      btn.style.opacity = '0.8';
      btn.disabled = true;
    });
  </script>

@endsection