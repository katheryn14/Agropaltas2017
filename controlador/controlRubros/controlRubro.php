<?php
if ($_SERVER["REQUEST_METHOD"]=="GET") {
	include_once("../../config/conexion.php");
	global $database;
	$sql = "EXEC SP_Rubro_Mnt @peticion=0";
	$database->setQuery($sql);
	$rows = $database->loadObjectList(); //
	//$tabla = "";
	$cont = 0;
	$lista=array();
	//falta validar que cuando no devuelve nada 
	foreach ($rows as $key => $v) {
		$v->idRubro = utf8_encode($v->idRubro);
		$v->Rubro = utf8_encode($v->Rubro);
		$v->Abreviatura = utf8_encode($v->Abreviatura);
		$v->Etiqueta = utf8_encode($v->Etiqueta);
		$item=array("ID"=>$v->idRubro,"Rubro"=>$v->Rubro,"Abreviatura"=>$v->Abreviatura,"Etiqueta"=>$v->Etiqueta );
		array_push($lista, $item);
	}
	echo json_encode($lista);
}else{
	include_once '../../modelo/modeloAcceso/modelRubro.php';

	$param = array();
	$param['param_opcion'] = '';
	$param['param_idUsuario'] = '';
	$param['param_idRubro'] = '';
	$param['param_rubro'] = '';
	$param['param_abreviatura'] = '';
	$param['param_etiqueta'] = '';
	$param['param_Activo'] = '';
	
	if(isset($_POST['param_opcion']))
	{
		$param['param_opcion'] = $_POST['param_opcion'];
	}
	if(isset($_POST['param_idUsuario']))
	{
		$param['param_idUsuario'] = $_POST['param_idUsuario'];
	}
	if(isset($_POST['param_idRubro']))
	{
		$param['param_idRubro'] = $_POST['param_idRubro'];
	}
	if(isset($_POST['param_rubro']))
	{
		$param['param_rubro'] = $_POST['param_rubro'];
	}
	if(isset($_POST['param_abreviatura']))
	{
		$param['param_abreviatura'] = $_POST['param_abreviatura'];
	}
	if(isset($_POST['param_etiqueta']))
	{
		$param['param_etiqueta'] = $_POST['param_etiqueta'];
	}
	if(isset($_POST['param_Activo']))
	{
		$param['param_Activo'] = $_POST['param_Activo'];
	}		

	$Rubro = new Rubro_model();
	echo $Rubro->gestionar($param);
}
	

?>