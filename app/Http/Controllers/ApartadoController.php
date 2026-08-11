<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartado;
use App\Models\Categoria;
use App\Models\Rubrica;

class ApartadoController extends Controller
{
    /**
     * Mostrar todos los apartados.
     */
    public function index()
    {
        $categorias = Categoria::with([
            'apartados' => function ($query) {

                $query->withCount('preguntas')
                    ->with('preguntas')
                    ->orderBy('Orden');

            }
        ])->get();

        return view('apartados.index', compact('categorias'));
    }

    /**
     * Formulario para crear un apartado.
     */
    public function create()
    {
        $rubricas = Rubrica::where('Estado', 'Activo')->get();
        $categorias = Categoria::all();

        return view('apartados.create', compact('categorias','rubricas'));
    }

    /**
     * Guardar un apartado.
     */
   public function store(Request $request)
{
    $request->validate([
        'Titulo' => 'required|string|max:255',
        'ID_Categoria' => 'required|exists:categorias,ID_Categoria',
        'ID_Rubrica' => 'required|exists:rubricas,ID_Rubrica',
    ]);

    // Obtener el último orden de la categoría seleccionada
    $ultimoOrden = Apartado::where('ID_Categoria', $request->ID_Categoria)
    ->where('ID_Rubrica', $request->ID_Rubrica)
    ->max('Orden');

    Apartado::create([
        'Titulo' => $request->Titulo,
        'ID_Categoria' => $request->ID_Categoria,
        'ID_Rubrica' => $request->ID_Rubrica,
        'Orden' => ($ultimoOrden ?? 0) + 1,
        'Estado' => 'Activo',
    ]);

    return redirect()
        ->route('apartados.index')
        ->with('success', 'Apartado creado correctamente.');
}

    /**
     * Mostrar un apartado.
     */
    public function show(string $id)
    {
        $apartado = Apartado::with([
            'categoria',
            'preguntas',
            'rubrica'
        ])->findOrFail($id);

        return view('apartados.show', compact('apartado'));
    }

    /**
     * Formulario para editar.
     */
    public function edit(string $id)
    {
        $apartado = Apartado::findOrFail($id);
        $categorias = Categoria::all();
        $rubricas = Rubrica::all();

        return view('apartados.edit', compact(
            'apartado',
            'categorias',
            'rubricas'
        ));
    }

    /**
     * Actualizar un apartado.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
    'Titulo' => 'required|string|max:255',
    'ID_Categoria' => 'required|exists:categorias,ID_Categoria',
    'ID_Rubrica' => 'required|exists:rubricas,ID_Rubrica',
    
]);

        $apartado = Apartado::findOrFail($id);

        $apartado->update([
            'Titulo' => $request->Titulo,
            'ID_Categoria' => $request->ID_Categoria,
            'ID_Rubrica' => $request->ID_Rubrica,
            'Estado' => 'Activo',
        ]);

        return redirect()
            ->route('apartados.index')
            ->with('success', 'Apartado actualizado correctamente.');
    }

    /**
     * Eliminar un apartado.
     */
    public function destroy(string $id)
    {
        $apartado = Apartado::findOrFail($id);

        $apartado->Update([
            'Estado' => 'Inactivo'
        ]);

        return redirect()
            ->route('apartados.index')
            ->with('success', 'Apartado eliminado correctamente.');
    }
}