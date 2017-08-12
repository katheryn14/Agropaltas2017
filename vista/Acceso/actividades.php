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

    <title><?php echo $_SESSION['U_Empresa'];?> | Roles </title>

    <link href="../css/alerta.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../assets/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../assets/css/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../../assets/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../recursos/jsgrid153/css/jsgrid.css" />

    <!-- Datatables -->
    <link href="../../assets/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/scroller.bootstrap.min.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

    <link rel="stylesheet" type="text/css" href="../../recursos/jsgrid153/css/jsgrid.css" />
    <link rel="stylesheet" type="text/css" href="../../recursos/jsgrid153/css/theme.css" />

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

            <!-- /sidebar menu -->
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
            <div class="clearfix"></div>
            <!-- /top tiles -->
            <ul class="nav nav-tabs">
              <li class="active"><a href="#rubro" data-toggle="tab">Rubro</a></li>
              <li ><a href="#actividad" data-toggle="tab">Actividad</a></li>
              <li><a href="#labor" data-toggle="tab">Labor</a></li>
            </ul>

            <div class="tab-content">
              <div id="rubro" class="tab-pane fade in active">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>LISTADO DE RUBROS</h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div >
                    <div id="jsGridRubros"></div>
                    
                  </div>
                </div>
              </div>
              <div id="actividad" class="tab-pane fade">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>ACTIVIDADES</h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div>
                    <div id="jsGridActividades"></div>
                  </div>
                  <?php 
                    //require('../Mantenedores/actividades.php');
                  ?>
                </div>
              </div>
              <div id="labor" class="tab-pane fade">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>LABORES</h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <?php 
                    //require('../Mantenedores/labores.php');
                  ?>
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
            <h4 class="modal-title">Registrar Rol</h4>
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
                <!--
                <div class="form-group">
                  <label class = "control-label col-md-3 col-sm-3 col-xs-12">Activo:</label>
                  <div class = "checkbox col-md-3 col-sm-3 col-xs-12">
                    <label>
                      <input type="checkbox"  id="chkActivo" checked disabled required  > 
                    </label>
                  </div>                        
                </div> -->

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


    <!-- jQuery -->
    <script src="../../assets/js/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../../assets/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../../assets/js/fastclick.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="../../assets/js/custom.min.js"></script>
    <!-- Autosize -->
    <script src="../../assets/js/autosize.min.js"></script>


    <!-- Datatables -->
    <script src="../../assets/js/buttons.bootstrap.min.js"></script>
    <script src="../../assets/js/buttons.flash.min.js"></script>
    <script src="../../assets/js/buttons.html5.min.js"></script>
    <script src="../../assets/js/buttons.print.min.js"></script>
    <script src="../../assets/js/responsive.bootstrap.js"></script>
    <script src="../../assets/js/jszip.min.js"></script>
    <script src="../../assets/js/pdfmake.min.js"></script>
    <script src="../../assets/js/vfs_fonts.js"></script>

    <script src="../../recursos/jsgrid153/src/jsgrid.core.js"></script>
    <script src="../../recursos/jsgrid153/src/jsgrid.load-indicator.js"></script>
    <script src="../../recursos/jsgrid153/src/jsgrid.load-strategies.js"></script>
    <script src="../../recursos/jsgrid153/src/jsgrid.sort-strategies.js"></script>
    <script src="../../recursos/jsgrid153/src/jsgrid.field.js"></script>
    <script src="../../recursos/jsgrid153/src/fields/jsgrid.field.text.js"></script>
    <script src="../../recursos/jsgrid153/src/fields/jsgrid.field.control.js"></script>
    <script src="../tabsAcceso/grillaRubros.js"></script>
    <script src="../tabsAcceso/grillaActividad.js"></script>
    
    <script>
      $(document).ready(function() {
        autosize($('.resizable_textarea'));
      });
    </script>
    
  </body>
</html>
<?php } ?>
