<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rubrica;

class RubricaController extends Controller
{
    /**
     * Mostrar todas las rúbricas.
     */
    public function index()
    {
        $rubricas = Rubrica::orderBy('Nombre')->get();

        return view('rubricas.index', compact('rubricas'));
    }

    /**
     * Mostrar formulario para crear.
     */
    public function create()
    {
        return view('rubricas.create');
    }

    /**
     * Guardar una nueva rúbrica.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:255|unique:rubricas,Nombre',
        ]);

        Rubrica::create([
            'Nombre' => $request->Nombre,
            'Estado' => 'Activo',
        ]);

        return redirect()
            ->route('rubricas.index')
            ->with('success', 'Rúbrica creada correctamente.');
    }

    /**
     * Mostrar una rúbrica.
     */
    public function show(string $id)
    {
        $rubrica = Rubrica::findOrFail($id);

        return view('rubricas.show', compact('rubrica'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(string $id)
    {
        $rubrica = Rubrica::findOrFail($id);

        return view('rubricas.edit', compact('rubrica'));
    }

    /**
     * Actualizar una rúbrica.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'Nombre' => 'required|string|max:255|unique:rubricas,Nombre,' . $id . ',ID_Rubrica',
            'Estado' => 'required|in:Activo,Inactivo',
        ]);

        $rubrica = Rubrica::findOrFail($id);

        $rubrica->update([
            'Nombre' => $request->Nombre,
            'Estado' => $request->Estado,
        ]);

        return redirect()
            ->route('rubricas.index')
            ->with('success', 'Rúbrica actualizada correctamente.');
    }

    /**
     * Desactivar una rúbrica.
     */
    public function destroy(string $id)
    {
        $rubrica = Rubrica::findOrFail($id);

        $rubrica->update([
            'Estado' => 'Inactivo',
        ]);

        return redirect()
            ->route('rubricas.index')
            ->with('success', 'Rúbrica desactivada correctamente.');
    }
}