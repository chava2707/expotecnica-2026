<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluación Adjunta — ExpoTÉCNICA 2026</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f7f9fb; font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

@php
    $nombreRubrica = $calificacion?->rubrica?->Nombre ?? '';
    $esEscrito = str_contains(mb_strtolower($nombreRubrica), 'escrito');
    $tipoEvaluacion = $esEscrito ? 'Trabajo Escrito' : 'Exposición';
    $enlaceImpresion = rtrim(config('app.url'), '/') . URL::signedRoute(
        'avisos.impresion.confirmar',
        ['correoEnviado' => $correoEnviado->ID_Correo],
        now()->addDays(2),
        false,
    );
@endphp

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f7f9fb;">
    <tr>
        <td align="center" style="padding: 40px 16px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 560px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);">

                {{-- Header --}}
                <tr>
                    <td style="background-color: #944a00; padding: 32px 40px; text-align: center;">
                        <h1 style="margin: 0 0 4px 0; font-size: 22px; font-weight: 700; color: #ffffff; letter-spacing: -0.02em;">
                            ExpoTÉCNICA 2026
                        </h1>
                        <p style="margin: 0; font-size: 12px; font-weight: 600; color: #ffb783; letter-spacing: 0.05em; text-transform: uppercase;">
                            Evaluación Adjunta &mdash; {{ $tipoEvaluacion }}
                        </p>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="padding: 40px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding-bottom: 16px;">
                                    <h2 style="margin: 0; font-size: 20px; font-weight: 700; color: #191c1e; letter-spacing: -0.02em;">
                                        Documento de evaluación ({{ $tipoEvaluacion }})
                                    </h2>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 24px;">
                                    <p style="margin: 0; font-size: 15px; line-height: 1.6; color: #564337;">
                                        Se adjunta la evaluación de <strong style="color: #191c1e;">{{ $tipoEvaluacion }}</strong> del proyecto <strong style="color: #191c1e;">{{ $proyecto->Nombre }}</strong> en formato PDF para su impresión.
                                    </p>
                                </td>
                            </tr>

                            {{-- Note --}}
                            <tr>
                                <td>
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #FFF8F0; border-radius: 8px; border: 1px solid #FFDCC5;">
                                        <tr>
                                            <td style="padding: 16px;">
                                                <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #713700;">
                                                    <strong>&#128206; Archivo adjunto:</strong> El documento PDF con la evaluación se encuentra adjunto a este correo para que pueda imprimirlo.
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            {{-- Confirm print button --}}
                            <tr>
                                <td style="padding-top: 24px; text-align: center;">
                                    <a href="{{ $enlaceImpresion }}" style="display: inline-block; background-color: #944a00; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 700; padding: 14px 28px; border-radius: 8px;">
                                        &#128424; Documento impreso &mdash; avisar al administrador
                                    </a>
                                    <p style="margin: 12px 0 0 0; font-size: 12px; color: #897365;">
                                        Púlselo una vez haya imprimido el documento. El enlace caduca en 2 d&iacute;as.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="background-color: #f2f4f6; padding: 24px 40px; border-top: 1px solid #E2E8F0;">
                        <p style="margin: 0 0 4px 0; font-size: 12px; color: #4e6073; text-align: center;">
                            Este es un correo generado automáticamente por la plataforma ExpoTÉCNICA 2026.
                        </p>
                        <p style="margin: 0; font-size: 12px; color: #897365; text-align: center;">
                            &copy; {{ date('Y') }} ExpoTÉCNICA. Todos los derechos reservados.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
