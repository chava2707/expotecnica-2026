<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $correosDestino = Configuracion::getList(Configuracion::CORREO_EVALUACIONES_PDF, []);

        return view('admin.configuracion.index', compact('correosDestino'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'correo_destino' => 'nullable|email|max:255',
            'correo_destino_2' => 'nullable|email|max:255',
        ]);

        $correos = array_values(array_filter([
            trim((string) $request->input('correo_destino')),
            trim((string) $request->input('correo_destino_2')),
        ]));

        Configuracion::set(
            Configuracion::CORREO_EVALUACIONES_PDF,
            $correos ? implode(', ', $correos) : null
        );

        return redirect()->route('admin.configuracion')
            ->with('success', 'Correos destino actualizados correctamente.');
    }
}
