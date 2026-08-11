@extends('plantillas.layout-admin')
@section('Title', 'Avisos de Impresión')
@section('AdminSidebarActiveAvisos', 'active')

@section('Main')
<style>
    body { font-family: 'Inter', sans-serif; background-color: #f7f9fb; }

    .aviso-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #E2E8F0;
        padding: 20px;
        transition: all 0.2s;
    }
    .aviso-card:hover {
        box-shadow: 0 4px 16px rgba(44, 62, 80, 0.1);
    }
    .aviso-card.pendiente { border-left: 4px solid #e65100; }
    .aviso-card.recogido { border-left: 4px solid #2e7d32; }
    .aviso-card.cancelado { border-left: 4px solid #78909c; }

    .estado-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }
    .estado-badge.pendiente { background: #fff3e0; color: #e65100; }
    .estado-badge.recogido { background: #e8f5e9; color: #2e7d32; }
    .estado-badge.cancelado { background: #eceff1; color: #546e7a; }

    .btn-admin {
        height: 36px;
        padding: 0 16px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8125rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }
    .btn-admin--recoger { background: #2e7d32; color: #fff; }
    .btn-admin--recoger:hover { background: #1b5e20; }
    .btn-admin--cancelar { background: #78909c; color: #fff; }
    .btn-admin--cancelar:hover { background: #546e7a; }
    .btn-admin--disabled { background: #e0e3e5; color: #897365; cursor: default; }
</style>

<div class="p-3 p-lg-4" style="background-color: #f7f9fb; min-height: 100vh; padding-top: 60px !important;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 style="font-family: 'Inter', sans-serif; font-size: 1.5rem; font-weight: 700; color: #191c1e; margin-bottom: 4px;">
                Avisos de Impresión
            </h1>
            <p style="font-size: 0.875rem; color: #4e6073; margin-bottom: 0;">
                Documentos impresos listos para recoger. Vea el PDF para entregarlo al juez o coordinación.
            </p>
        </div>
        <a href="{{ route('admin.dashboard') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.875rem;font-weight:600;color:#564337;text-decoration:none;padding:8px 16px;border-radius:8px;background:#fff;border:1px solid #E2E8F0;">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="d-flex flex-column gap-3">
        @forelse($avisos as $aviso)
        @php
            $proyecto = $aviso->correo?->proyecto ?? $aviso->proyecto;
        @endphp
        <div class="aviso-card {{ strtolower($aviso->Estado) }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div class="d-flex align-items-start gap-3">
                    <div class="judge-avatar" style="background-color:{{ $aviso->Estado === 'Pendiente' ? '#ffcc80' : ($aviso->Estado === 'Recogido' ? '#c8e6c9' : '#cfd8dc') }};color:#191c1e;width:48px;height:48px;font-size:.9rem;">
                        {{ strtoupper(substr($proyecto->Nombre ?? 'P', 0, 2)) }}
                    </div>
                    <div>
                        <p style="font-size:1rem;font-weight:600;color:#191c1e;margin-bottom:2px;">
                            {{ $proyecto->Nombre ?? 'Proyecto' }}
                        </p>
                        <p style="font-size:.875rem;color:#564337;margin-bottom:4px;">
                            <span style="color:#897365;">Categoría:</span> {{ $proyecto->categoria->Nombre ?? '—' }}
                        </p>
                        <p style="font-size:.8125rem;color:#897365;margin-bottom:4px;">
                            <i class="bi bi-envelope" style="margin-right:4px;"></i>
                            Documento enviado a: {{ $aviso->correo?->Correo_destino ?? '—' }}
                        </p>
                        @if($aviso->correo?->Archivo_PDF)
                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($aviso->correo->Archivo_PDF) }}"
                           target="_blank"
                           style="display:inline-flex;align-items:center;gap:6px;font-size:.8125rem;font-weight:600;color:#944a00;text-decoration:none;">
                            <i class="bi bi-file-earmark-pdf" style="margin-right:4px;"></i> Ver PDF
                        </a>
                        @endif
                        <p style="font-size:.75rem;color:#897365;margin-bottom:0;">
                            <i class="bi bi-clock" style="margin-right:4px;"></i>
                            Avisado {{ $aviso->created_at->diffForHumans() }}
                            @if($aviso->Fecha_Recogido)
                                · Recogido {{ \Illuminate\Support\Carbon::parse($aviso->Fecha_Recogido)->diffForHumans() }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="estado-badge {{ strtolower($aviso->Estado) }}">
                        @if($aviso->Estado === 'Pendiente')
                            <i class="bi bi-printer-fill" style="margin-right:4px;"></i>
                        @elseif($aviso->Estado === 'Recogido')
                            <i class="bi bi-check-circle" style="margin-right:4px;"></i>
                        @else
                            <i class="bi bi-x-circle" style="margin-right:4px;"></i>
                        @endif
                        {{ $aviso->Estado }}
                    </span>
                    @if($aviso->Estado === 'Pendiente')
                    <div class="d-flex gap-2">
                        <form action="{{ route('admin.avisos.recoger', $aviso->ID_Aviso) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-admin btn-admin--recoger">
                                <i class="bi bi-check-lg"></i> Marcar como recogido
                            </button>
                        </form>
                        <form action="{{ route('admin.avisos.cancelar', $aviso->ID_Aviso) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-admin btn-admin--cancelar">
                                <i class="bi bi-x-lg"></i> Cancelar
                            </button>
                        </form>
                    </div>
                    @else
                    <button class="btn-admin btn-admin--disabled" disabled>
                        @if($aviso->Estado === 'Recogido')
                            <i class="bi bi-check-circle"></i> Ya recogido
                        @else
                            <i class="bi bi-x-circle"></i> Cancelado
                        @endif
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="aviso-card" style="text-align:center;padding:48px;">
            <i class="bi bi-printer" style="font-size:3rem;color:#d8dadc;display:block;margin-bottom:12px;"></i>
            <p style="font-size:1rem;font-weight:600;color:#191c1e;margin-bottom:4px;">No hay avisos de impresión</p>
            <p style="font-size:0.875rem;color:#897365;margin-bottom:0;">Cuando alguien confirme la impresión de un documento, aparecerá aquí.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
