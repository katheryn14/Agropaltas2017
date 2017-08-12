<?php 
	session_start();  
	include_once( "../../config/conexion.php");

	class Usuario_model{
		private $param = array();
	    private $con;

	    public function __construct(){
	    	
	    }	


	    public function gestionar($param){
	    	$this->param = $param;
	    	switch ($this->param['param_opcion'])
			{
				case 'llenarCboEmpresa':
					echo $this->llenarCboEmpresa();
					break;
				case 'iniciarSesion':
					echo $this->iniciarSesion();
					break;	
				case 'mostrarMenu':
					echo $this->mostrarMenu();
					break;	
				case 'mostrarUsuarios':
					echo $this->mostrarUsuarios();
					break;	
				case 'insert':
					echo $this->insert();
					break;	
				case 'obtener':
					echo $this->obtener();
					break;
				case 'update':
					echo $this->update();
					break;		
				case 'eliminar':
					echo $this->eliminar();
					break;	
				case 'habilitar':
					echo $this->habilitar();
					break;
				case 'resetearUsuario':
					echo $this->resetearUsuario();
					break;	
				case 'updatePersona':
					echo $this->updatePersona();
					break;
				case 'updateUsuario':
					echo $this->updateUsuario();
					break;
			}
	    }	
	    private function llenarCboEmpresa(){
	    	global $database;
		    $sql = "select idEmpresa as 'idEmpresa',
		                                Descripcion as 'empresa' from empresa";
		    $database->setQuery($sql);
		    $rows = $database->loadObjectList(); //
		    $combo = "<option value='0' disabled selected>-- SELECCIONE EMPRESA --</option>";
		    foreach ($rows as $key => $v) {
            	$combo .= "<option value='".$v->idEmpresa."'>".$v->empresa."</option>";
		    }
		    return $combo;
	    }

	    private function iniciarSesion(){
	    	global $database;
		    //$idValoracion = _GetParam($_REQUEST, "idValoracion", '0');
		    $sql = "EXEC SP_controlUsuario_Mnt @peticion=0,
		    					@usuario='".$this->param['param_usuario']."',
		    					@pass='".md5($this->param['param_pass'])."',
		    					@idEmpresa='".$this->param['param_idEmpresa']."'" ;
		    $database->setQuery($sql);
		    $rows = $database->loadObjectList(); //
		    $respuesta = "";
		    foreach ($rows as $key => $v) {
		        $respuesta = $v->respuesta;
		    }
		    if($respuesta=='1'){
		    	$sql = "EXEC SP_controlUsuario_Mnt @peticion=1, 
		    					@usuario='".$this->param['param_usuario']."',
		    					@pass='".md5($this->param['param_pass'])."',
		    					@idEmpresa='".$this->param['param_idEmpresa']."'" ;
			    $database->setQuery($sql);
			    $rows = $database->loadObjectList();
			    foreach ($rows as $key => $v) {
		        	$_SESSION['U_idUsuario'] = $v->idUsuario;		
					$_SESSION['U_idPersona'] = $v->idPersona;
					$_SESSION['U_nombre'] = utf8_encode($v->nombre);
					$_SESSION['U_apePaterno'] = utf8_encode($v->apePaterno);
					$_SESSION['U_apeMaterno'] = utf8_encode($v->apeMaterno);
					$_SESSION['U_DNI'] = utf8_encode($v->DNI);
					$_SESSION['U_rol'] = $v->idRol;
					$_SESSION['U_usuario'] = utf8_encode($v->usuario);
					$_SESSION['U_Empresa'] = utf8_encode($v->empresa);
					$_SESSION['U_idEmpresa'] = $v->codEmpresa;
		   		}
		    }
		    return $respuesta;
	    }
	    private function mostrarUsuarios(){
	    	global $database;
		    //$idValoracion = _GetParam($_REQUEST, "idValoracion", '0');
		    $sql = "EXEC SP_Usuario_Mnt2 @peticion=2";
		    $database->setQuery($sql);
		    $rows = $database->loadObjectList(); //
		    $tabla = "";
		    $cont = 0;
		    foreach ($rows as $key => $v) {
		        $cont = $cont + 1;
		        $tabla .= "<tr>";
                    $tabla .= "<td style=' width: 3%;'>".$cont."</td>";
                    $tabla .= "<td id = 'dni' style=' width: 10%;'>".$v->DNI."</td>";
                    $tabla .= "<td id = 'nombre' style=' width: 15%;'>".utf8_decode($v->Nombre)."</td>";
                    $tabla .= "<td id = 'nombre' style=' width: 15%;'>".utf8_decode($v->ApePaterno)."</td>";
                    $tabla .= "<td id = 'nombre' style=' width: 15%;'>".utf8_decode($v->ApeMaterno)."</td>";
                    $tabla .= "<td id = 'rol' style=' width: 12%;'>".utf8_decode($v->rol)."</td>";
                    $tabla .= "<td id = 'login' style=' width: 12%;'>".utf8_decode($v->login)."</td>";
                    $tabla .= "<td id = 'login' style=' width: 12%;'>".$v->activo."</td>";
                    //$tabla .= "<td id = 'sexo' style=' width: 3%;'>".$fila["sexo"]."</td>";
                    $tabla .= "<th id='editar' style=' width: 20%;'>
                    			<a href='#modalUpdate' data-toggle='modal' class='btn btn-success btn-xs' onclick='obtener(".$v->idUsuario.")'><i class='fa fa-pencil'></i>  </a>

                    			<a href='#modalEliminar' data-toggle='modal' class='btn btn-danger btn-xs' onclick='obtenerId(".$v->idUsuario.")'><i class='fa fa-trash-o'></i></a>
                    			<a href='#modalHabilitar' data-toggle='modal' class='btn btn-primary btn-xs' onclick='obtenerId(".$v->idUsuario.")'><i class='fa fa-check'></i></a>
                    			<a href='#modalResetar' data-toggle='modal' class='btn btn-info btn-xs' onclick='obtenerId(".$v->idUsuario.")'><i class='fa fa-refresh'></i></a>
                    			</th>";
                $tabla .= "</tr>";
		    }
		    return $tabla;
	    }
	    private function insert(){
	    	global $database;
		    //$idValoracion = _GetParam($_REQUEST, "idValoracion", '0');
		    $sql = "EXEC SP_Usuario_Mnt2 @peticion=3,
		    	@usuario='".$this->param['param_usuario']."',
		    	@idRol=".$this->param['param_idRol'].",
		    	@pass='".$this->param['param_pass']."',
		    	@Nombre='".$this->param['param_nombre']."',
		    	@apePaterno='".$this->param['param_apePaterno']."',
		    	@apeMaterno='".$this->param['param_apeMaterno']."',
		    	@dni='".$this->param['param_dni']."'" ;
		    $database->setQuery($sql);
		    $rows = $database->loadObjectList(); //
		    $respuesta = "";
		    foreach ($rows as $key => $v) {
		        $respuesta = $v->respuesta;
		    }
		    return $respuesta;
	    }
	    private function obtener(){
	    	global $database;
	    	$sql="EXEC SP_Usuario_Mnt2 @peticion=6,@idUsuario=".$this->param['param_idUsuario'];
	    	$respuesta='';
	    	$database->setQuery($sql);
		    $rows = $database->loadObjectList();
	    	return json_encode($rows);
	    }
	    private function update(){
	    	global $database;
		    //$idValoracion = _GetParam($_REQUEST, "idValoracion", '0');
		    $sql = "EXEC SP_Usuario_Mnt2 @peticion=4,
		    	@idUsuario=".$this->param['param_idUsuario'].",
		    	@usuario='".$this->param['param_usuario']."',
		    	@idRol=".$this->param['param_idRol'].",
		    	@pass='".$this->param['param_pass']."',
		    	@Nombre='".$this->param['param_nombre']."',
		    	@apePaterno='".$this->param['param_apePaterno']."',
		    	@apeMaterno='".$this->param['param_apeMaterno']."',
		    	@dni='".$this->param['param_dni']."'" ;
		    $database->setQuery($sql);
		    $rows = $database->loadObjectList(); //
		    $respuesta = "";
		    foreach ($rows as $key => $v) {
		        $respuesta = $v->respuesta;
		    }
		    return $respuesta;
	    }
	    private function eliminar(){
	    	global $database;
		    //$idValoracion = _GetParam($_REQUEST, "idValoracion", '0');
		    $sql = "EXEC SP_Usuario_Mnt2 @peticion=5, @idUsuario=".$this->param['param_idUsuario'];
		    $database->setQuery($sql);
		    $rows = $database->loadObjectList(); //
		    $respuesta = "";
		    foreach ($rows as $key => $v) {
		        $respuesta = $v->respuesta;
		    }
		    return $respuesta;
	    }
	    private function habilitar(){
	    	global $database;
		    //$idValoracion = _GetParam($_REQUEST, "idValoracion", '0');
		    $sql = "EXEC SP_Usuario_Mnt2 @peticion=7, @idUsuario=".$this->param['param_idUsuario'];
		    $database->setQuery($sql);
		    $rows = $database->loadObjectList(); //
		    $respuesta = "";
		    foreach ($rows as $key => $v) {
		        $respuesta = $v->respuesta;
		    }
		    return $respuesta;
	    }
	    private function resetearUsuario(){
	    	global $database;
		    //$idValoracion = _GetParam($_REQUEST, "idValoracion", '0');
		    $sql = "EXEC SP_Usuario_Mnt2 @peticion=10, @idUsuario=".$this->param['param_idUsuario'];
		    $database->setQuery($sql);
		    $rows = $database->loadObjectList(); //
		    $respuesta = "";
		    foreach ($rows as $key => $v) {
		        $respuesta = $v->respuesta;
		    }
		    return $respuesta;
	    }

	    private function updatePersona(){
	    	global $database;
		    //$idValoracion = _GetParam($_REQUEST, "idValoracion", '0');
		    $sql = "EXEC SP_Usuario_Mnt2 @peticion=8,
		    	@idPersona=".$this->param['param_IP'].",
		    	@Nombre='".$this->param['param_nombre']."',
		    	@apePaterno='".$this->param['param_apePaterno']."',
		    	@apeMaterno='".$this->param['param_apeMaterno']."',
		    	@dni='".$this->param['param_dni']."'" ;
		    $database->setQuery($sql);
		    $rows = $database->loadObjectList(); //
		    $respuesta = "";
		    foreach ($rows as $key => $v) {
		        $respuesta = $v->respuesta;
		    }
		    return $respuesta;
	    }
	    private function updateUsuario(){
	    	global $database;
		    $sql = "
		    	EXEC SP_Usuario_Mnt2 @peticion=9,
				@idUsuario=".$this->param['param_idUsuario'].",
				@usuario='".$this->param['param_usuario']."',
				@pass='".$this->param['param_pass']."' ";
		    $database->setQuery($sql);
		    $rows = $database->loadObjectList(); //
		    $respuesta = "";
		    foreach ($rows as $key => $v) {
		        $respuesta = $v->respuesta;
		    }
		    return $respuesta;
	    }
	}
 ?>