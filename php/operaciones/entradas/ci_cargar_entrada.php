<?php

class ci_cargar_entrada extends docu_ci
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

    function evt__form__modificacion($datos)
    {
        $this->tabla('entradas')->set($datos);
    }

    //--------------------------------------------------------------------------
    //---- form_ml -------------------------------------------------------------
    //--------------------------------------------------------------------------

    function evt__form_ml__modificacion($datos)
    {
        $this->tabla('pases')->procesar_filas($datos);
    } 
    
    function evt__procesar()
    {
        try {
            $this->dep('relacion')->sincronizar();
            $this->dep('relacion')->resetear();
            $datos = toba::consulta_php('co_entradas')->get_ultimo_numero();
            toba::notificacion()->agregar('Entrada registrada con N° '.$datos['numero'], 'info');
        }catch (toba_error $e) {
            toba::notificacion()->agregar('No se puede insertar el registro', 'error');
        }
    }

    function evt__cancelar()
    {
        $this->dep('relacion')->resetear();
    }
}