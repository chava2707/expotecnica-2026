<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AvisoImpresion;
use App\Models\CorreoEnviado;

class AvisoImpresionController extends Controller
{
    public function confirmar($correoEnviado)
    {
        $correo = CorreoEnviado::findOrFail($correoEnviado);

        $yaConfirmado = AvisoImpresion::where('ID_Correo', $correo->ID_Correo)->exists();

        $aviso = AvisoImpresion::firstOrCreate(
            ['ID_Correo' => $correo->ID_Correo],
            [
                'ID_Proyecto' => $correo->ID_Proyecto,
                'Estado' => 'Pendiente',
            ]
        );

        return view('avisos.impresion-confirmada', compact('correo', 'aviso', 'yaConfirmado'));
    }

    public function index()
    {
        $avisos = AvisoImpresion::with(['correo.proyecto', 'proyecto'])
            ->orderByRaw("FIELD(Estado, 'Pendiente', 'Recogido', 'Cancelado')")
            ->orderByDesc('created_at')
            ->get();

        return view('admin.avisos.index', compact('avisos'));
    }

    public function recoger($id)
    {
        $aviso = AvisoImpresion::findOrFail($id);

        $aviso->update([
            'Estado' => 'Recogido',
            'Fecha_Recogido' => now(),
        ]);

        return back()->with('success', 'Aviso marcado como recogido. El documento ya puede entregarse.');
    }

    public function cancelar($id)
    {
        $aviso = AvisoImpresion::findOrFail($id);

        $aviso->update(['Estado' => 'Cancelado']);

        return back()->with('success', 'Aviso cancelado.');
    }
}
