<?php

class ci_modificar_entrada_edicion extends docu_ci
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

    function conf__form(docu_ei_formulario $form)
    {
        if ($this->relacion()->esta_cargada()) {
            $datos = $this->tabla('entradas')->get();
            $form->set_datos($datos);
        }
    }        

    function evt__form__modificacion($datos)
    {
        $this->tabla('entradas')->set($datos);
    }

    //-----------------------------------------------------------------------------------
    //---- form_ml ----------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function conf__form_ml(docu_ei_formulario_ml $form_ml)
    {
        if ($this->relacion()->esta_cargada()) {
            $datos = $this->tabla('pases')->get_filas();
            $form_ml->set_datos($datos);
        }
    }

    function evt__form_ml__modificacion($datos)
    {
        $this->tabla('pases')->procesar_filas($datos);
    }        
}
