<?php
	session_start();
	unset($_SESSION['U_idUsuario']);
	unset($_SESSION['U_idPersona']);
	unset($_SESSION['U_nombre']);
	unset($_SESSION['U_apePaterno']);
	unset($_SESSION['U_apeMaterno']);
	unset($_SESSION['U_DNI']);
	unset($_SESSION['U_usuario']);
	unset($_SESSION['U_idRol']);
	unset($_SESSION['U_Empresa']);
	unset($_SESSION['U_idEmpresa']);

	session_destroy();
	header("Location:../../index.php");
?>
