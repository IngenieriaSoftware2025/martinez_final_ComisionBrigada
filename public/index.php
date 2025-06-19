<?php
require_once __DIR__ . '/../includes/app.php';

use Controllers\AplicacionController;
use MVC\Router;
use Controllers\AppController;
use Controllers\AsignacionController;
use Controllers\ComisionController;
use Controllers\LoginController;
use Controllers\PermisoController;
use Controllers\PersonalController;
use Controllers\UsuariosController;
use Controllers\EstadisticaController;
use Controllers\MapasController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);



//url's login
$router->get('/', [LoginController::class, 'index']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);
$router->get('/inicio', [LoginController::class, 'inicio']);


//url's registrar usuario
$router->get('/usuarios', [UsuariosController::class, 'index']);
$router->post('/usuarios/modificarAPI', [UsuariosController::class, 'modificarAPI']);
$router->get('/usuarios/buscarAPI', [UsuariosController::class, 'buscarAPI']);
$router->get('/usuarios/eliminarAPI', [UsuariosController::class, 'eliminarAPI']);
$router->post('/usuarios/guardarAPI', [UsuariosController::class, 'guardarAPI']);



//url's registrar aplicaciones
$router->get('/aplicacion', [AplicacionController::class, 'index']);
$router->post('/aplicacion/modificarAPI', [AplicacionController::class, 'modificarAPI']);
$router->get('/aplicacion/buscarAPI', [AplicacionController::class, 'buscarAPI']);
$router->get('/aplicacion/eliminarAPI', [AplicacionController::class, 'eliminarAPI']);
$router->post('/aplicacion/guardarAPI', [AplicacionController::class, 'guardarAPI']);



//url's registrar asignaciones
$router->get('/asignacion', [AsignacionController::class, 'index']);
$router->post('/asignacion/guardarAPI', [AsignacionController::class, 'guardarAPI']);
$router->get('/asignacion/buscarAPI', [AsignacionController::class, 'buscarAPI']);
$router->post('/asignacion/modificarAPI', [AsignacionController::class, 'modificarAPI']);
$router->get('/asignacion/eliminarAPI', [AsignacionController::class, 'eliminarAPI']);
$router->get('/asignacion/finPermisoAPI', [AsignacionController::class, 'finPermisoAPI']);
$router->get('/asignacion/obtenerPermisosPorAplicacionAPI', [AsignacionController::class, 'obtenerPermisosPorAplicacionAPI']);



//url's registrar permiso
$router->get('/permiso', [PermisoController::class, 'index']);
$router->post('/permiso/modificarAPI', [PermisoController::class, 'modificarAPI']);
$router->get('/permiso/buscarAPI', [PermisoController::class, 'buscarAPI']);
$router->get('/permiso/eliminarAPI', [PermisoController::class, 'eliminarAPI']);
$router->post('/permiso/guardarAPI', [PermisoController::class, 'guardarAPI']);



//url's registrar personal
$router->get('/personal', [PersonalController::class, 'index']);
$router->post('/personal/modificarAPI', [PersonalController::class, 'modificarAPI']);
$router->get('/personal/buscarAPI', [PersonalController::class, 'buscarAPI']);
$router->get('/personal/eliminarAPI', [PersonalController::class, 'eliminarAPI']);
$router->post('/personal/guardarAPI', [PersonalController::class, 'guardarAPI']);



//url's registrar comision
$router->get('/comision', [ComisionController::class, 'index']);
$router->post('/comision/modificarAPI', [ComisionController::class, 'modificarAPI']);
$router->get('/comision/buscarAPI', [ComisionController::class, 'buscarAPI']);
$router->get('/comision/eliminarAPI', [ComisionController::class, 'eliminarAPI']);
$router->post('/comision/guardarAPI', [ComisionController::class, 'guardarAPI']);
$router->get('/comision/personalDisponibleAPI', [ComisionController::class, 'personalDisponibleAPI']);
$router->get('/comision/comisionesActivasAPI', [ComisionController::class, 'comisionesActivasAPI']);



// url's de estadisticas
$router->get('/estadistica', [EstadisticaController::class, 'renderizarPagina']);
$router->get('/estadistica/buscarComisionesPorFechaAPI', [EstadisticaController::class, 'buscarComisionesPorFechaAPI']);
$router->get('/estadistica/buscarComisionesInformaticaAPI', [EstadisticaController::class, 'buscarComisionesInformaticaAPI']);
$router->get('/estadistica/buscarComisionesTransmisionesAPI', [EstadisticaController::class, 'buscarComisionesTransmisionesAPI']);



//url's de mapas
$router->get('/mapas', [MapasController::class, 'renderizarPagina']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
