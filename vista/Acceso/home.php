<?php 
  session_start();  
  if(!isset($_SESSION['U_nombre']))
  {
    header("Location:../../index.php");
  }
  else
  {
    date_default_timezone_set('America/Lima');
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> <?php echo $_SESSION['U_Empresa']; ?> | Home</title>

    <!-- Bootstrap -->
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../assets/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../assets/css/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../../assets/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <!-- top menu -->
            <?php 
              require('../menus/topMenu.php');
            ?>
            <!-- /top menu -->

            <br />

            <!-- sidebar menu -->
            <?php 
              require('../menus/sideMenu.php');
            ?>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <?php 
              require('../menus/footerMenu.php');
            ?>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <?php 
          require('../menus/topNavigation.php');
        ?>  
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->  
            
          <div class="clearfix"></div>
          <!-- /top tiles -->

          <div class="row">
              <!-- form input mask -->
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Datos Personales</h2>                    
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left" name="frmPersona" id="frmPersona">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Nombre</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="text" class="form-control" placeholder="Ingrese nombres" value="<?php echo $_SESSION['U_nombre']; ?>" name="txtName" id="txtName" required>
                          <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Apellido Paterno</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="text" class="form-control" placeholder="Ingrese apellido paterno" value="<?php echo $_SESSION['U_apePaterno'];?>" name="txtApeP" id="txtApeP" required >
                          <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Apellido Materno</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="text" class="form-control" placeholder="Ingrese apellido materno" value="<?php echo $_SESSION['U_apeMaterno']; ?>" name="txtApeM" id="txtApeM" required >
                          <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">D.N.I.</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="text" class="form-control" placeholder="Ingrese su DNI" value="<?php echo $_SESSION['U_DNI']; ?>" name="txtDNI" id="txtDNI">
                          <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <button type="submit" class="btn btn-primary">Actualizar Registro</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
              <!-- /form input mask -->

              <!-- form color picker -->
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Datos de Usuario</h2>                    
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left" name="frmUsuario" id="frmUsuario">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre Usuario</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="demo1 form-control" value="<?php echo $_SESSION['U_usuario'];?>" required name="txtUsuario" id="txtUsuario"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Password Nueva</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <div class="input-group demo2">
                            <input type="password"  class="form-control" name="txtPass" id="txtPass" maxlength="50" required/>
                            <span class="input-group-addon"><i></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <button type="submit" class="btn btn-success">Actualizar Usuario</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- /form color picker -->
          </div>
          <br />        
        </div>
        <!-- /page content -->
      </div> 
      
      <!-- footer content -->
      <?php 
        require('../menus/footerContent.php');
      ?>
      <!-- /footer content -->
      </div>
    </div>
    <script>
      window.onload = function () {
        document.frmPersona.addEventListener('submit', actualizaPersona);
        document.frmUsuario.addEventListener('submit', actualizaUsuario);
      }
      function actualizaPersona(evObject){
        evObject.preventDefault(); var correcto = 0;
        var param_opcion = 'updatePersona';
        var param_nombre = document.getElementById('txtName').value;
        var param_apeP = document.getElementById('txtApeP').value;
        var param_apeM = document.getElementById('txtApeM').value;
        var param_dni = document.getElementById('txtDNI').value;
        var param_IP = '<?php echo $_SESSION['U_idPersona']; ?>';
        $.ajax({
          type: 'POST',
          data: 'param_opcion='+param_opcion+ 
            '&param_nombre='+param_nombre+
            '&param_apePaterno='+param_apeP+
            '&param_apeMaterno='+param_apeM+
            '&param_dni='+param_dni+
            '&param_IP='+param_IP,
          url: '../../controlador/controlAcceso/controlUsuario.php',
          success: function(data){
            if (data == 1) {
              alert('Se ha actualizado. LOS CAMBIOS SE VERAN EN SU SIGUIENTE INICION DE SESIÓN');
            } else {
              alert(data);
            }
          },
          error: function(data){
            alert('Exite un problema con la dirección de nuestro controlador');
          }
        });
        if (correcto==1) {document.frmPersona.submit();}
      }
      function actualizaUsuario(evObject){
        evObject.preventDefault(); var correcto = 0;
        
        var param_opcion = 'updateUsuario';
        var param_usuario = document.getElementById('txtUsuario').value;
        var param_pass = document.getElementById('txtPass').value;
        $.ajax({
          type: 'POST',
          data: 'param_opcion='+param_opcion+
            '&param_idUsuario='+'<?php echo $_SESSION["U_idUsuario"];?>'+ 
            '&param_usuario='+param_usuario+
            '&param_pass='+param_pass,
          url: '../../controlador/controlAcceso/controlUsuario.php',
          success: function(data){
            if (data == 1) {
              location.reload();
              alert('Usuario y password actualizados');
            } else {
              alert(data);
            }
          },
          error: function(data){
            alert('Exite un problema con la dirección de nuestro controlador');
          }
        });
        if (correcto==1) {document.frmUsuario.submit();}
      }
    </script>
    <!-- jQuery -->
    <script src="../../assets/js/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../../assets/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../../assets/js/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../../assets/js/nprogress.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="../../assets/js/custom.min.js"></script>    

</html>
<?php } ?>
