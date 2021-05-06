  <?php {
    // variables de sesion
    session_start();
    error_reporting(0);

// validacion de variable
    if (empty($_SESSION['rol'])) {
      header('location: ../ingreso/login.php');
    }
  }

  include "../includes/conexion.php";

// consultas de los select
  $consulta_usuario = mysqli_query($conexion, "SELECT documento , nombres  FROM tblusuario");
  $consulta_receta = mysqli_query($conexion, "SELECT r.codigo , pdt.nombre as 'producto', r.descripcion  FROM tblreceta as r  inner join tblproductoterminado as pdt on r.producto =  pdt.codigo");



  ?>

  <html>

  <head>
    <link rel="icon" href="../img/logo_prov_pestaña.png" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title> Produccion | Orden </title>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <!---libreria jquery--->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/css/estilos/r_produccion.css">
    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../bootstrap/js/jquery-3.5.1.min.js"></script>
    <!-- <script src="../bootstrap/js/validar_produccion.js"></script> -->
    <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>
    <script src="../bootstrap/js/validar_venta_compra.js"></script>

  </head>

  <body>
    <header class="d-flex justify-content-between">
      <div class="justify-content-start  mb-3 ">

        <?php include "../includes/btnVolver.php"; ?>
      </div>


      <h1 class="titulo display-4 "> CREAR ORDEN DE PRODUCCIÓN </h1>
      <form action="buscar.php" method="post" class="form-inline my-2 my-lg-0 ">
        <input class="form-control mr-sm-2" type="text" placeholder="Buscar" name="busqueda" id="busqueda" aria-label="Search" ata-placement="bottom" data-toggle="tooltip" title="Busque por el código, el nombre del empleado o el nombre del producto">
        <input type="submit" value="Buscar" class="btn-search form-control mr-sm-2">
      </form>

    </header>

    <div class="container-fluid">

      <div class="row div border border-primary factura">

<!-- formulario -->

        <form name="formulario" action="guardar_produccion.php" method="post" class="container needs-validation" novalidate>
          <div class="d-flex justify-content-center row">



            <div class="col-sm-12 col-lg-3 col-md-12">
              <div class="form-group row ">
                <label class="col-12"> Empleado:</label>
                <select id="usuario" name="usuario" class=" form-control mr-sm-2 " required>
                  <option value="" disabled selected>- Seleccione </option>
                  <?php
                  while ($datos = mysqli_fetch_array($consulta_usuario)) { //array recorre datos
                  ?>
                    <option value="<?php echo $datos['documento'] ?>"> <?php echo $datos['nombres'] ?> </option>
                  <?php } ?>
                </select>
                <div class="invalid-feedback"> Debe elegir un empleado. </div>
              </div>
            </div>
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


            <div class=" col-lg-2 col-12 col-md-12">
              <div class="form-group  ">
                <label class=" col-12"> Fecha:</label>
                <input required class="form-control mr-sm-2 col-12" type="date" name="fecha" id="fechaActual" value="" readonly>
              </div>
            </div>
            <div class=" col-xs-6 col-lg-2 col-md-5 col-sm-6">
              <div class="row ">
                <div class="  col-xs-6  col-lg-12 col-md-6 col-sm-7 ">
                  <button type="button" class="btn btn-primary rounded-pill button " onclick="agregarFila()" data-placement="top" data-toggle="tooltip" title="pulse aquí para agregar una fila a la tabla inferior">
                    Agregar fila</button>
                </div>
                <div class=" col-xs-6 col-lg-12 col-md-6 col-sm-7">
                  <button type="button" class="btn btn-primary  rounded-pill button" onclick="eliminarFila()" data-placement="bottom" data-toggle="tooltip" title="pulse aquí para eliminar una fila a la tabla inferior">
                    Eliminar fila</button>
                </div>
              </div>
            </div>
            <div class=" col-xs-6 col-lg-2 col-md-7 col-sm-6">

              <input type="submit" class="btn btn-primary button" value="CREAR ORDEN" id="boton">
            </div>
          </div>
          <div class="col-12">
            <table class="table">

              <thead class="table-primary">

                <tr>
                  <th>Código de la receta</th>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>Descripción</th>
                </tr>
              </thead>
              <tbody>
              <!-- script para insertar y eliminar filas en la tabla dinamica -->
                <script>
                  var myTable = document.querySelector("table");

                  function agregarFila()

                  { 

                    var row = myTable.insertRow(myTable.rows.length);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);



                    cell1.innerHTML = '<input  disabled   name="producto[]"  type="text"  min="1" class="col-12 form-control mr-sm-2" ></input>';


                    cell2.innerHTML = `<select   name="receta[]" class="col-12 form-control mr-sm-2" onchange="cambioOpciones1(), cambioOpciones()" required>
                                                   <option value="" disabled selected> - Seleccione - </option>
                                                   <?php

                                                    while ($datos = mysqli_fetch_array($consulta_receta)) {
                                                    ?>
                                                              <option value="<?php echo $datos['codigo'] ?>"
                                                               data-nombre="<?php echo $datos['codigo'] ?>"
                                                               data-nombre1="<?php echo $datos['descripcion'] ?>">

                                                               <?php echo $datos['producto'] ?>  </option>
                                                                <?php } ?>
                                                                </select>
                                                                <div class="invalid-feedback"> Debe un producto </div> `;

                    cell3.innerHTML = `<input name="cantidad[]" required class="form-control mr-sm-2   col-sm-3 col-md-12" type="number" min="0" max="1000000" list="cantidades">
                                <datalist id="cantidades">

                                    <option value="10">

                                    <option value="100">

                                    <option value="1000">

                                    <option value="10000">

                                </datalist>

                                <div class="invalid-feedback"> Debe elegir una cantidad </div>`;

                    cell4.innerHTML = ' <textarea required disabled  name="descripcion[]" class="col-12 form-control mr-sm-2"  cols="30" rows="2" >  </textarea>   ';
                  
                  }

                  function eliminarFila() {
                    var rowCount = myTable.rows.length;
                    if (rowCount <= 1) {
                      alert('No se puede eliminar el encabezado');
                    } else {
                      myTable.deleteRow(rowCount - 1);
                    }

                  }


                  //  AUTOCOMPLETADO DE NOMBRE
                  function cambioOpciones() {
                    //el evento siempre esta disponible en la función
                    //event.target -> elemento que disparó el evento ( select name= receta)
                    let sel = event.target;
                    //definir valor inicial
                    let value = '';
                    //si se selecciona una opción...
                    if (event.target.value) {
                      //tomar el nombre desde el atributo data-nombre de la opción seleccionada
                      value = sel.options[sel.selectedIndex].dataset.nombre;
                    }
                    // Obtener fila a la que pertenece el select
                    let tr = sel.closest('tr');
                    // Obtener campo desde TR, por atributo name y asignar valor
                    tr.querySelector('[name="producto[]"]').value = value;


                  }

                  function cambioOpciones1() {
                    //el evento siempre esta disponible en la función
                    //event.target -> elemento que disparó el evento ( select name= receta)
                    let sel = event.target;
                    //definir valor inicial
                    let value = '';
                    //si se selecciona una opción...
                    if (event.target.value) {
                      //tomar el nombre desde el atributo data-nombre de la opción seleccionada
                      value = sel.options[sel.selectedIndex].dataset.nombre1;
                    }
                    // Obtener fila a la que pertenece el select
                    let tr = sel.closest('tr');
                    // Obtener campo desde TR, por atributo name y asignar valor
                    tr.querySelector('[name="descripcion[]"]').value = value;


                  }

              

                </script>
              </tbody>
            </table>
          </div>
        </form>

      </div>

      <div class="container-fluid">
        <center>
          <h1 class="titulo display-4"> Lista de Producción</h1>
        </center>

        <div class="row d-flex justify-content-center">
          <div class="col-11">

          <!-- tabla que muestra la lista -->
            <table class="table table-hover">
              <thead class="table-primary">
                <tr>
                  <th>Codigo de la factura</th>
                  <th>Fecha</th>
                  <th>Empleado</th>
                  <th>Producto </th>
                  <th>Código de la receta</th>
                  <th>Cantidad</th>
                  <th>Descripción</th>
                  <th>Eliminar</th>
                </tr>
              </thead>


              <?php
              include "../includes/conexion.php";

              // query que trae los datos
              $seleccionar = $conexion->query("SELECT pdc.codigo, pdc.fecha , CONCAT(u.nombres, ' ' , u.apellidos ) as 'empleado' , pdt.nombre as 'producto', r.codigo as 'receta',
                              pr.cantidad , r.descripcion
                                From tblproduccion as pdc inner join tblusuario as u on u.documento = pdc.usuario
                Inner join tblproduccionreceta as pr on pdc.codigo=pr.cod_produccion inner join tblreceta as r on pr.cod_receta=r.codigo
                Inner join tblproductoterminado as pdt on r.producto =  pdt.codigo");
              while ($datos = $seleccionar->fetch_assoc()) {
              ?>
                <tbody>
                  <tr>
                    <td data-label="Código"> <?php echo $datos['codigo']; ?> </td>
                    <td data-label="Fecha"> <?php echo $datos['fecha']; ?> </td>
                    <td data-label="Empleado"> <?php echo $datos['empleado']; ?> </td>
                    <td data-label="Producto"> <?php echo $datos['producto']; ?> </td>
                    <td data-label="Receta"> <?php echo $datos['receta']; ?> </td>
                    <td data-label="Cantidad"> <?php echo $datos['cantidad']; ?> </td>
                    <td data-label="Descripción">
                      <div class="limitetd"><?php echo $datos['descripcion']; ?> .... </div>
                    </td>

                    <td><a href="borrar.php?codigo=<?php echo $datos['codigo'] ?>">ELIMINAR</a></td>
                  </tr>
                </tbody>
              <?php
              } //cerrar while
              include "../includes/desconexion.php";
              ?>
            </table>
          </div>
        </div>
      </div>


    </div>

  </body>

  </html>