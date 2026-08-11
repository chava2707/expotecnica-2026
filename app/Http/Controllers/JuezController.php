<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Jobs\EnviarCorreoEvaluacionJob;
use App\Models\Proyecto;
use App\Models\Calificacion;
use App\Models\PersonaAsignada;
use App\Models\Respuesta;
use App\Models\CorreoEnviado;
use App\Models\SolicitudEdicion;
use App\Models\Rubrica;
use App\Models\Apartado;
use App\Models\Configuracion;

class JuezController extends Controller
{
  public function dashboard()
  {
    $user = Auth::user();

    $asignaciones = PersonaAsignada::where('ID_Usuario', $user->id)
      ->with(['proyecto.categoria', 'proyecto.calificaciones', 'proyecto.personasAsignadas.usuario'])
      ->get();

    $proyectos = $asignaciones->pluck('proyecto')->filter()->unique('ID_Proyecto');

    $rubricas = Rubrica::where('Estado', 'Activo')
      ->orderBy('ID_Rubrica')
      ->get();

    $totalRubricas = $rubricas->count();

    $totalAsignados =  $proyectos->count();

    $completados = 0;

    foreach ($proyectos as $proyecto) {



      $misCalificaciones = $proyecto->calificaciones->where('ID_Usuario', $user->id);
      $evaluadasIds = $misCalificaciones?->pluck('ID_Rubrica');

      $proyecto->rubricasEvaluadas = $misCalificaciones->count();
      $proyecto->totalRubricas = $totalRubricas;
      $proyecto->completado = $totalRubricas > 0 && $misCalificaciones->count() >= $totalRubricas;
      $proyecto->pendiente = !$proyecto->completado;
      $proyecto->rubricasPendientes = $rubricas?->filter(function ($rubrica) use ($evaluadasIds) {
        return !$evaluadasIds->contains($rubrica->ID_Rubrica);
      });

      if ($proyecto->completado) {
        $completados++;
      }
    }

    $proyectosPendientes = $totalAsignados - $completados;

    $porcentajeGlobal = $totalAsignados > 0
      ? round(($completados / $totalAsignados) * 100)
      : 0;

    return view('juez.dashboard', compact(
      'proyectos',
      'totalAsignados',
      'completados',
      'proyectosPendientes',
      'porcentajeGlobal'
    ));
  }

  public function evaluaciones()
  {
    return view('juez.evaluaciones');
  }



  public function evaluar($proyectoId, $rubricaId)
  {
    $user = Auth::user();

    $asignado = PersonaAsignada::where('ID_Proyecto', $proyectoId)
      ->where('ID_Usuario', $user->id)
      ->exists();

    if (!$asignado) {
      abort(403, 'No tiene asignado este proyecto.');
    }

    $proyecto = Proyecto::with([
      'personasAsignadas.usuario'
    ])->findOrFail($proyectoId);

    $rubrica = Rubrica::findOrFail($rubricaId);

    $apartados = Apartado::with([
      'preguntas' => function ($query) {
        $query->where('Estado', 'Activo')
          ->orderBy('ID_Pregunta');
      }
    ])
      ->where('ID_Categoria', $proyecto->ID_categoria)
      ->where('ID_Rubrica', $rubricaId)
      ->where('Estado', 'Activo')
      ->orderBy('Orden')
      ->get();


    $respuestasExistentes = Respuesta::where('ID_Proyecto', $proyecto->ID_Proyecto)
      ->where('ID_Usuario', $user->id)
      ->where('ID_Rubrica', $rubricaId)
      ->pluck('Calificacion', 'ID_Pregunta')
      ->toArray();

    $comentariosExistentes = Respuesta::where('ID_Proyecto', $proyecto->ID_Proyecto)
      ->where('ID_Usuario', $user->id)
      ->where('ID_Rubrica', $rubricaId)
      ->pluck('Observaciones', 'ID_Pregunta')
      ->toArray();

    $calificacionExistente = Calificacion::where('ID_Proyecto', $proyecto->ID_Proyecto)
      ->where('ID_Usuario', $user->id)
      ->where('ID_Rubrica', $rubrica->ID_Rubrica)
      ->first();

    $bloqueado = false;
    $solicitudPendiente = false;
    $solicitudAprobada = false;

    if ($calificacionExistente && $calificacionExistente->Estado === 'Completado') {

      $bloqueado = true;

      $solicitudPendiente = SolicitudEdicion::where('ID_Calificacion', $calificacionExistente->ID_Calificaciones)
        ->where('ID_Usuario', $user->id)
        ->where('Estado', 'Pendiente')
        ->exists();

      $solicitudAprobada = SolicitudEdicion::where('ID_Calificacion', $calificacionExistente->ID_Calificaciones)
        ->where('ID_Usuario', $user->id)
        ->where('Estado', 'Aprobada')
        ->exists();

      if ($solicitudAprobada) {
        $bloqueado = false;
      }
    }

    return view('juez.evaluar', compact(
      'proyecto',
      'rubrica',
      'apartados',
      'respuestasExistentes',
      'comentariosExistentes',
      'calificacionExistente',
      'bloqueado',
      'solicitudPendiente',
      'solicitudAprobada'
    ));
  }






  public function rubricas($id)
  {
    $user = Auth::user();

    $asignado = PersonaAsignada::where('ID_Proyecto', $id)
      ->where('ID_Usuario', $user->id)
      ->exists();

    if (!$asignado) {
      abort(403, 'No tiene asignado este proyecto.');
    }

    $proyecto = Proyecto::with('categoria')->findOrFail($id);

    $rubricas = Rubrica::where('Estado', 'Activo')
      ->orderBy('ID_Rubrica')
      ->get();

    $calificaciones = Calificacion::where('ID_Proyecto', $proyecto->ID_Proyecto)
      ->where('ID_Usuario', $user->id)
      ->get()
      ->keyBy('ID_Rubrica');

    foreach ($rubricas as $rubrica) {

      $rubrica->calificacion = $calificaciones->get($rubrica->ID_Rubrica);

      $rubrica->evaluada = $rubrica->calificacion !== null;
    }

    return view(
      'juez.rubricas',
      compact(
        'proyecto',
        'rubricas'
      )
    );
  }




  public function configuracion()
  {
    return view('juez.configuracion');
  }

  public function lineamientos()
  {
    return view('juez.lineamientos');
  }

  public function updatePassword(Request $request)
  {
    $request->validate([
      'current_password' => ['required', 'string'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
      return back()->withErrors([
        'current_password' => 'La contraseña actual no es correcta.',
      ]);
    }

    $user->password = $request->password;
    $user->save();

    return back()->with('success', 'Contraseña actualizada correctamente.');
  }
  public function guardarEvaluacion(Request $request, Proyecto $proyecto, $rubricaId)
  {
    $user = Auth::user();

    $asignado = PersonaAsignada::where('ID_Proyecto', $proyecto->ID_Proyecto)
      ->where('ID_Usuario', $user->id)
      ->exists();

    if (!$asignado) {
      abort(403, 'No tiene asignado este proyecto.');
    }

    $calificacionExistente = Calificacion::where('ID_Proyecto', $proyecto->ID_Proyecto)
      ->where('ID_Usuario', $user->id)
      ->where('ID_Rubrica', $rubricaId)
      ->first();

    if ($calificacionExistente && $calificacionExistente->Estado === 'Completado') {
      $solicitudAprobada = SolicitudEdicion::where('ID_Calificacion', $calificacionExistente->ID_Calificaciones)
        ->where('ID_Usuario', $user->id)
        ->where('Estado', 'Aprobada')
        ->exists();

      if (!$solicitudAprobada) {
        return redirect()
          ->route('juez.evaluar', [$proyecto->ID_Proyecto, $rubricaId])
          ->with('error', 'No puede editar esta evaluación. Solicite permiso al administrador.');
      }

      SolicitudEdicion::where('ID_Calificacion', $calificacionExistente->ID_Calificaciones)
        ->where('ID_Usuario', $user->id)
        ->where('Estado', 'Aprobada')
        ->update(['Estado' => 'Usada']);
    }

    $apartados = Apartado::with([
      'preguntas' => function ($query) {
        $query->where('Estado', 'Activo');
      }
    ])
      ->where('ID_Categoria', $proyecto->ID_categoria)
      ->where('ID_Rubrica', $rubricaId)
      ->where('Estado', 'Activo')
      ->orderBy('Orden')
      ->get();

    $reglas = [];
    foreach ($apartados as $apartado) {
      foreach ($apartado->preguntas as $pregunta) {
        $reglas['pregunta_' . $pregunta->ID_Pregunta] = [
          'required',
          'integer',
          'between:0,' . $pregunta->Maxima_Calificacion,
        ];
        $reglas['comentario_' . $pregunta->ID_Pregunta] = ['nullable', 'string', 'max:2000'];
      }
    }

    $validated = $request->validate($reglas);

    $total = 0;

    foreach ($apartados as $apartado) {
      foreach ($apartado->preguntas as $pregunta) {
        $nota = $validated['pregunta_' . $pregunta->ID_Pregunta];
        $comentario = $request->input('comentario_' . $pregunta->ID_Pregunta);

        Respuesta::updateOrCreate(
          [
            'ID_Proyecto' => $proyecto->ID_Proyecto,
            'ID_Usuario' => $user->id,
            'ID_Pregunta' => $pregunta->ID_Pregunta,
            'ID_Rubrica' => $rubricaId,
          ],
          [
            'Calificacion' => $nota,
            'Observaciones' => $comentario,
            'Estado' => 'Completado',
          ]
        );

        $total += $nota;
      }
    }

    $calificacion = Calificacion::updateOrCreate(
      [
        'ID_Proyecto' => $proyecto->ID_Proyecto,
        'ID_Usuario' => $user->id,
        'ID_Rubrica' => $rubricaId,
      ],
      [
        'Nota_Final' => $total,
        'Estado' => 'Completado',
      ]
    );

    $this->generarYEnviarPDF($proyecto, $calificacion, $user);

    return redirect()
      ->route('juez.dashboard')
      ->with('success', 'Evaluación guardada y correo enviado correctamente.');
  }

  public function guardarBorrador(Request $request, Proyecto $proyecto, $rubricaId)
  {
    $user = Auth::user();

    $asignado = PersonaAsignada::where('ID_Proyecto', $proyecto->ID_Proyecto)
      ->where('ID_Usuario', $user->id)
      ->exists();

    if (!$asignado) {
      abort(403, 'No tiene asignado este proyecto.');
    }

    $calificacionExistente = Calificacion::where('ID_Proyecto', $proyecto->ID_Proyecto)
      ->where('ID_Usuario', $user->id)
      ->where('ID_Rubrica', $rubricaId)
      ->first();

    if ($calificacionExistente && $calificacionExistente->Estado === 'Completado') {
      $solicitudAprobada = SolicitudEdicion::where('ID_Calificacion', $calificacionExistente->ID_Calificaciones)
        ->where('ID_Usuario', $user->id)
        ->where('Estado', 'Aprobada')
        ->exists();

      if (!$solicitudAprobada) {
        return response()->json([
          'success' => false,
          'message' => 'Esta evaluación ya fue enviada y está bloqueada.',
        ], 403);
      }
    }

    $apartados = Apartado::with([
      'preguntas' => function ($query) {
        $query->where('Estado', 'Activo');
      }
    ])
      ->where('ID_Categoria', $proyecto->ID_categoria)
      ->where('ID_Rubrica', $rubricaId)
      ->where('Estado', 'Activo')
      ->orderBy('Orden')
      ->get();

    foreach ($apartados as $apartado) {
      foreach ($apartado->preguntas as $pregunta) {
        $nota = $request->input('pregunta_' . $pregunta->ID_Pregunta);
        $comentario = $request->input('comentario_' . $pregunta->ID_Pregunta);

        if ($nota === null || $nota === '') {
          $nota = null;
        } elseif (is_numeric($nota)) {
          $nota = max(0, min(intval($nota), (int) $pregunta->Maxima_Calificacion));
        } else {
          $nota = null;
        }

        Respuesta::updateOrCreate(
          [
            'ID_Proyecto' => $proyecto->ID_Proyecto,
            'ID_Usuario' => $user->id,
            'ID_Pregunta' => $pregunta->ID_Pregunta,
            'ID_Rubrica' => $rubricaId,
          ],
          [
            'Calificacion' => $nota,
            'Observaciones' => $comentario,
            'Estado' => 'Borrador',
          ]
        );
      }
    }

    return response()->json([
      'success' => true,
      'message' => 'Borrador guardado.',
    ]);
  }

  public function solicitarEdicion(Request $request, $calificacionId)
  {
    $user = Auth::user();

    $calificacion = Calificacion::findOrFail($calificacionId);

    if ($calificacion->ID_Usuario !== $user->id) {
      return back()->with('error', 'No tiene permiso para solicitar edición de esta evaluación.');
    }

    $existeSolicitud = SolicitudEdicion::where('ID_Calificacion', $calificacionId)
      ->where('ID_Usuario', $user->id)
      ->whereIn('Estado', ['Pendiente', 'Aprobada'])
      ->exists();

    if ($existeSolicitud) {
      return back()->with('error', 'Ya tiene una solicitud pendiente o aprobada para esta evaluación.');
    }

    SolicitudEdicion::create([
      'ID_Calificacion' => $calificacionId,
      'ID_Usuario' => $user->id,
      'Motivo' => $request->input('motivo', ''),
      'Estado' => 'Pendiente',
    ]);

    return back()->with('success', 'Solicitud de edición enviada al administrador.');
  }

  public function generarYEnviarPDF(Proyecto $proyecto, Calificacion $calificacion, $juez)
  {
    $proyecto->load([
      'categoria',
      'personasAsignadas.usuario',
    ]);

    $raw = Respuesta::where('ID_Proyecto', $proyecto->ID_Proyecto)
      ->where('ID_Usuario', $juez->id)
      ->where('ID_Rubrica', $calificacion->ID_Rubrica)
      ->get();

    $respuestasMap = [];
    foreach ($raw as $row) {
      $respuestasMap[intval($row->ID_Pregunta)] = [
        'score' => intval($row->Calificacion),
        'obs' => $row->Observaciones ?? '',
      ];
    }

    $apartados = Apartado::with(['preguntas'])
      ->where('ID_Categoria', $proyecto->ID_categoria)
      ->where('ID_Rubrica', $calificacion->ID_Rubrica)
      ->where('Estado', 'Activo')
      ->orderBy('Orden')
      ->get();

    $maxPosibleTotal = 0;
    $apartadosMax = [];
    foreach ($apartados as $apartado) {
      $subMax = 0;
      foreach ($apartado->preguntas as $p) {
        $subMax += intval($p->Maxima_Calificacion ?? 3);
      }
      $apartadosMax[$apartado->ID_Apartado] = $subMax;
      $maxPosibleTotal += $subMax;
    }

    $pdf = Pdf::loadView('pdf.rubrica-evaluacion', compact(
      'proyecto',
      'calificacion',
      'juez',
      'respuestasMap',
      'apartados',
      'apartadosMax',
      'maxPosibleTotal'
    ));

    $pdf->setPaper('letter');
    $pdf->setOption('isRemoteEnabled', true);

    $fileName = 'Rubrica-Evaluacion-' . $proyecto->ID_Proyecto . '-' . $juez->id . '-' . $calificacion->ID_Rubrica . '.pdf';
    $path = 'evaluaciones/' . $fileName;

    Storage::disk('public')->put($path, $pdf->output());

    $correosDestino = Configuracion::getList(Configuracion::CORREO_EVALUACIONES_PDF, []);

    if (empty($correosDestino)) {
      $correosDestino = [$juez->email ?? 'jkart2731@gmail.com'];
    }

    foreach ($correosDestino as $correoDestino) {
      $correoEnviado = CorreoEnviado::create([
        'ID_Proyecto' => $proyecto->ID_Proyecto,
        'Correo_destino' => $correoDestino,
        'Archivo_PDF' => $path,
        'Estado' => 'Pendiente',
      ]);

      EnviarCorreoEvaluacionJob::dispatch($correoEnviado, $proyecto, $calificacion, $juez, $path);
    }
  }
}
