<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta Creada — ExpoTÉCNICA 2026</title>
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
                            Notificación de Cuenta
                        </p>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="padding: 40px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding-bottom: 24px;">
                                    <div style="width: 48px; height: 48px; border-radius: 50%; background-color: #e6f9ee; text-align: center; line-height: 48px;">
                                        <span style="font-size: 24px;">&#10003;</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 16px;">
                                    <h2 style="margin: 0; font-size: 20px; font-weight: 700; color: #191c1e; letter-spacing: -0.02em;">
                                        Bienvenido, {{ $nombreCompleto }}
                                    </h2>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 24px;">
                                    <p style="margin: 0; font-size: 15px; line-height: 1.6; color: #564337;">
                                        Se ha creado tu cuenta de acceso a la plataforma de <strong style="color: #191c1e;">ExpoTÉCNICA 2026</strong>. A continuación encontrarás tus credenciales de inicio de sesión.
                                    </p>
                                </td>
                            </tr>

                            {{-- Credentials Card --}}
                            <tr>
                                <td style="padding-bottom: 24px;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f2f4f6; border-radius: 8px; border: 1px solid #E2E8F0;">
                                        <tr>
                                            <td style="padding: 24px;">
                                                <p style="margin: 0 0 16px 0; font-size: 11px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: #944a00;">
                                                    Tus Credenciales
                                                </p>
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td style="padding-bottom: 12px;">
                                                            <p style="margin: 0 0 2px 0; font-size: 11px; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">
                                                                Correo Electrónico
                                                            </p>
                                                            <p style="margin: 0; font-size: 15px; font-weight: 600; color: #191c1e;">
                                                                {{ $email }}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-bottom: 12px;">
                                                            <p style="margin: 0 0 2px 0; font-size: 11px; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">
                                                                Contraseña Temporal
                                                            </p>
                                                            <p style="margin: 0; font-size: 18px; font-weight: 700; color: #944a00; font-family: 'Courier New', Courier, monospace; background-color: #fff; display: inline-block; padding: 6px 14px; border-radius: 6px; border: 1px solid #E2E8F0;">
                                                                {{ $cedula }}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    @if($nombreUsuario)
                                                    <tr>
                                                        <td>
                                                            <p style="margin: 0 0 2px 0; font-size: 11px; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #4e6073;">
                                                                Nombre de Usuario
                                                            </p>
                                                            <p style="margin: 0; font-size: 15px; font-weight: 600; color: #191c1e;">
                                                                {{ $nombreUsuario }}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            {{-- Warning --}}
                            <tr>
                                <td style="padding-bottom: 24px;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #FFF8F0; border-radius: 8px; border: 1px solid #FFDCC5;">
                                        <tr>
                                            <td style="padding: 16px;">
                                                <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #713700;">
                                                    <strong>&#9888; Importante:</strong> Por seguridad, te recomendamos cambiar tu contraseña en tu primer inicio de sesión. Esta contraseña temporal es la misma que tu número de cédula.
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            {{-- CTA Button --}}
                            <tr>
                                <td align="center" style="padding-bottom: 8px;">
                                    <table role="presentation" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="background-color: #944a00; border-radius: 8px;">
                                                <a href="{{ url('/login') }}" style="display: inline-block; padding: 14px 32px; font-size: 14px; font-weight: 700; color: #ffffff; text-decoration: none; letter-spacing: 0.02em;">
                                                    Iniciar Sesión
                                                </a>
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
