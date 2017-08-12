<?php 
	include_once '../../modelo/modeloAcceso/modelUsuario.php';

	$param = array();
	$param['param_opcion'] = '';
	$param['param_idUsuario'] = '';
	$param['param_idRol'] = '';
	$param['param_idEmpresa'] = '';
	$param['param_dni'] = '';
	$param['param_nombre'] = '';
	$param['param_apePaterno'] = '';
	$param['param_apeMaterno'] = '';
	$param['param_usuario'] = '';
	$param['param_pass'] = '';
	$param['param_Activo'] = '';


	if(isset($_POST['param_opcion']))
	{
		$param['param_opcion'] = $_POST['param_opcion'];
	}
	if(isset($_POST['param_idUsuario']))
	{
		$param['param_idUsuario'] = $_POST['param_idUsuario'];
	}
	if(isset($_POST['param_idEmpresa']))
	{
		$param['param_idEmpresa'] = $_POST['param_idEmpresa'];
	}
	if(isset($_POST['param_idRol']))
	{
		$param['param_idRol'] = $_POST['param_idRol'];
	}
	if(isset($_POST['param_dni']))
	{
		$param['param_dni'] = $_POST['param_dni'];
	}
	if(isset($_POST['param_nombre']))
	{
		$param['param_nombre'] = $_POST['param_nombre'];
	}
	if(isset($_POST['param_apePaterno']))
	{
		$param['param_apePaterno'] = $_POST['param_apePaterno'];
	}
	if(isset($_POST['param_apeMaterno']))
	{
		$param['param_apeMaterno'] = $_POST['param_apeMaterno'];
	}
	if(isset($_POST['param_usuario']))
	{
		$param['param_usuario'] = $_POST['param_usuario'];
	}
	if(isset($_POST['param_pass']))
	{
		$param['param_pass'] = $_POST['param_pass'];
	}
	if(isset($_POST['param_Activo']))
	{
		$param['param_Activo'] = $_POST['param_Activo'];
	}		

	$Usuario = new Usuario_model();
	echo $Usuario->gestionar($param);
	//echo 1;
?>