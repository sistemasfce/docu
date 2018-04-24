<?php
/**
 * Esta clase fue y será generada automáticamente. NO EDITAR A MANO.
 * @ignore
 */
class docu_autoload 
{
	static function existe_clase($nombre)
	{
		return isset(self::$clases[$nombre]);
	}

	static function cargar($nombre)
	{
		if (self::existe_clase($nombre)) { 
			 require_once(dirname(__FILE__) .'/'. self::$clases[$nombre]); 
		}
	}

	static protected $clases = array(
		'docu_ci' => 'extension_toba/componentes/docu_ci.php',
		'docu_cn' => 'extension_toba/componentes/docu_cn.php',
		'docu_datos_relacion' => 'extension_toba/componentes/docu_datos_relacion.php',
		'docu_datos_tabla' => 'extension_toba/componentes/docu_datos_tabla.php',
		'docu_ei_arbol' => 'extension_toba/componentes/docu_ei_arbol.php',
		'docu_ei_archivos' => 'extension_toba/componentes/docu_ei_archivos.php',
		'docu_ei_calendario' => 'extension_toba/componentes/docu_ei_calendario.php',
		'docu_ei_codigo' => 'extension_toba/componentes/docu_ei_codigo.php',
		'docu_ei_cuadro' => 'extension_toba/componentes/docu_ei_cuadro.php',
		'docu_ei_esquema' => 'extension_toba/componentes/docu_ei_esquema.php',
		'docu_ei_filtro' => 'extension_toba/componentes/docu_ei_filtro.php',
		'docu_ei_firma' => 'extension_toba/componentes/docu_ei_firma.php',
		'docu_ei_formulario' => 'extension_toba/componentes/docu_ei_formulario.php',
		'docu_ei_formulario_ml' => 'extension_toba/componentes/docu_ei_formulario_ml.php',
		'docu_ei_grafico' => 'extension_toba/componentes/docu_ei_grafico.php',
		'docu_ei_mapa' => 'extension_toba/componentes/docu_ei_mapa.php',
		'docu_servicio_web' => 'extension_toba/componentes/docu_servicio_web.php',
		'docu_comando' => 'extension_toba/docu_comando.php',
		'docu_modelo' => 'extension_toba/docu_modelo.php',
	);
}
?>