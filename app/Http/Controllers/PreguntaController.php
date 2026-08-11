<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pregunta;
use App\Models\Apartado;
use App\Models\Categoria;

class PreguntaController extends Controller
{
    /**
     * Muestra todas las preguntas.
     */
    public function index()
    {
            $categorias = Categoria::with([
        'apartados' => function ($query) {
            $query->orderBy('Orden');
        },
        'apartados.preguntas' => function ($query) {
            $query->where('Estado', 'Activo');
        }
    ])->get();

        return view('preguntas.index', compact('categorias'));
    }

    /**
     * Muestra el formulario para crear una pregunta.
     */
    public function create()
    {
        $apartados = Apartado::with('categoria')
    ->where('Estado', 'Activo')
    ->orderBy('ID_Categoria')
    ->orderBy('Orden')
    ->get();

        return view('preguntas.create', compact('apartados'));
    }

    /**
     * Guarda una nueva pregunta.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Pregunta' => 'required|string|max:255',
            'ID_Apartado' => 'required|exists:apartados,ID_Apartado',
            'Maxima_Calificacion' => 'required|integer|min:1',
        ]);

        Pregunta::create([
            'Pregunta' => $request->Pregunta,
            'ID_Apartado' => $request->ID_Apartado,
            'Maxima_Calificacion' => $request->Maxima_Calificacion,
            'Estado' => 'Activo',
        ]);

        return redirect()
            ->route('preguntas.index')
            ->with('success', 'La pregunta se registró correctamente.');
    }

    /**
     * Muestra una pregunta específica.
     */
    public function show(string $id)
    {
        $pregunta = Pregunta::with('apartado')->findOrFail($id);

        return view('preguntas.show', compact('pregunta'));
    }

    /**
     * Muestra el formulario para editar una pregunta.
     */
    public function edit(string $id)
    {
        $pregunta = Pregunta::findOrFail($id);

        $apartados = Apartado::with('categoria')
            ->orderBy('ID_Categoria')
            ->orderBy('Orden')
            ->get();

        return view('preguntas.edit', compact('pregunta', 'apartados'));
    }

    /**
     * Actualiza una pregunta.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'Pregunta' => 'required|string|max:255',
            'ID_Apartado' => 'required|exists:apartados,ID_Apartado',
            'Maxima_Calificacion' => 'required|integer|min:1',
            
        ]);

        $pregunta = Pregunta::findOrFail($id);

        $pregunta->update([
            'Pregunta' => $request->Pregunta,
            'ID_Apartado' => $request->ID_Apartado,
            'Maxima_Calificacion' => $request->Maxima_Calificacion,
            'Estado' => 'Activo',
        ]);

        return redirect()
            ->route('preguntas.index')
            ->with('success', 'Pregunta actualizada correctamente.');
    }

    /**
     * Desactiva una pregunta.
     */
    public function destroy(string $id)
    {
        $pregunta = Pregunta::findOrFail($id);

        $pregunta->update([
            'Estado' => 'Inactivo'
        ]);

        return redirect()
            ->route('preguntas.index')
            ->with('success', 'La pregunta fue desactivada correctamente.');
    }
}