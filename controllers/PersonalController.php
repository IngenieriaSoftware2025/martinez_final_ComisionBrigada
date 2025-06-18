<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Personal;
use MVC\Router;

class PersonalController extends ActiveRecord
{
    public function index(Router $router)
    {
        $router->render('personal/index', [], 'layouts/layout');
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        // Validar grado
        if (empty($_POST['perso_grado'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El grado es obligatorio'
            ]);
            return;
        }

        // Validar nombre
        if (empty($_POST['perso_nombre'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre es obligatorio'
            ]);
            return;
        }

        // Validar apellidos
        if (empty($_POST['perso_apellidos'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Los apellidos son obligatorios'
            ]);
            return;
        }

        // Limpiar y validar datos
        $_POST['perso_grado'] = htmlspecialchars(trim($_POST['perso_grado']));
        $_POST['perso_nombre'] = htmlspecialchars(trim($_POST['perso_nombre']));
        $_POST['perso_apellidos'] = htmlspecialchars(trim($_POST['perso_apellidos']));
        $_POST['perso_unidad'] = htmlspecialchars(trim($_POST['perso_unidad'] ?? ''));

        // Validar longitudes
        if (strlen($_POST['perso_grado']) > 50) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El grado no puede exceder 50 caracteres'
            ]);
            return;
        }

        if (strlen($_POST['perso_nombre']) > 50) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre no puede exceder 50 caracteres'
            ]);
            return;
        }

        if (strlen($_POST['perso_apellidos']) > 50) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Los apellidos no pueden exceder 50 caracteres'
            ]);
            return;
        }

        if (strlen($_POST['perso_unidad']) > 100) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La unidad no puede exceder 100 caracteres'
            ]);
            return;
        }

        // Verificar que no exista el mismo personal
        $personalExistente = Personal::verificarPersonalExistente(
            $_POST['perso_nombre'],
            $_POST['perso_apellidos'],
            $_POST['perso_grado']
        );

        if ($personalExistente) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Ya existe personal con el mismo nombre, apellidos y grado'
            ]);
            return;
        }

        try {
            $data = new Personal([
                'perso_grado' => ucwords(strtolower($_POST['perso_grado'])),
                'perso_nombre' => ucwords(strtolower($_POST['perso_nombre'])),
                'perso_apellidos' => ucwords(strtolower($_POST['perso_apellidos'])),
                'perso_unidad' => ucwords(strtolower($_POST['perso_unidad'])),
                'perso_situacion' => '1'
            ]);

            $crear = $data->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Éxito, el personal ha sido registrado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI()
    {
        try {
            $data = Personal::obtenerPersonal();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Personal obtenido correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener el personal',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['perso_id'];

        // Validar grado
        if (empty($_POST['perso_grado'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El grado es obligatorio'
            ]);
            return;
        }

        // Validar nombre
        if (empty($_POST['perso_nombre'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre es obligatorio'
            ]);
            return;
        }

        // Validar apellidos
        if (empty($_POST['perso_apellidos'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Los apellidos son obligatorios'
            ]);
            return;
        }

        // Limpiar y validar datos
        $_POST['perso_grado'] = htmlspecialchars(trim($_POST['perso_grado']));
        $_POST['perso_nombre'] = htmlspecialchars(trim($_POST['perso_nombre']));
        $_POST['perso_apellidos'] = htmlspecialchars(trim($_POST['perso_apellidos']));
        $_POST['perso_unidad'] = htmlspecialchars(trim($_POST['perso_unidad'] ?? ''));

        // Validar longitudes
        if (strlen($_POST['perso_grado']) > 50) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El grado no puede exceder 50 caracteres'
            ]);
            return;
        }

        if (strlen($_POST['perso_nombre']) > 50) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre no puede exceder 50 caracteres'
            ]);
            return;
        }

        if (strlen($_POST['perso_apellidos']) > 50) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Los apellidos no pueden exceder 50 caracteres'
            ]);
            return;
        }

        if (strlen($_POST['perso_unidad']) > 100) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La unidad no puede exceder 100 caracteres'
            ]);
            return;
        }

        // Verificar que no exista otro personal igual (excluyendo el actual)
        $sql = "SELECT perso_id FROM amb_personal WHERE perso_nombre = '{$_POST['perso_nombre']}' AND perso_apellidos = '{$_POST['perso_apellidos']}' AND perso_grado = '{$_POST['perso_grado']}' AND perso_id != $id AND perso_situacion = '1'";
        $existePersonal = self::fetchArray($sql);
        
        if (!empty($existePersonal)) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Ya existe otro personal con el mismo nombre, apellidos y grado'
            ]);
            return;
        }

        try {
            $data = Personal::find($id);
            $data->sincronizar([
                'perso_grado' => ucwords(strtolower($_POST['perso_grado'])),
                'perso_nombre' => ucwords(strtolower($_POST['perso_nombre'])),
                'perso_apellidos' => ucwords(strtolower($_POST['perso_apellidos'])),
                'perso_unidad' => ucwords(strtolower($_POST['perso_unidad']))
            ]);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La información del personal ha sido modificada exitosamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function eliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            $ejecutar = Personal::EliminarPersonal($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El registro del personal ha sido eliminado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarPorGradoAPI()
    {
        try {
            $grado = $_GET['grado'] ?? '';
            
            if (empty($grado)) {
                $data = Personal::obtenerPersonal();
            } else {
                $data = Personal::buscarPorGrado($grado);
            }

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Búsqueda completada',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error en la búsqueda',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarPorUnidadAPI()
    {
        try {
            $unidad = $_GET['unidad'] ?? '';
            
            if (empty($unidad)) {
                $data = Personal::obtenerPersonal();
            } else {
                $data = Personal::buscarPorUnidad($unidad);
            }

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Búsqueda completada',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error en la búsqueda',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function estadisticasAPI()
    {
        try {
            $data = Personal::contarPorGrado();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Estadísticas obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener estadísticas',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}