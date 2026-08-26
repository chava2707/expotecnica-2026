<?php

use Illuminate\Support\Facades\Route;

use App\Models\Categoria;
use App\Models\Proyecto;
use App\Models\Calificacion;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PersonaAsignadaController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\ResultadosController;
use App\Http\Controllers\JuezController;
use App\Http\Controllers\ApartadoController;
use App\Http\Controllers\SolicitudEdicionController;
use App\Http\Controllers\SolicitudAyudaController;
use App\Http\Controllers\EjeTematicoController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\AvisoImpresionController;
use App\Http\Controllers\ForgotPasswordController;

Route::get('/', function () {
  $categorias = Categoria::withCount('proyectos')->get();

  $totalProyectos = Proyecto::count();
  $proyectosConCalificacion = Proyecto::has('calificaciones')->count();
  $proyectosEvaluadosPct = $totalProyectos > 0
    ? round(($proyectosConCalificacion / $totalProyectos) * 100)
    : 0;

  return view('Landing.index', compact('categorias', 'proyectosEvaluadosPct'));
});

// ==========================
// RUTAS PÚBLICAS
// ==========================

// Detalle del proyecto
Route::get('/proyectos/{id}', [ProyectoController::class, 'show'])
  ->name('proyectos.show');

// ==========================
// AUTENTICACIÓN
// ==========================

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Recovery
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])
    ->name('password.update');

// ==========================
// PANEL ADMINISTRATIVO
// ==========================

Route::middleware(['auth', 'admin'])->group(function () {

  // Dashboard
  Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard');

  Route::get('/admin/dashboard/api', [DashboardController::class, 'apiData'])
    ->name('admin.dashboard.api');

  // ==========================
  // USUARIOS
  // ==========================

  Route::get('/admin/usuarios', [UsuarioController::class, 'index'])
    ->name('admin.usuarios');

  Route::post('/admin/usuarios', [UsuarioController::class, 'store'])
    ->name('admin.usuarios.store');

  Route::post('/admin/usuarios/{id}/reenviar', [UsuarioController::class, 'reenviarCredenciales'])
    ->name('admin.usuarios.reenviar');

  Route::put('/admin/usuarios/{id}', [UsuarioController::class, 'update'])
    ->name('admin.usuarios.update');

  Route::delete('/admin/usuarios/{id}', [UsuarioController::class, 'destroy'])
    ->name('admin.usuarios.destroy');

  // ==========================
  // PROYECTOS
  // ==========================

  Route::get('/admin/proyectos', [ProyectoController::class, 'index'])
    ->name('admin.proyectos');

  Route::get('/admin/proyectos/crear', [ProyectoController::class, 'create'])
    ->name('proyectos.crear');

  Route::post('/proyectos', [ProyectoController::class, 'store'])
    ->name('proyectos.store');

  Route::get('/proyectos/{id}/editar', [ProyectoController::class, 'edit'])
    ->name('proyectos.edit');

  Route::put('/proyectos/{id}', [ProyectoController::class, 'update'])
    ->name('proyectos.update');

  Route::delete('/proyectos/{id}', [ProyectoController::class, 'destroy'])
    ->name('proyectos.destroy');

  Route::get('/admin/proyectos/{id}/pdfs', [ProyectoController::class, 'pdfs'])
    ->name('admin.proyectos.pdfs');

  Route::get('/admin/proyectos/{proyecto}/pdfs/{calificacion}', [ProyectoController::class, 'pdf'])
    ->name('admin.proyectos.pdf');

  // ==========================
  // CONFIGURACIÓN
  // ==========================

  Route::get('/admin/configuracion', [ConfiguracionController::class, 'index'])
    ->name('admin.configuracion');

  Route::post('/admin/configuracion', [ConfiguracionController::class, 'update'])
    ->name('admin.configuracion.update');

  // ==========================
  // CATEGORÍAS
  // ==========================

  Route::resource('categorias', CategoriaController::class);

  // ==========================
  // ASIGNACIONES
  // ==========================

  Route::get('/proyectos/{id_proyecto}/asignaciones', [PersonaAsignadaController::class, 'index'])
    ->name('asignaciones.index');

  Route::post('/asignaciones', [PersonaAsignadaController::class, 'store'])
    ->name('asignaciones.store');

  Route::delete('/asignaciones/{id}', [PersonaAsignadaController::class, 'destroy'])
    ->name('asignaciones.destroy');

  // ==========================
  // PREGUNTAS
  // ==========================

  Route::resource('preguntas', PreguntaController::class);

  // ==========================
  // APARTADOS
  // ==========================

    Route::resource('apartados', ApartadoController::class);
    Route::patch('/apartados/{apartado}/subir', [ApartadoController::class, 'subir'])
    ->name('apartados.subir');

Route::patch('/apartados/{apartado}/bajar', [ApartadoController::class, 'bajar'])
    ->name('apartados.bajar');


  // ==========================
  // RESULTADOS
  // ==========================

  Route::get('/admin/resultados', [ResultadosController::class, 'index'])
    ->name('admin.resultados');

  // ==========================
  // SOLICITUDES DE EDICIÓN
  // ==========================

  Route::get('/admin/solicitudes', [SolicitudEdicionController::class, 'index'])
    ->name('admin.solicitudes');

  Route::post('/admin/solicitudes/{id}/aprobar', [SolicitudEdicionController::class, 'aprobar'])
    ->name('admin.solicitudes.aprobar');

  Route::post('/admin/solicitudes/{id}/rechazar', [SolicitudEdicionController::class, 'rechazar'])
    ->name('admin.solicitudes.rechazar');

  // ==========================
  // SOLICITUDES DE AYUDA
  // ==========================

  Route::get('/admin/ayudas', [SolicitudAyudaController::class, 'index'])
    ->name('admin.ayudas');

  Route::post('/admin/ayudas/{id}/resolver', [SolicitudAyudaController::class, 'resolver'])
    ->name('admin.ayudas.resolver');

  Route::post('/admin/ayudas/{id}/cancelar', [SolicitudAyudaController::class, 'cancelar'])
    ->name('admin.ayudas.cancelar');

  // ==========================
  // AVISOS DE IMPRESIÓN
  // ==========================

  Route::get('/admin/avisos', [AvisoImpresionController::class, 'index'])
    ->name('admin.avisos');

  Route::post('/admin/avisos/{id}/recoger', [AvisoImpresionController::class, 'recoger'])
    ->name('admin.avisos.recoger');

  Route::post('/admin/avisos/{id}/cancelar', [AvisoImpresionController::class, 'cancelar'])
    ->name('admin.avisos.cancelar');



  // ==========================================
  // CRUD: EJES TEMÁTICOS
  // ==========================================
  Route::prefix('admin/ejes')->name('ejes.')->group(function () {

    // Listar todos los ejes temáticos
    Route::get('/', [EjeTematicoController::class, 'index'])->name('index');

    // Mostrar formulario para crear un nuevo eje
    Route::get('/crear', [EjeTematicoController::class, 'create'])->name('create');

    // Guardar el nuevo eje en la base de datos
    Route::post('/', [EjeTematicoController::class, 'store'])->name('store');

    // Mostrar formulario para editar un eje existente
    Route::get('/{id}/editar', [EjeTematicoController::class, 'edit'])->name('edit');

    // Actualizar el eje en la base de datos
    Route::put('/{id}', [EjeTematicoController::class, 'update'])->name('update');

    // Eliminar un eje
    Route::delete('/{id}', [EjeTematicoController::class, 'destroy'])->name('destroy');
  });
});

// ==========================
// PANEL DEL JUEZ
// ==========================

Route::get('/juez/dashboard', [JuezController::class, 'dashboard'])
  ->middleware('auth')
  ->name('juez.dashboard');

Route::get('/juez/evaluaciones', [JuezController::class, 'evaluaciones'])
  ->middleware('auth')
  ->name('juez.evaluaciones');

Route::get('/juez/rubricas/{id}', [JuezController::class, 'rubricas'])
    ->middleware('auth')
    ->name('juez.rubricas');

Route::get('/juez/configuracion', [JuezController::class, 'configuracion'])
  ->middleware('auth')
  ->name('juez.configuracion');

Route::get('/juez/lineamientos', [JuezController::class, 'lineamientos'])
  ->middleware('auth')
  ->name('juez.lineamientos');

Route::get('/juez/evaluar/{proyecto}/{rubrica}', [JuezController::class, 'evaluar'])
    ->middleware('auth')
    ->name('juez.evaluar');

Route::get('/proyectos/{proyecto}/trabajo', [ProyectoController::class, 'descargarTrabajo'])
    ->middleware('auth')
    ->name('proyectos.trabajo');

Route::post(
  '/juez/configuracion/password',
  [JuezController::class, 'updatePassword']
)->middleware('auth')
  ->name('juez.configuracion.password');

Route::post('/juez/evaluar/{proyecto}/{rubrica}', [JuezController::class, 'guardarEvaluacion'])
  ->middleware('auth')
  ->name('juez.evaluar.guardar');

Route::post('/juez/evaluar/{proyecto}/{rubrica}/borrador', [JuezController::class, 'guardarBorrador'])
  ->middleware('auth')
  ->name('juez.evaluar.borrador');

Route::post('/juez/solicitar-edicion/{calificacion}', [JuezController::class, 'solicitarEdicion'])
  ->middleware('auth')
  ->name('juez.solicitar.edicion');

Route::post('/juez/solicitar-ayuda', [SolicitudAyudaController::class, 'solicitar'])
  ->middleware('auth')
  ->name('juez.solicitar.ayuda');

// ==========================
// AVISO DE IMPRESIÓN (enlace firmado del correo)
// ==========================

Route::get('/avisos/impresion/{correoEnviado}', [AvisoImpresionController::class, 'confirmar'])
  ->middleware('signed:relative')
  ->name('avisos.impresion.confirmar');
