<?php
class ci_consultar_entradas extends docu_ci
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
        $perfil = toba::usuario()->get_perfiles_funcionales();
        if ($perfil[0] == 'investigacion') {
            $responsable = 2;
            $where .= ' AND responsable =  '.$responsable;
        }
        if ($perfil[0] == 'academica') {
            $responsable = 1;
            $where .= ' AND responsable =  '.$responsable;
        }
        $datos = toba::consulta_php('co_entradas')->get_entradas($where);
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