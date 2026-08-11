<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento impreso — ExpoTÉCNICA 2026</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f7f9fb; font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f7f9fb;">
    <tr>
        <td align="center" style="padding: 60px 16px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 460px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0px 4px 12px rgba(44, 62, 80, 0.08);">

                <tr>
                    <td style="background-color: #944a00; padding: 32px 40px; text-align: center;">
                        <h1 style="margin: 0; font-size: 20px; font-weight: 700; color: #ffffff; letter-spacing: -0.02em;">
                            ExpoTÉCNICA 2026
                        </h1>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 40px; text-align: center;">
                        @if($aviso->Estado === 'Pendiente')
                            <div style="width: 64px; height: 64px; margin: 0 auto 20px auto; border-radius: 50%; background-color: #E6F4EA; display: flex; align-items: center; justify-content: center; font-size: 28px; line-height: 1;">&#9989;</div>
                            <h2 style="margin: 0 0 12px 0; font-size: 18px; font-weight: 700; color: #191c1e;">
                                @if($yaConfirmado)
                                    Aviso ya registrado
                                @else
                                    &#127881; Aviso enviado
                                @endif
                            </h2>
                            <p style="margin: 0 0 8px 0; font-size: 14px; line-height: 1.6; color: #564337;">
                                El administrador ha sido notificado de que el documento del proyecto
                                <strong style="color: #191c1e;">{{ $correo->proyecto->Nombre ?? 'sin proyecto' }}</strong>
                                fue impreso y est&aacute; listo para recoger.
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #897365;">
                                @if($yaConfirmado)
                                    Ya hab&iacute;a registrado este aviso anteriormente. No es necesario hacerlo de nuevo.
                                @else
                                    Gracias por confirmar la impresi&oacute;n del documento.
                                @endif
                            </p>
                        @else
                            <div style="width: 64px; height: 64px; margin: 0 auto 20px auto; border-radius: 50%; background-color: #FFF8E1; display: flex; align-items: center; justify-content: center; font-size: 28px; line-height: 1;">&#128221;</div>
                            <h2 style="margin: 0 0 12px 0; font-size: 18px; font-weight: 700; color: #191c1e;">
                                Este aviso ya fue gestionado
                            </h2>
                            <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #564337;">
                                El administrador ya marc&oacute; el documento del proyecto
                                <strong style="color: #191c1e;">{{ $correo->proyecto->Nombre ?? 'sin proyecto' }}</strong>
                                como recogido. No es necesaria ninguna acci&oacute;n adicional.
                            </p>
                        @endif
                    </td>
                </tr>

                <tr>
                    <td style="background-color: #f2f4f6; padding: 24px 40px; border-top: 1px solid #E2E8F0;">
                        <p style="margin: 0; font-size: 12px; color: #4e6073; text-align: center;">
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
