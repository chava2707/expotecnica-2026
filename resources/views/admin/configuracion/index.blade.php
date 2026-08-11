@extends('plantillas.layout-admin')

@section('Title', 'Configuración - Admin')
@section('AdminSidebarActiveConfig', 'active')

@section('Main')

  <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3 border-bottom pb-4" style="border-color: #E2E8F0 !important;">
    <div style="max-width: 560px;">
      <div class="mb-2">
        <span class="badge d-inline-flex align-items-center gap-1 rounded-pill px-3 py-2" style="background-color: #eceef0; color: #4e6073; font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase;">
          <i class="bi bi-gear-fill" style="font-size: 0.75rem;"></i>
          Configuración
        </span>
      </div>
      <h1 style="font-family: 'Inter', sans-serif; font-size: clamp(1.75rem, 4vw, 2.5rem); font-weight: 700; color: #191c1e; margin-bottom: 8px;">
        Correo de Evaluaciones
      </h1>
      <p style="font-size: 0.9375rem; color: #564337; margin-bottom: 0;">
        Define a qué correo se envían los PDFs de las evaluaciones para su impresión.
      </p>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2 py-3" style="border-radius: 0.5rem; font-size: 0.875rem;">
      <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
  @endif

  <div class="row">
    <div class="col-12 col-lg-8">
      <div class="card border-0" style="background-color: #fff; border: 1px solid #E2E8F0 !important; border-radius: 0.75rem;">
        <div class="p-4 p-lg-5">
          <div class="d-flex align-items-center gap-3 mb-4">
            <div class="judge-avatar" style="background-color: #fff1e6; color: #944a00; width: 48px; height: 48px; font-size: 1.25rem;">
              <i class="bi bi-envelope-fill"></i>
            </div>
            <div>
              <div style="font-weight: 700; font-size: 1.0625rem; color: #191c1e;">Correo destino de PDFs</div>
              <div style="font-size: 0.8125rem; color: #4e6073;">Se enviará una copia de cada rúbrica de evaluación a este correo.</div>
            </div>
          </div>

          <form action="{{ route('admin.configuracion.update') }}" method="POST">
            @csrf

            <div class="mb-4">
              <label for="correo_destino" style="font-size: 0.8125rem; font-weight: 600; color: #191c1e; margin-bottom: 8px; display: block;">
                Primer correo electrónico
              </label>
              <input type="email" name="correo_destino" id="correo_destino"
                     value="{{ old('correo_destino', $correosDestino[0] ?? '') }}"
                     placeholder="impresiones@expotecnica.edu"
                     class="form-control form-control-lg"
                     style="border-radius: 0.5rem; border: 1px solid #E2E8F0; font-size: 0.9375rem; padding: 12px 16px;">
              @error('correo_destino')
                <small style="color: #dc3545; font-size: 0.75rem; margin-top: 4px; display: block;">{{ $message }}</small>
              @enderror
            </div>

            <div class="mb-4">
              <label for="correo_destino_2" style="font-size: 0.8125rem; font-weight: 600; color: #191c1e; margin-bottom: 8px; display: block;">
                Segundo correo electrónico <span style="font-weight: 400; color: #897365;">(opcional)</span>
              </label>
              <input type="email" name="correo_destino_2" id="correo_destino_2"
                     value="{{ old('correo_destino_2', $correosDestino[1] ?? '') }}"
                     placeholder="impresiones2@expotecnica.edu"
                     class="form-control form-control-lg"
                     style="border-radius: 0.5rem; border: 1px solid #E2E8F0; font-size: 0.9375rem; padding: 12px 16px;">
              @error('correo_destino_2')
                <small style="color: #dc3545; font-size: 0.75rem; margin-top: 4px; display: block;">{{ $message }}</small>
              @enderror
            </div>

            <button type="submit" class="btn d-inline-flex align-items-center justify-content-center gap-2 px-4 text-decoration-none" style="height: 48px; background-color: #944a00; color: #fff; font-weight: 600; font-size: 0.875rem; border-radius: 0.5rem; border: none;">
              <i class="bi bi-check-lg"></i> Guardar correos
            </button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-4">
      <div class="card border-0 h-100" style="background-color: #FFF8F0; border: 1px solid #FFDCC5 !important; border-radius: 0.75rem;">
        <div class="p-4">
          <div style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #944a00; margin-bottom: 12px;">
            <i class="bi bi-info-circle-fill me-1"></i> Cómo funciona
          </div>
          <ul style="margin: 0; padding-left: 18px; color: #713700; font-size: 0.875rem; line-height: 1.8;">
            <li>Cada vez que un juez completa una evaluación, se genera el PDF de la rúbrica.</li>
            <li>Ese PDF se adjunta y se envía automáticamente a los correos que configure aquí (hasta 2).</li>
            <li>Si deja ambos campos vacíos, se usará el correo del juez que evaluó.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

@endsection
