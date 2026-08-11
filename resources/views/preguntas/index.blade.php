@extends('plantillas.layout-admin')

@section('Title', 'Rúbrica de Evaluación')
@section('AdminSidebarActivePreguntas', 'active')

@section('Main')

    <style>
        .grid-pattern {
            background-image:
                linear-gradient(to right, #e0e3e5 1px, transparent 1px),
                linear-gradient(to bottom, #e0e3e5 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .category-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #944a00;
        }

        .apartado-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(44, 62, 80, .08);
            transition: .25s;
        }

        .apartado-card:hover {
            transform: translateY(-3px);
        }

        .apartado-header {
            background: #944a00;
            color: white;
            padding: 18px 22px;
        }

        .question-item {
            border-left: 4px solid #944a00;
            background: #f8f9fb;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 12px;
        }

        .question-item:last-child {
            margin-bottom: 0;
        }

        .btn-add {
            background: #944a00;
            color: white;
            border: none;
            border-radius: 10px;
        }

        .btn-add:hover {
            background: #b65a00;
            color: white;
        }

        .empty-box {
            border: 2px dashed #d8d8d8;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
        }
    </style>

    <section class="grid-pattern py-5 min-vh-100" style="background:#f7f9fb;">

        <div class="container">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">
                <div>
                    <h2 class="fw-bold">
                        Rúbrica de Evaluación
                    </h2>
                    <p class="text-muted mb-0">
                        Organice los Indicadores exactamente como serán vistos por los jueces.
                    </p>
                </div>

                <a href="{{ route('preguntas.create') }}" class="btn btn-add px-4 py-3">
                    <i class="bi bi-plus-circle me-2"></i>
                    Agregar Indicador
                </a>
            </div>

            @foreach($categorias as $categoria)

                <div class="mb-5">

                    <div class="category-title mb-4">
                        {{ $categoria->Nombre }}
                    </div>

                    <div class="row g-4">

                        @foreach($categoria->apartados as $apartado)

                            <div class="col-lg-6">

                                <div class="apartado-card">

                                    <div class="apartado-header d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1">
                                                {{ $apartado->Titulo }}
                                            </h5>
                                            <small>
                                                {{ $apartado->preguntas->count() }} preguntas
                                            </small>
                                        </div>
                                    </div>

                                    <div class="card-body">

                                        @if($apartado->preguntas->count())

                                            @foreach($apartado->preguntas as $pregunta)

                                                <div class="question-item">

                                                    <div class="d-flex justify-content-between">

                                                        <div>
                                                            <div class="fw-semibold">
                                                                {{ $pregunta->Pregunta }}
                                                            </div>

                                                            <small class="text-muted">
                                                                Máximo: {{ $pregunta->Maxima_Calificacion }} puntos
                                                            </small>
                                                        </div>

                                                        <div class="text-end">

                                                            <a href="{{ route('preguntas.edit', $pregunta->ID_Pregunta) }}"
                                                                class="btn btn-outline-secondary btn-sm mb-2">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>

                                                            <form action="{{ route('preguntas.destroy', $pregunta->ID_Pregunta) }}"
                                                                method="POST" class="form-eliminar">

                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>

                                                            </form>

                                                        </div>

                                                    </div>

                                                </div>

                                            @endforeach

                                        @else

                                            <div class="empty-box">

                                                <i class="bi bi-question-circle fs-1 text-secondary"></i>

                                                <h6 class="mt-3">
                                                    Este apartado aún no tiene Indicadores
                                                </h6>

                                                <p class="text-muted mb-0">
                                                    Presione "Agregar Indicador" para comenzar.
                                                </p>

                                            </div>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            @endforeach

        </div>

    </section>

    {{-- Script de SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // 1. Modal de Confirmación al Eliminar
            const formsEliminar = document.querySelectorAll('.form-eliminar');
            formsEliminar.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    Swal.fire({
                        title: '¿Eliminar indicador?',
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