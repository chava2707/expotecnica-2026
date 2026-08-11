@extends('plantillas.layout-admin')

@section('Title', 'Crear Proyecto - Admin')
@section('AdminSidebarActive2', 'active')

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

    .drag-drop-zone:hover i.icon-upload {
      color: #944a00 !important;
    }

    /* Efectos hover para botones */
    .btn-outline-custom:hover {
      background-color: #e6e8ea !important;
    }

    .btn-primary-custom:hover {
      background-color: #e67e22 !important;
    }

    /* Botón cerrar de la imagen */
    .btn-remove-image {
      transition: all 0.2s;
      background: rgba(255, 255, 255, 0.9);
      color: #ba1a1a;
      border: 1px solid #ba1a1a;
    }

    .btn-remove-image:hover {
      background: #ba1a1a;
      color: white;
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
          <h1 class="mb-4 pb-3" style="font-size: clamp(1.25rem, 3vw, 1.5rem); font-weight: 700; color: #191c1e; border-bottom: 1px solid #e6e8ea;">
            Información del Proyecto
          </h1>

          <form action="{{ route('proyectos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="d-flex flex-column gap-4">

              {{-- Nombre del Proyecto --}}
              <div>
                <label for="nombre" class="form-label d-block mb-2" style="font-size: 0.75rem; font-weight: 600; color: #564337; letter-spacing: 0.05em;">
                  Nombre del Proyecto
                </label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" class="form-control form-control-custom" placeholder="Ej. Sistema de Riego Automatizado" style="height: 48px; background-color: #f2f4f6; border: 1px solid #dcc1b1; color: #191c1e; font-size: 0.875rem; border-radius: 0.5rem; padding: 0.75rem 1rem; transition: all 0.2s;">
              </div>

              {{-- Categoría --}}
              <div>
                <label for="categoria_id" class="form-label d-block mb-2" style="font-size: 0.75rem; font-weight: 600; color: #564337; letter-spacing: 0.05em;">
                  Categoría
                </label>
                <select id="categoria_id" name="categoria_id" class="form-select form-select-custom" style="height: 48px; background-color: #f2f4f6; border: 1px solid #dcc1b1; color: #191c1e; font-size: 0.875rem; border-radius: 0.5rem; padding: 0.75rem 1rem; cursor: pointer; transition: all 0.2s;">
                  <option value="" disabled {{ old('categoria_id') ? '' : 'selected' }}>Seleccione una categoría</option>
                  @foreach($categorias as $cat)
                    <option value="{{ $cat->ID_Categoria }}" {{ old('categoria_id') == $cat->ID_Categoria ? 'selected' : '' }}>
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
                  <option value="" disabled {{ old('ID_Eje') ? '' : 'selected' }}>Seleccione un eje temático</option>
                  @foreach($ejes as $eje)
                    <option value="{{ $eje->ID_Eje }}" {{ old('ID_Eje') == $eje->ID_Eje ? 'selected' : '' }}>
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
                <textarea id="descripcion" name="descripcion" class="form-control form-control-custom" placeholder="Describa el objetivo principal y el funcionamiento de su proyecto..." rows="4" style="min-height: 120px; background-color: #f2f4f6; border: 1px solid #dcc1b1; color: #191c1e; font-size: 0.875rem; border-radius: 0.5rem; padding: 0.75rem 1rem; resize: vertical; transition: all 0.2s;">{{ old('descripcion') }}</textarea>
              </div>

              {{-- Drag & Drop Imagen con Vista Previa --}}
              <div>
                <label class="form-label d-block mb-2" style="font-size: 0.75rem; font-weight: 600; color: #564337; letter-spacing: 0.05em;">
                  Imagen del Proyecto (Opcional)
                </label>
                <div class="drag-drop-zone d-flex justify-content-center align-items-center rounded-3 text-center position-relative overflow-hidden" style="border: 1px dashed #dcc1b1; background-color: #f2f4f6; transition: all 0.2s; cursor: pointer; min-height: 200px;" onclick="document.getElementById('imagenInput').click();">

                  {{-- Contenido Inicial (Textos y Nube) --}}
                  <div id="uploadTextContainer" class="p-4 p-md-5 w-100">
                    <i class="bi bi-cloud-arrow-up icon-upload" style="font-size: 2.5rem; color: #564337; transition: color 0.2s;"></i>
                    <div class="mt-3" style="font-size: 0.875rem; color: #564337;">
                      Arrastra y suelta tu imagen aquí, o haz clic para seleccionar
                    </div>
                    <p class="mt-2 mb-0" style="font-size: 0.75rem; color: #564337;">PNG, JPG, GIF hasta 5MB</p>
                  </div>

                  {{-- Contenedor de Vista Previa (Oculto por defecto) --}}
                  <div id="imagePreviewContainer" class="d-none w-100 h-100 position-absolute top-0 start-0 align-items-center justify-content-center p-3" style="background-color: #f2f4f6;">
                    <img id="imagePreview" src="" alt="Vista previa" class="img-fluid rounded" style="max-height: 180px; object-fit: contain;">

                    {{-- Botón para remover la imagen --}}
                    <button type="button" id="removeImageBtn" class="btn btn-remove-image rounded-circle position-absolute top-0 end-0 m-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; padding: 0; z-index: 10;" title="Quitar imagen">
                      <i class="bi bi-x-lg"></i>
                    </button>
                  </div>

                  <input type="file" id="imagenInput" name="imagen" class="d-none" accept=".png, .jpg, .jpeg, .gif">
                </div>
              </div>

              {{-- Trabajo Escrito (PDF) --}}
              <div>
                <label for="archivoPdfInput" class="form-label d-block mb-2" style="font-size: 0.75rem; font-weight: 600; color: #564337; letter-spacing: 0.05em;">
                  Trabajo Escrito (PDF)
                </label>
                <div class="drag-drop-zone d-flex justify-content-center align-items-center rounded-3 text-center position-relative overflow-hidden" style="border: 1px dashed #dcc1b1; background-color: #f2f4f6; transition: all 0.2s; cursor: pointer; min-height: 140px;" onclick="document.getElementById('archivoPdfInput').click();">

                  <div id="pdfUploadTextContainer" class="p-4 w-100">
                    <i class="bi bi-file-earmark-pdf icon-upload" style="font-size: 2rem; color: #564337; transition: color 0.2s;"></i>
                    <div class="mt-2" style="font-size: 0.875rem; color: #564337;">
                      Arrastra y suelta tu documento aquí, o haz clic para seleccionar
                    </div>
                    <p class="mt-2 mb-0" style="font-size: 0.75rem; color: #564337;">PDF hasta 20MB</p>
                  </div>

                  <div id="pdfFileNameContainer" class="d-none p-4 w-100">
                    <i class="bi bi-file-earmark-pdf-fill" style="font-size: 2rem; color: #944a00;"></i>
                    <div id="pdfFileName" class="mt-2 text-break" style="font-size: 0.875rem; font-weight: 600; color: #191c1e;"></div>
                    <div class="mt-1" style="font-size: 0.75rem; color: #564337;">PDF listo para subir</div>
                    <button type="button" id="removePdfBtn" class="btn btn-remove-image rounded-circle position-absolute top-0 end-0 m-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; padding: 0; z-index: 10;" title="Quitar archivo">
                      <i class="bi bi-x-lg"></i>
                    </button>
                  </div>

                  <input type="file" id="archivoPdfInput" name="archivo_pdf" class="d-none" accept=".pdf, application/pdf">
                </div>
              </div>

            </div>

            {{-- Botones de Acción --}}
            <div class="mt-5 pt-4 d-flex flex-column flex-sm-row justify-content-end gap-3" style="border-top: 1px solid #e6e8ea;">
              <a href="{{ route('admin.proyectos') ?? '#' }}" class="btn btn-outline-custom d-inline-flex align-items-center justify-content-center" style="height: 48px; padding: 0 1.5rem; border: 1px solid #564337; color: #564337; background-color: transparent; font-weight: 600; font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase; border-radius: 0.5rem; transition: all 0.2s; text-decoration: none;">
                Cancelar
              </a>
              <button type="submit" class="btn btn-primary-custom d-inline-flex align-items-center justify-content-center" style="height: 48px; padding: 0 1.5rem; background-color: #944a00; color: #ffffff; border: none; font-weight: 600; font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: all 0.2s;">
                Guardar Cambios
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </section>

  {{-- SCRIPT PARA LA VISTA PREVIA --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const input = document.getElementById('imagenInput');
      const uploadTextContainer = document.getElementById('uploadTextContainer');
      const imagePreviewContainer = document.getElementById('imagePreviewContainer');
      const imagePreview = document.getElementById('imagePreview');
      const removeImageBtn = document.getElementById('removeImageBtn');

      // Cuando el usuario selecciona una imagen
      input.addEventListener('change', function (event) {
        const file = event.target.files[0];

        if (file) {
          // Creamos un objeto de lectura
          const reader = new FileReader();

          reader.onload = function (e) {
            // Asignamos la imagen al src
            imagePreview.src = e.target.result;

            // Ocultamos los textos y mostramos la vista previa
            uploadTextContainer.classList.add('d-none');
            imagePreviewContainer.classList.remove('d-none');
            imagePreviewContainer.classList.add('d-flex'); // Activamos flex para centrar
          }

          reader.readAsDataURL(file);
        }
      });

      // Cuando el usuario presiona la "X" para borrar la imagen
      removeImageBtn.addEventListener('click', function (event) {
        event.stopPropagation(); // Evita que se vuelva a abrir la ventana de elegir archivo

        // Limpiamos el input
        input.value = '';
        imagePreview.src = '';

        // Ocultamos la vista previa y mostramos los textos originales
        imagePreviewContainer.classList.add('d-none');
        imagePreviewContainer.classList.remove('d-flex');
        uploadTextContainer.classList.remove('d-none');
      });

      // ===== PDF del trabajo escrito =====
      const pdfInput = document.getElementById('archivoPdfInput');
      const pdfUploadTextContainer = document.getElementById('pdfUploadTextContainer');
      const pdfFileNameContainer = document.getElementById('pdfFileNameContainer');
      const pdfFileName = document.getElementById('pdfFileName');
      const removePdfBtn = document.getElementById('removePdfBtn');

      if (pdfInput) {
        pdfInput.addEventListener('change', function (event) {
          const file = event.target.files[0];
          if (file) {
            pdfFileName.textContent = file.name;
            pdfUploadTextContainer.classList.add('d-none');
            pdfFileNameContainer.classList.remove('d-none');
          }
        });

        removePdfBtn.addEventListener('click', function (event) {
          event.stopPropagation();
          pdfInput.value = '';
          pdfFileName.textContent = '';
          pdfFileNameContainer.classList.add('d-none');
          pdfUploadTextContainer.classList.remove('d-none');
        });
      }
    });
  </script>

@endsection
