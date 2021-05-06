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

  // traer datos de selects
  $consulta_proveedor = mysqli_query($conexion, "SELECT nit ,  CONCAT (nombre, ' ' , apellido ) as 'nombre' FROM tblproveedor");
  $consulta_f_pago = mysqli_query($conexion, "SELECT codigo , nombre FROM tblformapago");
  $consulta_u_medida = mysqli_query($conexion, "SELECT codigo , nombre  FROM tblunidadmedida");
  ?>

  <html>

  <head>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <!---libreria jquery--->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" href="../img/logo_prov_pestaña.png" />
    <title> Compras | Entradas </title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/css/estilos/compra.css">
    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../bootstrap/js/jquery-3.5.1.min.js"></script>
    <script src="../bootstrap/js/validar_venta_compra.js"></script>
    <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>
  </head>

  <body>
    <header class="d-flex justify-content-between">

      <div class=" justify-content-start  mb-3 ">

        <?php include "../includes/btnVolver.php"; ?>

      </div>
      <h1 class="titulo display-4 "> FACTURAS DE COMPRA </h1>
      <form action="buscar.php" method="post" class="form-inline my-2 my-lg-0 ">

        <input class="form-control mr-sm-2" type="text" placeholder="Buscar" name="busqueda" id="busqueda" aria-label="Search" ata-placement="bottom" data-toggle="tooltip" title="Busque por el número , proveedor o  fecha de la factura">
        <input type="submit" value="Buscar" class="btn-search form-control mr-sm-2">
      </form>
    </header>

    <div class="container-fluid">
      <div class="row div border border-primary factura">

      <!-- formulario -->
        <form action="guardar.php" method="post" name="formulario" class="needs-validation" novalidate>
          <div class="col-12">
            <div class="d-flex  justify-content-center row">
              <!-------------PONER FECHA ACTUAL----------->
              <script type="text/javascript">
                window.onload = function() {
                  var fecha = new Date(); //Fecha actual
                  var anio = fecha.getFullYear(); //obteniendo año
                  var mes = fecha.getMonth() + 1; //obteniendo mes
                  var dia = fecha.getDate(); //obteniendo dia
                  if (dia < 10)
                    dia = '0' + dia; //agrega cero si el menor de 10
                  if (mes < 10)
                    mes = '0' + mes //agrega cero si el menor de 10
                  document.getElementById('fechaActual').value = anio + "-" + mes + "-" + dia;
                }
              </script>


              <div class="col-lg-2 col-12 col-md-12">
                <div class="form-group  ">
                  <label class="col-12"> Fecha:</label>
                  <input min="2021-03-24" class="form-control mr-sm-2 col-12" type="date" name="fecha" id="fechaActual" value="" readonly>
                </div>
              </div>


              <div class="col-lg-2 col-md-12  col-12 ">
                <div class="form-group">
                  <label class=" col-12"> Número Externo:</label>
                  <input class="form-control mr-sm-2 col-12" type="text" name="numeroFactura" required>
                </div>
              </div>
              <div class="col-lg-2 col-md-12">
                <div class="form-group  ">
                  <label class=" col-12"> Proveedor:</label>
                  <select name="proveedor" class="col-12 form-control mr-sm-2 " required>
                    <option value="" disabled selected>- Seleccione -</option>
                    <?php
                    while ($datos = mysqli_fetch_array($consulta_proveedor)) { //array recorre datos
                    ?>
                      <option value="<?php echo $datos['nit'] ?>"> <?php echo $datos['nombre'] ?> </option>
                    <?php } ?>
                  </select>

                </div>
              </div>
              <div class="col-lg-2 col-md-12">
                <div class="form-group ">
                  <label class=" col-12">Forma de pago:</label>
                  <select class="col-12 form-control mr-sm-2 " name="forma_pago" required>
                    <option value="" disabled selected>- Seleccione -</option>
                    <?php
                    while ($datos = mysqli_fetch_array($consulta_f_pago)) { //array recorre datos
                    ?>
                      <option value="<?php echo $datos['codigo'] ?>"> <?php echo $datos['nombre'] ?> </option>
                    <?php } ?>
                  </select>
                </div>
              </div>


              <div class=" col-xs-6 col-lg-2 col-md-5 col-sm-6">
                <div class="row ">
                  <div class="  col-xs-6  col-lg-12 col-md-6 col-sm-7 ">
                    <button type="button" class="btn btn-primary rounded-pill button" onclick="agregarFila()" data-placement="top" data-toggle="tooltip" title="pulse aquí para agregar una fila a la tabla inferior">
                      Agregar fila</button>
                  </div>
                  <div class="  col-xs-6 col-lg-12 col-md-6 col-sm-7">
                    <button type="button" class="btn btn-primary  rounded-pill button" onclick="eliminarFila()" data-placement="bottom" data-toggle="tooltip" title="pulse aquí para eliminar una fila a la tabla inferior">
                      Eliminar fila</button>
                  </div>
                </div>
              </div>


              <div class=" col-xs-6 col-lg-2 col-md-7 col-sm-6">
                <input type="submit" class="btn btn-primary button" value="CREAR FACTURA" id="boton">
              </div>
            </div>



            <div class="col-12">

              <table class="table" id="table">

                <thead class="table-primary ">
                  <tr>
                    <th>Código de existencia</th>
                    <th>Nombre</th>
                    <th>Unidad medida</th>
                    <th>Fecha vencimiento</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>

                  </tr>
                </thead>

                <tbody>



                  <!---------------------SCRIPT PARA BOTONES AGREGAR Y ELIMINAR FILA---------------->

                  <script>
                    var myTable = document.querySelector("table");

                    function agregarFila() {

                      var row = myTable.insertRow(myTable.rows.length);
                      var cell1 = row.insertCell(0);
                      var cell2 = row.insertCell(1);
                      var cell3 = row.insertCell(2);
                      var cell4 = row.insertCell(3);
                      var cell5 = row.insertCell(4);
                      var cell6 = row.insertCell(5);

                      cell1.innerHTML = '<input  class="form-control mr-sm-2 col-12" type="text" name="codigo[]" id="codigo" required> <div class="invalid-feedback"> Debe elegir un código de existencia. </div>';
                      cell2.innerHTML = '<input  class="form-control mr-sm-2 col-12" type="text" name="nombre[]"  id="nombre" required> <div class="invalid-feedback"> Debe elegir un nombre de existencia.</div>';
                      cell3.innerHTML = `<select  class="col-12 form-control mr-sm-2" name="unidad_medida[]" required > <option disabled selected value=""> - Seleccione - </option><?php while ($dat = mysqli_fetch_array($consulta_u_medida)) { ?> <option 
                    value = "<?php echo $dat['codigo'] ?>" > <?php echo $dat['nombre'] ?> </option> <?php } ?></select><div class ="invalid-feedback" > Debe elegir una unidad de medida. </div>`;
                    
                  

                      cell4.innerHTML = '<input class="form-control mr-sm-2 col-12" type="date" name="fecha_vencimiento[]" id="fecha_vencimiento[]" required value="<?php echo date("Y-m-d");?>" min="<?php echo date("Y-m-d");?>" max="2025-01-01"> <div class="invalid-feedback"  > Elija una fecha valida. </div>';


                  
                      cell5.innerHTML = `<input name="cantidad[]" required class="form-control mr-sm-2   col-sm-3 col-md-12" type="number" min="0" max="1000000" list="cantidades">
                                <datalist id="cantidades">

                                    <option value="10">

                                    <option value="100">

                                    <option value="1000">

                                    <option value="10000">

                                </datalist> <div class="invalid-feedback"> Debe elegir una cantidad </div>`;;
                      cell6.innerHTML = `<input name="precio_unitario[]" required class="form-control mr-sm-2  col-sm-3 col-md-12" type="number" list="precios" min="0" max="1000000">
                                <datalist id="precios">

                                    <option value="1000">

                                    <option value="10000">

                                    <option value="10000">

                                    <option value="100000">

                                </datalist> 
                                <div class="invalid-feedback"> Debe elegir un precio, no poner signos. </div>`;

                    }

                    function eliminarFila() {
                      var rowCount = myTable.rows.length;
                      if (rowCount <= 1) {
                        alert('No se puede eliminar el encabezado');
                      } else {
                        myTable.deleteRow(rowCount - 1);
                      }

                    }
                  </script>

                </tbody>
              </table>

            </div>
        </form>
      </div>
    </div>


    <div class="container-fluid">
      <center>
        <h1 class="titulo display-4"> Lista de facturas creadas </h1>
      </center>

      <div class="row d-flex justify-content-center">
      
        <table class="table table-hover">
          <thead class="table-primary">
            <tr>
              <th>Codigo Factura </th>
              <th>Codigo Exterior </th>
              <th>Proveedor </th>
              <th>Forma de pago</th>
              <th>Fecha</th>
              <th>Código existencia</th>
              <th>Nombre existencia</th>
              <th>Unidad Medida</th>
              <th>Cantidad</th>
              <th>Precio Unitario</th>
              <th>Precio total</th>
              <th>Eliminar</th>
            </tr>
          </thead>

          <?php
          include "../includes/conexion.php";
          $seleccionar = $conexion->query("SELECT fa.numero , fa.proveedorFactura as 'cExterior', CONCAT(p.nombre, ' ' , p.apellido ) as 'proveedor' , fp.nombre as 'formapago' ,
                                  fa.fecha , m.codigo , m.nombre, u.nombre as'unidadmedida' , fm.cantidad , fm.precio_unitario,
                                  (fm.cantidad * fm.precio_unitario) as 'preciototal'
                                  FROM tblfacturacompra as fa
                                  INNER JOIN tblfacturacompramateriaprima as fm ON fa.numero = fm.factura_compra
                                  INNER JOIN tblproveedor  as p ON fa.proveedor = p.nit
                                  INNER JOIN tblformapago  as fp ON fa.forma_pago = fp.codigo
                                  inner join tblmateriaprima as m on fm.materia_prima = m.codigo
                                  INNER JOIN tblunidadmedida  as u ON m.unidad_medida = u.codigo
                                  ORDER BY fa.numero ASC	");
          while ($datos = $seleccionar->fetch_assoc()) { //$datos = $seleccionar->fetch_assoc()
          ?>
            <tbody>
              <tr>
                <td data-label="Número Factura"> <?php echo $datos['numero']; ?> </td>
                <td data-label="Codigo exterior"> <?php echo $datos['cExterior']; ?> </td>
                <td data-label="Proveedor"><?php echo $datos['proveedor']; ?></td>
                <td data-label="Forma de pago"> <?php echo $datos['formapago']; ?> </td>
                <td data-label="Fecha"> <?php echo $datos['fecha']; ?> </td>
                <td data-label="Código"> <?php echo $datos['codigo']; ?> </td>
                <td data-label="Nombre"> <?php echo $datos['nombre']; ?> </td>
                <td data-label="Unidad Medida"> <?php echo $datos['unidadmedida']; ?> </td>
                <td data-label="Cantidad"> <?php echo $datos['cantidad']; ?> </td>
                <td data-label="Precio Unitario"> <?php echo $datos['precio_unitario']; ?> </td>
                <td data-label="Precio total"> <?php echo $datos['preciototal']; ?> </td>
                <td><a href="borrar.php?numero=<?php echo $datos['numero'] ?>">ELIMINAR</a></td>
              </tr>
            </tbody>
          <?php }
          include "../includes/desconexion.php";

          ?>
        </table>
        <script src="../bootstrap/js/validar_compras.js"></script>
      </div>
    </div>

  </body>

  </html>