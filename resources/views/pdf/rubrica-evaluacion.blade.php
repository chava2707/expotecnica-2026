<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Rúbrica de Evaluación - {{ $proyecto->Nombre }}</title>
    <style>
        @page {
            margin: 15mm 12mm;
            size: letter;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 9pt;
            color: #1a1a1a;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #2d6a4f;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }

        .header h1 {
            font-size: 15pt;
            font-weight: 700;
            color: #1b4332;
            margin-bottom: 2px;
        }

        .header h2 {
            font-size: 10pt;
            font-weight: 600;
            color: #2d6a4f;
            margin-bottom: 4px;
        }

        .header .subtitle {
            font-size: 8pt;
            color: #555;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 8.5pt;
        }

        .info-table td {
            padding: 4px 8px;
            border: 1px solid #ccc;
        }

        .info-table .label {
            background-color: #d8f3dc;
            font-weight: 700;
            width: 28%;
            color: #1b4332;
        }

        .info-table .value {
            background-color: #fff;
        }

        .instructions {
            background-color: #f0f7f0;
            border: 1px solid #b7e4c7;
            border-radius: 4px;
            padding: 8px 10px;
            margin-bottom: 12px;
            font-size: 7.5pt;
            line-height: 1.5;
        }

        .instructions strong {
            color: #1b4332;
        }

        .section-title {
            font-size: 10pt;
            font-weight: 700;
            color: #1b4332;
            background-color: #d8f3dc;
            padding: 5px 8px;
            border-left: 4px solid #2d6a4f;
            margin: 12px 0 0 0;
        }

        .eval-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
            font-size: 8pt;
        }

        .eval-table thead th {
            background-color: #b7e4c7;
            color: #1b4332;
            padding: 5px 3px;
            text-align: center;
            font-weight: 700;
            font-size: 6.5pt;
            border: 1px solid #95d5b2;
        }

        .eval-table thead th:first-child {
            text-align: left;
        }

        .eval-table thead th:last-child {
            font-size: 6pt;
        }

        .eval-table tbody td {
            padding: 4px 3px;
            border: 1px solid #ccc;
            vertical-align: top;
            text-align: center;
        }

        .eval-table tbody td:first-child {
            text-align: left;
        }

        .eval-table tbody td:last-child {
            font-size: 7pt;
            color: #555;
        }

        .eval-table tbody tr:nth-child(even) {
            background-color: #f8fdf8;
        }

        .subtotal-row {
            background-color: #d8f3dc !important;
            font-weight: 700;
        }

        .subtotal-row td {
            padding: 4px 5px;
            font-weight: 700;
            color: #1b4332;
            border: 1px solid #95d5b2;
        }

        .total-section {
            margin-top: 12px;
            border: 2px solid #2d6a4f;
            border-radius: 4px;
            overflow: hidden;
        }

        .total-header {
            background-color: #2d6a4f;
            color: #fff;
            padding: 6px 10px;
            font-weight: 700;
            font-size: 10pt;
            text-align: center;
        }

        .total-body {
            padding: 10px;
        }

        .total-row {
            display: flex;
            justify-content: space-around;
            margin-bottom: 8px;
        }

        .total-box {
            text-align: center;
            padding: 6px 16px;
            background-color: #f0f7f0;
            border-radius: 4px;
            border: 1px solid #b7e4c7;
        }

        .total-box .label {
            font-size: 7pt;
            font-weight: 700;
            text-transform: uppercase;
            color: #2d6a4f;
            letter-spacing: 0.05em;
        }

        .total-box .value {
            font-size: 14pt;
            font-weight: 700;
            color: #1b4332;
        }

        .recommendations {
            margin-top: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
        }

        .recommendations-header {
            background-color: #d8f3dc;
            padding: 5px 10px;
            font-weight: 700;
            font-size: 9pt;
            color: #1b4332;
            border-bottom: 1px solid #ccc;
        }

        .recommendations-body {
            padding: 10px;
            min-height: 60px;
            font-size: 8.5pt;
            color: #444;
        }

        .signature-section {
            margin-top: 14px;
            width: 100%;
            border-collapse: collapse;
        }

        .signature-section td {
            width: 33.33%;
            text-align: center;
            padding: 8px 10px 0 10px;
            vertical-align: bottom;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin: 0 20px;
        }

        .signature-label {
            font-size: 7.5pt;
            font-weight: 600;
            color: #333;
        }

        .observations-text {
            font-style: italic;
            font-size: 7pt;
            color: #666;
        }

        .check-mark {
            font-size: 10pt;
            color: #2d6a4f;
            font-weight: 700;
        }
    </style>
</head>
<body>

    @php
        $nombreRubrica = $calificacion?->rubrica?->Nombre ?? '';
        $esEscrito = str_contains(mb_strtolower($nombreRubrica), 'escrito');
        $tipoRubrica = $esEscrito ? 'Trabajo Escrito' : 'Exposición';

        $nombreCategoria = mb_strtolower($proyecto->categoria->Nombre ?? '');
        $etiquetaCategoria = str_contains($nombreCategoria, 'emprend')
            ? 'Desafío de Emprendimiento'
            : 'Desafío STEAM';

        $parteRubrica = $esEscrito ? 'del Trabajo Escrito' : 'de la Exposición';
        $headerTitulo = 'Evaluación ' . $parteRubrica . ' del Proyecto (' . $etiquetaCategoria . ')';
    @endphp

    {{-- HEADER --}}
    <div class="header">
        <h1>ExpoTÉCNICA 2026</h1>
        <h2>{{ $headerTitulo }}</h2>
        <div class="subtitle">Rúbrica Oficial de Evaluación ({{ $tipoRubrica }}) — Comité de Juzgamiento</div>
    </div>

    {{-- DATOS GENERALES --}}
    <table class="info-table">
        <tr>
            <td class="label">Centro Educativo</td>
            <td class="value">COVAO Nocturno</td>
            <td class="label" style="width: 18%;">Curso Lectivo</td>
            <td class="value" style="width: 20%;">{{ date('Y') }}</td>
        </tr>
        <tr>
            <td class="label">Personas Estudiantes</td>
            <td class="value">{{ $proyecto->personasAsignadas->filter(function ($asignacion) {
                $rol = strtolower(trim($asignacion->usuario->rol->Nombre_rol ?? ''));
                return $rol === 'estudiante';
            })->pluck('usuario.name')->filter()->implode(', ') ?: 'Sin asignar' }}</td>
            <td class="label">Categoría</td>
            <td class="value">{{ $proyecto->categoria->Nombre ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Título del Proyecto</td>
            <td class="value" colspan="3">{{ $proyecto->Nombre }}</td>
        </tr>
        <tr>
            <td class="label">Eje Temático</td>
            <td class="value" colspan="3">{{ $proyecto->ejeTematico->Nombre ?? 'N/A' }}</td>
        </tr>
    </table>

    {{-- INSTRUCCIONES --}}
    <div class="instructions">
        <strong>Instrucciones:</strong> Evalúe cada indicador según la escala de calificación de <strong>0</strong> a <strong>{{ $maxPosibleTotal > 0 ? 'su máximo asignado' : 'N' }}</strong> puntos.
        Marque con una <strong>X</strong> el nivel de cumplimiento que mejor describa el desempeño observado.
        Complete la columna de observaciones con comentarios específicos para cada indicador.
        El puntaje máximo posible es de <strong>{{ $maxPosibleTotal }} puntos</strong>.
    </div>

    {{-- SECCIONES DE EVALUACIÓN --}}
    @php
        $grandTotal = 0;
    @endphp

    @foreach($apartados as $apartado)
        @php
            $sectionMax = $apartadosMax[$apartado->ID_Apartado] ?? 0;
            $numIndicadores = $apartado->preguntas->count();
            $preguntaMax = [];
            foreach ($apartado->preguntas as $p) {
                $preguntaMax[$p->ID_Pregunta] = intval($p->Maxima_Calificacion ?? 5);
            }
            $sectionMaxScale = max($preguntaMax);
        @endphp

        <div class="section-title">Sección {{ chr(64 + $loop->iteration) }}. {{ $apartado->Titulo }}</div>

        <table class="eval-table">
            <thead>
                <tr>
                    <th style="width: 38%;">Indicadores</th>
                    @for($i = 0; $i <= $sectionMaxScale; $i++)
                        <th>{{ $i }}<br>ptos</th>
                    @endfor
                    <th style="width: 16%;">Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($apartado->preguntas as $pregunta)
                    @php
                        $pid = intval($pregunta->ID_Pregunta);
                        $entry = $respuestasMap[$pid] ?? null;
                        $score = $entry ? $entry['score'] : 0;
                        $obs = $entry ? $entry['obs'] : '';
                        $pMax = $preguntaMax[$pid];
                    @endphp
                    <tr>
                        <td>
                            <strong>{{ chr(96 + $loop->iteration) }})</strong> {{ $pregunta->Pregunta }}
                            <span style="font-size:6pt; color:#999;">(máx. {{ $pMax }})</span>
                        </td>
                        @for($i = 0; $i <= $sectionMaxScale; $i++)
                            @if($i <= $pMax)
                                <td>{!! $score == $i ? '<span class="check-mark">X</span>' : '' !!}</td>
                            @else
                                <td style="background-color: #f5f5f5; color: #ccc;">-</td>
                            @endif
                        @endfor
                        <td class="observations-text">{{ $obs ?: '-' }}</td>
                    </tr>
                @endforeach
                @php
                    $subtotal = 0;
                    foreach ($apartado->preguntas as $p) {
                        $pid = intval($p->ID_Pregunta);
                        $e = $respuestasMap[$pid] ?? null;
                        $subtotal += $e ? $e['score'] : 0;
                    }
                    $grandTotal += $subtotal;
                @endphp
                <tr class="subtotal-row">
                    <td style="text-align: right; padding-right: 8px;">
                        Subtotal Sección {{ chr(64 + $loop->iteration) }}
                    </td>
                    <td colspan="{{ $sectionMaxScale + 1 }}" style="text-align: right; padding-right: 8px;">
                        {{ $numIndicadores }} indicadores
                    </td>
                    <td style="text-align: center; font-size: 9pt;">
                        {{ $subtotal }} / {{ $sectionMax }}
                    </td>
                </tr>
            </tbody>
        </table>
    @endforeach

    {{-- PUNTAJE TOTAL --}}
    <div class="total-section">
        <div class="total-header">Resultado Final de la Evaluación</div>
        <div class="total-body">
            <div class="total-row">
                <div class="total-box">
                    <div class="label">Puntaje Total</div>
                    <div class="value">{{ $calificacion->Nota_Final ?? $grandTotal }} / {{ $maxPosibleTotal }}</div>
                </div>
                <div class="total-box">
                    <div class="label">Porcentaje Obtenido</div>
                    <div class="value">{{ $maxPosibleTotal > 0 ? round((($calificacion->Nota_Final ?? $grandTotal) / $maxPosibleTotal) * 100) : 0 }}%</div>
                </div>
            </div>
        </div>
    </div>

    {{-- RECOMENDACIONES --}}
    <div class="recommendations">
        <div class="recommendations-header">Recomendaciones para la Mejora del Proyecto</div>
        <div class="recommendations-body">
            @php
                $allObs = [];
                foreach ($respuestasMap as $entry) {
                    if (!empty($entry['obs'])) {
                        $allObs[] = $entry['obs'];
                    }
                }
                $allObsStr = implode(' | ', $allObs);
            @endphp
            {{ $allObsStr ?: 'Sin observaciones adicionales.' }}
        </div>
    </div>

    {{-- FIRMA --}}
    <table class="signature-section">
        <tr>
            <td>
                <div class="signature-line"></div>
                <div class="signature-label">Nombre de la Persona Juez</div>
                <div style="font-size: 7.5pt; color: #555; margin-top: 2px;">{{ $juez->name ?? 'N/A' }}</div>
            </td>
            <td>
                <div class="signature-line"></div>
                <div class="signature-label">Firma</div>
            </td>
            <td>
                <div class="signature-line"></div>
                <div class="signature-label">Fecha</div>
                <div style="font-size: 7.5pt; color: #555; margin-top: 2px;">{{ now()->format('d/m/Y') }}</div>
            </td>
        </tr>
    </table>

</body>
</html>
