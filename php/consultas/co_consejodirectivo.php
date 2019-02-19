<?php
 
class co_consejodirectivo
{
    function get_cd_resoluciones($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *
                FROM cd_resoluciones
                WHERE $where
            
        ";
	return toba::db()->consultar($sql);
    }

}