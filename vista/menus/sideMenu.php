<?php
  include_once( "../../config/conexion.php");
?>
<?php
  $nombreG = array();
  $idG = array();
  global $database;
  $sql = "EXEC SP_MostrarMenu_Mnt @peticion=0,
                                  @idEmpresa=".$_SESSION['U_idEmpresa'].",
                                  @idUsuario=".$_SESSION['U_idUsuario'];
  $database->setQuery($sql);
  $rows = $database->loadObjectList(); //

  foreach ($rows as $key => $v) {
    if($v->nombre !='Home'){
      $nombre=utf8_encode($v->nombre);
      $id = $v->idGrupo;
      array_push($nombreG,$nombre);
      array_push($idG,$id);
    }
  }
  $iconos = array();
  array_push($iconos,'fa fa-database','fa fa-laptop','fa fa-fire','fa fa-windows');
?>

<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>General</h3>
    <ul class="nav side-menu">
      <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="../Acceso/home.php">Datos Personales</a></li>
        </ul>
      </li>
    </ul>
  </div>
  <div class="menu_section">
    <h3>Manejo de datos</h3>
    <ul class="nav side-menu">
    <?php 
      for ($i=0; $i <count($idG) ; $i++) { 
        echo '
          <li><a><i class="'.$iconos[$i].'"></i>'.utf8_encode($nombreG[$i]).'<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">';
            $sql = "EXEC SP_MostrarMenu_Mnt 
                        @peticion=1,
                        @idUsuario=".$_SESSION['U_idUsuario'].",
                        @idGrupo=".$idG[$i];
            $database->setQuery($sql);
            $rows = $database->loadObjectList(); //
            foreach ($rows as $key => $v) {
              echo '<li><a href="'.utf8_encode($v->url).'">'.utf8_encode($v->nombre).'</a></li>';
            }
        echo 
            '</ul>
          </li>
        ';
      }
    ?>
  </div>
</div>