# Changelog

Todos los cambios relevantes de este proyecto se documentan aquí.
El formato sigue [Keep a Changelog](https://keepachangelog.com/es-ES/1.1.0/) y
el versionado [SemVer](https://semver.org/lang/es/).

## [1.0.0] - 2026-11-25

Primera versión estable del sistema de gestión y calificación de proyectos para
la ExpoTÉCNICA 2026.

### Añadido

- Panel público con categorías, proyectos y porcentaje de avance de la evaluación.
- Autenticación con roles de administrador, juez y suplente.
- Gestión de usuarios con envío de credenciales por correo.
- CRUD de proyectos, categorías, ejes temáticos, apartados y preguntas.
- Asignación de jueces y suplentes por proyecto.
- Evaluación en línea con rúbricas ponderadas, borradores y envío final.
- Resultados consolidados y exportación de rúbricas a PDF (DomPDF).
- Solicitudes de edición y de ayuda, con flujo de aprobación.
- Avisos de impresión mediante enlace firmado enviado por correo.
- Notificaciones por correo en cola (`database`) con worker dedicado.
- Despliegue con Docker Compose: aplicación, worker y MySQL 8.
- Documentación de instalación local y despliegue.
- Integración continua con GitHub Actions (pruebas automatizadas).
