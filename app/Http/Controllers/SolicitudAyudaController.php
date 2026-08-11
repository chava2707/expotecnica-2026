<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SolicitudAyuda;

class SolicitudAyudaController extends Controller
{
    public function solicitar(Request $request)
    {
        $user = Auth::user();

        $existePendiente = SolicitudAyuda::where('ID_Usuario', $user->id)
            ->where('Estado', 'Pendiente')
            ->exists();

        if ($existePendiente) {
            return back()->with('error', 'Ya tiene una solicitud de ayuda pendiente.');
        }

        SolicitudAyuda::create([
            'ID_Usuario' => $user->id,
            'Mensaje' => $request->input('mensaje', 'Solicitud de asistencia en sitio.'),
            'Estado' => 'Pendiente',
        ]);

        return back()->with('success', 'Solicitud de ayuda enviada. Un administrador lo asistirá pronto.');
    }

    public function index()
    {
        $solicitudes = SolicitudAyuda::with(['usuario'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.ayudas.index', compact('solicitudes'));
    }

    public function resolver($id, Request $request)
    {
        $solicitud = SolicitudAyuda::findOrFail($id);
        $solicitud->update([
            'Estado' => 'Atendida',
            'Respuesta' => $request->input('respuesta', 'Asistencia enviada.'),
        ]);

        return back()->with('success', 'Solicitud marcada como atendida.');
    }

    public function cancelar($id)
    {
        $solicitud = SolicitudAyuda::findOrFail($id);
        $solicitud->update(['Estado' => 'Cancelada']);

        return back()->with('success', 'Solicitud cancelada.');
    }
}
