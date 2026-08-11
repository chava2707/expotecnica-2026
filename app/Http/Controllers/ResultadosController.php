<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartado;
use App\Models\Categoria;
use App\Models\Proyecto;
use App\Models\Calificacion;

class ResultadosController extends Controller
{
    public function index()
    {
        $maximoPorCombinacion = Apartado::maximaPorCombinacion();

        $categorias = Categoria::with(['proyectos.calificaciones'])->get();

        $resultadosPorCategoria = $categorias->map(function ($categoria) use ($maximoPorCombinacion) {
            $proyectos = $categoria->proyectos->map(function ($proyecto) use ($maximoPorCombinacion) {
                $calificaciones = $proyecto->calificaciones;

                $porcentajes = $calificaciones
                    ->filter(fn($cal) => $cal->Nota_Final !== null)
                    ->map(function ($cal) use ($maximoPorCombinacion, $proyecto) {
                        $combinacion = $proyecto->ID_categoria . '|' . $cal->ID_Rubrica;
                        $maximo = $maximoPorCombinacion->get($combinacion, 0);

                        return $maximo > 0 ? ($cal->Nota_Final / $maximo) * 100 : 0;
                    });

                $promedio = $porcentajes->isNotEmpty() ? round($porcentajes->avg(), 2) : null;
                $maxima = $porcentajes->isNotEmpty() ? round($porcentajes->max(), 2) : null;
                $totalJueces = $calificaciones->pluck('ID_Usuario')->unique()->count();

                return (object) [
                    'id'             => $proyecto->ID_Proyecto,
                    'nombre'         => $proyecto->Nombre,
                    'promedio'       => $promedio,
                    'maxima'         => $maxima,
                    'totalJueces'    => $totalJueces,
                    'calificaciones' => $calificaciones,
                ];
            });

            $ranking = $proyectos->sortByDesc('promedio')->values();
            $evaluados = $ranking->filter(fn($p) => $p->promedio !== null);

            $top3 = $evaluados->take(3);

            $totalProyectos = $categoria->proyectos->count();
            $evaluadosCount = $evaluados->count();
            $promedioCategoria = $evaluados->isNotEmpty()
                ? round($evaluados->pluck('promedio')->avg(), 2)
                : null;

            return [
                'id'            => $categoria->ID_Categoria,
                'nombre'        => $categoria->Nombre,
                'descripcion'   => $categoria->Descripcion,
                'ranking'       => $ranking,
                'top3'          => $top3,
                'totalProyectos' => $totalProyectos,
                'evaluadosCount'  => $evaluadosCount,
                'promedioCategoria' => $promedioCategoria,
            ];
        });

        $categoriaActiva = $resultadosPorCategoria->isNotEmpty() ? 0 : null;

        $totalProyectos = Proyecto::count();
        $totalEvaluados = Proyecto::whereHas('calificaciones')->count();
        $totalJuecesActivos = $totalEvaluados > 0 ? Calificacion::distinct('ID_Usuario')->count('ID_Usuario') : 0;

        return view('admin.resultados.index', compact(
            'resultadosPorCategoria',
            'categoriaActiva',
            'totalProyectos',
            'totalEvaluados',
            'totalJuecesActivos',
        ));
    }
}
