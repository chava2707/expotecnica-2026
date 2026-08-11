@extends('plantillas.layout-admin')
@section('Title', 'Solicitudes de Edición')
@section('AdminSidebarActiveSolicitudes', 'active')

@section('Main')
<style>
    body { font-family: 'Inter', sans-serif; background-color: #f7f9fb; }

    .solicitud-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #E2E8F0;
        padding: 20px;
        transition: all 0.2s;
    }
    .solicitud-card:hover {
        box-shadow: 0 4px 16px rgba(44, 62, 80, 0.1);
    }
    .solicitud-card.pendiente { border-left: 4px solid #e65100; }
    .solicitud-card.aprobada { border-left: 4px solid #2e7d32; }
    .solicitud-card.rechazada { border-left: 4px solid #ba1a1a; }
    .solicitud-card.usada { border-left: 4px solid #4e6073; }

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
    .estado-badge.aprobada { background: #e8f5e9; color: #2e7d32; }
    .estado-badge.rechazada { background: #ffebee; color: #ba1a1a; }
    .estado-badge.usada { background: #eceef0; color: #4e6073; }

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
    .btn-admin--aprobar { background: #2e7d32; color: #fff; }
    .btn-admin--aprobar:hover { background: #1b5e20; }
    .btn-admin--rechazar { background: #ba1a1a; color: #fff; }
    .btn-admin--rechazar:hover { background: #8e1c1c; }
    .btn-admin--disabled { background: #e0e3e5; color: #897365; cursor: default; }
</style>

<div class="p-3 p-lg-4" style="background-color: #f7f9fb; min-height: 100vh; padding-top: 60px !important;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 style="font-family: 'Inter', sans-serif; font-size: 1.5rem; font-weight: 700; color: #191c1e; margin-bottom: 4px;">
                Solicitudes de Edición
            </h1>
            <p style="font-size: 0.875rem; color: #4e6073; margin-bottom: 0;">
                Gestione las solicitudes de los jueces para modificar evaluaciones ya enviadas.
            </p>
        </div>
        <a href="{{ route('admin.dashboard') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.875rem;font-weight:600;color:#564337;text-decoration:none;padding:8px 16px;border-radius:8px;background:#fff;border:1px solid #E2E8F0;">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="d-flex flex-column gap-3">
        @forelse($solicitudes as $solicitud)
        <div class="solicitud-card {{ strtolower($solicitud->Estado) }}">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div class="d-flex align-items-start gap-3">
                    <div class="judge-avatar" style="background-color:{{ $solicitud->Estado === 'Pendiente' ? '#ffcc80' : ($solicitud->Estado === 'Aprobada' ? '#c8e6c9' : '#ffcdd2') }};color:#191c1e;width:44px;height:44px;font-size:.875rem;">
                        {{ strtoupper(substr($solicitud->usuario->name ?? 'J', 0, 2)) }}
                    </div>
                    <div>
                        <p style="font-size:1rem;font-weight:600;color:#191c1e;margin-bottom:2px;">
                            {{ $solicitud->usuario->name ?? 'Juez sin nombre' }}
                        </p>
                        <p style="font-size:.875rem;color:#564337;margin-bottom:4px;">
                            Solicita editar: <strong style="color:#944a00;">{{ $solicitud->calificacion->proyecto->Nombre ?? 'Proyecto' }}</strong>
                            <span style="color:#897365;">(Puntaje: {{ $solicitud->calificacion->Nota_Final ?? 'N/A' }})</span>
                        </p>
                        @if($solicitud->Motivo)
                        <p style="font-size:.8125rem;color:#564337;margin-bottom:4px;font-style:italic;background:#f7f9fb;padding:8px 12px;border-radius:6px;border:1px solid #E2E8F0;">
                            "{{ $solicitud->Motivo }}"
                        </p>
                        @endif
                        <p style="font-size:.75rem;color:#897365;margin-bottom:0;">
                            <i class="bi bi-clock" style="margin-right:4px;"></i>
                            {{ $solicitud->created_at->diffForHumans() }}
                            @if($solicitud->updated_at && $solicitud->updated_at != $solicitud->created_at)
                                · Procesado {{ $solicitud->updated_at->diffForHumans() }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="estado-badge {{ strtolower($solicitud->Estado) }}">
                        @if($solicitud->Estado === 'Pendiente')
                            <i class="bi bi-clock-history" style="margin-right:4px;"></i>
                        @elseif($solicitud->Estado === 'Aprobada')
                            <i class="bi bi-check-circle" style="margin-right:4px;"></i>
                        @elseif($solicitud->Estado === 'Rechazada')
                            <i class="bi bi-x-circle" style="margin-right:4px;"></i>
                        @else
                            <i class="bi bi-check2-all" style="margin-right:4px;"></i>
                        @endif
                        {{ $solicitud->Estado }}
                    </span>
                    @if($solicitud->Estado === 'Pendiente')
                    <div class="d-flex gap-2">
                        <form action="{{ route('admin.solicitudes.aprobar', $solicitud->ID_Solicitud) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-admin btn-admin--aprobar">
                                <i class="bi bi-check-lg"></i> Aprobar
                            </button>
                        </form>
                        <form action="{{ route('admin.solicitudes.rechazar', $solicitud->ID_Solicitud) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-admin btn-admin--rechazar">
                                <i class="bi bi-x-lg"></i> Rechazar
                            </button>
                        </form>
                    </div>
                    @else
                    <button class="btn-admin btn-admin--disabled" disabled>
                        @if($solicitud->Estado === 'Aprobada')
                            <i class="bi bi-check-circle"></i> Ya Aprobada
                        @elseif($solicitud->Estado === 'Rechazada')
                            <i class="bi bi-x-circle"></i> Ya Rechazada
                        @else
                            <i class="bi bi-check2-all"></i> Utilizada
                        @endif
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="solicitud-card" style="text-align:center;padding:48px;">
            <i class="bi bi-inbox" style="font-size:3rem;color:#d8dadc;display:block;margin-bottom:12px;"></i>
            <p style="font-size:1rem;font-weight:600;color:#191c1e;margin-bottom:4px;">No hay solicitudes de edición</p>
            <p style="font-size:0.875rem;color:#897365;margin-bottom:0;">Las solicitudes de los jueces aparecerán aquí.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
