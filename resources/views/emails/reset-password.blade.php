<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña — ExpoTÉCNICA 2026</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f7f9fb; font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

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
                            Restablecer Contraseña
                        </p>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="padding: 40px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding-bottom: 24px;">
                                    <div style="width: 48px; height: 48px; border-radius: 50%; background-color: #fff3e6; text-align: center; line-height: 48px;">
                                        <span style="font-size: 24px;">&#128274;</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 16px;">
                                    <h2 style="margin: 0; font-size: 20px; font-weight: 700; color: #191c1e; letter-spacing: -0.02em;">
                                        Hola, {{ $nombre }}
                                    </h2>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 24px;">
                                    <p style="margin: 0; font-size: 15px; line-height: 1.6; color: #564337;">
                                        Recibimos una solicitud para restablecer la contraseña de tu cuenta en <strong style="color: #191c1e;">ExpoTÉCNICA 2026</strong>. Haz clic en el botón de abajo para crear una nueva contraseña.
                                    </p>
                                </td>
                            </tr>

                            {{-- CTA Button --}}
                            <tr>
                                <td align="center" style="padding-bottom: 24px;">
                                    <table role="presentation" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="background-color: #944a00; border-radius: 8px;">
                                                <a href="{{ $resetUrl }}" style="display: inline-block; padding: 14px 32px; font-size: 14px; font-weight: 700; color: #ffffff; text-decoration: none; letter-spacing: 0.02em;">
                                                    Restablecer Contraseña
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            {{-- Warning --}}
                            <tr>
                                <td style="padding-bottom: 0;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #FFF8F0; border-radius: 8px; border: 1px solid #FFDCC5;">
                                        <tr>
                                            <td style="padding: 16px;">
                                                <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #713700;">
                                                    <strong>&#9888; Importante:</strong> Este enlace expirará en 60 minutos. Si no solicitaste este cambio, puedes ignorar este correo de forma segura.
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
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
