<?php

class ci_modificar_resolucion_edicion extends docu_ci
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
            $datos = $this->tabla('resoluciones')->get();
            // si esta cargada la resolucion
            if ($datos['archivo_path'] != '') {
                // el 19 es para que corte la cadena despues del caracter 15, de /home/fce/docu/
                $nombre = substr($datos['archivo_path'],15);
                $dir_tmp = toba::proyecto()->get_www_temp();
                if(!file_exists($dir_tmp['path']."/".$nombre))
                    exec("cp '". $datos['archivo_path']. "' '" .$dir_tmp['path']."/".$nombre."'");
                $temp_archivo = toba::proyecto()->get_www_temp($nombre);
                $tamanio = round(filesize($temp_archivo['path']) / 1024);
                $datos['archivo_path'] = "<a href='{$temp_archivo['url']}'target='_blank'>Descargar archivo</a>";
                $datos['archivo'] = $nombre. ' - Tam.: '.$tamanio. ' KB';           
            }
            $form->set_datos($datos);
        }
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
    }
}
