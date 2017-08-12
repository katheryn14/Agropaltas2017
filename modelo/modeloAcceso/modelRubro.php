<?php 
	session_start();  
	include_once( "../../config/conexion.php");

	class Rubro_model{
		private $param = array();
	    private $con;

	    public function __construct(){
	    	
	    }	


	    public function gestionar($param){
	    	$this->param = $param;
	    	switch ($this->param['param_opcion'])
			{
				case 'getDataRubros':
					echo $this->getDataRubros();
					break;
			}
	    }	
	    private function getDataRubros(){
	    	global $database;
		    $sql = "EXEC SP_Rubro_Mnt @peticion=0";
		    $database->setQuery($sql);
		    $rows = $database->loadObjectList();
		   	/*$cadena = '['; $cont = 0;
		    foreach ($rows as $key => $v) {
		    	if ($cont>0) {
		    		$cadena .= ',';
		    	}
            	$cadena .=
            	'{"ID": "'.$v->idRubro.'","Rubro": "'.utf8_encode($v->Rubro).'","Abreviatura": "'.utf8_encode($v->Abreviatura).'","Etiqueta": "'.utf8_encode($v->Etiqueta).'"}';
            	$cont=1;
		    }
		    $cadena .= ']';
		    return $cadena;*/
		    return json_encode($rows);
	    }
	}
 ?>