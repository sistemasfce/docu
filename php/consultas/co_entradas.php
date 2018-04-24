<?php
 
class co_entradas
{
    function get_entradas($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT entradas.*,
                        destinos.descripcion as destino_desc
		FROM entradas LEFT OUTER JOIN destinos ON (entradas.destino = destinos.destino)
		WHERE $where
                ORDER BY numero::Int
        ";
	return toba::db()->consultar($sql);
    }
}
