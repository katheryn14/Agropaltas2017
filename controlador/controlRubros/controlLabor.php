<?php
if ($_SERVER["REQUEST_METHOD"]=="GET") {
	include_once("../../config/conexion.php");
	global $database;
	$sql = "EXEC SP_Labor_Mnt @peticion=0";
	$database->setQuery($sql);
	$rows = $database->loadObjectList(); //
	//$tabla = "";
	$cont = 0;
	$lista=array();
	//falta validar que cuando no devuelve nada 
	foreach ($rows as $key => $v) {
		$v->idLabor = utf8_encode($v->idLabor);
		$v->idActividad = utf8_encode($v->idActividad);
		$v->idRubro = utf8_encode($v->idRubro);
		$v->actividad = utf8_encode($v->actividad);
		$v->labor = utf8_encode($v->labor);
		$v->rubro = utf8_encode($v->rubro);
		$v->medida = utf8_encode($v->medida);
		$v->codigoERP = utf8_encode($v->codigoERP);
		$item=array("IdLabor"=>$v->idLabor,"IdActividad"=>$v->idActividad,"IdRubro"=>$v->idRubro,"Actividad"=>$v->actividad,"Labor"=>$v->labor,"Rubro"=>$v->rubro,"Medida"=>$v->medida,"CodigoERP"=>$v->codigoERP );
		array_push($lista, $item);
	}
	echo json_encode($lista);
}else{
	include_once '../../modelo/modeloAcceso/modelLabor.php';

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