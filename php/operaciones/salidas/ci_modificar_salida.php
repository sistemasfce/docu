<?php

class ci_modificar_salida extends docu_ci
{
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
    //---- cuadro -----------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function conf__cuadro(docu_ei_cuadro $cuadro)
    {
            $where = $this->dep('filtro')->get_sql_where();
            $perfil = toba::usuario()->get_perfiles_funcionales();
            if ($perfil[0] == 'investigacion') {
                $responsable = 2;
                $where .= ' AND salidas.responsable =  '.$responsable;
            }
            if ($perfil[0] == 'academica') {
                $responsable = 1;
                $where .= ' AND salidas.responsable =  '.$responsable;
            }
            $datos = toba::consulta_php('co_salidas')->get_salidas($where);
            $cuadro->set_datos($datos);
    }

    function evt__cuadro__seleccion($seleccion)
    {
            $this->relacion()->cargar($seleccion);
            $this->set_pantalla('pant_edicion');
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
    //-----------------------------------------------------------------------------------
    //---- Eventos ----------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function evt__procesar()
    {
            $this->dep('relacion')->sincronizar();
            $this->dep('relacion')->resetear();
            $this->set_pantalla('pant_seleccion');
    }

    function evt__cancelar()
    {
            $this->dep('relacion')->resetear();
            $this->set_pantalla('pant_seleccion');
    }  
}
