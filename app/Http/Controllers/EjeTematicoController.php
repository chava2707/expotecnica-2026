<?php

namespace App\Http\Controllers;

use App\Models\EjeTematico;
use App\Models\Categoria;
use Illuminate\Http\Request;

class EjeTematicoController extends Controller
{
  // Mostrar lista de ejes temáticos
  public function index()
  {
    // Traemos los ejes junto con su categoría asociada
    $ejes = EjeTematico::with('categoria')->get();
    return view('ejes_tematicos.index', compact('ejes'));
  }

  // Mostrar el formulario de creación
  public function create()
  {
    // Necesitamos las categorías para llenar un <select> en la vista
    $categorias = Categoria::all();
    return view('ejes_tematicos.create', compact('categorias'));
  }

  // Guardar el nuevo eje temático en la base de datos
  public function store(Request $request)
  {
    $request->validate([
      'Nombre' => 'required|string|max:255',
      'Descripcion' => 'nullable|string',
      'ID_Categoria' => 'required|exists:categorias,ID_Categoria',
    ]);

    EjeTematico::create([
      'Nombre' => $request->Nombre,
      'Descripcion' => $request->Descripcion,
      'ID_Categoria' => $request->ID_Categoria,
    ]);

    return redirect()->route('ejes.index')->with('success', 'Eje Temático creado exitosamente.');
  }

  // Mostrar el formulario de edición
  public function edit($id)
  {
    $eje = EjeTematico::findOrFail($id);
    $categorias = Categoria::all();
    return view('ejes_tematicos.edit', compact('eje', 'categorias'));
  }

  // Actualizar el eje en la base de datos
  public function update(Request $request, $id)
  {
    $request->validate([
      'Nombre' => 'required|string|max:255',
      'Descripcion' => 'nullable|string',
      'ID_Categoria' => 'required|exists:categorias,ID_Categoria',
    ]);

    $eje = EjeTematico::findOrFail($id);
    $eje->update([
      'Nombre' => $request->Nombre,
      'Descripcion' => $request->Descripcion,
      'ID_Categoria' => $request->ID_Categoria,
    ]);

    return redirect()->route('ejes.index')->with('success', 'Eje Temático actualizado exitosamente.');
  }

  // Eliminar el eje temático
  public function destroy($id)
  {
    $eje = EjeTematico::findOrFail($id);

    // Opcional: Verificar si el eje tiene proyectos asignados antes de borrar
    if ($eje->proyectos()->count() > 0) {
      return redirect()->route('ejes.index')->withErrors('No se puede eliminar porque hay proyectos asociados a este eje.');
    }

    $eje->delete();

    return redirect()->route('ejes.index')->with('success', 'Eje Temático eliminado exitosamente.');
  }
}