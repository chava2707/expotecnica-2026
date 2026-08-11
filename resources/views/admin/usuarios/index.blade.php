@extends('plantillas.layout-admin')

@section('Title', 'Gestion de Usuarios - Admin')
@section('AdminSidebarActive3', 'active')

@section('Main')

<style>
    .metric-card {
        background-color: #fff;
        border-radius: 0.75rem;
        padding: 24px;
        box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);
        border-left: 4px solid transparent;
        transition: all 0.25s ease;
    }
    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(44, 62, 80, 0.1);
    }
    .metric-card.primary { border-left-color: #944a00; }
    .metric-card.secondary { border-left-color: #4e6073; }
    .metric-card.tertiary { border-left-color: #006d37; }

    .metric-label {
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #4e6073;
    }
    .metric-value {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.2;
        letter-spacing: -0.02em;
        color: #191c1e;
    }

    .widget-card {
        background-color: #fff;
        border-radius: 0.75rem;
        box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);
        border: 1px solid #E2E8F0;
        overflow: hidden;
    }

    .table-admin thead {
        background-color: rgba(207, 226, 249, 0.2);
    }
    .table-admin thead th {
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #526478;
        border-bottom: 1px solid #E2E8F0;
        padding: 16px 24px;
    }
    .table-admin tbody td {
        padding: 16px 24px;
        border-bottom: 1px solid #E2E8F0;
        vertical-align: middle;
    }
    .table-admin tbody tr:hover {
        background-color: #e6e8ea;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.75rem;
        flex-shrink: 0;
        border: 1px solid #E2E8F0;
    }

    .role-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .role-badge.juez {
        background-color: #cfe2f9;
        color: #526478;
    }
    .role-badge.admin {
        background-color: #2d3133;
        color: #eff1f3;
    }
    .role-badge.staff {
        background-color: #e0e3e5;
        color: #564337;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }
    .status-dot.active { background-color: #29af61; }
    .status-dot.inactive { background-color: #897365; }

    .btn-admin-primary {
        background-color: #944a00;
        color: #fff;
        border: none;
        height: 48px;
        font-weight: 600;
        font-size: 0.875rem;
        border-radius: 0.5rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .btn-admin-primary:hover {
        background-color: #e67e22;
        color: #fff;
        transform: translateY(-1px);
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 0.5rem;
        border: none;
        background: transparent;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
    }
    .btn-action.edit { color: #4e6073; }
    .btn-action.edit:hover { background-color: #e6e8ea; color: #944a00; }
    .btn-action.view { color: #006d37; }
    .btn-action.view:hover { background-color: #d1f7df; color: #006d37; }
    .btn-action.delete { color: #ba1a1a; }
    .btn-action.delete:hover { background-color: #ffdad6; }

    .filter-select {
        background-color: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 0.5rem;
        padding: 8px 16px;
        font-size: 0.875rem;
        color: #191c1e;
        transition: border-color 0.15s ease;
    }
    .filter-select:focus {
        border-color: #944a00;
        outline: none;
        box-shadow: 0 0 0 2px rgba(148, 74, 0, 0.1);
    }

    .search-input {
        background-color: #f2f4f6;
        border: 1px solid #E2E8F0;
        border-radius: 9999px;
        padding: 8px 16px 8px 40px;
        font-size: 0.875rem;
        color: #191c1e;
        width: 100%;
        max-width: 320px;
        transition: all 0.15s ease;
    }
    .search-input:focus {
        border-color: #944a00;
        outline: none;
        box-shadow: 0 0 0 2px rgba(148, 74, 0, 0.1);
        background-color: #fff;
    }

    .pagination .page-item .page-link {
        color: #564337;
        border: 1px solid #E2E8F0;
        border-radius: 0.5rem;
        margin: 0 2px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.15s ease;
    }
    .pagination .page-item.active .page-link {
        background-color: #944a00;
        border-color: #944a00;
        color: #fff;
    }
    .pagination .page-item .page-link:hover:not(.active) {
        background-color: #e6e8ea;
        color: #191c1e;
    }
    .pagination .page-item.disabled .page-link {
        color: #d8dadc;
        background-color: #f7f9fb;
        border-color: #E2E8F0;
    }

    .modal-content {
        border: 1px solid #E2E8F0;
        border-radius: 0.75rem;
        box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);
    }
    .modal-header {
        border-bottom: 1px solid #E2E8F0;
    }
    .modal-footer {
        border-top: 1px solid #E2E8F0;
    }

    .is-invalid {
        border-color: #ba1a1a !important;
    }
    .is-invalid:focus {
        box-shadow: 0 0 0 2px rgba(186, 26, 26, 0.15) !important;
    }
    .invalid-feedback {
        display: none;
        font-size: 0.75rem;
        color: #ba1a1a;
        margin-top: 4px;
        font-weight: 500;
    }
    .invalid-feedback.d-block {
        display: block;
    }
</style>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3 border-bottom pb-4" style="border-color: #E2E8F0 !important;">
    <div style="max-width: 560px;">
        <div class="mb-2">
            <span class="badge d-inline-flex align-items-center gap-1 rounded-pill px-3 py-2" style="background-color: #eceef0; color: #4e6073; font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase;">
                <i class="bi bi-people-fill" style="font-size: 0.75rem;"></i>
                Administración
            </span>
        </div>
        <h1 style="font-family: 'Inter', sans-serif; font-size: clamp(1.75rem, 4vw, 2.5rem); font-weight: 700; color: #191c1e; margin-bottom: 8px;">
            Gestión de Usuarios
        </h1>
        <p style="font-size: 0.9375rem; color: #564337; margin-bottom: 0;">
            Administra los permisos y roles de los participantes de la ExpoTÉCNICA 2026.
        </p>
    </div>

    <button class="btn btn-admin-primary" data-bs-toggle="modal" data-bs-target="#crearUsuarioModal">
        <i class="bi bi-person-plus-fill"></i> Añadir Nuevo Usuario
    </button>
</div>

@if(session('success'))
    <div class="alert d-flex align-items-center gap-2 mb-4" role="alert" style="background-color: #e6f9ee; color: #003a1a; border: 1px solid #29af61; border-radius: 0.5rem; padding: 12px 16px; font-size: 0.875rem; font-weight: 500;">
        <i class="bi bi-check-circle-fill" style="color: #006d37;"></i>
        {{ session('success') }}
    </div>
@endif

<section class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-lg-4">
        <div class="metric-card primary">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="metric-label">Total Usuarios</span>
                <i class="bi bi-people" style="color: #944a00; font-size: 1.25rem;"></i>
            </div>
            <div class="d-flex align-items-end gap-2">
                <span class="metric-value">{{ number_format($totalUsuarios) }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-4">
        <div class="metric-card tertiary">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="metric-label">Jueces Activos</span>
                <i class="bi bi-person-check" style="color: #006d37; font-size: 1.25rem;"></i>
            </div>
            <div class="d-flex align-items-end gap-2">
                <span class="metric-value" style="color: #006d37;">{{ $juecesActivos }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-4">
        <div class="metric-card secondary">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="metric-label">Administradores</span>
                <i class="bi bi-shield-lock" style="color: #4e6073; font-size: 1.25rem;"></i>
            </div>
            <div class="d-flex align-items-end gap-2">
                <span class="metric-value">{{ $totalAdmins }}</span>
            </div>
        </div>
    </div>
</section>

<div class="widget-card">
    <div class="p-4 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3" style="border-color: #E2E8F0 !important;">
        <form method="GET" action="{{ route('admin.usuarios') }}" class="d-flex flex-wrap align-items-center gap-2 w-100">
            <div class="position-relative">
                <i class="bi bi-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #897365; font-size: 0.875rem;"></i>
                <input type="text" name="busqueda" class="search-input" placeholder="Buscar por nombre, email o usuario..." value="{{ request('busqueda') }}">
            </div>

            <select name="rol" class="filter-select" onchange="this.form.submit()">
                <option value="">Rol: Todos</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol->ID_Roles }}" {{ request('rol') == $rol->ID_Roles ? 'selected' : '' }}>
                        {{ $rol->Nombre_rol }}
                    </option>
                @endforeach
            </select>

            <select name="estado" class="filter-select" onchange="this.form.submit()">
                <option value="">Estado: Todos</option>
                <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>

            @if(request('busqueda') || request('rol') || request('estado'))
                <a href="{{ route('admin.usuarios') }}" class="btn d-inline-flex align-items-center gap-1" style="height: 38px; background-color: #fff1f0; color: #dc3545; font-weight: 600; font-size: 0.8125rem; border-radius: 0.5rem; border: 1px solid #ffcdd2; text-decoration: none;">
                    <i class="bi bi-x-lg" style="font-size: 0.75rem;"></i> Limpiar
                </a>
            @endif

            <div class="ms-auto" style="font-size: 0.875rem; color: #4e6073; font-weight: 500;">
                Mostrando <span style="color: #191c1e; font-weight: 700;">{{ $usuarios->count() }}</span> de <span style="color: #191c1e; font-weight: 700;">{{ number_format($totalUsuarios) }}</span> registros
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-admin mb-0">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Nombre de Usuario</th>
                    <th class="text-center">Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="user-avatar" style="background-color: {{ $usuario->rol && $usuario->rol->Nombre_rol === 'Administrador' ? '#ffb783' : ($usuario->rol && $usuario->rol->Nombre_rol === 'Juez' ? '#d1e4fb' : '#e0e3e5') }}; color: {{ $usuario->rol && $usuario->rol->Nombre_rol === 'Administrador' ? '#301400' : ($usuario->rol && $usuario->rol->Nombre_rol === 'Juez' ? '#091d2e' : '#564337') }};">
                                    {{ strtoupper(substr($usuario->name, 0, 2)) }}
                                </div>
                                <div>
                                    <strong style="color: #191c1e; font-size: 0.875rem;">{{ $usuario->name }}</strong>
                                    <p style="font-size: 0.75rem; color: #4e6073; margin-bottom: 0;">{{ $usuario->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $rolNombre = $usuario->rol->Nombre_rol ?? 'Sin rol';
                                $rolClase = 'staff';
                                if ($rolNombre === 'Juez') $rolClase = 'juez';
                                elseif ($rolNombre === 'Administrador') $rolClase = 'admin';
                            @endphp
                            <span class="role-badge {{ $rolClase }}">{{ $rolNombre }}</span>
                        </td>
                        <td style="color: #564337; font-size: 0.875rem;">
                            {{ $usuario->Nombre_usuario ?? '—' }}
                        </td>
                        <td class="text-center">
                            @if($usuario->Activo)
                                <span class="d-inline-flex align-items-center gap-2">
                                    <span class="status-dot active"></span>
                                    <span style="font-size: 0.75rem; font-weight: 600; color: #564337; text-transform: uppercase; letter-spacing: 0.03em;">Activo</span>
                                </span>
                            @else
                                <span class="d-inline-flex align-items-center gap-2" style="opacity: 0.6;">
                                    <span class="status-dot inactive"></span>
                                    <span style="font-size: 0.75rem; font-weight: 600; color: #564337; text-transform: uppercase; letter-spacing: 0.03em;">Inactivo</span>
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end gap-1">
                                <button class="btn-action view" title="Ver información" data-bs-toggle="modal" data-bs-target="#verUsuarioModal"
                                    data-name="{{ $usuario->name }}"
                                    data-username="{{ $usuario->Nombre_usuario }}"
                                    data-email="{{ $usuario->email }}"
                                    data-rol="{{ $usuario->rol->Nombre_rol ?? 'Sin rol' }}"
                                    data-activo="{{ $usuario->Activo ? 'Activo' : 'Inactivo' }}"
                                    data-telefonos="{{ $usuario->persona ? $usuario->persona->telefonos->pluck('Numero_Telefono')->filter()->implode(', ') : '' }}"
                                    data-correos="{{ $usuario->persona ? $usuario->persona->correos->pluck('Correo')->filter()->implode(', ') : '' }}">
                                    <i class="bi bi-eye" style="font-size: 1rem;"></i>
                                </button>
                                <button class="btn-action edit" title="Editar" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal"
                                    data-id="{{ $usuario->id }}"
                                    data-name="{{ $usuario->name }}"
                                    data-email="{{ $usuario->email }}"
                                    data-username="{{ $usuario->Nombre_usuario }}"
                                    data-rol="{{ $usuario->IDrol }}"
                                    data-activo="{{ $usuario->Activo ? '1' : '0' }}">
                                    <i class="bi bi-pencil" style="font-size: 1rem;"></i>
                                </button>
                                <button class="btn-action delete" title="Eliminar" onclick="confirmarEliminacion({{ $usuario->id }}, '{{ addslashes($usuario->name) }}')">
                                    <i class="bi bi-trash" style="font-size: 1rem;"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #d8dadc;"></i>
                            <p class="mt-3" style="color: #564337;">No se encontraron usuarios con los filtros seleccionados.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($usuarios->hasPages())
        <div class="p-4 d-flex justify-content-center" style="border-top: 1px solid #E2E8F0;">
            {{ $usuarios->links() }}
        </div>
    @endif
</div>

<div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="crearUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f2f4f6;">
                <h5 class="modal-title" id="crearUsuarioModalLabel" style="font-family: 'Inter', sans-serif; font-weight: 700; color: #191c1e;">
                    <i class="bi bi-person-plus-fill me-2" style="color: #944a00;"></i> Añadir Nuevo Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="crearUsuarioForm" method="POST" action="{{ route('admin.usuarios.store') }}" novalidate>
                @csrf
                <div class="modal-body p-4">
                    @if($errors->any() && session('_modal') === 'crear')
                        <div class="alert d-flex align-items-center gap-2 mb-4" role="alert" style="background-color: #ffdad6; color: #93000a; border: 1px solid #ba1a1a; border-radius: 0.5rem; padding: 12px 16px; font-size: 0.8125rem; font-weight: 500;">
                            <i class="bi bi-exclamation-triangle-fill" style="color: #ba1a1a;"></i>
                            <span>Corrige los errores antes de continuar.</span>
                        </div>
                    @endif

                    <div class="mb-4 pb-3" style="border-bottom: 1px solid #E2E8F0;">
                        <h6 style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: #944a00; margin-bottom: 16px;">
                            <i class="bi bi-person-badge me-1"></i> Datos Personales
                        </h6>
                        <div class="row g-3">
                            <div class="col-12 col-sm-4">
                                <label class="form-label" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">Cédula <span style="color: #ba1a1a;">*</span></label>
                                <input type="number" name="cedula" class="form-control @error('cedula') is-invalid @enderror" required placeholder="Ej: 20123456" style="border: 1px solid #E2E8F0; border-radius: 0.5rem; padding: 10px 16px;" value="{{ old('cedula') }}">
                                @error('cedula')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-8">
                                <label class="form-label" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">Nombre Completo <span style="color: #ba1a1a;">*</span></label>
                                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" required placeholder="Ej: María Elena" style="border: 1px solid #E2E8F0; border-radius: 0.5rem; padding: 10px 16px;" value="{{ old('nombre') }}">
                                @error('nombre')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">Primer Apellido <span style="color: #ba1a1a;">*</span></label>
                                <input type="text" name="apellido_1" class="form-control @error('apellido_1') is-invalid @enderror" required placeholder="Ej: González" style="border: 1px solid #E2E8F0; border-radius: 0.5rem; padding: 10px 16px;" value="{{ old('apellido_1') }}">
                                @error('apellido_1')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">Segundo Apellido</label>
                                <input type="text" name="apellido_2" class="form-control @error('apellido_2') is-invalid @enderror" placeholder="Ej: Rojas" style="border: 1px solid #E2E8F0; border-radius: 0.5rem; padding: 10px 16px;" value="{{ old('apellido_2') }}">
                                @error('apellido_2')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 pb-3" style="border-bottom: 1px solid #E2E8F0;">
                        <h6 style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: #944a00; margin-bottom: 16px;">
                            <i class="bi bi-envelope-at me-1"></i> Contacto
                        </h6>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">Correo Electrónico <span style="color: #ba1a1a;">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required placeholder="Ej: maria@unl.edu.ar" style="border: 1px solid #E2E8F0; border-radius: 0.5rem; padding: 10px 16px;" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">Teléfono <span style="color: #ba1a1a;">*</span></label>
                                <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" required placeholder="Ej: +54 351 123456" style="border: 1px solid #E2E8F0; border-radius: 0.5rem; padding: 10px 16px;" value="{{ old('telefono') }}">
                                @error('telefono')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <h6 style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: #944a00; margin-bottom: 16px;">
                            <i class="bi bi-shield-lock me-1"></i> Cuenta y Acceso
                        </h6>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">Nombre de Usuario</label>
                                <input type="text" name="nombre_usuario" class="form-control @error('nombre_usuario') is-invalid @enderror" placeholder="Ej: mgonzalez" style="border: 1px solid #E2E8F0; border-radius: 0.5rem; padding: 10px 16px;" value="{{ old('nombre_usuario') }}">
                                @error('nombre_usuario')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">Rol <span style="color: #ba1a1a;">*</span></label>
                                <select name="id_rol" class="form-select @error('id_rol') is-invalid @enderror" required style="border: 1px solid #E2E8F0; border-radius: 0.5rem; padding: 10px 16px;">
                                    <option value="">Seleccionar rol...</option>
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->ID_Roles }}" {{ old('id_rol') == $rol->ID_Roles ? 'selected' : '' }}>{{ $rol->Nombre_rol }}</option>
                                    @endforeach
                                </select>
                                @error('id_rol')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="p-3" style="background-color: #f2f4f6; border-radius: 0.5rem; border: 1px solid #E2E8F0;">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-info-circle" style="color: #4e6073;"></i>
                                        <span style="font-size: 0.8125rem; color: #564337;">
                                            La contraseña inicial será la <strong style="color: #944a00;">cédula de la persona</strong>. El usuario deberá cambiarla en su primer inicio de sesión.
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end gap-2">
                    <button type="button" class="btn" style="background-color: #e6e8ea; color: #564337; font-weight: 600; border-radius: 0.5rem; padding: 8px 24px; border: none;" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-admin-primary" style="height: 40px;">
                        <i class="bi bi-check-lg"></i> Crear Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="verUsuarioModal" tabindex="-1" aria-labelledby="verUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f2f4f6;">
                <h5 class="modal-title" id="verUsuarioModalLabel" style="font-family: 'Inter', sans-serif; font-weight: 700; color: #191c1e;">
                    <i class="bi bi-person-lines-fill me-2" style="color: #006d37;"></i> Información del Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="user-avatar" id="verAvatar" style="background-color: #d1f7df; color: #006d37; width: 48px; height: 48px; font-size: 0.875rem;">
                        --
                    </div>
                    <div>
                        <strong style="color: #191c1e; font-size: 1rem;" id="verName">—</strong>
                        <p style="font-size: 0.8125rem; color: #4e6073; margin-bottom: 0;" id="verUsername">—</p>
                    </div>
                </div>

                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-center justify-content-between p-3" style="background-color: #fafbfc; border: 1px solid #E2E8F0; border-radius: 0.5rem;">
                        <span style="font-size: 0.8125rem; font-weight: 600; color: #4e6073;"><i class="bi bi-envelope-fill me-2" style="color: #944a00;"></i> Correo electrónico</span>
                        <span style="font-size: 0.875rem; color: #191c1e; font-weight: 600; text-align: right;" id="verEmail">—</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between p-3" style="background-color: #fafbfc; border: 1px solid #E2E8F0; border-radius: 0.5rem;">
                        <span style="font-size: 0.8125rem; font-weight: 600; color: #4e6073;"><i class="bi bi-phone-fill me-2" style="color: #944a00;"></i> Teléfono(s)</span>
                        <span style="font-size: 0.875rem; color: #191c1e; font-weight: 600; text-align: right;" id="verTelefonos">—</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between p-3" style="background-color: #fafbfc; border: 1px solid #E2E8F0; border-radius: 0.5rem;">
                        <span style="font-size: 0.8125rem; font-weight: 600; color: #4e6073;"><i class="bi bi-envelope-paper me-2" style="color: #944a00;"></i> Correo(s) registrado(s)</span>
                        <span style="font-size: 0.875rem; color: #191c1e; font-weight: 600; text-align: right;" id="verCorreos">—</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between p-3" style="background-color: #fafbfc; border: 1px solid #E2E8F0; border-radius: 0.5rem;">
                        <span style="font-size: 0.8125rem; font-weight: 600; color: #4e6073;"><i class="bi bi-shield-lock-fill me-2" style="color: #944a00;"></i> Rol</span>
                        <span style="font-size: 0.875rem; color: #191c1e; font-weight: 600; text-align: right;" id="verRol">—</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between p-3" style="background-color: #fafbfc; border: 1px solid #E2E8F0; border-radius: 0.5rem;">
                        <span style="font-size: 0.8125rem; font-weight: 600; color: #4e6073;"><i class="bi bi-circle-fill me-2" style="color: #006d37;"></i> Estado</span>
                        <span style="font-size: 0.875rem; color: #191c1e; font-weight: 600; text-align: right;" id="verEstado">—</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-end gap-2">
                <button type="button" class="btn" style="background-color: #e6e8ea; color: #564337; font-weight: 600; border-radius: 0.5rem; padding: 8px 24px; border: none;" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f2f4f6;">
                <h5 class="modal-title" id="editarUsuarioModalLabel" style="font-family: 'Inter', sans-serif; font-weight: 700; color: #191c1e;">
                    <i class="bi bi-pencil-square me-2" style="color: #944a00;"></i> Editar Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="editarUsuarioForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">Nombre Completo</label>
                        <input type="text" name="name" class="form-control" id="editName" required style="border: 1px solid #E2E8F0; border-radius: 0.5rem; padding: 10px 16px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" id="editEmail" required style="border: 1px solid #E2E8F0; border-radius: 0.5rem; padding: 10px 16px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">Nombre de Usuario</label>
                        <input type="text" name="Nombre_usuario" class="form-control" id="editUsername" style="border: 1px solid #E2E8F0; border-radius: 0.5rem; padding: 10px 16px;">
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">Rol</label>
                            <select name="IDrol" class="form-select" id="editRol" required style="border: 1px solid #E2E8F0; border-radius: 0.5rem; padding: 10px 16px;">
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->ID_Roles }}">{{ $rol->Nombre_rol }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">Estado</label>
                            <select name="Activo" class="form-select" id="editActivo" style="border: 1px solid #E2E8F0; border-radius: 0.5rem; padding: 10px 16px;">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end gap-2">
                    <button type="button" class="btn" style="background-color: #e6e8ea; color: #564337; font-weight: 600; border-radius: 0.5rem; padding: 8px 24px; border: none;" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-admin-primary" style="height: 40px;">
                        <i class="bi bi-check-lg"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="eliminarUsuarioModal" tabindex="-1" aria-labelledby="eliminarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ffdad6;">
                <h5 class="modal-title" id="eliminarUsuarioModalLabel" style="font-family: 'Inter', sans-serif; font-weight: 700; color: #93000a;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <p style="color: #191c1e; font-size: 0.9375rem; margin-bottom: 0;">
                    ¿Estás seguro de que deseas eliminar al usuario <strong id="eliminarUsuarioNombre"></strong>? Esta acción no se puede deshacer.
                </p>
            </div>
            <div class="modal-footer d-flex justify-content-end gap-2">
                <button type="button" class="btn" style="background-color: #e6e8ea; color: #564337; font-weight: 600; border-radius: 0.5rem; padding: 8px 24px; border: none;" data-bs-dismiss="modal">Cancelar</button>
                <form id="eliminarUsuarioForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="height: 40px; background-color: #ba1a1a; color: #fff; font-weight: 600; border-radius: 0.5rem; padding: 8px 24px; border: none;">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function limpiarErrores(form) {
        form.querySelectorAll('.is-invalid').forEach(function(el) {
            el.classList.remove('is-invalid');
        });
        form.querySelectorAll('.invalid-feedback.d-block').forEach(function(el) {
            el.classList.remove('d-block');
        });
    }

    function mostrarError(input, mensaje) {
        input.classList.add('is-invalid');
        var feedback = input.parentElement.querySelector('.invalid-feedback');
        if (feedback) {
            feedback.textContent = mensaje;
            feedback.classList.add('d-block');
        }
    }

    function validarFormularioCrear(form) {
        limpiarErrores(form);
        var valido = true;

        var cedula = form.querySelector('[name="cedula"]');
        if (!cedula.value.trim()) {
            mostrarError(cedula, 'La cédula es obligatoria.');
            valido = false;
        } else if (cedula.value.trim().length < 7) {
            mostrarError(cedula, 'La cédula debe tener al menos 7 dígitos.');
            valido = false;
        } else if (parseInt(cedula.value) <= 0) {
            mostrarError(cedula, 'La cédula debe ser un número positivo.');
            valido = false;
        }

        var nombre = form.querySelector('[name="nombre"]');
        if (!nombre.value.trim()) {
            mostrarError(nombre, 'El nombre completo es obligatorio.');
            valido = false;
        } else if (nombre.value.trim().length < 2) {
            mostrarError(nombre, 'El nombre debe tener al menos 2 caracteres.');
            valido = false;
        }

        var apellido1 = form.querySelector('[name="apellido_1"]');
        if (!apellido1.value.trim()) {
            mostrarError(apellido1, 'El primer apellido es obligatorio.');
            valido = false;
        } else if (apellido1.value.trim().length < 2) {
            mostrarError(apellido1, 'El apellido debe tener al menos 2 caracteres.');
            valido = false;
        }

        var email = form.querySelector('[name="email"]');
        if (!email.value.trim()) {
            mostrarError(email, 'El correo electrónico es obligatorio.');
            valido = false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
            mostrarError(email, 'El correo electrónico no tiene un formato válido (ej: usuario@dominio.com).');
            valido = false;
        }

        var telefono = form.querySelector('[name="telefono"]');
        if (!telefono.value.trim()) {
            mostrarError(telefono, 'El teléfono es obligatorio.');
            valido = false;
        } else if (telefono.value.trim().length < 7) {
            mostrarError(telefono, 'El teléfono debe tener al menos 7 dígitos.');
            valido = false;
        }

        var idRol = form.querySelector('[name="id_rol"]');
        if (!idRol.value) {
            mostrarError(idRol, 'Debes seleccionar un rol.');
            valido = false;
        }

        if (!valido) {
            form.querySelector('.btn[type="submit"]').focus();
        }
        return valido;
    }

    document.getElementById('crearUsuarioForm').addEventListener('submit', function(e) {
        if (!validarFormularioCrear(this)) {
            e.preventDefault();
            e.stopPropagation();
        }
    });

    document.getElementById('crearUsuarioForm').addEventListener('reset', function() {
        limpiarErrores(this);
    });

    @if($errors->any() && session('_modal') === 'crear')
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('crearUsuarioModal'));
            modal.show();
        });
    @endif

    document.getElementById('verUsuarioModal').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        document.getElementById('verName').textContent = button.getAttribute('data-name');
        document.getElementById('verUsername').textContent = button.getAttribute('data-username') || 'Sin nombre de usuario';
        document.getElementById('verEmail').textContent = button.getAttribute('data-email') || '—';
        document.getElementById('verTelefonos').textContent = button.getAttribute('data-telefonos') || '—';
        document.getElementById('verCorreos').textContent = button.getAttribute('data-correos') || '—';
        document.getElementById('verRol').textContent = button.getAttribute('data-rol');
        document.getElementById('verEstado').textContent = button.getAttribute('data-activo');

        var nombre = button.getAttribute('data-name') || '';
        var avatar = document.getElementById('verAvatar');
        if (avatar) avatar.textContent = nombre.trim().substring(0, 2).toUpperCase() || '--';
    });

    document.getElementById('editarUsuarioModal').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var name = button.getAttribute('data-name');
        var email = button.getAttribute('data-email');
        var username = button.getAttribute('data-username');
        var rol = button.getAttribute('data-rol');
        var activo = button.getAttribute('data-activo');

        document.getElementById('editName').value = name;
        document.getElementById('editEmail').value = email;
        document.getElementById('editUsername').value = username || '';
        document.getElementById('editRol').value = rol;
        document.getElementById('editActivo').value = activo;

        document.getElementById('editarUsuarioForm').action = '/admin/usuarios/' + id;
    });

    function confirmarEliminacion(id, nombre) {
        document.getElementById('eliminarUsuarioNombre').textContent = nombre;
        document.getElementById('eliminarUsuarioForm').action = '/admin/usuarios/' + id;
        var modal = new bootstrap.Modal(document.getElementById('eliminarUsuarioModal'));
        modal.show();
    }
</script>

@endsection
