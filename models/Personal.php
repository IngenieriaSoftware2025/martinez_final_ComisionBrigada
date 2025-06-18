<?php

namespace Model;
use Model\ActiveRecord;

class Personal extends ActiveRecord
{

    public static $tabla = 'amb_personal';
    public static $columnasDB = [
        'perso_grado',
        'perso_nombre',
        'perso_apellidos',
        'perso_unidad',
        'perso_situacion'
    ];
    public static $idTabla = 'perso_id';

    public $perso_id;
    public $perso_grado;
    public $perso_nombre;
    public $perso_apellidos;
    public $perso_unidad;
    public $perso_situacion;


    public function __construct($args = [])
    {
        $this->perso_id = $args['perso_id'] ?? null;
        $this->perso_grado = $args['perso_grado'] ?? '';
        $this->perso_nombre = $args['perso_nombre'] ?? '';
        $this->perso_apellidos = $args['perso_apellidos'] ?? '';
        $this->perso_unidad = $args['perso_unidad'] ?? '';
        $this->perso_situacion = $args['perso_situacion'] ?? 1;
    }

    public static function EliminarPersonal($id)
    {
        $sql = "UPDATE amb_personal SET perso_situacion = 0 WHERE perso_id = $id";
        return self::SQL($sql);
    }

    public static function obtenerPersonal()
    {
        $sql = "SELECT 
                perso_id,
                perso_grado,
                perso_nombre,
                perso_apellidos,
                perso_unidad,
                perso_situacion
              FROM amb_personal
              WHERE perso_situacion = 1
              ORDER BY perso_grado, perso_apellidos, perso_nombre";
        
        $resultado = self::fetchArray($sql);
        
        return $resultado ?: [];
    }

    public static function buscarPorGrado($grado)
    {
        $sql = "SELECT 
                perso_id,
                perso_grado,
                perso_nombre,
                perso_apellidos,
                perso_unidad
              FROM amb_personal
              WHERE perso_grado ILIKE '%$grado%' 
              AND perso_situacion = 1
              ORDER BY perso_apellidos, perso_nombre";
        
        $resultado = self::fetchArray($sql);
        
        return $resultado ?: [];
    }

    public static function buscarPorUnidad($unidad)
    {
        $sql = "SELECT 
                perso_id,
                perso_grado,
                perso_nombre,
                perso_apellidos,
                perso_unidad
              FROM amb_personal
              WHERE perso_unidad ILIKE '%$unidad%' 
              AND perso_situacion = 1
              ORDER BY perso_grado, perso_apellidos, perso_nombre";
        
        $resultado = self::fetchArray($sql);
        
        return $resultado ?: [];
    }

    public static function contarPorGrado()
    {
        $sql = "SELECT 
                perso_grado,
                COUNT(*) as cantidad
              FROM amb_personal
              WHERE perso_situacion = 1
              GROUP BY perso_grado
              ORDER BY cantidad DESC";
        
        $resultado = self::fetchArray($sql);
        
        return $resultado ?: [];
    }

    public static function verificarPersonalExistente($nombre, $apellidos, $grado)
    {
        $sql = "SELECT COUNT(*) as total 
              FROM amb_personal 
              WHERE perso_nombre = '$nombre' 
              AND perso_apellidos = '$apellidos'
              AND perso_grado = '$grado'
              AND perso_situacion = 1";
        
        $resultado = self::fetchArray($sql);
        
        return $resultado[0]['total'] > 0;
    }
}