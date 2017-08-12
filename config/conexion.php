<?php
  
  /*if (!file_exists( "../config/config.php" )){
    //header( "Location: ../../logout.php" );
    echo 'Sin Conexion';
    exit();
  }

  require_once( "../config/config.php" );
  require_once( "../config/database.php" );
  require_once( "../config/functions.php" );
  require_once( "../config/common.php" );*/

  require_once( "config.php" );
  require_once( "database.php" );
  require_once( "functions.php" );
  require_once( "common.php" );
  //session_name( "dx/dy" );
  //session_start();

  $database = new database( $_DB_host, $_DB_user, $_DB_pass, $_DB_name, $_DB_table_prefix );
  
?>