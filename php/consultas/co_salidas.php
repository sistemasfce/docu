<?php
 
class co_salidas
{
    function get_salidas($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT salidas.*,
                    conceptos.descripcion as concepto_desc,
                    destinos.descripcion as destino_desc   
		FROM salidas LEFT OUTER JOIN conceptos ON salidas.concepto = conceptos.concepto
                    LEFT OUTER JOIN destinos ON salidas.destino = destinos.destino
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
