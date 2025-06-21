<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Rutas;
use MVC\Router;

class RutasController extends ActiveRecord
{
    public function index(Router $router)
    {
        isAuth();
        hasPermission(['rutas']);

        $router->render('rutas/index', [], 'layouts/layout');
    }

    public static function guardarAPI()
    {
        isAuthApi();
        hasPermissionApi(['rutas']);
        getHeadersApi();

        $_POST['rut_aplicacion'] = htmlspecialchars($_POST['rut_aplicacion']);
        $cantidad_aplicacion = strlen($_POST['rut_aplicacion']);

        if ($cantidad_aplicacion < 1) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La aplicación es obligatoria'
            ]);
            return;
        }

        if ($cantidad_aplicacion > 50) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La aplicación no puede exceder 50 caracteres'
            ]);
            return;
        }

        $_POST['rut_ruta'] = htmlspecialchars($_POST['rut_ruta']);
        $cantidad_ruta = strlen($_POST['rut_ruta']);

        if ($cantidad_ruta < 1) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La ruta es obligatoria'
            ]);
            return;
        }

        if ($cantidad_ruta > 100) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La ruta no puede exceder 100 caracteres'
            ]);
            return;
        }

        $_POST['rut_descripcion'] = htmlspecialchars($_POST['rut_descripcion']);
        $cantidad_descripcion = strlen($_POST['rut_descripcion']);

        if ($cantidad_descripcion < 1) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La descripción es obligatoria'
            ]);
            return;
        }

        if ($cantidad_descripcion > 200) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La descripción no puede exceder 200 caracteres'
            ]);
            return;
        }

        // Verificar que no exista una ruta con la misma aplicación y ruta
        $sql = "SELECT rut_id FROM amb_rutas WHERE rut_aplicacion = '{$_POST['rut_aplicacion']}' AND rut_ruta = '{$_POST['rut_ruta']}' AND rut_situacion = 1";
        $rutaExistente = self::fetchArray($sql);
        if (!empty($rutaExistente)) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Ya existe una ruta con esta aplicación y ruta'
            ]);
            return;
        }

        try {
            $data = new Rutas([
                'rut_aplicacion' => $_POST['rut_aplicacion'],
                'rut_ruta' => $_POST['rut_ruta'],
                'rut_descripcion' => $_POST['rut_descripcion'],
                'rut_situacion' => 1
            ]);

            $crear = $data->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Éxito, la ruta ha sido registrada correctamente'
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
        isAuthApi();
        hasPermissionApi(['rutas']);
        try {
            $sql = "SELECT * FROM amb_rutas WHERE rut_situacion = 1 ORDER BY rut_id DESC";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Rutas obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las rutas',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        isAuthApi();
        hasPermissionApi(['rutas']);
        getHeadersApi();

        $id = $_POST['rut_id'];

        $_POST['rut_aplicacion'] = htmlspecialchars($_POST['rut_aplicacion']);
        $cantidad_aplicacion = strlen($_POST['rut_aplicacion']);

        if ($cantidad_aplicacion < 1) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La aplicación es obligatoria'
            ]);
            return;
        }

        if ($cantidad_aplicacion > 50) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La aplicación no puede exceder 50 caracteres'
            ]);
            return;
        }

        $_POST['rut_ruta'] = htmlspecialchars($_POST['rut_ruta']);
        $cantidad_ruta = strlen($_POST['rut_ruta']);

        if ($cantidad_ruta < 1) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La ruta es obligatoria'
            ]);
            return;
        }

        if ($cantidad_ruta > 100) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La ruta no puede exceder 100 caracteres'
            ]);
            return;
        }

        $_POST['rut_descripcion'] = htmlspecialchars($_POST['rut_descripcion']);
        $cantidad_descripcion = strlen($_POST['rut_descripcion']);

        if ($cantidad_descripcion < 1) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La descripción es obligatoria'
            ]);
            return;
        }

        if ($cantidad_descripcion > 200) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La descripción no puede exceder 200 caracteres'
            ]);
            return;
        }

        // Verificar que no exista otra ruta con la misma aplicación y ruta (excluyendo la actual)
        $sql = "SELECT rut_id FROM amb_rutas WHERE rut_aplicacion = '{$_POST['rut_aplicacion']}' AND rut_ruta = '{$_POST['rut_ruta']}' AND rut_id != $id AND rut_situacion = 1";
        $existeRuta = self::fetchArray($sql);
        if (!empty($existeRuta)) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Ya existe otra ruta con esta aplicación y ruta'
            ]);
            return;
        }

        try {
            $data = Rutas::find($id);
            $data->sincronizar([
                'rut_aplicacion' => $_POST['rut_aplicacion'],
                'rut_ruta' => $_POST['rut_ruta'],
                'rut_descripcion' => $_POST['rut_descripcion']
            ]);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La información de la ruta ha sido modificada exitosamente'
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

    public static function eliminarAPI()
    {
        isAuthApi();
        hasPermissionApi(['rutas']);
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            $ejecutar = Rutas::EliminarRutas($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El registro ha sido eliminado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al Eliminar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}