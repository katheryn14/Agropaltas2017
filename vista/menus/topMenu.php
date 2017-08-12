<div class="navbar nav_title" style="border: 0;">
	<a href="../Acceso/home.php" class="site_title">
		<i class="fa fa-leaf"></i> <span><?php echo $_SESSION['U_Empresa'];?></span>
	</a>
</div>

<div class="clearfix"></div>

            
<div class="profile clearfix">      
  <div class="profile_info">
    <span>Bienvenido, </span>
    <h2><?php echo $_SESSION['U_nombre'].' '.$_SESSION['U_apePaterno']; ?></h2>
  </div>
</div>