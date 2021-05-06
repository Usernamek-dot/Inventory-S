<?php {
  session_start();
  error_reporting(0);

  if (empty($_SESSION['rol'])) {
    header('location: ../ingreso/login.php');
  }
}

?>
<html>

<head>
  <link rel="icon" href="../img/logo_prov_pestaña.png" />
  <title>Reporte Ventas</title>
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


  <header class="d-flex justify-content-between">
    <div class="d-flex justify-content-start  mb-3 ">
      <?php include "../includes/btnVolver.php"; ?>
    </div>
    <h1 class="titulo display-4"> Informe de las productos vendidos </h1>

  </header>
  <br> <br>

  <div class="row d-flex justify-content-center">
    <div class="col-9">

      <table class="table table-hover">
        <thead class="table-primary">
          <tr>
            <th>Cantidad de factura </th>
            <th>Producto</th>
            <th>Cantidad de producto</th>
          </tr>
        </thead>
        <?php

        include "../includes/conexion.php";

        $seleccionar = $conexion->query(" CALL Rp_NumeroVentas() ");

        foreach ($seleccionar as $op) : //creamos las opciones a partir de los datos obtenidos 


        ?>
          <tbody>
            <tr>
              <td data-label="Cantidad de factura"> <?php echo $op['Numero_facturas']; ?> </td>
              <td data-label="Producto"> <?php echo $op['producto']; ?> </td>
              <td data-label="Cantidad de producto"> <?php echo $op['Cantidad_producto']; ?> </td>

            </tr>
          </tbody>
        <?php
        endforeach;
        include "../includes/desconexion.php";
        ?>
      </table>
    </div>
  
</div>
  





</body>

</html>