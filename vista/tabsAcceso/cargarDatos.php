<?php
include_once("../../config/conexion.php");



	global $database;
	 $sql = "select * from Rubro";
	 $database->setQuery($sql);
	 $rows = $database->loadObjectList(); //
	 //$tabla = "";
	 $cont = 0;
	 $lista=array();
	 //falta validar que cuando no devuelve nada 
	     foreach ($rows as $key => $v) {
		    	$v->idRubro = utf8_encode($v->idRubro);
		        $v->Descripcion = utf8_encode($v->Descripcion);
		        $v->Abreviatura = utf8_encode($v->Abreviatura);
		        $v->Etiqueta = utf8_encode($v->Etiqueta);
		        $cont = $cont + 1;
		        $item=array("ID"=>$v->idRubro,"Descripcion"=>$v->Descripcion,"Abreviatura"=>$v->Abreviatura,"Etiqueta"=>$v->Etiqueta );
		        array_push($lista, $item);
		       
		    }

		 echo json_encode($lista);


?>