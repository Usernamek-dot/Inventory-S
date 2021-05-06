<?php {
  session_start();
  error_reporting(0);

  if (empty($_SESSION['rol'])) {
    header('location: ../ingreso/login.php');
  }
}

include "../includes/conexion.php"; ?>
<html>

<head>
  <link rel="icon" href="../img/logo_prov_pestaña.png" />
  <title>Recetas | Buscando...</title>
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <!---libreria jquery--->
  <!-- LINK MEDIA QUERYS importante ! -->
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

  <meta charset="utf-8">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bootstrap/css/estilos/compra.css">
  <script src="../bootstrap/js/popper.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <script src="../bootstrap/js/jquery-3.5.1.min.js"></script>
  <script src="../bootstrap/js/validar_compra.js"></script>
  <script src="../bootstrap/js/botones.js"></script>
  <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>

</head>

<body>
  <?php
  $busqueda = strtolower($_REQUEST['busqueda']);
  if (empty($busqueda)) {
    header("location:registrar_receta.php");
  } ?>


  <header class="d-flex justify-content-between">
    <div class="d-flex justify-content-start  mb-3 ">
      <?php include "../includes/btnVolver.php"; ?>
    </div>
    <h1 class="titulo display-4"> BUSCANDO RECETA </h1>
    <form action="buscar.php" method="post" class="form-inline my-2 my-lg-0 ">
      <input class="form-control mr-sm-2" type="text" placeholder="Buscar" name="busqueda" id="busqueda" aria-label="Search" value="<?php echo $busqueda; ?>" ata-placement="bottom" data-toggle="tooltip" title="Busque por el número , empleado o el nombre del producto">
      <input type="submit" value="Buscar" class="btn-search form-control mr-sm-2">
    </form>
  </header>
  <br> <br>
  <div class="container-fluid">
    <div class="row d-flex justify-content-center">
      <div class="col-12">
        <table class="table table-hover">
          <thead class="table-primary">
            <tr>
              <th>Número</th>
              <th>Fecha </th>
              <th>Empleado</th>
              <th>Producto</th>
              <th>Actualizar</th>
              <th>Eliminar</th>
            </tr>
          </thead>
          <?php

          include "../includes/conexion.php";

          $seleccionar = $conexion->query("SELECT
rc.codigo,
rc.fecha,
CONCAT(u.nombres,' ',u.apellidos) as 'usuario',
p.nombre as 'producto'
FROM
tblreceta as rc INNER JOIN tblusuario as u ON rc.usuario=u.documento
 INNER JOIN tblproductoterminado as p on rc.producto = p.codigo  
 WHERE rc.codigo LIKE '%$busqueda%'
 OR CONCAT(u.nombres,' ',u.apellidos) LIKE '%$busqueda%' 
 OR p.nombre  LIKE '%$busqueda%'
 ");
          //devolver todos los resultados en un arreglo y, para que sea asociativo, envía el parámetro MYSQLI_ASSOC:
          $filas = $seleccionar->fetch_all(MYSQLI_ASSOC);
          // Verificar si hay filas o no
          if (empty($filas)) {
            echo '<script type="text/javascript">
alert("No existen datos que coincidan con su busqueda");
window.location.href="registrar_receta.php";   
</script>';
          } else {
            foreach ($filas as $datos) {    ?>
              <tbody>
                <tr>
                  <td> <?php echo $datos['codigo']; ?> </td>
                  <td> <?php echo $datos['fecha']; ?> </td>
                  <td> <?php echo $datos['usuario']; ?> </td>
                  <td> <?php echo $datos['producto']; ?> </td>
                  <td><a href="actualizar.php?codigo=<?php echo $datos['codigo'] ?>">ACTUALIZAR</a></td>
                  <td><a href="borrar_receta.php?codigo=<?php echo $datos['codigo'] ?>">ELIMINAR</a></td>
                </tr>
              </tbody>
          <?php
            } //se cierra ciclo while
          } //cerrar else
          include "../includes/desconexion.php";
          ?>
        </table>
      </div>
    </div>
  </div>
</body>

</html>