<?php
 
class co_consejodirectivo
{
    function get_cd_resoluciones($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *
                FROM cd_resoluciones
                WHERE $where
                ORDER BY ciclo_lectivo DESC, resolucion_numero::Int
            
        ";
	return toba::db()->consultar($sql);
    }

    function get_cd_disposiciones($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *
                FROM cd_disposiciones
                WHERE $where
                ORDER BY ciclo_lectivo DESC, disposicion_numero::Int
            
        ";
	return toba::db()->consultar($sql);
    }
    
    function get_cd_actas($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *
                FROM cd_actas
                WHERE $where
                ORDER BY ciclo_lectivo DESC, acta_numero::Int
            
        ";
	return toba::db()->consultar($sql);
    }    
}