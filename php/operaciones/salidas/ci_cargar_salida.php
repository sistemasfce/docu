<?php

class ci_cargar_salida extends docu_ci
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
        $this->tabla('salidas')->set($datos);
    }

    function evt__procesar()
    {
        try {
            $this->dep('relacion')->sincronizar();
            $this->dep('relacion')->resetear();
            $datos = toba::consulta_php('co_salidas')->get_ultimo_numero();
            toba::notificacion()->agregar('Salida registrada con N° '.$datos['numero'], 'info');
        }catch (toba_error $e) {
            toba::notificacion()->agregar('No se puede eliminar el registro', 'error');
        }
    }

    function evt__cancelar()
    {
        $this->dep('relacion')->resetear();
    }    
    
    function get_responsables()
    {
        $where = ' 1=1 ';
        $perfil = toba::usuario()->get_perfiles_funcionales();
        if ($perfil[0] == 'investigacion') {
            $responsable = 2;
            $where .= ' AND responsable =  '.$responsable;
        }
        if ($perfil[0] == 'academica') {
            $responsable = 1;
            $where .= ' AND responsable =  '.$responsable;
        }
        return toba::consulta_php('co_parametros')->get_responsables($where);
    }    
}
