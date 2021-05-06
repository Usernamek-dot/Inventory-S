  <?php include "../includes/conexion.php";
  ?>
<html>

  <head>

    <title> Producción | Buscando...</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" href="../img/logo_prov_pestaña.png" />
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/css/estilos/r_produccion.css">
    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../bootstrap/js/jquery-3.5.1.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>
    <!---libreria jquery--->

  </head>

  <body>
    <?php
    // traer datos buscados y validar
    $busqueda = strtolower($_REQUEST['busqueda']);
    if (empty($busqueda)) {
      header("location:registrar_produccion.php");
    }

    ?>


    <header class="d-flex justify-content-between">
      <div class="d-flex justify-content-start  mb-3 ">

          <?php include "../includes/btnVolver.php";?>
      </div>
      <h1 class="titulo display-4 "> BUSCANDO ORDEN DE PRODUCCIÓN... </h1>
      <!-- formulario de buscar -->
      <form action="buscar.php" method="post" class="form-inline my-2 my-lg-0 ">
                <input class="form-control mr-sm-2" type="text" placeholder="Buscar" name="busqueda" id="busqueda" aria-label="Search" ata-placement="bottom" data-toggle="tooltip" title="Busque por el código, el nombre del empleado o el nombre del producto." value="<?php echo $busqueda; ?>">
                <input type="submit" value="Buscar" class="btn-search form-control mr-sm-2">
      </form>
    </header>
       
 <br><br><br>
        <div class="row d-flex justify-content-center">
            <div class="col-12">
            <!-- tabla -->
                <table class="table">
                      <thead class="table-primary">
                        <tr>
                          <th>codigo</th>
                          <th>Fecha</th>
                          <th>Empleado</th>
                          <th>Producto </th>
                          <th>Receta</th>
                          <th>Cantidad</th>
                          <th>Descripción</th>
                         
                        </tr>
                      </thead>
                            <?php
                            include "../includes/conexion.php";

                            //crear consulta
                            $seleccionar = $conexion->query("SELECT pdc.codigo, pdc.fecha , CONCAT(u.nombres, ' ' , u.apellidos ) as 'empleado' , pdt.nombre as 'producto', r.codigo as 'receta', pr.cantidad , r.descripcion 
                              FROM tblproduccion as pdc 
                              INNER JOIN tblusuario as u on u.documento = pdc.usuario 
                              INNER JOIN tblproduccionreceta as pr on pdc.codigo=pr.cod_produccion 
                              INNER JOIN tblreceta as r on pr.cod_receta=r.codigo
                              INNER JOIN tblproductoterminado as pdt on r.producto =  pdt.codigo
                              WHERE pdc.codigo LIKE '%$busqueda%' OR pdc.fecha LIKE '%$busqueda%' OR pdt.nombre LIKE '%$busqueda%' OR CONCAT(u.nombres, ' ' , u.apellidos ) LIKE '%$busqueda%'");

                            //devolver todos los resultados en un arreglo y, para que sea asociativo, envía el parámetro MYSQLI_ASSOC:
                          $filas = $seleccionar->fetch_all(MYSQLI_ASSOC);
                            // Verificar si hay filas o no
                            if (empty($filas)) {
                              echo '<script type="text/javascript">
                               alert("No existen datos que coincidan con su busqueda");
                                window.location.href="registrar_produccion.php";   
                               </script>';
                               } else {
                                 foreach ($filas as $datos) {
                          ?>
                      <tbody>
                        <tr>
                         <td> <?php echo $datos['codigo']; ?> </td>
                         <td> <?php echo $datos['fecha']; ?> </td>
                         <td> <?php echo $datos['empleado']; ?> </td>
                         <td> <?php echo $datos['producto']; ?> </td>
                         <td> <?php echo $datos['receta']; ?> </td>
                         <td> <?php echo $datos['cantidad']; ?> </td>
                         <td>
                         <div class="limitetd"><?php echo $datos['descripcion']; ?> .... </div>
                         </td>
                        </tr>
                      </tbody>
                              <?php
                           }  }  include "../includes/desconexion.php";

                              ?>
                </table>
            </div>
        </div>
  </body>

</html>