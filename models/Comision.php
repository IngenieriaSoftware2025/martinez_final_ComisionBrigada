<?php

namespace Model;
use Model\ActiveRecord;

class Comision extends ActiveRecord
{
    public static $tabla = 'amb_comisiones';
    public static $columnasDB = [
        'com_usuario',
        'com_destino',
        'com_descripcion',
        'com_fech_inicio',
        'com_fech_fin',
        'com_situacion'
    ];
    public static $idTabla = 'com_id';

    public $com_id;
    public $com_usuario;
    public $com_destino;
    public $com_descripcion;
    public $com_fech_inicio;
    public $com_fech_fin;
    public $com_situacion;

    public function __construct($args = [])
    {
        $this->com_id = $args['com_id'] ?? null;
        $this->com_usuario = $args['com_usuario'] ?? '';
        $this->com_destino = $args['com_destino'] ?? '';
        $this->com_descripcion = $args['com_descripcion'] ?? '';
        $this->com_fech_inicio = $args['com_fech_inicio'] ?? '';
        $this->com_fech_fin = $args['com_fech_fin'] ?? '';
        $this->com_situacion = $args['com_situacion'] ?? '1';
    }

    // Eliminar comisión 
    public static function eliminarComision($id)
    {
        $sql = "UPDATE amb_comisiones SET com_situacion = '0' WHERE com_id = $id";
        return self::SQL($sql);
    }

    // Obtener todas las comisiones con información del personal
    public static function obtenerComisiones()
    {
        $sql = "SELECT 
                    c.com_id,
                    c.com_usuario,
                    c.com_destino,
                    c.com_descripcion,
                    c.com_fech_inicio,
                    c.com_fech_fin,
                    c.com_situacion,
                    p.perso_grado,
                    p.perso_nombre,
                    p.perso_apellidos,
                    p.perso_unidad,
                    (p.perso_grado || ' ' || p.perso_nombre || ' ' || p.perso_apellidos) as personal_completo
                FROM amb_comisiones c
                INNER JOIN amb_personal p ON c.com_usuario = p.perso_id
                WHERE c.com_situacion = '1'
                ORDER BY c.com_fech_inicio DESC";
        
        $resultado = self::fetchArray($sql);
        return $resultado ?: [];
    }

    // VALIDACIÓN PRINCIPAL: Verificar si un usuario tiene comisión activa
    public static function verificarUsuarioConComisionActiva($usuario_id)
    {
        $fechaActual = date('Y-m-d H:i');
        $sql = "SELECT com_id FROM amb_comisiones 
                WHERE com_usuario = $usuario_id 
                AND com_fech_inicio <= '$fechaActual'
                AND com_fech_fin >= '$fechaActual'
                AND com_situacion = '1'";
        
        $resultado = self::fetchArray($sql);
        return !empty($resultado);
    }

    // Verificar usuario con comisión activa excluyendo una comisión específica (para modificar)
    public static function verificarUsuarioConComisionActivaExcluyendo($usuario_id, $excluir_com_id)
    {
        $fechaActual = date('Y-m-d H:i');
        $sql = "SELECT com_id FROM amb_comisiones 
                WHERE com_usuario = $usuario_id 
                AND com_fech_inicio <= '$fechaActual'
                AND com_fech_fin >= '$fechaActual'
                AND com_situacion = '1'
                AND com_id != $excluir_com_id";
        
        $resultado = self::fetchArray($sql);
        return !empty($resultado);
    }

    // Verificar conflicto de fechas para un usuario
    public static function verificarConflictoFechas($usuario_id, $fecha_inicio, $fecha_fin)
    {
        $sql = "SELECT com_id FROM amb_comisiones 
                WHERE com_usuario = $usuario_id 
                AND ((com_fech_inicio <= '$fecha_inicio' AND com_fech_fin >= '$fecha_inicio')
                     OR (com_fech_inicio <= '$fecha_fin' AND com_fech_fin >= '$fecha_fin')
                     OR (com_fech_inicio >= '$fecha_inicio' AND com_fech_fin <= '$fecha_fin'))
                AND com_situacion = '1'";
        
        $resultado = self::fetchArray($sql);
        return !empty($resultado);
    }

    // Obtener personal disponible (sin comisiones activas)
    public static function obtenerPersonalDisponible()
    {
        $fechaActual = date('Y-m-d H:i');
        $sql = "SELECT 
                    p.perso_id,
                    p.perso_grado,
                    p.perso_nombre,
                    p.perso_apellidos,
                    p.perso_unidad,
                    (p.perso_grado || ' ' || p.perso_nombre || ' ' || p.perso_apellidos) as personal_completo
                FROM amb_personal p
                WHERE p.perso_situacion = '1'
                AND p.perso_id NOT IN (
                    SELECT c.com_usuario 
                    FROM amb_comisiones c 
                    WHERE c.com_fech_inicio <= '$fechaActual'
                    AND c.com_fech_fin >= '$fechaActual'
                    AND c.com_situacion = '1'
                )
                ORDER BY p.perso_grado, p.perso_apellidos";
        
        $resultado = self::fetchArray($sql);
        return $resultado ?: [];
    }

    // Buscar comisiones por personal
    public static function buscarPorPersonal($personal_id)
    {
        $sql = "SELECT 
                    c.com_id,
                    c.com_usuario,
                    c.com_destino,
                    c.com_descripcion,
                    c.com_fech_inicio,
                    c.com_fech_fin,
                    c.com_situacion,
                    p.perso_grado,
                    p.perso_nombre,
                    p.perso_apellidos,
                    p.perso_unidad,
                    (p.perso_grado || ' ' || p.perso_nombre || ' ' || p.perso_apellidos) as personal_completo
                FROM amb_comisiones c
                INNER JOIN amb_personal p ON c.com_usuario = p.perso_id
                WHERE c.com_situacion = '1' AND c.com_usuario = $personal_id
                ORDER BY c.com_fech_inicio DESC";
        
        $resultado = self::fetchArray($sql);
        return $resultado ?: [];
    }

    // Buscar comisiones por destino
    public static function buscarPorDestino($destino)
    {
        $sql = "SELECT 
                    c.com_id,
                    c.com_usuario,
                    c.com_destino,
                    c.com_descripcion,
                    c.com_fech_inicio,
                    c.com_fech_fin,
                    c.com_situacion,
                    p.perso_grado,
                    p.perso_nombre,
                    p.perso_apellidos,
                    p.perso_unidad,
                    (p.perso_grado || ' ' || p.perso_nombre || ' ' || p.perso_apellidos) as personal_completo
                FROM amb_comisiones c
                INNER JOIN amb_personal p ON c.com_usuario = p.perso_id
                WHERE c.com_situacion = '1' 
                AND UPPER(c.com_destino) LIKE UPPER('%$destino%')
                ORDER BY c.com_fech_inicio DESC";
        
        $resultado = self::fetchArray($sql);
        return $resultado ?: [];
    }

    // Obtener comisiones activas
    public static function obtenerComisionesActivas()
    {
        $fechaActual = date('Y-m-d H:i');
        $sql = "SELECT 
                    c.com_id,
                    c.com_usuario,
                    c.com_destino,
                    c.com_descripcion,
                    c.com_fech_inicio,
                    c.com_fech_fin,
                    c.com_situacion,
                    p.perso_grado,
                    p.perso_nombre,
                    p.perso_apellidos,
                    p.perso_unidad,
                    (p.perso_grado || ' ' || p.perso_nombre || ' ' || p.perso_apellidos) as personal_completo
                FROM amb_comisiones c
                INNER JOIN amb_personal p ON c.com_usuario = p.perso_id
                WHERE c.com_situacion = '1'
                AND c.com_fech_inicio <= '$fechaActual'
                AND c.com_fech_fin >= '$fechaActual'
                ORDER BY c.com_fech_inicio DESC";
        
        $resultado = self::fetchArray($sql);
        return $resultado ?: [];
    }

    // Obtener estadísticas
    public static function obtenerEstadisticas()
    {
        $fechaActual = date('Y-m-d H:i');
        
        $sql = "SELECT 
                    COUNT(*) as total_comisiones,
                    SUM(CASE WHEN com_fech_inicio <= '$fechaActual' AND com_fech_fin >= '$fechaActual' THEN 1 ELSE 0 END) as activas,
                    SUM(CASE WHEN com_fech_inicio > '$fechaActual' THEN 1 ELSE 0 END) as pendientes,
                    SUM(CASE WHEN com_fech_fin < '$fechaActual' THEN 1 ELSE 0 END) as finalizadas
                FROM amb_comisiones 
                WHERE com_situacion = '1'";
        
        $resultado = self::fetchArray($sql);
        return $resultado[0] ?? [];
    }
}