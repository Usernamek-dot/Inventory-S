<?php {
  session_start();
  error_reporting(0);

  if (empty($_SESSION['rol'])) {
    header('location: ../ingreso/login.php');
  }
}
include '../includes/conexion.php';
?>
<html>

<head>
  <meta charset="utf-8">
  <link rel="icon" href="../img/logo_prov_pestaña.png" />
  <title> Salidas | Producto terminado</title>
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <!---libreria jquery--->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bootstrap/css/estilos/producto.css">
  <script src="../bootstrap/js/popper.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>



</head>

<body>
  <?php
  $busqueda = strtolower($_REQUEST['busqueda']);
  if (empty($busqueda)) {
    header("location:registro_producto.php");
  }

  ?>
  <header class="d-flex justify-content-between">
    <div class="d-flex justify-content-start  mb-3 ">
      <?php include "../includes/btnVolver.php"; ?>
    </div>
    <h1 class="titulo display-4 "> BUSCANDO PRODUCTO TERMINADO </h1>
    <form action="buscar_producto.php" method="post" class="form-inline my-2 my-lg-0 ">
      <input class="form-control mr-sm-2" type="text" placeholder="Buscar" name="busqueda" id="busqueda" value="<?php echo $busqueda; ?>" aria-label="Search" ata-placement="bottom" data-toggle="tooltip" title="Busque por el código o el nombre del producto">
      <input type="submit" value="Buscar" class="btn-search form-control mr-sm-2">
    </form>

  </header>
   <br><br><br>
  <div class="row d-flex justify-content-center table-responsive">
    <div class="col-12">
      <table class="table table-hover">
        <thead class="table-primary">
          <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Fecha de creación</th>
            <th>Fecha de vencimiento</th>
            <th>Categoría</th>
            <th>Unidades disponibles</th>
            <th>Unidad de medida</th>
            <th>Editar</th>
            <th>Eliminar</th>
          </tr>
        </thead>
        <?php

        include "../includes/conexion.php";

        $seleccionar = $conexion->query("SELECT c.nombre as 'categoria', um.nombre as 'unidad_medida',pt.codigo,pt.nombre,pt.unidades_disponibles,pt.fecha_vencimiento,pt.fecha_creacion FROM tblproductoterminado as pt INNER JOIN tblunidadmedida as um ON pt.unidad_medida = um.codigo INNER JOIN tblcategoria as c ON pt.categoria = c.codigo
        WHERE pt.codigo LIKE '%$busqueda%' OR pt.nombre LIKE '%$busqueda%'");
        //devolver todos los resultados en un arreglo y, para que sea asociativo, envía el parámetro MYSQLI_ASSOC:
        $filas = $seleccionar->fetch_all(MYSQLI_ASSOC);
        // Verificar si hay filas o no
        if (empty($filas)) {
          echo '<script type="text/javascript">
  alert("No existen datos que coincidan con su busqueda");
  window.location.href="registro_producto.php";   
  </script>';
        } else {
          foreach ($filas as $datos) {
        ?>
            <tbody>
              <tr>
                <td data-label="Código"><?php echo $datos['codigo'] ?></td>
                <td data-label="Nombre"><?php echo $datos['nombre'] ?></td>
                <td data-label="Feha de creación"><?php echo $datos['fecha_creacion'] ?></td>
                <td data-label="Fecha de vencimiento"><?php echo $datos['fecha_vencimiento'] ?></td>
                <td data-label="Categoría"><?php echo $datos['categoria']  ?></td>
                <td data-label="Unidades disponibles"><?php echo $datos['unidades_disponibles'] ?></td>
                <td data-label="Unidad medida"><?php echo $datos['unidad_medida']  ?></td>
                <td><a href="actualizar_producto.php?codigo=<?php echo $datos['codigo'] ?>">ACTUALIZAR</a></td>
                <td><a href="borrar_producto.php?codigo=<?php echo $datos['codigo'] ?>">ELIMINAR</a></td>
              </tr>

            </tbody>
        <?php
          }
        }   //se cierra ciclo while
        include "../includes/desconexion.php";
        ?>
      </table>
    </div>
  </div>
</body>

</html>