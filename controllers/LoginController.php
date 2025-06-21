<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;

class LoginController extends ActiveRecord
{
    public static function index(Router $router)
    {
        $router->render('pages/index', [], 'layouts/principal');
    }

    public static function login()
    {
        getHeadersApi();

        try {
            $correo = htmlspecialchars($_POST['us_correo']);
            $password = htmlspecialchars($_POST['us_contrasenia']);

            $queryExisteUser = "SELECT us_id, us_nombres, us_apellidos, us_correo, us_contrasenia FROM amb_usuarios WHERE us_correo = '$correo' AND us_situacion = '1'";

            $ExisteUsuario = ActiveRecord::fetchArray($queryExisteUser);

            if (!empty($ExisteUsuario)) {
                $usuario = $ExisteUsuario[0];
                $passDB = $usuario['us_contrasenia'];

                if (password_verify($password, $passDB)) {
                    session_start();

                    $_SESSION['user'] = $usuario['us_nombres'] . ' ' . $usuario['us_apellidos'];
                    $_SESSION['us_id'] = $usuario['us_id'];
                    $_SESSION['us_nombres'] = $usuario['us_nombres'];
                    $_SESSION['us_apellidos'] = $usuario['us_apellidos'];
                    $_SESSION['us_correo'] = $usuario['us_correo'];
                    $_SESSION['login'] = true;

                    // Cargar permisos de la BD
                    $sqlPermisos = "SELECT p.per_clave_permiso 
                                  FROM amb_asig_permisos a 
                                  INNER JOIN amb_permisos p ON a.asig_permisos = p.per_id 
                                  WHERE a.asig_usuario = {$usuario['us_id']} 
                                  AND a.asig_situacion = '1'";
                    
                    $permisos = self::fetchArray($sqlPermisos);
                    
                    // cargar permisos en sesion
                    foreach ($permisos as $permiso) {
                        $clave = strtolower($permiso['per_clave_permiso']);
                        $_SESSION[$clave] = true;
                    }

                    
                    // permisos ADMIN
                    if (isset($_SESSION['admin'])) {
                        $_SESSION['usuarios'] = true;
                        $_SESSION['permisos'] = true;
                        $_SESSION['aplicaciones'] = true;
                        $_SESSION['asignaciones'] = true;
                        $_SESSION['personal'] = true;
                        $_SESSION['comisiones'] = true;
                        $_SESSION['estadisticas'] = true;
                        $_SESSION['mapas'] = true;
                        $_SESSION['rutas'] = true;
                    }
                    
                    // permisos BAT
                    if (isset($_SESSION['bat'])) {
                        $_SESSION['comisiones'] = true;
                        $_SESSION['estadisticas'] = true;
                        $_SESSION['mapas'] = true;
                    }
                    
                    // permisios PER
                    if (isset($_SESSION['per'])) {
                        $_SESSION['personal'] = true;
                        $_SESSION['estadisticas'] = true;
                        $_SESSION['mapas'] = true;
                    }

                    echo json_encode([
                        'codigo' => 1,
                        'mensaje' => 'Usuario logueado exitosamente',
                    ]);
                } else {
                    echo json_encode([
                        'codigo' => 0,
                        'mensaje' => 'La contraseña que ingresó es incorrecta',
                    ]);
                }
            } else {
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El usuario que intenta loguearse NO EXISTE',
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al intentar loguearse',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public static function logout()
    {
        session_start();
        
        // reinicia todas las variables de permisos
        unset($_SESSION['admin']);
        unset($_SESSION['per']); 
        unset($_SESSION['bat']);
        unset($_SESSION['usuarios']);
        unset($_SESSION['permisos']);
        unset($_SESSION['aplicaciones']);
        unset($_SESSION['asignaciones']);
        unset($_SESSION['personal']);
        unset($_SESSION['comisiones']);
        unset($_SESSION['estadisticas']);
        unset($_SESSION['mapas']);
        unset($_SESSION['rutas']);
        
        session_destroy();
        header('Location: /martinez_final_ComisionBrigada/');
        exit;
    }

    public static function inicio(Router $router)
    {
        session_start();
        
        // verificar si esta logueado
        if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
            header('Location: /martinez_final_ComisionBrigada/');
            exit;
        }
        
        // renderizar vista de bienvenida
        $router->render('bienvenida/index', [
            'usuario' => $_SESSION['user'],
            'nombres' => $_SESSION['us_nombres'],
            'apellidos' => $_SESSION['us_apellidos'],
            'correo' => $_SESSION['us_correo']
        ]);
    }
}