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

    <title>Turismo | Grupos </title>

    <link href="../css/alerta.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../assets/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../assets/css/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../../assets/css/custom.min.css" rel="stylesheet">

    <!-- Datatables -->
    <link href="../../assets/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/scroller.bootstrap.min.css" rel="stylesheet">

    <link href="../css/modal.css" rel="stylesheet">
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
            <?php 
              require('../menus/footerMenu.php');
            ?>

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
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Registro de Grupos </h2>
                         
                  <div class="clearfix"></div>
                </div>

                <div class="x_content">
                  <button data-toggle="modal" href="#myModal" class="btn btn-primary">Agregar</button>
                  <br/>
                  <br/>                       
                  <table id="tabla" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Activo</th>
                        <th>Opciones</th>
                      </tr>
                    </thead>
                    <tbody id="cuerpo">
                       
                    </tbody>
                  </table>
                </div>
              </div>
            </div> 
          </div>   
        </div>      
      </div>
        <!-- /page content -->

      <!-- footer content -->
      <?php 
        require('../menus/footerContent.php');
      ?>
      <!-- /footer content -->
    </div>
  </div>



  <!-- modal  insert-->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Registrar Grupo</h4>
        </div>
        <div class="modal-body">
          <div class="row">            
            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
              <div class="form-group">
                <label for="txtNombre" class = "control-label col-md-3 col-sm-3 col-xs-12">Nombre:</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="txtNombre" class="form-control col-md-7 col-xs-12" name="txtNombre" required />
                </div>                        
              </div>
              <div class="form-group">
                <label for="txtDescripcion" class = "control-label col-md-3 col-sm-3 col-xs-12">Descripción:</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea id="txtDescripcion" required="required" class="form-control col-md-7 col-xs-12" name="txtDescripcion" ></textarea>
                </div>                        
              </div>

              <div class="form-group">
                <label class = "control-label col-md-3 col-sm-3 col-xs-12">Activo:</label>
                <div class = "checkbox col-md-3 col-sm-3 col-xs-12">
                  <label>
                    <input type="checkbox"  id="chkActivo" checked disabled required  > 
                  </label>
                </div>                        
              </div>   

              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
                  <button type="button" class="btn btn-danger" id="btnCancelar" data-dismiss="modal">Cancelar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>    
  </div>
  <!-- /modal insert-->


  <!-- modal update-->
  <div class="modal fade" id="modalUpdate">
    <div class="modal-dialog alerta">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Editar Grupo</h4>
        </div>
        <div class="modal-body">
          <div class="row">            
            <form id="demo-form" data-parsley-validate class="form-horizontal form-label-left">
              <div class="form-group">
                <label for="txtNombreE" class = "control-label col-md-3 col-sm-3 col-xs-12">Nombre * :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="txtNombreE" class="form-control col-md-7 col-xs-12" name="txtNombreE" required />
                </div>                        
              </div>
              <div class="form-group">
                <label for="txtDescripcionE" class = "control-label col-md-3 col-sm-3 col-xs-12">Descripción * :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea id="txtDescripcionE" required class="form-control col-md-7 col-xs-12" name="txtDescripcionE" ></textarea>
                </div>                        
              </div>

              <div class="form-group">
                <label class = "control-label col-md-3 col-sm-3 col-xs-12">Activo:</label>
                <div class = "checkbox col-md-3 col-sm-3 col-xs-12">
                  <label>
                    <input type="checkbox"  id="chkActivoE" checked  > 
                  </label>
                </div>                        
              </div>   

              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="button" class="btn btn-primary" id="btnEditar">Guardar</button>
                  <button type="button" class="btn btn-danger"  id="btnCancelarE" data-dismiss="modal">Cancelar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>    
  </div>
  <!-- /modal-->

  <!-- modal eliminar-->
    <div class="modal fade" id="modalEliminar">
      <div class="modal-dialog alerta">
        <div class="modal-content">
          <div class="modal-header">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <h4> ¿Desea eliminar este grupo? </h4>
              </div>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="row">   
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="button" class="btn btn-primary" id="btnEliminar" data-dismiss="modal">Sí</button>
                <button type="button" class="btn btn-danger"  id="btnCancelarE" data-dismiss="modal">No</button>
              </div>
            </div>
          </div>
        </div>
      </div>    
    </div>
    <!-- /modal-->
  


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

    
    <!-- Parsley -->
    <script src="../../assets/js/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="../../assets/js/autosize.min.js"></script>


    <!-- Datatables -->
    <script src="../../assets/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/js/dataTables.bootstrap.min.js"></script>
    <script src="../../assets/js/dataTables.buttons.min.js"></script>
    <script src="../../assets/js/buttons.bootstrap.min.js"></script>
    <script src="../../assets/js/buttons.flash.min.js"></script>
    <script src="../../assets/js/buttons.html5.min.js"></script>
    <script src="../../assets/js/buttons.print.min.js"></script>
    <script src="../../assets/js/dataTables.fixedHeader.min.js"></script>
    <script src="../../assets/js/dataTables.keyTable.min.js"></script>
    <script src="../../assets/js/dataTables.responsive.min.js"></script>
    <script src="../../assets/js/responsive.bootstrap.js"></script>
    <script src="../../assets/js/datatables.scroller.min.js"></script>
    <script src="../../assets/js/jszip.min.js"></script>
    <script src="../../assets/js/pdfmake.min.js"></script>
    <script src="../../assets/js/vfs_fonts.js"></script>
    


    <!-- Autosize -->
    <script>
      $(document).ready(function() {
        autosize($('.resizable_textarea'));
      });
    </script>
    <!-- /Autosize -->


    <script src="../js/Acceso/despachadorGrupo.js"></script>
    
  </body>
</html>
<?php } ?>
