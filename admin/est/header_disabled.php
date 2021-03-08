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
            <a class="nav-link" class="<?php echo $currentPage == 'index' ? 'active' : '' ?>" href="lista_aprobados.php" style="color:white !important;">Consulta de Clientes <span class="sr-only">(current)</span></a>
        </li>
      <!--<li class="nav-item">
        <a class="nav-link" class="<?php echo $currentPage == 'precios' ? 'active' : '' ?>" href="precios.php">Precios</a>
      </li>-->
        <!--<li class="nav-item">
            <a class="nav-link" class="<?php echo $currentPage == 'descuentos' ? 'active' : '' ?>" href="descuentos.php" style="color:white !important;">Mantenedor de descuentos</a>
        </li> -->
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:gray !important;">
          Campañas y Descuentos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
				<a class="dropdown-item" class="<?php echo $currentPage == 'consulta_t' ? 'active' : '' ?>" href="">Creador de Campañas</a>
          <a class="dropdown-item" class="<?php echo $currentPage == 'cobros' ? 'active' : '' ?>" href="">Consulta de Campañas</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" class="<?php echo $currentPage == 'consulta_re' ? 'active' : '' ?>" href="">Mantenedor de descuentos</a>
                <div class="dropdown-divider"></div>
          <a class="dropdown-item" class="<?php echo $currentPage == 'completar' ? 'active' : '' ?>" href="">Completar Registros</a>
            </div>
        </li>    
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:gray !important;">
          Menu Cobros
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          		<a class="dropdown-item" class="<?php echo $currentPage == 'consulta_t' ? 'active' : '' ?>" href="">Consulta Cobros</a>
          <a class="dropdown-item" class="<?php echo $currentPage == 'cobros' ? 'active' : '' ?>" href="">Panel de Cobros</a>
          <a class="dropdown-item" class="<?php echo $currentPage == 'cobros' ? 'active' : '' ?>" href="">Consulta Vencidos</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" class="<?php echo $currentPage == 'consulta_re' ? 'active' : '' ?>" href="">Reversas</a>
        <div class="dropdown-divider"></div>
          <a class="dropdown-item" class="<?php echo $currentPage == 'consulta_rein' ? 'active' : '' ?>" href="">Consulta Reingreso</a> 
          <a class="dropdown-item" class="<?php echo $currentPage == 'reingreso' ? 'active' : '' ?>" href="">Panel Reingreso</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" class="<?php echo $currentPage == 'reingreso' ? 'active' : '' ?>" href="">Descuentos Finalizados</a>
            </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:gray !important;">
          Menu Usuarios
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" class="<?php echo $currentPage == 'r_usuarios' ? 'active' : '' ?>" href="">Añadir Usuario</a>
          <a class="dropdown-item" class="<?php echo $currentPage == 'c_usuarios' ? 'active' : '' ?>" href="">Consulta de Usuarios</a>
        </div>
      </li>
     </ul>
   <ul class="navbar-nav ml-auto .justify-content-end text-center">
      <li class="nav-item justify-content-end">
        <a class="nav-link" href="" style="color:gray !important;">Desvinculación</a>
      </li>
      <li class="nav-item justify-content-end">
        <a class="nav-link" href="" style="color:gray !important;">Ingreso Asistido</a>
      </li>
      <li class="nav-item justify-content-end">
        <a class="nav-link" href="" style="color:gray !important;">Panel OC Normal</a>
      </li>
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