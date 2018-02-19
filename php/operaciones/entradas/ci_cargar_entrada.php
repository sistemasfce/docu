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
        
	function evt__procesar()
	{
		try {
			$this->dep('relacion')->sincronizar();
			$this->dep('relacion')->resetear();
		}catch (toba_error $e) {
				toba::notificacion()->agregar('No se puede eliminar el registro', 'error');
		}
	}

	function evt__cancelar()
	{
		$this->dep('relacion')->resetear();
	}          
}

