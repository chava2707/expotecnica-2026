@extends('plantillas.layout-judge')

@section('Title', 'Seleccionar Rúbrica')
@section('JudgeSidebarActive2', 'active')

@section('Main')

    <style>
        .grid-pattern {
            background-image:
                linear-gradient(to right, #e0e3e5 1px, transparent 1px),
                linear-gradient(to bottom, #e0e3e5 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .header-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 12px rgba(44, 62, 80, .08);
            overflow: hidden;
        }

        .header-top {
            border-top: 8px solid #944a00;
            padding: 35px;
        }

        .rubrica-card {
            background: #fff;
            border: none;
            border-radius: 18px;
            box-shadow: 0 4px 12px rgba(44, 62, 80, .08);
            transition: .25s;
            height: 100%;
        }

        .rubrica-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 28px rgba(44, 62, 80, .12);
        }

        .rubrica-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            background: #fff3e7;
            color: #944a00;
            margin: auto;
        }

        .estado {
            font-size: .8rem;
            font-weight: 700;
            border-radius: 30px;
            padding: 6px 14px;
            display: inline-block;
        }

        .estado-pendiente {
            background: #fff3cd;
            color: #8a6d00;
        }

        .estado-completado {
            background: #d1f7df;
            color: #006d37;
        }

        .btn-rubrica {
            background: #944a00;
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            height: 48px;
            transition: .2s;
        }

        .btn-rubrica:hover {
            background: #b65a00;
            color: #fff;
        }
    </style>

    <section class="grid-pattern py-5 min-vh-100">

        <div class="container" style="max-width:1000px;">

            <div class="header-card mb-5">
                <div class="header-top">
                    <span class="badge bg-warning text-dark mb-3">
                        {{ $proyecto->categoria->Nombre ?? 'Sin Categoría' }}
                    </span>

                    <h2 class="fw-bold mb-2">
                        {{ $proyecto->Nombre }}
                    </h2>

                    <p class="text-muted mb-0">
                        {{ $proyecto->Descripcion }}
                    </p>

                    @if($proyecto->Archivo_PDF)
                        <div class="mt-4">
                            <a href="{{ route('proyectos.trabajo', $proyecto->ID_Proyecto) }}"
                                class="btn btn-rubrica d-inline-flex align-items-center gap-2" data-no-transition>
                                <i class="bi bi-file-earmark-pdf-fill"></i>
                                Descargar Trabajo Escrito
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="text-center mb-5">
                <h3 class="fw-bold">
                    ¿Qué desea evaluar?
                </h3>

                <p class="text-muted">
                    Seleccione la rúbrica correspondiente para comenzar la evaluación.
                </p>
            </div>

            <div class="row g-4 justify-content-center">

                @foreach($rubricas as $rubrica)

                            @php
                                // 1. Identificar si la rúbrica es de "Trabajo Escrito"
                                $esTrabajoEscrito = str_contains(mb_strtolower($rubrica->Nombre), 'escrito');

                                // 2. Obtener el ID de categoría de forma segura desde el proyecto o su relación
                                $idCategoria = $proyecto->ID_Categoria
                                    ?? $proyecto->categoria_id
                                    ?? ($proyecto->categoria->ID_Categoria ?? $proyecto->categoria->id_categoria ?? $proyecto->categoria->id ?? null);

                                // 3. Consultar si existen apartados asignados a esta rúbrica y categoría
                                $tieneApartados = \App\Models\Apartado::where('ID_Rubrica', $rubrica->ID_Rubrica)
                                    ->when($idCategoria, function ($query) use ($idCategoria) {
                                        return $query->where('ID_Categoria', $idCategoria);
                                    })
                                    ->exists();
                            @endphp

                            {{-- Ocultar SOLO si es Trabajo Escrito Y NO tiene ningún apartado en la categoría --}}
                            @if($esTrabajoEscrito && !$tieneApartados)
                                @continue
                            @endif

                            <div class="col-md-6">
                                <div class="rubrica-card">
                                    <div class="card-body p-5 text-center">

                                        <div class="rubrica-icon mb-4">
                                            @if($esTrabajoEscrito)
                                                <i class="bi bi-file-earmark-text-fill"></i>
                                            @else
                                                <i class="bi bi-mic-fill"></i>
                                            @endif
                                        </div>

                                        <h3 class="fw-bold mb-3">
                                            {{ $rubrica->Nombre }}
                                        </h3>

                                        <p class="text-muted mb-4">
                                            @if($esTrabajoEscrito)
                                                Evalúe el documento entregado por el equipo utilizando la rúbrica correspondiente.
                                            @else
                                                Evalúe la presentación oral realizada por el equipo utilizando la rúbrica correspondiente.
                                            @endif
                                        </p>

                                        @if($rubrica->evaluada)
                                            <span class="estado estado-completado mb-4">
                                                <i class="bi bi-check-circle-fill me-1"></i>
                                                Completada
                                            </span>
                                        @else
                                            <span class="estado estado-pendiente mb-4">
                                                <i class="bi bi-clock-fill me-1"></i>
                                                Pendiente
                                            </span>
                                        @endif

                                        <div class="mt-4">
                                            <a href="{{ route('juez.evaluar', [
                        'proyecto' => $proyecto->ID_Proyecto,
                        'rubrica' => $rubrica->ID_Rubrica
                    ]) }}" class="btn btn-rubrica w-100">

                                                @if($rubrica->evaluada)
                                                    Ver evaluación
                                                @else
                                                    Iniciar evaluación
                                                @endif

                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>

                @endforeach

            </div>

        </div>

    </section>

@endsection