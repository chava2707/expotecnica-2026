<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Proyecto;
use App\Models\Categoria;
use App\Models\Calificacion;
use App\Models\User;
use App\Models\Role;
use App\Models\PersonaAsignada;
use App\Models\Respuesta;
use App\Models\Apartado;
use App\Models\SolicitudEdicion;
use App\Models\SolicitudAyuda;
use App\Models\AvisoImpresion;
use App\Models\Rubrica;

class DashboardController extends Controller
{
    public function index()
    {
        $data = $this->getDashboardData();
        return view('admin.dashboard', $data);
    }

    public function apiData()
    {
        return response()->json($this->getDashboardData());
    }

    private function getDashboardData(): array
    {
        $totalProyectos = Proyecto::count();
        $proyectosConCalificacion = Proyecto::has('calificaciones')->count();
        $proyectosEvaluadosPct = $totalProyectos > 0
            ? round(($proyectosConCalificacion / $totalProyectos) * 100)
            : 0;

        $juecesActivos = User::whereHas('rol', fn($q) => $q->where('Nombre_rol', 'Juez'))
            ->where('Activo', true)->count();
        $totalJueces = User::whereHas('rol', fn($q) => $q->where('Nombre_rol', 'Juez'))->count();
        $participacionJueces = $totalJueces > 0
            ? round(($juecesActivos / $totalJueces) * 100)
            : 0;

        $maximoPorCombinacion = Apartado::maximaPorCombinacion();

        $promedioGeneral = round(Calificacion::whereNotNull('Nota_Final')->get()
            ->map(function ($cal) use ($maximoPorCombinacion) {
                $combinacion = ($cal->proyecto->ID_categoria ?? '') . '|' . ($cal->ID_Rubrica ?? '');
                $maximo = $maximoPorCombinacion->get($combinacion, 0);

                return $maximo > 0 ? ($cal->Nota_Final / $maximo) * 100 : 0;
            })
            ->avg() ?? 0, 1);

        $evaluacionesPendientes = Proyecto::doesntHave('calificaciones')->count();

        $categorias = Categoria::withCount(['proyectos', 'proyectos as proyectos_evaluados' => function ($q) {
            $q->has('calificaciones');
        }])->get()->map(function ($cat) use ($totalProyectos) {
            $total = $cat->proyectos_count;
            $evaluados = $cat->proyectos_evaluados;
            $pct = $total > 0 ? round(($evaluados / $total) * 100) : 0;
            return [
                'nombre' => $cat->Nombre,
                'total' => $total,
                'evaluados' => $evaluados,
                'porcentaje' => $pct,
            ];
        });

        $totalEnvios = Respuesta::count();
        $enRevision = Calificacion::where('Estado', 'Pendiente')->count();
        $marcados = Calificacion::where('Estado', 'Marcado')->count();

        $totalRubricasActivas = Rubrica::where('Estado', 'Activo')->count();

        $rubricasActivas = Rubrica::where('Estado', 'Activo')->get();

        $jueces = User::whereHas('rol', fn($q) => $q->whereIn('Nombre_rol', ['Juez', 'Jurado', 'Juez Suplente', 'Jurado Suplente']))
            ->with(['persona', 'rol', 'personasAsignadas.proyecto.categoria', 'personasAsignadas.proyecto.calificaciones.rubrica'])
            ->get()
            ->map(function ($juez) use ($totalRubricasActivas, $rubricasActivas) {
                $asignaciones = $juez->personasAsignadas;
                $proyectosAsignados = $asignaciones->pluck('proyecto')->filter()->unique('ID_Proyecto');
                $totalAsignados = $proyectosAsignados->count();

                $proyectosDetalle = $proyectosAsignados->map(function ($proyecto) use ($juez, $rubricasActivas) {
                    $calificacionesJuez = $proyecto->calificaciones->where('ID_Usuario', $juez->id);
                    $rubricasEvaluadas = $calificacionesJuez->pluck('ID_Rubrica')->unique();

                    $rubricasDetalle = $rubricasActivas->map(function ($rubrica) use ($calificacionesJuez, $rubricasEvaluadas) {
                        $cal = $calificacionesJuez->firstWhere('ID_Rubrica', $rubrica->ID_Rubrica);
                        return [
                            'id' => $rubrica->ID_Rubrica,
                            'nombre' => $rubrica->Nombre,
                            'evaluada' => $rubricasEvaluadas->contains($rubrica->ID_Rubrica),
                            'estado' => $cal ? $cal->Estado : 'Sin evaluar',
                            'nota' => $cal && $cal->Nota_Final !== null ? $cal->Nota_Final : null,
                        ];
                    })->values();

                    $totalRubricas = $rubricasActivas->count();
                    $evaluadasCount = $rubricasEvaluadas->count();
                    $completado = $totalRubricas > 0 && $evaluadasCount >= $totalRubricas;

                    return [
                        'id' => $proyecto->ID_Proyecto,
                        'nombre' => $proyecto->Nombre,
                        'categoria' => $proyecto->categoria->Nombre ?? 'Sin categoría',
                        'rubricas' => $rubricasDetalle->toArray(),
                        'evaluadas' => $evaluadasCount,
                        'total_rubricas' => $totalRubricas,
                        'completado' => $completado,
                    ];
                })->values();

                $completados = $proyectosDetalle->where('completado', true)->count();
                $progreso = $totalAsignados > 0 ? round(($completados / $totalAsignados) * 100) : 0;
                $categorias = $asignaciones->pluck('proyecto.categoria.Nombre')->filter()->unique()->implode(', ');

                return [
                    'id' => $juez->id,
                    'nombre' => $juez->name,
                    'rol' => $juez->rol->Nombre_rol ?? '',
                    'categoria' => $categorias ?: 'Sin asignar',
                    'total_asignados' => $totalAsignados,
                    'progreso' => $progreso,
                    'completado' => $totalAsignados > 0 && $completados >= $totalAsignados,
                    'proyectos' => $proyectosDetalle->toArray(),
                ];
            })
            ->values()
            ->toArray();

        $actividadReciente = User::with(['persona', 'rol'])
            ->latest('created_at')
            ->limit(10)
            ->get()
            ->map(function ($user) {
                return [
                    'tipo' => 'usuario_creado',
                    'usuario' => $user->name,
                    'rol' => $user->rol->Nombre_rol ?? '',
                    'fecha' => $user->created_at,
                ];
            });

        $solicitudesPendientes = SolicitudEdicion::with(['calificacion.proyecto', 'usuario'])
            ->where('Estado', 'Pendiente')
            ->orderBy('created_at', 'desc')
            ->get();

        $solicitudesPendientesJson = $solicitudesPendientes->map(function ($s) {
            return [
                'id' => $s->ID_Solicitud,
                'usuario_name' => $s->usuario->name ?? 'Juez',
                'proyecto_nombre' => $s->calificacion->proyecto->Nombre ?? 'Proyecto',
                'motivo' => $s->Motivo ?? '',
                'created_at' => $s->created_at->toIso8601String(),
            ];
        });

        $ayudasPendientes = SolicitudAyuda::with(['usuario'])
            ->where('Estado', 'Pendiente')
            ->orderBy('created_at', 'desc')
            ->get();

        $ayudasPendientesJson = $ayudasPendientes->map(function ($a) {
            return [
                'id' => $a->ID_Solicitud,
                'usuario_name' => $a->usuario->name ?? 'Juez',
                'mensaje' => $a->Mensaje ?? '',
                'created_at' => $a->created_at->toIso8601String(),
            ];
        });

        $avisosPendientes = AvisoImpresion::with(['correo.proyecto'])
            ->where('Estado', 'Pendiente')
            ->orderBy('created_at', 'desc')
            ->get();

        $avisosPendientesJson = $avisosPendientes->map(function ($a) {
            return [
                'id' => $a->ID_Aviso,
                'proyecto_nombre' => $a->correo?->proyecto?->Nombre ?? 'Proyecto',
                'archivo_pdf' => $a->correo?->Archivo_PDF ?? '',
                'created_at' => $a->created_at->toIso8601String(),
            ];
        });

        return compact(
            'totalProyectos',
            'proyectosConCalificacion',
            'proyectosEvaluadosPct',
            'juecesActivos',
            'totalJueces',
            'participacionJueces',
            'promedioGeneral',
            'evaluacionesPendientes',
            'categorias',
            'totalEnvios',
            'enRevision',
            'marcados',
            'jueces',
            'actividadReciente',
            'solicitudesPendientes',
            'ayudasPendientes',
            'avisosPendientes',
            'solicitudesPendientesJson',
            'ayudasPendientesJson',
            'avisosPendientesJson'
        );
    }
}
