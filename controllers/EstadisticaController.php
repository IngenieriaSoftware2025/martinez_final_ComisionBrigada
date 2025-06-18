<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;

class EstadisticaController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
        $router->render('estadistica/index', []);
    }

    // comisiones por fechas
    public static function buscarComisionesPorFechaAPI()
    {
        try {
            $sql = "SELECT 
                    com_fech_inicio as fecha,
                       COUNT(*) as cantidad
                    FROM amb_comisiones 
                    WHERE com_situacion = '1'
                    GROUP BY com_fech_inicio
                    ORDER BY com_fech_inicio DESC";
            
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Comisiones por fecha obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las comisiones por fecha',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    // comisiones de Informatica
    public static function buscarComisionesInformaticaAPI()
    {
        try {
            $sql = "SELECT 
                       c.com_destino,
                       COUNT(*) as cantidad
                    FROM amb_comisiones c
                    INNER JOIN amb_personal p ON c.com_usuario = p.perso_id
                    WHERE c.com_situacion = '1'
                    AND p.perso_unidad LIKE 'Informatica'
                    GROUP BY c.com_destino
                    ORDER BY cantidad DESC";
            
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Comisiones de Informática obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las comisiones de Informática',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    // comisiones de Transmisiones
    public static function buscarComisionesTransmisionesAPI()
    {
        try {
            $sql = "SELECT 
                       c.com_destino,
                       COUNT(*) as cantidad
                    FROM amb_comisiones c
                    INNER JOIN amb_personal p ON c.com_usuario = p.perso_id
                    WHERE c.com_situacion = '1'
                    AND p.perso_unidad LIKE 'Transmisiones'
                    GROUP BY c.com_destino
                    ORDER BY cantidad DESC";
            
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Comisiones de Transmisiones obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las comisiones de Transmisiones',
                'detalle' => $e->getMessage()
            ]);
        }
    }
}