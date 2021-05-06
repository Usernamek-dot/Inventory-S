<?php {
  session_start();
  error_reporting(0);

  if (empty($_SESSION['rol'])) {
    header('location: ../ingreso/login.php');
  }
}

include "../includes/conexion.php";
?>
<html>

<head>
  <title> Ventas | Buscando...</title>
  <!-- LINK MEDIA QUERYS importante ! -->
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

  <meta charset="utf-8">
  <link rel="icon" href="../img/logo_prov_pestaña.png" />
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bootstrap/css/estilos/compra.css">
  <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <!---libreria jquery--->
  <script src="../bootstrap/js/popper.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
  <?php
  $busqueda = strtolower($_REQUEST['busqueda']);
  if (empty($busqueda)) {
    header("location:registrar_venta.php");
  }

  ?>
  <header class="d-flex justify-content-between">
    <!-- -------BOTON VOLVER  CON SESIONES--- -->

    <div class="d-flex justify-content-start  mb-3 ">
      <?php include "../includes/btnVolver.php"; ?>
    </div>

    <h1 class="titulo display-4 "> Modulo venta | Buscando... </h1>
    <form action="buscar.php" method="post" class="form-inline my-2 my-lg-0 ">
      <input class="form-control mr-sm-2" type="text" placeholder="Buscar" name="busqueda" id="busqueda" value="<?php echo $busqueda; ?>" aria-label="Search" ata-placement="bottom" data-toggle="tooltip" title="Busque por el número o fecha de la factura">
      <input type="submit" value="Buscar" class="btn-search form-control mr-sm-2">
    </form>
  </header>
  <br><br><br>
  <div class="row d-flex justify-content-center">
    <div class="col-12">
      <table class="table table-hover">
        <thead class="table-primary">
          <tr>
             <th>Número</th>
                            <th>Producto</th>
                            <th>Cliente </th>
                            <th>Fecha</th>
                            <th>Forma de pago</th>
                            <th>Precio Total</th>
            <!-- <th>Imprimir</th> -->
            <!-- <th>Eliminar</th> -->
          </tr>
        </thead>
        <?php
        include "../includes/conexion.php";
// hacer una consulta
        $seleccionar = $conexion->query("SELECT fv.numero , CONCAT(c.nombres , ' ' , c.apellidos ) as 'cliente' ,
fp.nombre as 'formapago' , pt.nombre as 'producto', pt.unidades_disponibles as 'cantidad',
fv.fecha , (fvpt.cantidad * pt.precio) as 'preciototal'
FROM tblfacturaventa as fv
INNER JOIN tblfacturventaproducto as fvpt ON fv.numero = fvpt.factura_venta
INNER JOIN tbl_cliente  as c ON fv.cliente = c.documento
INNER JOIN tblformapago  as fp ON fv.forma_pago = fp.codigo
inner join tblproductoterminado as pt on fvpt.producto = pt.codigo
 WHERE fv.numero LIKE '%$busqueda%' OR fv.fecha LIKE '%$busqueda%' ");
         //devolver todos los resultados en un arreglo y, para que sea asociativo, envía el parámetro MYSQLI_ASSOC:
                          $filas = $seleccionar->fetch_all(MYSQLI_ASSOC);
                            // Verificar si hay filas o no
                            if (empty($filas)) {
                              echo '<script type="text/javascript">
                               alert("No existen datos que coincidan con su busqueda");
                                window.location.href="registrar_venta.php";   
                               </script>';
                               } else {
                                 foreach ($filas as $datos) {
                          ?>
            <tbody>
              <tr>
                <td data-label="Número"> <?php echo $datos['numero']; ?> </td>
                                <td data-label="Producto"> <?php echo $datos['producto']; ?> </td>
                                <td data-label="Cliente"> <?php echo $datos['cliente']; ?> </td>
                                <td data-label="Fecha"> <?php echo $datos['fecha']; ?> </td>
                                <td data-label="Forma pago"> <?php echo $datos['formapago']; ?> </td>
                                <td data-label="Precio total"> <?php echo $datos['preciototal']; ?> </td>
                
              </tr>
            </tbody>
        <?php
          } //se cierra ciclo foreach
        } //cerrar else
        include "../includes/desconexion.php";
        ?>
      </table>
    </div>
  </div>

</html>