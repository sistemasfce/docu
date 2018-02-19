<?php
 
class co_entradas
{
    function get_entradas($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *
		FROM entradas
		WHERE $where
                ORDER BY numero
        ";
	return toba::db()->consultar($sql);
    }
}
