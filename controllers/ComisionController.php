<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Comision;
use Model\Personal;
use MVC\Router;

class ComisionController extends ActiveRecord
{
    public function index(Router $router)
    {

        $personal = Personal::all(); 
        $router->render('comision/index', [
            'personal' => $personal
        ], 'layouts/layout');
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        // Validar usuario
        if (empty($_POST['com_usuario'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar un personal'
            ]);
            return;
        }

        // Validar destino
        if (empty($_POST['com_destino'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El destino es obligatorio'
            ]);
            return;
        }

        // Validar descripción
        if (empty($_POST['com_descripcion'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La descripción es obligatoria'
            ]);
            return;
        }

        // Validar fechas
        if (empty($_POST['com_fech_inicio']) || empty($_POST['com_fech_fin'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Las fechas de inicio y fin son obligatorias'
            ]);
            return;
        }

        // Limpiar datos
        $_POST['com_usuario'] = filter_var($_POST['com_usuario'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['com_destino'] = htmlspecialchars(trim($_POST['com_destino']));
        $_POST['com_descripcion'] = htmlspecialchars(trim($_POST['com_descripcion']));
        $_POST['com_fech_inicio'] = date('Y-m-d H:i', strtotime($_POST['com_fech_inicio']));
        $_POST['com_fech_fin'] = date('Y-m-d H:i', strtotime($_POST['com_fech_fin']));

        // Validar longitudes
        if (strlen($_POST['com_destino']) > 250) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El destino no puede exceder 250 caracteres'
            ]);
            return;
        }

        if (strlen($_POST['com_descripcion']) > 500) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La descripción no puede exceder 500 caracteres'
            ]);
            return;
        }

        // Validar fechas 
        if (strtotime($_POST['com_fech_fin']) <= strtotime($_POST['com_fech_inicio'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La fecha de fin debe ser posterior a la fecha de inicio'
            ]);
            return;
        }

        // rificar que el usuario no tenga una comisión activa
        $comisionActiva = Comision::verificarUsuarioConComisionActiva($_POST['com_usuario']);
        if ($comisionActiva) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El personal seleccionado ya tiene una comisión activa. No se puede asignar otra comisión hasta que finalice la actual.'
            ]);
            return;
        }

        // Verificar que no haya conflicto de fechas para el mismo destino
        $conflictoFechas = Comision::verificarConflictoFechas(
            $_POST['com_usuario'],
            $_POST['com_fech_inicio'],
            $_POST['com_fech_fin']
        );

        if ($conflictoFechas) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El personal ya tiene una comisión programada en el rango de fechas seleccionado'
            ]);
            return;
        }

        try {
            $data = new Comision([
                'com_usuario' => $_POST['com_usuario'],
                'com_destino' => ucwords(strtolower($_POST['com_destino'])),
                'com_descripcion' => ucfirst(strtolower($_POST['com_descripcion'])),
                'com_fech_inicio' => $_POST['com_fech_inicio'],
                'com_fech_fin' => $_POST['com_fech_fin'],
                'com_situacion' => '1'
            ]);

            $crear = $data->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La comisión ha sido registrada correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar la comisión',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI()
    {
        try {
            $data = Comision::obtenerComisiones();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Comisiones obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las comisiones',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['com_id'];

        if (empty($_POST['com_usuario'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar un personal'
            ]);
            return;
        }

        if (empty($_POST['com_destino'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El destino es obligatorio'
            ]);
            return;
        }

        if (empty($_POST['com_descripcion'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La descripción es obligatoria'
            ]);
            return;
        }

        if (empty($_POST['com_fech_inicio']) || empty($_POST['com_fech_fin'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Las fechas de inicio y fin son obligatorias'
            ]);
            return;
        }

        // Limpiar datos
        $_POST['com_usuario'] = filter_var($_POST['com_usuario'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['com_destino'] = htmlspecialchars(trim($_POST['com_destino']));
        $_POST['com_descripcion'] = htmlspecialchars(trim($_POST['com_descripcion']));
        $_POST['com_fech_inicio'] = htmlspecialchars(trim($_POST['com_fech_inicio']));
        $_POST['com_fech_fin'] = htmlspecialchars(trim($_POST['com_fech_fin']));

        // Validar fechas 
        if (strtotime($_POST['com_fech_fin']) <= strtotime($_POST['com_fech_inicio'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La fecha de fin debe ser posterior a la fecha de inicio'
            ]);
            return;
        }

        // Verificar que el usuario no tenga otra comisión activa 
        $comisionActiva = Comision::verificarUsuarioConComisionActivaExcluyendo($_POST['com_usuario'], $id);
        if ($comisionActiva) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El personal seleccionado ya tiene otra comisión activa. No se puede modificar a este personal.'
            ]);
            return;
        }

        try {
            $data = Comision::find($id);
            $data->sincronizar([
                'com_usuario' => $_POST['com_usuario'],
                'com_destino' => ucwords(strtolower($_POST['com_destino'])),
                'com_descripcion' => ucfirst(strtolower($_POST['com_descripcion'])),
                'com_fech_inicio' => $_POST['com_fech_inicio'],
                'com_fech_fin' => $_POST['com_fech_fin']
            ]);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La comisión ha sido modificada exitosamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar la comisión',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function eliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            $ejecutar = Comision::eliminarComision($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La comisión ha sido eliminada correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar la comisión',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function comisionesActivasAPI()
    {
        try {
            $data = Comision::obtenerComisionesActivas();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Comisiones activas obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener comisiones activas',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}