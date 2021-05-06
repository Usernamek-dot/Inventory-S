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
  <title> Configurar usuario</title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

  <meta charset="utf-8">
  <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>

  <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
  <link rel="icon" href="../img/logo_prov_pestaña.png">
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bootstrap/css/estilos/usuario.css">
  <script src="../bootstrap/js/popper.min.js"></script>

</head>

<body>
  <?php
  $busqueda = strtolower($_REQUEST['busqueda']);
  if (empty($busqueda)) {
    header("location:usuario.php");
  }

  ?>

  <header class="d-flex justify-content-between ">
    <div class="d-flex justify-content-start  mb-3 ">
      <!-- BOTON VOLVER -->
      <?php include "../includes/btnVolver.php"; ?>
    </div>
    <h1 class="titulo display-4 "> Buscando Usuario.. </h1>
    <form action="buscar_usuario.php" method="post" class="form-inline my-2 my-lg-0 ">
      <input class="form-control mr-sm-2" type="text" placeholder="Buscar" name="busqueda" id="busqueda" value="<?php echo $busqueda; ?>" aria-label="Search" ata-placement="bottom" data-toggle="tooltip" title="Busque por el documento de identidad, los nombres o los apellidos del usuario">
      <input type="submit" value="Buscar" class="btn-search form-control mr-sm-2">
    </form>
  </header>

  <br><br><br>
  <div class="row d-flex justify-content-center ">
    <div class="col-12">
      <table class="table table-hover">

        <thead class="table-primary">
          <tr>
            <th>Documento</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Correo </th>
            <th>Telefono</th>
            <th>Dirección</th>
            <th>Clave</th>
            <th>Perfil</th>
            <th>Municipio </th>
            <th>Actualizar</th>
          </tr>
        </thead>
        <?php

        $rol = '';
        if ($busqueda == 'Superadministrador') {
          $rol = "OR rol LIKE '%1%'";
        } elseif ($busqueda == 'administrador') {
          $rol = "OR rol LIKE '%2%'";
        } elseif ($busqueda == 'operario') {
          $rol = "OR rol LIKE '%3%'";
        }
        $seleccionar = $conexion->query("SELECT
u.documento,
u.nombres as 'nombre',
u.apellidos as 'apellido',
u.correo,
u.telefono,
u.direccion,
u.clave,
tp.nombre as 'rol',
m.nombre as 'municipio'
FROM
tblusuario as u
    left JOIN
tbltipousuario as tp ON u.tipo_usuario = tp.id
inner join
tblmunicipio as m ON u.municipio = m.codigo
 WHERE documento LIKE '%$busqueda%' OR 
nombres LIKE '%$busqueda%' OR apellidos LIKE '%$busqueda%'  $rol");

//VALIDAR SELECT

        //devolver todos los resultados en un arreglo y, para que sea asociativo, envía el parámetro MYSQLI_ASSOC:
        $filas = $seleccionar->fetch_all(MYSQLI_ASSOC);
        // Verificar si hay filas o no
        if (empty($filas)) {
          echo '<script type="text/javascript">
              alert("No existen datos que coincidan con su busqueda");
              window.location.href="usuario.php";   
              </script>';
        } else {
          foreach ($filas as $datos) {        ?>
            <tbody>
              <tr>
                <td data-label="Documento"> <?php echo $datos["documento"]; ?> </td>
              <td data-label="Nombre"> <?php echo $datos["nombre"]; ?> </td>
              <td data-label="Apellido"> <?php echo $datos["apellido"]; ?> </td>
              <td data-label="Correo"> <?php echo $datos["correo"]; ?> </td>
              <td data-label="Teléfono"> <?php echo $datos["telefono"]; ?> </td>
              <td data-label="Dirección"> <?php echo $datos["direccion"]; ?> </td>
              <td data-label="Clave"> <?php echo $datos["clave"]; ?> </td>
              <td data-label="Perfil"><?php echo $datos["rol"]; ?></td>
              <td data-label="Municipio"><?php echo $datos["municipio"]; ?></td>

              
                <td><a href="actualizar.php?documento=<?php echo $datos['documento'] ?>">ACTUALIZAR</a></td>
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

</html>