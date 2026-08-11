<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudEdicion;
use App\Models\Calificacion;

class SolicitudEdicionController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudEdicion::with(['calificacion.proyecto', 'usuario'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.solicitudes.index', compact('solicitudes'));
    }

    public function aprobar($id)
    {
        $solicitud = SolicitudEdicion::findOrFail($id);
        $solicitud->update(['Estado' => 'Aprobada']);

        return back()->with('success', 'Solicitud aprobada. El juez ya puede editar la evaluación.');
    }

    public function rechazar($id)
    {
        $solicitud = SolicitudEdicion::findOrFail($id);
        $solicitud->update(['Estado' => 'Rechazada']);

        return back()->with('success', 'Solicitud rechazada.');
    }
}
