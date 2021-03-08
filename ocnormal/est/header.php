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
<nav class="navbar navbar-expand-lg" style="background-color: #171a21;">
   <a class="navbar-brand;" href="index.php">
    <img src="../img/logob.png" width="230" height="80" style="margin-left:15%;" alt="">
  </a>
  <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mx-auto text-center">
        <li class="nav-item active">
        <a class="nav-link" class="<?php echo $currentPage == 'index' ? 'active' : '' ?>" href="index.php">Consulta de Transacciones <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" class="<?php echo $currentPage == 'cobro' ? 'active' : '' ?>" href="cobro.php">Cobro Manual</a>
      </li>
        <!--<li class="nav-item">
        <a class="nav-link" class="<?php echo $currentPage == 'descuentos' ? 'active' : '' ?>" href="descuentos.php">Mantenedor de descuentos</a>
      </li>
        <li class="nav-item">
        <a class="nav-link" class="<?php echo $currentPage == 'planes' ? 'active' : '' ?>" href="planes.php">Modificar Planes-Descuentos</a>
      </li>-->
     </ul>
   <ul class="navbar-nav ml-auto .justify-content-end text-center">
      <!--<li class="nav-item justify-content-end">
        <a class="nav-link" href="asistencia.php">Ingreso Asistido</a>
      </li>-->
	  <li class="nav-item justify-content-end">
        <a class="nav-link" href="https://planes.rest911.cl/admin">Volver a Panel OC Mall</a>
      </li>
      <li class="nav-item justify-content-end">
        <a class="nav-link" href="https://planes.rest911.cl/">Ir al sitio</a>
      </li>
      <li class="nav-item justify-content-end">
        <a class="nav-link" href="salir.php" tabindex="-1">Cerrar Sesion</a>
      </li>
      </ul>
  </div>
</nav>
<div class="franja" style="background-color:#2a475e;">
</div>
</body>
</html>