<?php 
{ 
    session_start();
    error_reporting(0);
 
    if(empty($_SESSION['rol']))
    {
        header('location: ../ingreso/login.php');
    }
 
}
include "../includes/conexion.php";?>
<html>
    <head>
        <meta charset="utf-8">
        <title> Bucando...</title>
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script> <!---libreria jquery--->
        <meta charset="utf-8">
        <link rel="icon" href="../img/logo_prov_pestaña.png">

        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
       <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../bootstrap/css/estilos/materia_prima.css">
        <script src="../bootstrap/js/popper.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>

    </head>
    <body>
      <?php
    //   variable que guarda los datos de busqueda

$busqueda = strtolower($_REQUEST['busqueda']);
if (empty($busqueda)) {
    header("location:inventario_materia.php");
}

?>
      <header class="d-flex justify-content-between">
            <div class="d-flex justify-content-start  mb-3 ">
               <?php include "../includes/btnVolver.php"; ?>
            </div>
                <center>
            <h1 class="titulo display-4 "> Buscando Materia prima.. </h1>

              </center>
              <!-- formulario de buscar -->
                <form class="form-inline my-2 my-lg-0" action="buscar.php" method="post">
                   <input class="form-control mr-sm-2" type="text" placeholder="Buscar"
                   name="busqueda" id="busqueda" value="<?php echo $busqueda; ?>" aria-label="Search">
                  <input type="submit" value="Buscar" class="btn-search form-control mr-sm-2" >
                </form>
        </header>
            <br><br><br>
          <div class="row d-flex justify-content-center table-responsive">
          <!-- tabla que trae la busqueda -->
          <table class="table table-hover">
             <thead class="thead-light">

                <th>Código</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Unidad de medida</th>
                <th>Fecha de vencimiento</th>
                <th>Actualizar</th>
                <th>Eliminar</th>

            <?php

include "../includes/conexion.php";

$seleccionar = $conexion->query("SELECT mp.codigo , mp.nombre as 'nombre',
                    mp.unidades_disponibles as 'cantidad' , mp.fecha_vencimiento as'fecha' ,
                    um.nombre as 'unidad_medida'
                     FROM tblmateriaprima as mp INNER JOIN tblunidadmedida as um
                     ON mp.unidad_medida=um.codigo
                    WHERE mp.codigo LIKE '%$busqueda%'
                    OR mp.nombre LIKE '%$busqueda%' ");

  //devolver todos los resultados en un arreglo y, para que sea asociativo, envía el parámetro MYSQLI_ASSOC:
        $filas = $seleccionar->fetch_all(MYSQLI_ASSOC);
        // Verificar si hay filas o no
        if (empty($filas)) {
          echo '<script type="text/javascript">
  alert("No existen datos que coincidan con su busqueda");
  window.location.href="inventario_materia.php";   
  </script>';
        } else {
          foreach ($filas as $datos) {
    ?>
            <tbody>
                    <tr>
                            <td data-label="Código"><?php echo $datos['codigo'] ?></td>
                            <td data-label="Nombre"><?php echo $datos['nombre'] ?></td>
                            <td data-label="Cantidad"><?php echo $datos['cantidad'] ?></td>
                            <td data-label="Unidad Medida"><?php echo $datos['unidad_medida'] ?></td>
                            <td data-label="Fecha de Vecimiento"><?php echo $datos['fecha'] ?></td>
                            <td><a href="actualizar_materia.php?codigo=<?php echo $datos['codigo'] ?>">ACTUALIZAR</a></td>
                            <td><a href="borrar_materia.php?codigo=<?php echo $datos['codigo'] ?>">ELIMINAR</a></td>
                    </tr>

                    </tbody>
            <?php   }  //se cierra ciclo foreach
        }   //se cierra condicional if

        include "../includes/desconexion.php"; ?>
        </table>
    </div>
    </body>
</html>

