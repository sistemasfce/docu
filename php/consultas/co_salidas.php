<?php
 
class co_salidas
{
    function get_salidas($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *
                        
		FROM salidas
		WHERE $where
                ORDER BY fecha DESC, numero
        ";
	return toba::db()->consultar($sql);
    }
    
    function get_ultimo_numero()
    {
        $sql = "SELECT numero FROM salidas WHERE numero <> '' ORDER BY salida DESC LIMIT 1";
        return toba::db()->consultar_fila($sql);
    }
}
