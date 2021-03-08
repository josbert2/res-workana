<?php
    $acceso_descuentos        = getPermisos('descuentos', $rol);
    $acceso_consulta_t        = getPermisos('consulta_t', $rol);
    $acceso_panel_c           = getPermisos('panel_c', $rol);
    $acceso_consulta_re       = getPermisos('consulta_re', $rol);
    $acceso_registro_usuarios = getPermisos('registro_usuarios', $rol);
    $acceso_desvincular       = getPermisos('desvincular', $rol);
    $acceso_asistencia        = getPermisos('asistencia', $rol);
    $acceso_ocnormal          = getPermisos('ocnormal', $rol);
    $acceso_reingreso         = getPermisos('reingreso', $rol);
    $acceso_vencidos          = getPermisos('vencidos', $rol);
    $acceso_campana           = getPermisos('campana', $rol);
    $acceso_completar         = getPermisos('completar', $rol);
?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="bootstrap/bootstrap.css">
        <link rel="stylesheet" href="css/header.css">
        
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->     
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="bootstrap/bootstrap.js"></script>
	</head>

	<body>                
<nav class="navbar navbar-expand-lg" style="background-color: #0049a2;">
   <a class="navbar-brand;" href="index.php">
    <img src="../img/logob.png" width="230" height="80" style="margin-left:15%;" alt="">
  </a>
  <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mx-auto text-center">
        <li class="nav-item active">
            <a class="nav-link" class="<?php echo $currentPage == 'index' ? 'active' : '' ?>" href="index.php" style="color:white !important;">Consulta de Clientes <span class="sr-only">(current)</span></a>
        </li>
      <!--<li class="nav-item">
        <a class="nav-link" class="<?php echo $currentPage == 'precios' ? 'active' : '' ?>" href="precios.php">Precios</a>
      </li>-->
    <?php if($acceso_descuentos || $acceso_completar){ ?>
        <!--<li class="nav-item">
            <a class="nav-link" class="<?php echo $currentPage == 'descuentos' ? 'active' : '' ?>" href="descuentos.php" style="color:white !important;">Mantenedor de descuentos</a>
        </li> -->
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#d7e811 !important;">
          Campañas y Descuentos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			<?php if($acceso_campana) { ?>
				<a class="dropdown-item" class="<?php echo $currentPage == 'consulta_t' ? 'active' : '' ?>" href="registro_camp.php">Creador de Campañas</a>
          <a class="dropdown-item" class="<?php echo $currentPage == 'cobros' ? 'active' : '' ?>" href="consulta_camp.php">Consulta de Campañas</a>
			<?php } ?>
          <?php if($acceso_descuentos) { ?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" class="<?php echo $currentPage == 'consulta_re' ? 'active' : '' ?>" href="descuentos.php">Mantenedor de descuentos</a>
            <?php } ?>
            <?php if($acceso_descuentos && $acceso_completar) { ?>
                <div class="dropdown-divider"></div>
            <?php } ?>
            <?php if($acceso_completar) { ?>
          <a class="dropdown-item" class="<?php echo $currentPage == 'completar' ? 'active' : '' ?>" href="completar.php">Completar Registros</a>
            <?php } ?>
            </div>
        </li>    
    <?php } ?>
    <?php if($acceso_consulta_t){ ?>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#d7e811 !important;">
          Menu Cobros
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			<?php if($acceso_consulta_t) { ?>
          		<a class="dropdown-item" class="<?php echo $currentPage == 'consulta_t' ? 'active' : '' ?>" href="consulta_t.php">Consulta Cobros</a>
			<?php } ?>
        <?php if($acceso_panel_c){ ?>
          <a class="dropdown-item" class="<?php echo $currentPage == 'cobros' ? 'active' : '' ?>" href="panel_c.php">Panel de Cobros</a>
          <a class="dropdown-item" class="<?php echo $currentPage == 'cobros' ? 'active' : '' ?>" href="consulta_vencidos.php">Consulta Vencidos</a>
        <?php } ?>
        <?php if($acceso_consulta_re){ ?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" class="<?php echo $currentPage == 'consulta_re' ? 'active' : '' ?>" href="consulta_re.php">Reversas</a>
        <?php } ?>
        <?php if($acceso_reingreso){ ?>
        <div class="dropdown-divider"></div>
          <a class="dropdown-item" class="<?php echo $currentPage == 'consulta_rein' ? 'active' : '' ?>" href="consulta_rein.php">Consulta Reingreso</a> 
          <a class="dropdown-item" class="<?php echo $currentPage == 'reingreso' ? 'active' : '' ?>" href="reingreso.php">Panel Reingreso</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" class="<?php echo $currentPage == 'reingreso' ? 'active' : '' ?>" href="consulta_desc.php">Descuentos Finalizados</a>
        <?php } ?>
            </div>
      </li>
    <?php } ?>
    <?php if($acceso_registro_usuarios){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#fff !important;">
          Menu Usuarios
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" class="<?php echo $currentPage == 'r_usuarios' ? 'active' : '' ?>" href="registro_usuarios.php">Añadir Usuario</a>
          <a class="dropdown-item" class="<?php echo $currentPage == 'c_usuarios' ? 'active' : '' ?>" href="consulta_us.php">Consulta de Usuarios</a>
        </div>
      </li>
    <?php } ?>
     </ul>
   <ul class="navbar-nav ml-auto .justify-content-end text-center">
    <?php if($acceso_desvincular){ ?>
      <li class="nav-item justify-content-end">
        <a class="nav-link" href="desvincular.php" style="color:white !important;">Desvinculación</a>
      </li>
    <?php } ?>
    <?php if($acceso_asistencia){ ?>
      <li class="nav-item justify-content-end">
        <a class="nav-link" href="asistencia.php" style="color:white !important;">Ingreso Asistido</a>
      </li>
    <?php } ?>
    <?php if($acceso_ocnormal){ ?>
      <li class="nav-item justify-content-end">
        <a class="nav-link" href="https://planes.rest911.cl/ocnormal" style="color:white !important;">Panel OC Normal</a>
      </li>
    <?php } ?>
      <li class="nav-item justify-content-end">
        <a class="nav-link" href="https://planes.rest911.cl/" style="color:white !important;">Ir al sitio</a>
      </li>
      <li class="nav-item justify-content-end">
        <a class="nav-link" href="salir.php" tabindex="-1" style="color:white !important;">Cerrar Sesion</a>
      </li>
      </ul>
  </div>
</nav>
<div class="franja" style="background-color:#d7e811;">
</div>
</body>
</html>