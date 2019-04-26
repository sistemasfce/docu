<?php
class ci_pases_consejo extends docu_ci
{
    protected $s__filtro;

    //-------------------------------------------------------------------------
    function relacion()
    {
        return $this->controlador->dep('relacion');
    }

    //-------------------------------------------------------------------------
    function tabla($id)
    {
        return $this->controlador->dep('relacion')->tabla($id);    
    }
    
    //-----------------------------------------------------------------------------------
    //---- cuadro ------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function conf__cuadro(docu_ei_cuadro $cuadro)
    {   
        $where = $this->dep('filtro')->get_sql_where();
        $datos = toba::consulta_php('co_entradas')->get_pases_consejo($where);
        $cuadro->set_datos($datos);
    }
    
    //-----------------------------------------------------------------------------------
    //---- filtro -----------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function conf__filtro(docu_ei_filtro $filtro)
    {
        if (isset($this->s__filtro)) {
            $filtro->set_datos($this->s__filtro);
        }
    }

    function evt__filtro__filtrar($datos)
    {
        $this->s__filtro = $datos;
    }

    function evt__filtro__cancelar()
    {
        unset($this->s__filtro);
    }     
}
