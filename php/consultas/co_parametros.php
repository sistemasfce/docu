<?php
 
class co_parametros
{
    function get_destinos($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *
		FROM destinos
		WHERE $where
                ORDER BY descripcion
        ";
	return toba::db()->consultar($sql);
    }
    
    function get_origenes($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *
		FROM origenes
		WHERE $where
        ";
	return toba::db()->consultar($sql);
    }   
    
    function get_conceptos($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *
		FROM conceptos
		WHERE $where
        ";
	return toba::db()->consultar($sql);
    }  
    
    function get_responsables($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *
		FROM responsables
		WHERE $where
        ";
	return toba::db()->consultar($sql);
    }   
    
    function get_operadores($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *
		FROM operadores
		WHERE $where
        ";
	return toba::db()->consultar($sql);
    } 
    
    function get_operadores_por_responsable($responsable)
    {
        $sql = "SELECT operadores.operador,
                        apellido || ', ' || nombres as nombre_completo
		FROM responsables_operadores LEFT OUTER JOIN operadores ON responsables_operadores.operador = operadores.operador
		WHERE responsable = $responsable
                    ORDER BY nombre_completo
        ";
	return toba::db()->consultar($sql);
    }     
    
    function get_entradas_tipos($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *
		FROM entradas_tipos
		WHERE $where
        ";
	return toba::db()->consultar($sql);
    } 
    
    function get_salidas_tipos($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *
		FROM salidas_tipos
		WHERE $where
        ";
	return toba::db()->consultar($sql);
    }    

    function get_pases_tipos($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *
		FROM pases_tipos
		WHERE $where
        ";
	return toba::db()->consultar($sql);
    }    
    
    function get_pases_estados($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *
		FROM pases_estados
		WHERE $where
        ";
	return toba::db()->consultar($sql);
    }     
    
    function get_ciclos_lectivos($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT *
		FROM ciclos_lectivos
		WHERE $where
        ";
	return toba::db()->consultar($sql);
    }      
}
