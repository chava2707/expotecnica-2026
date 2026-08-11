<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonaAsignada;
use App\Models\User;
use App\Models\Proyecto;

class PersonaAsignadaController extends Controller
{
  public function index($id_proyecto)
  {
    $proyecto = Proyecto::findOrFail($id_proyecto);

    $usuarios = User::with('rol')->whereHas('rol', function ($query) {
      $query->whereIn('Nombre_rol', [
        'estudiante',
        'Estudiante',
        'jurado',
        'juez',
        'Juez',
        'Jurado',
        'juez suplente',
        'jurado suplente',
        'Juez Suplente',
        'Jurado Suplente'
      ]);
    })->get();

    $asignaciones = PersonaAsignada::with(['usuario.rol'])
      ->where('ID_Proyecto', $id_proyecto)
      ->get();

    // Calcular contadores para las alertas dinámicas en la vista
    $juecesTitularesContador = $asignaciones->filter(function ($asig) {
      return in_array(strtolower(trim($asig->usuario->rol->Nombre_rol ?? '')), ['juez', 'jurado']);
    })->count();

    $juecesSuplentesContador = $asignaciones->filter(function ($asig) {
      return in_array(strtolower(trim($asig->usuario->rol->Nombre_rol ?? '')), ['juez suplente', 'jurado suplente']);
    })->count();

    return view('asignaciones.index', compact(
      'proyecto',
      'usuarios',
      'asignaciones',
      'juecesTitularesContador',
      'juecesSuplentesContador'
    ));
  }

  public function store(Request $request)
  {
    $request->validate([
      'ID_Usuario' => 'required|exists:users,id',
      'ID_Proyecto' => 'required|exists:proyectos,ID_Proyecto',
    ]);

    $usuario = User::with('rol')->findOrFail($request->ID_Usuario);
    $idProyecto = $request->ID_Proyecto;

    $asignacionExistente = PersonaAsignada::where('ID_Usuario', $usuario->id)
      ->where('ID_Proyecto', $idProyecto)
      ->exists();

    if ($asignacionExistente) {
      return back()->withErrors(['error' => 'Este usuario ya está asignado a este proyecto.'])->withInput();
    }

    $nombreRol = strtolower(trim($usuario->rol->Nombre_rol ?? ''));

    $cantidadProyectosDelUsuario = PersonaAsignada::where('ID_Usuario', $usuario->id)->count();

    $juecesTitularesEnProyecto = PersonaAsignada::where('ID_Proyecto', $idProyecto)
      ->whereHas('usuario.rol', function ($q) {
        $q->whereIn('Nombre_rol', ['juez', 'jurado', 'Juez', 'Jurado']);
      })->count();

    $juecesSuplentesEnProyecto = PersonaAsignada::where('ID_Proyecto', $idProyecto)
      ->whereHas('usuario.rol', function ($q) {
        $q->whereIn('Nombre_rol', ['juez suplente', 'jurado suplente', 'Juez Suplente', 'Jurado Suplente']);
      })->count();

    if ($nombreRol === 'estudiante') {
      if ($cantidadProyectosDelUsuario >= 1) {
        return back()->withErrors(['error' => 'El estudiante ya alcanzó el límite de 1 proyecto asignado.'])->withInput();
      }
    } elseif ($nombreRol === 'jurado' || $nombreRol === 'juez') {
      if ($cantidadProyectosDelUsuario >= 3) {
        return back()->withErrors(['error' => 'El juez/jurado ya alcanzó el límite máximo de 3 proyectos asignados en total.'])->withInput();
      }

      if ($juecesTitularesEnProyecto >= 3) {
        return back()->withErrors(['error' => 'Este proyecto ya cuenta con el límite máximo de 3 jueces titulares asignados.'])->withInput();
      }
    } elseif ($nombreRol === 'juez suplente' || $nombreRol === 'jurado suplente') {
      if ($cantidadProyectosDelUsuario >= 3) {
        return back()->withErrors(['error' => 'El juez suplente ya alcanzó el límite máximo de 3 proyectos asignados en total.'])->withInput();
      }

      if ($juecesSuplentesEnProyecto >= 2) {
        return back()->withErrors(['error' => 'Este proyecto ya cuenta con el límite máximo de 2 jueces suplentes asignados.'])->withInput();
      }
    } else {
      return back()->withErrors(['error' => 'El rol de este usuario (' . ($usuario->rol->Nombre_rol ?? 'Sin Rol') . ') no permite asignaciones de proyectos.'])->withInput();
    }

    PersonaAsignada::create([
      'ID_Usuario' => $usuario->id,
      'ID_Proyecto' => $idProyecto,
    ]);

    return back()->with('success', 'Usuario asignado al proyecto exitosamente.');
  }

  public function destroy($id)
  {
    $asignacion = PersonaAsignada::findOrFail($id);
    $asignacion->delete();

    return back()->with('success', 'La asignación ha sido removida exitosamente.');
  }
}
