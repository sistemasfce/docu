<?php
 
class co_salidas
{
    function get_salidas($where=null)
    {
	if (!isset($where)) $where = '1=1';
        $sql = "SELECT salidas.*,
                    conceptos.descripcion as concepto_desc,
                    destinos.descripcion as destino_desc,
                    op2.apellido || ', ' || op2.nombres as operador_desc,
                    responsables.descripcion as responsable_desc,
                    salidas_tipos.descripcion as tipo_desc
		FROM salidas LEFT OUTER JOIN conceptos ON salidas.concepto = conceptos.concepto
                LEFT OUTER JOIN salidas_tipos ON (salidas.salida_tipo = salidas_tipos.salida_tipo)
                LEFT OUTER JOIN destinos ON salidas.destino = destinos.destino
                LEFT OUTER JOIN operadores as op2 ON (salidas.operador = op2.operador)
                LEFT OUTER JOIN responsables ON (salidas.responsable = responsables.responsable)
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
