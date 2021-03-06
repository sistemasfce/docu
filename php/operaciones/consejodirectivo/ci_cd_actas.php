<?php
class ci_cd_actas extends docu_ci
{
    //-------------------------------------------------------------------------
    function relacion()
    {
        return $this->dep('relacion');
    }

    //-------------------------------------------------------------------------
    function tabla($id)
    {
        return $this->dep('relacion')->tabla($id);    
    }
    
    //-----------------------------------------------------------------------------------
    //---- cuadro -------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function conf__cuadro(docu_ei_cuadro $cuadro)
    {
        $aux = array();
        $where = $this->dep('filtro')->get_sql_where();
        $datos = toba::consulta_php('co_consejodirectivo')->get_cd_actas($where);
        foreach ($datos as $dat) {
            if ($dat['archivo_path'] != '') {
                // el 27 es para que corte la cadena despues del caracter 27, de /home/fce/consejodirectivo/
                $nombre = substr($dat['archivo_path'],27);
                $dir_tmp = toba::proyecto()->get_www_temp();
                if(!file_exists($dir_tmp['path']."/".$nombre))
                    exec("cp '". $dat['archivo_path']. "' '" .$dir_tmp['path']."/".$nombre."'");
                $temp_archivo = toba::proyecto()->get_www_temp($nombre);
                $dat['acta'] = "<a href='{$temp_archivo['url']}'target='_blank'>".$dat['acta_numero']."</a>";    
            }
            if ($dat['audio_path'] != '') {
                // el 27 es para que corte la cadena despues del caracter 27, de /home/fce/consejodirectivo/
                $nombre = substr($dat['audio_path'],27);
                $dir_tmp = toba::proyecto()->get_www_temp();
                if(!file_exists($dir_tmp['path']."/".$nombre))
                    exec("cp '". $dat['audio_path']. "' '" .$dir_tmp['path']."/".$nombre."'");
                $temp_archivo = toba::proyecto()->get_www_temp($nombre);
                $dat['audio'] = "<a href='{$temp_archivo['url']}'target='_blank'>".$dat['acta_numero']."</a>";    
            }            
            if ($dat['archivo_path'] != '') {
                $dat['subio_pdf'] = 'S';
            } else
                $dat['subio_pdf'] = 'N';
            if ($dat['audio_path'] != '') {
                $dat['subio_audio'] = 'S';
            } else
                $dat['subio_audio'] = 'N';
            $aux[] = $dat;
        }
        $cuadro->set_datos($aux);        
    }
    
    function evt__cuadro__seleccion($seleccion)
    {
        $this->relacion()->cargar($seleccion);
        $this->set_pantalla('edicion');
    }

    //-----------------------------------------------------------------------------------    
    //---- form_ficha -------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function conf__form(docu_ei_formulario $form)
    {
        $fecha = new DateTime();
        $fecha->getTimestamp();
        $datos = $this->tabla('cd_actas')->get();

        // si esta cargada la resolucion
        if ($datos['archivo_path'] != '') {
            // el 19 es para que corte la cadena despues del caracter 19, de /home/fce/consejodirectivo/
            $nombre = substr($datos['archivo_path'],27);
            $dir_tmp = toba::proyecto()->get_www_temp();
            if(!file_exists($dir_tmp['path']."/".$nombre))
                exec("cp '". $datos['archivo_path']. "' '" .$dir_tmp['path']."/".$nombre."'");
            $temp_archivo = toba::proyecto()->get_www_temp($nombre);
            $tamanio = round(filesize($temp_archivo['path']) / 1024);
            $datos['archivo_path'] = "<a href='{$temp_archivo['url']}'target='_blank'>Descargar archivo</a>";
            $datos['archivo'] = $nombre. ' - Tam.: '.$tamanio. ' KB';           
        }
        if ($datos['audio_path'] != '') {
            // el 19 es para que corte la cadena despues del caracter 19, de /home/fce/consejodirectivo/
            $nombre = substr($datos['audio_path'],27);
            $dir_tmp = toba::proyecto()->get_www_temp();
            if(!file_exists($dir_tmp['path']."/".$nombre))
                exec("cp '". $datos['audio_path']. "' '" .$dir_tmp['path']."/".$nombre."'");
            $temp_archivo = toba::proyecto()->get_www_temp($nombre);
            $tamanio = round(filesize($temp_archivo['path']) / 1024);
            $datos['audio_path'] = "<a href='{$temp_archivo['url']}'target='_blank'>Descargar archivo</a>";
            $datos['audio'] = $nombre. ' - Tam.: '.$tamanio. ' KB';           
        }        
        $form->set_datos($datos);
    }

    function evt__form__modificacion($datos)
    {
        if (isset($datos['archivo']) or isset($datos['archivo_path'])) {
            $nombre_archivo = $datos['archivo']['name'];
            $nombre_nuevo = 'acta_'.$datos['ciclo_lectivo'].'_'.$datos['acta_numero'].'.pdf';   
            $destino = '/home/fce/consejodirectivo/'.$nombre_nuevo;
            // Mover los archivos subidos al servidor del directorio temporal PHP a uno propio.
            move_uploaded_file($datos['archivo']['tmp_name'], $destino); 
            $datos['archivo_path'] = $destino; 
        }  
        if (isset($datos['audio']) or isset($datos['audio_path'])) {
            $nombre_archivo = $datos['audio']['name'];
            $nombre_nuevo = 'acta_'.$datos['ciclo_lectivo'].'_'.$datos['acta_numero'].'.mp3';   
            $destino = '/home/fce/consejodirectivo/'.$nombre_nuevo;
            // Mover los archivos subidos al servidor del directorio temporal PHP a uno propio.
            move_uploaded_file($datos['audio']['tmp_name'], $destino); 
            $datos['audio_path'] = $destino; 
        }           
        $this->tabla('cd_actas')->set($datos);
        $this->tabla('cd_actas')->sincronizar();
    }
    
    //-----------------------------------------------------------------------------------
    //---- Eventos ----------------------------------------------------------------------
    //-----------------------------------------------------------------------------------

    function evt__agregar()
    {
        $this->set_pantalla('edicion');
    }

    function evt__cancelar()
    {
        $this->dep('relacion')->resetear();
        $this->set_pantalla('seleccion');
    }

    function evt__eliminar()
    {
        try {
            $this->dep('relacion')->eliminar_todo();
            $this->set_pantalla('seleccion');
        } catch (toba_error $e) {
            toba::notificacion()->agregar('No es posible eliminar el registro.');
        }
    }  
    
    function evt__guardar()
    {
        try {
            $this->dep('relacion')->sincronizar();
            $this->dep('relacion')->resetear();
        } catch (toba_error $e) {
            $this->informar_msg('Error al dar de alta usuario - '. $e->get_mensaje());
            return;
        }  
        $this->set_pantalla('seleccion');
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