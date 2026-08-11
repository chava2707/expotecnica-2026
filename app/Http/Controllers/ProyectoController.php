<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Proyecto;
use App\Models\Categoria;
use App\Models\EjeTematico;
use App\Models\Calificacion;

class ProyectoController extends Controller
{
  public function index()
  {
    $proyectos = Proyecto::with('categoria')->get();
    return view('proyectos.index', compact('proyectos'));
  }

  public function show(string $id)
  {
    $proyecto = Proyecto::with(['categoria', 'personasAsignadas.usuario.persona', 'calificaciones'])->findOrFail($id);
    return view('proyectos.show', compact('proyecto'));
  }

  public function create()
  {
    $categorias = Categoria::all();
    $ejes = EjeTematico::all();

    // VALIDACIÓN: Si la tabla de ejes temáticos está vacía...
    if ($ejes->isEmpty()) {
      // Redirigimos de vuelta a la lista con un mensaje de error flash
      return redirect()->route('admin.proyectos') // Asegúrate de que esta sea la ruta correcta de tu index
        ->with('error', 'Agregue primero un Eje Temático para poder crear un proyecto.');
    }

    // Si sí hay ejes, mostramos la vista normalmente
    return view('proyectos.create', compact('categorias', 'ejes'));
  }

  public function store(Request $request)
  {
    // ¡CORRECCIÓN AQUÍ! Validamos el ID_Eje
    $request->validate([
      'nombre'       => 'required|string|max:255',
      'categoria_id' => 'required|exists:categorias,ID_Categoria',
      'ID_Eje'       => 'required|exists:ejes_tematicos,ID_Eje', // Nueva validación
      'descripcion'  => 'required|string',
      'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
      'archivo_pdf'  => 'nullable|mimes:pdf|max:20480',
    ]);

    $rutaImagen = null;
    if ($request->hasFile('imagen')) {
      // Se guardará en storage/app/public/proyectos
      $rutaImagen = $request->file('imagen')->store('proyectos', 'public');
    }

    $rutaPdf = null;
    if ($request->hasFile('archivo_pdf')) {
      // Se guardará en storage/app/public/proyectos
      $rutaPdf = $request->file('archivo_pdf')->store('proyectos', 'public');
    }

    // ¡CORRECCIÓN AQUÍ! Guardamos el ID_Eje en la BD
    Proyecto::create([
      'Nombre'       => $request->nombre,
      'ID_categoria' => $request->categoria_id,
      'ID_Eje'       => $request->ID_Eje, // Nuevo campo
      'Descripcion'  => $request->descripcion,
      'Imagen'       => $rutaImagen,
      'Archivo_PDF'  => $rutaPdf,
    ]);

    return redirect()->route('admin.proyectos')
      ->with('success', 'El proyecto se guardó correctamente.');
  }

  public function edit($id)
  {
    $proyecto = Proyecto::findOrFail($id);
    $categoria = Categoria::all();
    $ejes = EjeTematico::all();

    // ¡CORRECCIÓN AQUÍ! Agregamos 'ejes' al compact
    return view('proyectos.edit', compact('proyecto', 'categoria', 'ejes'));
  }

  public function update(Request $request, string $id)
  {
    // ¡CORRECCIÓN AQUÍ! Validamos el ID_Eje
    $request->validate([
      'nombre'       => 'required|string|max:255',
      'categoria_id' => 'required|exists:categorias,ID_Categoria',
      'ID_Eje'       => 'required|exists:ejes_tematicos,ID_Eje', // Nueva validación
      'descripcion'  => 'required|string',
      'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
      'archivo_pdf'  => 'nullable|mimes:pdf|max:20480',
    ]);

    $proyecto = Proyecto::where('ID_Proyecto', $id)->firstOrFail();

    // ¡CORRECCIÓN AQUÍ! Agregamos el ID_Eje para que se actualice
    $datosActualizar = [
      'Nombre'       => $request->nombre,
      'ID_categoria' => $request->categoria_id,
      'ID_Eje'       => $request->ID_Eje, // Nuevo campo
      'Descripcion'  => $request->descripcion,
    ];

    if ($request->hasFile('imagen')) {
      $rutaImagen = $request->file('imagen')->store('proyectos', 'public');
      $datosActualizar['Imagen'] = $rutaImagen;
    }

    if ($request->hasFile('archivo_pdf')) {
      if ($proyecto->Archivo_PDF && Storage::disk('public')->exists($proyecto->Archivo_PDF)) {
        Storage::disk('public')->delete($proyecto->Archivo_PDF);
      }
      $rutaPdf = $request->file('archivo_pdf')->store('proyectos', 'public');
      $datosActualizar['Archivo_PDF'] = $rutaPdf;
    }

    $proyecto->update($datosActualizar);

    return redirect()->route('admin.proyectos')->with('success', 'Se actualizo correctamente el proyecto');
  }

  public function destroy($id)
  {
    $proyecto = Proyecto::findOrFail($id);

    if ($proyecto->Imagen && Storage::disk('public')->exists($proyecto->Imagen)) {
      Storage::disk('public')->delete($proyecto->Imagen);
    }

    if ($proyecto->Archivo_PDF && Storage::disk('public')->exists($proyecto->Archivo_PDF)) {
      Storage::disk('public')->delete($proyecto->Archivo_PDF);
    }

    $proyecto->delete();

    return redirect()->route('admin.proyectos')->with('success', 'Proyecto eliminado correctamente.');
  }

  public function descargarTrabajo($id)
  {
    $proyecto = Proyecto::findOrFail($id);

    if (!$proyecto->Archivo_PDF || !Storage::disk('public')->exists($proyecto->Archivo_PDF)) {
      abort(404, 'El trabajo escrito de este proyecto no existe.');
    }

    $nombreDescarga = 'Trabajo-Escrito-' . $proyecto->ID_Proyecto . '-' . str_replace(' ', '-', $proyecto->Nombre) . '.pdf';

    return Storage::disk('public')->download($proyecto->Archivo_PDF, $nombreDescarga);
  }

  public function pdfs($id)
  {
    $proyecto = Proyecto::with(['categoria', 'calificaciones.usuario.persona', 'calificaciones.rubrica'])
      ->findOrFail($id);

    foreach ($proyecto->calificaciones as $calificacion) {
      $calificacion->ruta_pdf = $this->rutaPdf($calificacion);
    }

    return view('admin.proyectos.pdfs', compact('proyecto'));
  }

  public function pdf($proyectoId, $calificacionId)
  {
    $proyecto = Proyecto::findOrFail($proyectoId);

    $calificacion = Calificacion::where('ID_Calificaciones', $calificacionId)
      ->where('ID_Proyecto', $proyectoId)
      ->firstOrFail();

    $ruta = $this->rutaPdf($calificacion);

    if (!$ruta || !Storage::disk('public')->exists($ruta)) {
      abort(404, 'El PDF de esta evaluación no existe.');
    }

    return Storage::disk('public')->response($ruta, basename($ruta));
  }

  private function rutaPdf(Calificacion $calificacion): ?string
  {
    $patronExacto = 'evaluaciones/Rubrica-Evaluacion-' . $calificacion->ID_Proyecto
      . '-' . $calificacion->ID_Usuario . '-' . $calificacion->ID_Rubrica . '.pdf';

    if (Storage::disk('public')->exists($patronExacto)) {
      return $patronExacto;
    }

    $patronLegacy = 'Rubrica-Evaluacion-' . $calificacion->ID_Proyecto . '-' . $calificacion->ID_Usuario;
    foreach (Storage::disk('public')->files('evaluaciones') as $archivo) {
      if (str_starts_with(basename($archivo), $patronLegacy)) {
        return $archivo;
      }
    }

    return null;
  }
}
