<?php
 
class co_resoluciones
{
    function get_resoluciones($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *,
                        resoluciones_tipos.descripcion as tipo_desc
		FROM resoluciones 
                LEFT OUTER JOIN resoluciones_tipos ON (resoluciones.tipo = resoluciones_tipos.resolucion_tipo)
		WHERE $where
                ORDER BY fecha DESC
        ";
	return toba::db()->consultar($sql);
    }
 
}
