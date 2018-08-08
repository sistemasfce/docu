<?php
 
class co_entradas
{
    function get_entradas($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT entradas.*,
                        destinos.descripcion as destino_desc,
                        entradas_tipos.descripcion as tipo_desc
		FROM entradas LEFT OUTER JOIN destinos ON (entradas.destino = destinos.destino)
                LEFT OUTER JOIN entradas_tipos ON (entradas.entrada_tipo = entradas_tipos.entrada_tipo)
		WHERE $where
                ORDER BY numero::Int DESC
        ";
	return toba::db()->consultar($sql);
    }
}
