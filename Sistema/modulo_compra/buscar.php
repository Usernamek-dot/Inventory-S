<?php 
error_reporting(0);
{ 
  session_start();
  error_reporting(0);

  if(empty($_SESSION['rol']))
  {
      header('location: ../ingreso/login.php');
  }

}
include "../includes/conexion.php";

  ?>
  <html>
      <head>
          <link  rel="icon" href="../img/logo_prov_pestaña.png"/>
          <title>Compras | Buscando...</title>
          <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script> <!---libreria jquery--->
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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
          header("location:registro_compra.php");
          }

          ?>


              <header class="d-flex justify-content-between">
              <div class=" justify-content-start  mb-3 ">
                  
                <?php include "../includes/btnVolver.php"; ?>
              </div>
                  <h1 class="titulo display-4 "> BUSCANDO FACTURAS DE COMPRA... </h1>
                  <form action="buscar.php" method="post" class="form-inline my-2 my-lg-0 ">
                     <input class="form-control mr-sm-2" type="text" placeholder="Buscar" name="busqueda"
                     id="busqueda"  aria-label="Search" value="<?php echo $busqueda; ?>" 
                     ata-placement="bottom" data-toggle="tooltip" 
                     title="Busque por el número , proveedor o  fecha de la factura">
                      <input type="submit" value="Buscar" class="btn-search form-control mr-sm-2" >
                  </form>
              </header>
<br><br><br>
              <div class="row d-flex justify-content-center">
                  <div class="col-12">
                      <table class="table  table-hover">
                               <thead class="table-primary">
                                  <tr>
                                    <th>Número</th>
                                    <th>Proveedor </th>
                                    <th>Forma de pago</th>
                                    <th>Fecha</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Unidad Medida</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Precio total</th>
                                    <th>Eliminar</th>
                                  </tr>
                               </thead>
                                     <?php
                                              include "../includes/conexion.php";
                                                               $seleccionar = $conexion->query("SELECT fa.numero , CONCAT(p.nombre, ' ' , p.apellido ) as 'proveedor' , fp.nombre as 'formapago' ,fa.fecha , m.codigo , m.nombre, u.nombre as'unidadmedida' , fm.cantidad , fm.precio_unitario,(fm.cantidad * fm.precio_unitario) as 'preciototal'FROM tblfacturacompra as fa 
                                      INNER JOIN tblfacturacompramateriaprima as fm ON fa.numero = fm.factura_compra
                                      INNER JOIN tblproveedor  as p ON fa.proveedor = p.nit
                                      INNER JOIN tblformapago  as fp ON fa.forma_pago = fp.codigo
                                      INNER JOIN tblmateriaprima as m on fm.materia_prima = m.codigo
                                      INNER JOIN tblunidadmedida  as u ON m.unidad_medida = u.codigo
                                      WHERE fa.numero LIKE '%$busqueda%' OR CONCAT(p.nombre, ' ' , p.apellido ) LIKE '%$busqueda%'
                                      OR fa.fecha LIKE '%$busqueda%'
                                      ORDER BY fa.numero ASC");
                                      $filas = $seleccionar->fetch_all(MYSQLI_ASSOC);
                                        // Verificar si hay filas o no
                                       if (empty($filas)) {
                                      echo '<script type="text/javascript">
                                        alert("No existen datos que coincidan con su busqueda");
                                        window.location.href="registro_compra.php";   
                                        </script>';
                              
                                        } else {
                                      foreach ($filas as $datos) {

                      
                                     ?>
                                <tbody>
                                    <tr>
                                        <td data-label="Número" > <?php echo $datos['numero']; ?> </td>
                                        <td data-label="Proveedor" ><?php echo $datos['proveedor']; ?></td>
                                        <td data-label="Forma pago"  > <?php echo $datos['formapago']; ?> </td>
                                        <td data-label="Fecha" > <?php echo $datos['fecha']; ?> </td>
                                        <td data-label="Codigo de existencia" > <?php echo $datos['codigo']; ?> </td>
                                        <td data-label="Nombre de existencia" > <?php echo $datos['nombre']; ?> </td>
                                        <td data-label="Unidad de medida" > <?php echo $datos['unidadmedida']; ?> </td>
                                        <td data-label="Cantidad" > <?php echo $datos['cantidad']; ?> </td>
                                        <td data-label="Precio unitario" > <?php echo $datos['precio_unitario']; ?> </td>
                                        <td data-label="Precio total" > <?php echo $datos['preciototal']; ?> </td>
                                        <td><a href="borrar.php?numero=<?php echo $datos['numero'] ?>">ELIMINAR</a></td>
                                    </tr>
                                </tbody>

                                  <?php
                                      } } 
                                  include "../includes/desconexion.php";

                                  ?>
                      </table>
                  </div>
              </div>
      </body>
  </html>
