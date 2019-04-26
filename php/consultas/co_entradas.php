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
                ORDER BY fecha DESC, numero
        ";
	return toba::db()->consultar($sql);
    }
    
    function get_ultimo_numero()
    {
        $sql = "SELECT numero FROM entradas WHERE numero <> '' ORDER BY entrada DESC LIMIT 1";
        return toba::db()->consultar_fila($sql);
    }   
    
    function get_pases_consejo($where)
    {
        $sql = "SELECT entradas.numero, entradas.asunto, pases.fecha FROM pases LEFT OUTER JOIN entradas ON pases.entrada = entradas.entrada"
                . "  WHERE pase_tipo = 3 AND $where";
        return toba::db()->consultar($sql);
    }    
}
