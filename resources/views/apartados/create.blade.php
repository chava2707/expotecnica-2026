@extends('plantillas.layout-admin')

@section('Title', 'Nuevo Apartado')
@section('AdminSidebarActive4', 'active')

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
            background: #e6e8ea;
        }

        .btn-primary-custom:hover {
            background: #e67e22;
        }

        .info-box {
            background: #FFF8F2;
            border-left: 5px solid #944a00;
            border-radius: 8px;
        }

        .rubrica-disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>

    <section class="grid-pattern d-flex align-items-center justify-content-center py-5 min-vh-100">

        <div class="container" style="max-width:850px;">

            @if($errors->any())
                <div class="alert alert-danger rounded-3 mb-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4 p-md-5">

                    <h2 class="fw-bold mb-4 pb-3 border-bottom">
                        Crear Apartado
                    </h2>

                    <div class="info-box p-3 mb-4">
                        <h6 class="fw-bold mb-2">
                            <i class="bi bi-info-circle-fill"></i>
                            ¿Qué es un apartado?
                        </h6>
                        <p class="mb-0">
                            Los apartados permiten organizar la rúbrica de evaluación.
                            Cada apartado agrupa varias preguntas relacionadas que posteriormente responderán los jueces.
                        </p>
                    </div>

                    <form action="{{ route('apartados.store') }}" method="POST">

                        @csrf

                        <div class="d-flex flex-column gap-4">

                            {{-- Título del Apartado --}}
                            <div>
                                <label class="form-label fw-semibold">
                                    Título del Apartado
                                </label>
                                <input type="text" name="Titulo" class="form-control form-control-custom"
                                    value="{{ old('Titulo') }}" placeholder="Ej. Identificación y formulación del problema">
                                <small class="text-muted">
                                    Este título será visible para los jueces durante la evaluación.
                                </small>
                            </div>

                            {{-- Categoría --}}
                            <div>
                                <label class="form-label fw-semibold">
                                    Categoría
                                </label>

                                <select name="ID_Categoria" id="selectCategoria" class="form-select form-select-custom">
                                    <option disabled {{ old('ID_Categoria') ? '' : 'selected' }}>
                                        Seleccione una categoría
                                    </option>

                                    @foreach($categorias as $categoria)
                                        @php
                                            // Identificar si la categoría es Dominio Lingüístico
                                            $esLinguistico = Str::contains(mb_strtolower($categoria->Nombre), ['linguist', 'lingüíst']);
                                        @endphp
                                        <option value="{{ $categoria->ID_Categoria }}"
                                            data-es-linguistico="{{ $esLinguistico ? '1' : '0' }}"
                                            {{ old('ID_Categoria') == $categoria->ID_Categoria ? 'selected' : '' }}>
                                            {{ $categoria->Nombre }}
                                        </option>
                                    @endforeach
                                </select>

                                <small class="text-muted">
                                    Los proyectos únicamente visualizarán los apartados pertenecientes a su categoría.
                                </small>
                            </div>

                            {{-- Rúbrica --}}
                            <div>
                                <label class="form-label mb-3"
                                    style="font-size:.75rem;font-weight:600;color:#564337;letter-spacing:.05em;">
                                    Rúbrica
                                </label>

                                <div class="d-flex flex-column gap-3">
                                    @foreach($rubricas as $rubrica)
                                        @php
                                            $esEscrito = Str::contains(mb_strtolower($rubrica->Nombre), 'escrito');
                                            $esExposicion = Str::contains(mb_strtolower($rubrica->Nombre), ['exposic', 'oral']);
                                        @endphp

                                        <div class="form-check rubric-wrapper" id="wrapperRubrica{{ $rubrica->ID_Rubrica }}">
                                            <input
                                                class="form-check-input radio-rubrica"
                                                type="radio"
                                                name="ID_Rubrica"
                                                id="rubrica{{ $rubrica->ID_Rubrica }}"
                                                value="{{ $rubrica->ID_Rubrica }}"
                                                data-es-escrito="{{ $esEscrito ? '1' : '0' }}"
                                                data-es-exposicion="{{ $esExposicion ? '1' : '0' }}"
                                                {{ old('ID_Rubrica') == $rubrica->ID_Rubrica ? 'checked' : '' }}>

                                            <label class="form-check-label fw-semibold" for="rubrica{{ $rubrica->ID_Rubrica }}">
                                                {{ $rubrica->Nombre }}
                                                @if($esEscrito)
                                                    <small class="text-danger ms-2 d-none msg-no-disponible" style="font-size: .75rem;">
                                                        (No disponible para Dominio Lingüístico)
                                                    </small>
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <small class="text-muted mt-2 d-block">
                                    Seleccione la rúbrica a la que pertenecerá este apartado.
                                </small>
                            </div>

                        </div>

                        <div class="border-top mt-5 pt-4 d-flex flex-column flex-sm-row justify-content-end gap-3">
                            <a href="{{ route('apartados.index') }}" class="btn btn-outline-secondary btn-outline-custom">
                                Cancelar
                            </a>

                            <button type="submit" class="btn btn-primary btn-primary-custom" style="background:#944a00;border:none;">
                                <i class="bi bi-check-circle"></i>
                                Guardar Apartado
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </section>

    {{-- Script para gestionar la restricción de Rúbrica por Categoría --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectCategoria = document.getElementById('selectCategoria');
            const radiosRubrica = document.querySelectorAll('.radio-rubrica');

            function evaluarRestriccionRubrica() {
                const optionSeleccionada = selectCategoria.options[selectCategoria.selectedIndex];
                const esLinguistico = optionSeleccionada && optionSeleccionada.getAttribute('data-es-linguistico') === '1';

                radiosRubrica.forEach(radio => {
                    const esEscrito = radio.getAttribute('data-es-escrito') === '1';
                    const wrapper = radio.closest('.rubric-wrapper');
                    const msgText = wrapper.querySelector('.msg-no-disponible');

                    if (esLinguistico && esEscrito) {
                        radio.disabled = true;
                        if (msgText) msgText.classList.remove('d-none');
                        wrapper.classList.add('rubrica-disabled');

                        // Si estaba seleccionado "Trabajo Escrito", cambiamos automáticamente a Exposición
                        if (radio.checked) {
                            radio.checked = false;
                            const radioExposicion = document.querySelector('.radio-rubrica[data-es-exposicion="1"]');
                            if (radioExposicion) {
                                radioExposicion.checked = true;
                            }
                        }
                    } else if (esEscrito) {
                        radio.disabled = false;
                        if (msgText) msgText.classList.add('d-none');
                        wrapper.classList.remove('rubrica-disabled');
                    }
                });
            }

            selectCategoria.addEventListener('change', evaluarRestriccionRubrica);

            // Evaluar al cargar la página por si hay valores cargados de old()
            evaluarRestriccionRubrica();
        });
    </script>

@endsection