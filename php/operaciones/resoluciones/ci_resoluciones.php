<?php

class ci_resoluciones extends docu_ci
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
        if (isset($datos['archivo']) or isset($datos['archivo_path'])) {
            $nombre_archivo = $datos['archivo']['name'];
            $nombre_nuevo = 'resol_'.$datos['ciclo_lectivo'].'_'.$datos['numero'].'.pdf';   
            $destino = '/home/fce/docu/'.$nombre_nuevo;
            // Mover los archivos subidos al servidor del directorio temporal PHP a uno propio.
            move_uploaded_file($datos['archivo']['tmp_name'], $destino); 
            $datos['archivo_path'] = $destino; 
        }      
        $this->tabla('resoluciones')->set($datos);
        //$this->tabla('resoluciones')->sincronizar();
    }
    
    function evt__procesar()
    {
        try {
            $this->dep('relacion')->sincronizar();
            $this->dep('relacion')->resetear();
            toba::notificacion()->agregar('Resolcuión cargada correctamente', 'info');
        }catch (toba_error $e) {
            toba::notificacion()->agregar('No se puede insertar el registro', 'error');
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