<?php
{ 
    session_start();
    error_reporting(0);
 
    if(empty($_SESSION['rol']))
    {
        header('location: ../ingreso/login.php');
    }
 
}
include '../includes/conexion.php';
?>
<html>

<head>
  <meta charset="utf-8">
  <link rel="icon" href="../img/logo_prov_pestaña.png" />
  <title> Cliente | Buscando... </title>
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <!---libreria jquery--->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bootstrap/css/estilos/proveedor.css">
  <script src="../bootstrap/js/popper.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>

</head>

<body>
  <?php
  $busqueda = strtolower($_REQUEST['busqueda']);
  if (empty($busqueda)) {
    header("location:registro_cliente.php");
  }

  ?>
  <header class="d-flex justify-content-between">

    <div class="d-flex justify-content-start  mb-3 ">
      <?php include "../includes/btnVolver.php"; ?>
       </div>
    <h1 class="titulo display-4 "> BUSCANDO CLIENTE </h1>
    <form action="buscar_cliente.php" method="post" class="form-inline my-2 my-lg-0 ">
      <input class="form-control mr-sm-2" type="text" placeholder="Buscar" name="busqueda" id="busqueda" value="<?php echo $busqueda; ?>" aria-label="Search" ata-placement="bottom" data-toggle="tooltip" title="Busque por el documento , los nombres o los apellidos del cliente ">
      <input type="submit" value="Buscar" class="btn-search form-control mr-sm-2">
    </form>
  </header>
  <br><br>
  <div class="container-fluid">
  <div class="row d-flex justify-content-center">
    <div class="col-12">
      <table class="table table-hover">
        <thead class="table-primary">
          <tr>
            <th>Documento </th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Telefono </th>
            <th>Correo</th>
            <th>Dirección</th>
            <th>Municipio</th>
            <th>Actualizar</th>
            <th>Eliminar</th>
          </tr>
        </thead>
        <?php

        include "../includes/conexion.php";

        $seleccionar = $conexion->query("SELECT
cl.documento,
cl.nombres as 'nombres',
cl.apellidos as 'apellidos',
cl.correo,
cl.telefono,
cl.direccion,
m.nombre as 'municipio'
FROM
tbl_cliente as cl
inner join
tblmunicipio as m ON cl.municipio = m.codigo 
WHERE documento = '$busqueda' OR nombres LIKE '%$busqueda%'OR apellidos LIKE '%$busqueda%'");

        //devolver todos los resultados en un arreglo y, para que sea asociativo, envía el parámetro MYSQLI_ASSOC:
        $filas = $seleccionar->fetch_all(MYSQLI_ASSOC);
        // Verificar si hay filas o no
        if (empty($filas)) {
          echo '<script type="text/javascript">
  alert("No existen datos que coincidan con su busqueda");
  window.location.href="registro_cliente.php";   
  </script>';
        } else {
          foreach ($filas as $datos) {
        ?>
            <tbody>
              <tr>
                 <td data-label="Documento"><?php echo $datos['documento'] ?></td>
                <td data-label="Nombres"><?php echo $datos['nombres'] ?></td>
                <td data-label="Apellidos"><?php echo $datos['apellidos'] ?></td>
                <td data-label="Teléfono"><?php echo $datos['telefono'] ?></td>
                <td data-label="Correo"><?php echo $datos['correo'] ?></td>
                <td data-label="Dirección"><?php echo $datos['direccion'] ?></td>
                <td data-label="Municipio"><?php echo $datos['municipio'] ?></td>
                <td><a href="actualizar_cliente.php?documento=<?php echo $datos['documento'] ?>">ACTUALIZAR</a></td>
                <td><a href="borrar_cliente.php?documento=<?php echo $datos['documento'] ?>">ELIMINAR</a></td>
              </tr>

            </tbody>
        <?php

          }  //se cierra ciclo foreach
        }   //se cierra condicional if

        include "../includes/desconexion.php";
        ?>
      </table>
    </div>
  </div>
</div>
</body>

</html>