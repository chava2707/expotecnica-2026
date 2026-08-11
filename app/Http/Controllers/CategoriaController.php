<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{


  public function index()
  {
    $categorias = Categoria::all();
    return view('categorias.index', compact('categorias'));
  }

  public function create()
  {

    return view('categorias.create');
  }

  public function store(Request $request)
  {

    $request->validate([
      'nombre' => 'required|string|max:255',
      'descripcion' => 'required|string',
    ]);


    Categoria::create([
      'Nombre' => $request->nombre,
      'Descripcion' => $request->descripcion,
    ]);

    return redirect()->route('categorias.index')
      ->with('success', 'Categoría creada exitosamente.');
  }

  public function edit($id)
  {

    $categoria = Categoria::where('ID_Categoria', $id)->firstOrFail();
    return view('categorias.edit', compact('categoria'));
  }

  public function update(Request $request, string $id)
  {

    $categoria = Categoria::where('ID_Categoria', $id)->firstOrFail();

    $request->validate([
      'nombre' => 'required|string|max:255',
      'descripcion' => 'required|string',
    ]);

    $categoria->update([
      'Nombre' => $request->nombre,
      'Descripcion' => $request->descripcion,
    ]);

    return redirect()->route('categorias.index')
      ->with('success', 'Categoría actualizada.');
  }

  public function destroy($id)
  {
    $categoria = Categoria::where('ID_Categoria', $id)->firstOrFail();

    // 1. Verificamos si existen proyectos usando esta categoría
    // Usamos 'ID_categoria' que es el nombre de la columna en tu tabla proyectos
    $proyectosAsociados = \App\Models\Proyecto::where('ID_categoria', $id)->count();

    if ($proyectosAsociados > 0) {
      // 2. Si hay proyectos, cancelamos y mandamos un mensaje de error
      return redirect()->route('categorias.index')
        ->with('error', 'No puedes eliminar esta categoría porque hay proyectos usándola.');
    }

    // 3. Si no hay proyectos, procedemos a eliminarla normalmente
    $categoria->delete();

    return redirect()->route('categorias.index')
      ->with('success', 'Categoría eliminada.');
  }
}