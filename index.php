<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LOGGER euler</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom Theme Style -->
    <link href="assets/css/custom.min.css" rel="stylesheet">
</head>

<body>
  <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form onsubmit="return iniciarSesion()" >
            	<div align="center"><img src="logo_region.png" width="50%"></div>
              <h1>BIENVENIDO</h1>
              <div>
                <select id="cboEmpresa" class="form-control" required>
                  <option value='0' disabled selected>-- SELECCIONE EMPRESA --</option>
                </select><br>
                <input required  type="text" name="Usser" id = "txtUsuario" class="form-control" placeholder="Usuario">
                <input type="password" name="txtPass" id = "txtPass" class="form-control" placeholder="Password" required >
              </div>
              <div align="center">
                <input class="btn btn-default submit"  type="submit" name="btnAcceder" id="btnAcceder" value="Acceder">
              </div>
              <div class="clearfix"></div>
              <div class="separator">
                <div class="clearfix"></div>
                <br />
                <div>
                  <h1> AGROPALTAS </h1>
                  <p>©2017 Derechos reservados a PREMIUN.NET</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
</body>
<script src="assets/js/jquery.min.js"></script>
<script src="recursos/Accesos/index.js"></script>
<script>
  function iniciarSesion(){
    var param_opcion = 'iniciarSesion';
    var param_empresa = document.getElementById('cboEmpresa').value;
    var param_usuario = document.getElementById('txtUsuario').value;
    var param_pass = document.getElementById('txtPass').value;

    $.ajax({
      type: 'POST',
      data: 'param_opcion='+param_opcion+
            '&param_idEmpresa='+param_empresa+
            '&param_usuario='+param_usuario+
            '&param_pass='+param_pass, 
      url: 'controlador/controlAcceso/controlUsuario.php',
      success: function(data){    
        if(data == '1'){
          //alert('se logeara');
          location.href = "vista/Acceso/home.php";
        }
        else{
          alert(data);
        }
      },
      error:function(data){
        alert('Error al mostrar');
      }
    });
    return false;
  }
  
</script>
</html>