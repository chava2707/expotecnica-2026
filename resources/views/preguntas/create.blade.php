@extends('plantillas.layout-admin')

@section('Title', 'Crear Pregunta - Admin')
@section('AdminSidebarActivePreguntas', 'active')

@section('Main')

<style>
    .grid-pattern {
        background-image:
            linear-gradient(to right, #e0e3e5 1px, transparent 1px),
            linear-gradient(to bottom, #e0e3e5 1px, transparent 1px);
        background-size: 24px 24px;
    }

    .form-control-custom:focus,
    .form-select-custom:focus {
        outline: none;
        border-color: #944a00 !important;
        box-shadow: 0 0 0 1px #944a00 !important;
    }

    .btn-outline-custom:hover {
        background-color: #e6e8ea !important;
    }

    .btn-primary-custom:hover {
        background-color: #e67e22 !important;
    }
</style>

<section class="grid-pattern d-flex align-items-center justify-content-center py-5 min-vh-100"
    style="background:#f7f9fb;font-family:'Inter',sans-serif;">

    <div class="container px-3 px-md-4" style="max-width:800px;">

        @if ($errors->any())
            <div class="alert alert-danger rounded-3 mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card border-0 overflow-hidden"
            style="background:#fff;border-radius:.75rem;box-shadow:0 4px 12px rgba(44,62,80,.08);">

            <div class="card-body p-4 p-md-5">

                <h1 class="mb-4 pb-3"
                    style="font-size:clamp(1.3rem,3vw,1.6rem);font-weight:700;color:#191c1e;border-bottom:1px solid #e6e8ea;">
                    Nuevo Indicador
                </h1>

                <form action="{{ route('preguntas.store') }}" method="POST">

                    @csrf

                    <div class="d-flex flex-column gap-4">

                        {{-- Pregunta / Indicador --}}
                        <div>
                            <label class="form-label mb-2"
                                style="font-size:.75rem;font-weight:600;color:#564337;letter-spacing:.05em;">
                                Indicador
                            </label>

                            <textarea
                                name="Pregunta"
                                rows="3"
                                class="form-control form-control-custom"
                                placeholder="Escriba el Indicador que será calificado por los jueces..."
                                style="background:#f2f4f6;border:1px solid #dcc1b1;border-radius:.5rem;padding:1rem;">{{ old('Pregunta') }}</textarea>
                        </div>

                        {{-- Apartado --}}
                        <div>
                            <label class="form-label mb-2"
                                style="font-size:.75rem;font-weight:600;color:#564337;letter-spacing:.05em;">
                                Apartado
                            </label>

                            <select
                                name="ID_Apartado"
                                class="form-select form-select-custom"
                                style="height:48px;background:#f2f4f6;border:1px solid #dcc1b1;border-radius:.5rem;">

                                <option value="" selected disabled>
                                    Seleccione un apartado
                                </option>

                                @foreach($apartados as $apartado)
                                    <option
                                        value="{{ $apartado->ID_Apartado }}"
                                        {{ old('ID_Apartado') == $apartado->ID_Apartado ? 'selected' : '' }}>
                                        
                                        [{{ $apartado->rubrica->Nombre ?? 'Sin Rúbrica' }}] 
                                        {{ $apartado->categoria->Nombre ?? 'Sin Categoría' }} 
                                        → 
                                        {{ $apartado->Titulo }}

                                    </option>
                                @endforeach

                            </select>

                            <small class="text-muted">
                                Seleccione el apartado (con su respectiva rúbrica y categoría) al que pertenecerá esta pregunta.
                            </small>
                        </div>

                        {{-- Calificación --}}
                        <div>
                            <label class="form-label mb-2"
                                style="font-size:.75rem;font-weight:600;color:#564337;letter-spacing:.05em;">
                                Calificación Máxima
                            </label>

                            <input
                                type="number"
                                min="1"
                                max="10"
                                value="{{ old('Maxima_Calificacion', 10) }}"
                                name="Maxima_Calificacion"
                                class="form-control form-control-custom"
                                style="height:48px;background:#f2f4f6;border:1px solid #dcc1b1;border-radius:.5rem;">
                        </div>

                    </div>

                    <div class="mt-5 pt-4 d-flex flex-column flex-sm-row justify-content-end gap-3"
                        style="border-top:1px solid #e6e8ea;">

                        <a href="{{ route('preguntas.index') }}"
                            class="btn btn-outline-custom"
                            style="height:48px;border:1px solid #564337;color:#564337;font-weight:600;border-radius:.5rem;display:flex;align-items:center;justify-content:center;">
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary-custom"
                            style="height:48px;background:#944a00;color:white;font-weight:600;border:none;border-radius:.5rem;">
                            Guardar Pregunta
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</section>

@endsection