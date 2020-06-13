<?php
 
class co_resoluciones
{
    function get_resoluciones($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *,
                        resoluciones_tipos.descripcion as tipo_desc,
                        responsables.descripcion as responsable_desc
		FROM resoluciones 
                LEFT OUTER JOIN resoluciones_tipos ON (resoluciones.tipo = resoluciones_tipos.resolucion_tipo)
                LEFT OUTER JOIN responsables ON (resoluciones.responsable = responsables.responsable)
		WHERE $where
                ORDER BY fecha DESC
        ";
	return toba::db()->consultar($sql);
    }
 
}
