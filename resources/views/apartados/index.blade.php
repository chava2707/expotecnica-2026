@extends('plantillas.layout-admin')

@section('Title', 'Apartados')
@section('AdminSidebarActive4', 'active')

@section('Main')

    <style>
        .grid-pattern {
            background-image:
                linear-gradient(to right, #e0e3e5 1px, transparent 1px),
                linear-gradient(to bottom, #e0e3e5 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .card-apartado {
            transition: .25s;
            border-radius: 16px;
        }

        .card-apartado:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, .10);
        }

        .badge-custom {
            background: #f2f4f6;
            color: #564337;
            font-weight: 600;
            padding: .4rem .7rem;
            border-radius: 30px;
        }

        .btn-custom {
            background: #944a00;
            color: white;
        }

        .btn-custom:hover {
            background: #e67e22;
            color: white;
        }
    </style>

    <section class="grid-pattern py-4 py-md-5 min-vh-100">

        <div class="container-fluid container-lg">

            <!-- Encabezado responsivo para móvil y escritorio -->
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4 mb-md-5">

                <div>
                    <h2 class="fw-bold mb-1 fs-3 fs-md-2">
                        Administración de Rúbricas
                    </h2>

                    <p class="text-muted mb-0 small fs-6">
                        Organiza los apartados de evaluación ordenados por rúbrica y categoría.
                    </p>
                </div>

                <a href="{{ route('apartados.create') }}" class="btn btn-custom w-80 w-md-auto text-nowrap">
                    <i class="bi bi-plus-circle me-1"></i>
                    Nuevo Apartado
                </a>

            </div>

            @php
                // Se obtienen las Rúbricas registradas (Trabajo escrito, Exposición, etc.)
                $rubricasLista = isset($rubricas) ? $rubricas : \App\Models\Rubrica::all();
            @endphp

            <!-- FILA PRINCIPAL: 2 Columnas en Escritorio (col-lg-6), Apilados en Móvil (col-12) -->
            <div class="row g-4">

                @foreach($rubricasLista as $rubrica)

                    <div class="col-12 col-lg-6">

                        <!-- Panel Contenedor de la Rúbrica -->
                        <div class="bg-white p-3 p-md-4 rounded-4 shadow-sm border h-100">

                            <!-- Título de la Rúbrica -->
                            <div class="border-bottom pb-3 mb-4 d-flex align-items-center gap-2">
                                <i
                                    class="bi {{ Str::contains(strtolower($rubrica->Nombre), 'escrito') ? 'bi-file-earmark-text' : 'bi-easel' }} fs-4 text-warning"></i>
                                <h3 class="fw-bold fs-4 mb-0 text-dark">
                                    {{ $rubrica->Nombre }}
                                </h3>
                            </div>

                            <!-- División Interna por Categoría (Steam / Emprendimiento) -->
                            @foreach($categorias as $categoria)

                                @php
                                    // Filtra los apartados que corresponden a esta Rúbrica y Categoría específica
                                    $apartadosFiltrados = $categoria->apartados->filter(function ($apartado) use ($rubrica) {
                                        return $apartado->ID_Rubrica == $rubrica->ID_Rubrica;
                                    });
                                @endphp

                                <div class="mb-4">

                                    <!-- Subtítulo de Categoría -->
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <span class="badge bg-secondary rounded-pill px-3 py-2 fs-6">
                                            {{ $categoria->Nombre }}
                                        </span>
                                    </div>

                                    <div class="row g-3">

                                        @forelse($apartadosFiltrados as $apartado)

                                            <div class="col-12 col-md-6">

                                                <div class="card card-apartado border-0 shadow-sm h-100 bg-light">

                                                    <div class="card-body p-3">

                                                        <div class="d-flex justify-content-between align-items-center">

                                                            <span class="badge-custom">
                                                                Orden {{ $apartado->Orden }}
                                                            </span>

                                                            <span class="badge bg-success">
                                                                {{ $apartado->Estado }}
                                                            </span>

                                                        </div>

                                                        <h6 class="fw-bold text-dark mt-3 mb-1">
                                                            {{ $apartado->Titulo }}
                                                        </h6>

                                                        <p class="text-muted small mb-2">
                                                            {{ $apartado->preguntas_count ?? $apartado->preguntas->count() }} preguntas
                                                            registradas
                                                        </p>

                                                        <hr class="my-2">

                                                        <div class="d-flex justify-content-end gap-1">

                                                            <a href="{{ route('apartados.show', $apartado->ID_Apartado) }}"
                                                                class="btn btn-outline-secondary btn-sm">
                                                                <i class="bi bi-eye"></i>
                                                            </a>

                                                            <a href="{{ route('apartados.edit', $apartado->ID_Apartado) }}"
                                                                class="btn btn-outline-warning btn-sm">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>

                                                            <form action="{{ route('apartados.destroy', $apartado->ID_Apartado) }}"
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

                                            </div>

                                        @empty

                                            <div class="col-12">
                                                <div class="alert alert-light border-0 bg-white text-muted small mb-0 py-2">
                                                    No hay apartados para {{ $categoria->Nombre }} en {{ $rubrica->Nombre }}.
                                                </div>
                                            </div>

                                        @endforelse

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </section>

    {{-- Script de SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // 1. Modal de Confirmación al Eliminar Apartado
            const formsEliminar = document.querySelectorAll('.form-eliminar');
            formsEliminar.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    Swal.fire({
                        title: '¿Eliminar apartado?',
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