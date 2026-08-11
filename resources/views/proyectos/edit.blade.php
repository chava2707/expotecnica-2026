@extends('plantillas.layout')

@section('Main')

  <style>
    /* Patrón de cuadrícula de fondo */
    .grid-pattern {
      background-image: linear-gradient(to right, #e0e3e5 1px, transparent 1px),
        linear-gradient(to bottom, #e0e3e5 1px, transparent 1px);
      background-size: 24px 24px;
    }

    /* Estilos para el focus de los inputs */
    .form-control-custom:focus,
    .form-select-custom:focus {
      outline: none;
      border-color: #944a00 !important;
      box-shadow: 0 0 0 1px #944a00 !important;
    }

    /* Efectos hover para la zona de Drag & Drop */
    .drag-drop-zone:hover {
      background-color: #e0e3e5 !important;
    }

    .drag-drop-zone:hover i {
      color: #944a00 !important;
    }

    /* Efectos hover para botones */
    .btn-outline-custom:hover {
      background-color: #e6e8ea !important;
    }

    .btn-primary-custom:hover {
      background-color: #e67e22 !important;
    }
  </style>

  <section class="grid-pattern d-flex align-items-center justify-content-center py-5 min-vh-100" style="background-color: #f7f9fb; font-family: 'Inter', sans-serif;">
    <div class="container px-3 px-md-4" style="max-width: 800px;">

      {{-- Alertas de Validación --}}
      @if ($errors->any())
        <div class="alert alert-danger mb-4 rounded-3">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- Tarjeta Principal del Formulario --}}
      <div class="card border-0 w-100 overflow-hidden" style="background-color: #ffffff; border-radius: 0.75rem; box-shadow: 0px 4px 12px rgba(44,62,80,0.08);">
        <div class="card-body p-4 p-md-5">

          {{-- Título --}}
          <div class="d-flex justify-content-between align-items-center mb-4 pb-3" style="border-bottom: 1px solid #e6e8ea;">
            <h1 style="font-size: clamp(1.25rem, 3vw, 1.5rem); font-weight: 700; color: #191c1e; margin: 0;">
              Editar Proyecto
            </h1>
            <span class="badge" style="background-color: #f2f4f6; color: #564337; border: 1px solid #dcc1b1;">
              ID: {{ $proyecto->ID_Proyecto }}
            </span>
          </div>

          {{-- FORMULARIO DE EDICIÓN --}}
          <form action="{{ route('proyectos.update', $proyecto->ID_Proyecto) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="d-flex flex-column gap-4">

              {{-- Nombre del Proyecto --}}
              <div>
                <label for="nombre" class="form-label d-block mb-2" style="font-size: 0.75rem; font-weight: 600; color: #564337; letter-spacing: 0.05em;">
                  Nombre del Proyecto
                </label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $proyecto->Nombre) }}" class="form-control form-control-custom" placeholder="Ej. Sistema de Riego Automatizado" style="height: 48px; background-color: #f2f4f6; border: 1px solid #dcc1b1; color: #191c1e; font-size: 0.875rem; border-radius: 0.5rem; padding: 0.75rem 1rem; transition: all 0.2s;">
              </div>

              {{-- Categoría --}}
              <div>
                <label for="categoria_id" class="form-label d-block mb-2" style="font-size: 0.75rem; font-weight: 600; color: #564337; letter-spacing: 0.05em;">
                  Categoría
                </label>
                <select id="categoria_id" name="categoria_id" class="form-select form-select-custom" style="height: 48px; background-color: #f2f4f6; border: 1px solid #dcc1b1; color: #191c1e; font-size: 0.875rem; border-radius: 0.5rem; padding: 0.75rem 1rem; cursor: pointer; transition: all 0.2s;">
                  <option value="" disabled>Seleccione una categoría</option>
                  @foreach($categoria as $cat)
                    <option value="{{ $cat->ID_Categoria }}" {{ old('categoria_id', $proyecto->ID_categoria) == $cat->ID_Categoria ? 'selected' : '' }}>
                      {{ $cat->Nombre }}
                    </option>
                  @endforeach
                </select>
              </div>

              {{-- Eje Temático NUEVO --}}
              <div>
                <label for="ID_Eje" class="form-label d-block mb-2" style="font-size: 0.75rem; font-weight: 600; color: #564337; letter-spacing: 0.05em;">
                  Eje Temático
                </label>
                <select id="ID_Eje" name="ID_Eje" class="form-select form-select-custom" style="height: 48px; background-color: #f2f4f6; border: 1px solid #dcc1b1; color: #191c1e; font-size: 0.875rem; border-radius: 0.5rem; padding: 0.75rem 1rem; cursor: pointer; transition: all 0.2s;">
                  <option value="" disabled>Seleccione un eje temático</option>
                  @foreach($ejes as $eje)
                    <option value="{{ $eje->ID_Eje }}" {{ old('ID_Eje', $proyecto->ID_Eje) == $eje->ID_Eje ? 'selected' : '' }}>
                      {{ $eje->Nombre }}
                    </option>
                  @endforeach
                </select>
              </div>

              {{-- Descripción --}}
              <div>
                <label for="descripcion" class="form-label d-block mb-2" style="font-size: 0.75rem; font-weight: 600; color: #564337; letter-spacing: 0.05em;">
                  Descripción
                </label>
                <textarea id="descripcion" name="descripcion" class="form-control form-control-custom" rows="4" style="min-height: 120px; background-color: #f2f4f6; border: 1px solid #dcc1b1; color: #191c1e; font-size: 0.875rem; border-radius: 0.5rem; padding: 0.75rem 1rem; resize: vertical; transition: all 0.2s;">{{ old('descripcion', $proyecto->Descripcion) }}</textarea>
              </div>

              {{-- Zona de Imagen --}}
              <div>
                <label class="form-label d-block mb-2" style="font-size: 0.75rem; font-weight: 600; color: #564337; letter-spacing: 0.05em;">
                  Imagen del Proyecto
                </label>

                @if($proyecto->Imagen)
                  <div class="mb-3 p-3 rounded" style="background-color: #f8f9fa; border: 1px solid #e6e8ea; display: inline-block;">
                    <p class="mb-2" style="font-size: 0.75rem; color: #6c757d;">Imagen actual:</p>
                    <img src="{{ asset('storage/' . $proyecto->Imagen) }}" alt="Imagen de {{ $proyecto->Nombre }}" style="max-height: 120px; border-radius: 4px; object-fit: cover;">
                  </div>
                @endif

                <div class="drag-drop-zone d-flex justify-content-center align-items-center rounded-3 text-center p-4" style="border: 1px dashed #dcc1b1; background-color: #f2f4f6; transition: all 0.2s; cursor: pointer;" onclick="document.getElementById('imagenInput').click();">
                  <div>
                    <i class="bi bi-cloud-arrow-up" style="font-size: 2rem; color: #564337; transition: color 0.2s;"></i>
                    <div class="mt-2" style="font-size: 0.875rem; color: #564337;">
                      {{ $proyecto->Imagen ? 'Sube una nueva imagen para reemplazar la actual' : 'Arrastra y suelta tu imagen aquí, o haz clic' }}
                    </div>
                    <p class="mt-1 mb-0" style="font-size: 0.75rem; color: #564337;">PNG, JPG, GIF hasta 5MB</p>

                    <input type="file" id="imagenInput" name="imagen" class="d-none" accept=".png, .jpg, .jpeg, .gif">
                  </div>
                </div>
              </div>

              {{-- Trabajo Escrito (PDF) --}}
              <div>
                <label for="archivoPdfInput" class="form-label d-block mb-2" style="font-size: 0.75rem; font-weight: 600; color: #564337; letter-spacing: 0.05em;">
                  Trabajo Escrito (PDF)
                </label>

                @if($proyecto->Archivo_PDF)
                  <div class="mb-3 p-3 rounded" style="background-color: #f8f9fa; border: 1px solid #e6e8ea;">
                    <p class="mb-2" style="font-size: 0.75rem; color: #6c757d;">Archivo actual:</p>
                    <div class="d-flex align-items-center gap-2">
                      <i class="bi bi-file-earmark-pdf-fill" style="font-size: 1.5rem; color: #ba1a1a;"></i>
                      <span style="font-size: 0.875rem; color: #191c1e;">{{ basename($proyecto->Archivo_PDF) }}</span>
                      <a href="{{ route('proyectos.trabajo', $proyecto->ID_Proyecto) }}" class="btn btn-sm ms-auto d-inline-flex align-items-center gap-1" data-no-transition style="background-color: #944a00; color: #fff; border: none; font-weight: 600; font-size: 0.75rem; border-radius: 0.5rem; text-decoration: none;">
                        <i class="bi bi-download"></i> Descargar
                      </a>
                    </div>
                  </div>
                @endif

                <div class="drag-drop-zone d-flex justify-content-center align-items-center rounded-3 text-center p-4" style="border: 1px dashed #dcc1b1; background-color: #f2f4f6; transition: all 0.2s; cursor: pointer;" onclick="document.getElementById('archivoPdfInput').click();">
                  <div>
                    <i class="bi bi-file-earmark-pdf" style="font-size: 2rem; color: #564337; transition: color 0.2s;"></i>
                    <div class="mt-2" style="font-size: 0.875rem; color: #564337;">
                      {{ $proyecto->Archivo_PDF ? 'Sube un nuevo PDF para reemplazar el actual' : 'Arrastra y suelta tu documento aquí, o haz clic' }}
                    </div>
                    <p class="mt-1 mb-0" style="font-size: 0.75rem; color: #564337;">PDF hasta 20MB</p>

                    <input type="file" id="archivoPdfInput" name="archivo_pdf" class="d-none" accept=".pdf, application/pdf">
                  </div>
                </div>
              </div>

            </div>

            {{-- Botones de Acción --}}
            <div class="mt-5 pt-4 d-flex flex-column flex-sm-row justify-content-end gap-3" style="border-top: 1px solid #e6e8ea;">
              <a href="{{ route('admin.proyectos') }}" class="btn btn-outline-custom d-inline-flex align-items-center justify-content-center" style="height: 48px; padding: 0 1.5rem; border: 1px solid #564337; color: #564337; background-color: transparent; font-weight: 600; font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase; border-radius: 0.5rem; transition: all 0.2s; text-decoration: none;">
                Cancelar
              </a>
              <button type="submit" class="btn btn-primary-custom d-inline-flex align-items-center justify-content-center" style="height: 48px; padding: 0 1.5rem; background-color: #944a00; color: #ffffff; border: none; font-weight: 600; font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: all 0.2s;">
                Actualizar Proyecto
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const pdfInput = document.getElementById('archivoPdfInput');
      const pdfHint = document.querySelector('.drag-drop-zone[onclick*="archivoPdfInput"] > div > div:nth-child(2)');

      if (pdfInput) {
        pdfInput.addEventListener('change', function (event) {
          const file = event.target.files[0];
          if (file && pdfHint) {
            pdfHint.textContent = 'Archivo seleccionado: ' + file.name;
          }
        });
      }
    });
  </script>

@endsection
