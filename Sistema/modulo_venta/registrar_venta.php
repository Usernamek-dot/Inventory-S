<?php {

    //iniciar sesion
    session_start();
    error_reporting(0);
    //validar si la sesion esta activa
    if (empty($_SESSION['rol'])) {
        header('location: ../ingreso/login.php');
    }
}




include "../includes/conexion.php";


// consultas de selects
$consulta_cliente = mysqli_query($conexion, "SELECT documento , concat(nombres,' ',apellidos) as 'nombre' FROM tbl_cliente");
$consulta_f_pago = mysqli_query($conexion, "SELECT codigo , nombre FROM tblformapago");
$consulta_producto = mysqli_query($conexion, "SELECT codigo , nombre, precio as 'precio_unitario', unidades_disponibles  FROM tblproductoterminado  where fecha_vencimiento > NOW()  ");

$consulta_U_producto =  mysqli_query($conexion, "SELECT  unidades_disponibles  FROM tblproductoterminado  where fecha_vencimiento > NOW()  ");

$consulta_categoria = mysqli_query($conexion, "SELECT codigo , nombre FROM tblcategoria ");
?>
<html>

<head>
    <meta charset="utf-8">
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <link rel="icon" href="../img/logo_prov_pestaña.png" />
    <title>Salidas | ventas </title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/css/estilos/compra.css">
    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>
    <!-- LINK MEDIA QUERYS importante ! -->
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="../bootstrap/js/validar_venta_compra.js"></script>



</head>

<body>

    <!-- codigo de alerta para no repetir productos -->
    <?php
    echo '<script type="text/javascript">
    alert("Recuerde NO repetir productos a la hora de crear una factura de venta. En cada fila ingrese un producto diferente.");
    </script>';
    ?>

    <header class="d-flex justify-content-between">
        <div class="d-flex justify-content-start  mb-3 x">
            <!-- -------BOTON VOLVER  CON SESIONES--- -->
            <?php include "../includes/btnVolver.php"; ?>
        </div>
        <h1 class="titulo display-4 "> FACTURAS DE VENTA </h1>
        <form action="buscar.php" method="post" class="form-inline my-2 my-lg-0 ">
            <input class="form-control mr-sm-2" type="text" placeholder="Buscar factura" name="busqueda" id="busqueda" aria-label="Search" data-placement="bottom" data-toggle="tooltip" title="Busque por el número o fecha de la factura">
            <input type="submit" value="Buscar" class="btn-search form-control mr-sm-2">
        </form>
    </header>



    <div class="container-fluid">
        <div class=" div border border-primary factura">
            <form method="post" action="guardar_venta.php " name="formulario" id="cantidad_filas" class="needs-validation" novalidate>
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


                    <div class=" col-lg-3 col-12 col-md-12">
                        <div class="form-group  ">
                            <label class=" col-12"> Fecha:</label>
                            <input class="form-control mr-sm-2 col-12" type="date" name="fecha" id="fechaActual" value="" readonly>
                        </div>
                    </div>


                    <div class=" col-lg-2 col-12 col-md-12">
                        <div class="form-group ">
                            <label class=" col-12"> Cliente:</label>
                            <select required name="cliente" class="form-control mr-sm-2 col-12">
                                <option disabled selected value=""> - Seleccione - </option>
                                <?php while ($datos = mysqli_fetch_array($consulta_cliente)) { //array recorre datos
                                ?>
                                    <option value="<?php echo $datos['documento'] ?>"> <?php echo $datos['nombre'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback">
                                Elija un cliente.
                            </div>
                        </div>
                    </div>


                    <div class=" col-lg-2 col-12 col-md-12">
                        <div class="form-group  ">
                            <label class=" col-12 ">Forma de pago:</label>
                            <select required class="col-12 form-control mr-sm-2" name="forma_pago">
                                <option disabled selected value=""> - Seleccione - </option>
                                <?php
                                while ($datos = mysqli_fetch_array($consulta_f_pago)) { //array recorre datos
                                ?>
                                    <option value="<?php echo $datos['codigo'] ?>"> <?php echo $datos['nombre'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback">
                                Eliga una forma de pago.
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-lg-2 col-md-5 col-sm-6 ">
                        <div class="row ">
                            <div class=" col-xs-6 col-lg-12 col-md-6 col-sm-7 ">
                                <button type="button" class="button btn btn-primary rounded-pill " onclick="agregarFila()" data-placement="top" data-toggle="tooltip" title="pulse aquí para agregar una fila a la tabla inferior">
                                    Agregar fila</button>
                            </div>
                            <div class=" col-xs-6 col-lg-12 col-md-6 col-sm-7 ">
                                <button type="button" class="button btn btn-primary  rounded-pill" onclick="eliminarFila()" data-placement="bottom" data-toggle="tooltip" title="pulse aquí para eliminar una fila a la tabla inferior">
                                    Eliminar fila</button>
                            </div>
                        </div>
                    </div>
                    <div class=" col-xs-6 col-lg-2 col-md-7 col-sm-6 ">
                        <input type="submit" class=" btn btn-primary button" value="CREAR FACTURA" id="boton">
                    </div>
                </div>

                <div class="col-12">

                    <!-- tabla dinamica -->
                    <table class="table">

                        <thead class="table-primary">
                            <tr>
                                <th>Código producto</th>
                                <th>Nombre producto</th>
                                <th>Cantidad</th>
                                <th>Unidades disponibles</th>
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


                                    cell1.innerHTML = `<input name="nombre[]"   disabled required  type="text"  class="form-control mr-sm-2  col-sm-3 col-md-12 " > <div class="invalid-feedback"> Eliga un producto.</div>`;
                                    cell2.innerHTML = `<select required  class=" col-sm-3 col-md-12 form-control mr-sm-2 " name="codigo[]" id='opciones' onchange="cambioOpciones2(), cambioOpciones1(), cambioOpciones()" required>
                                    <option disabled selected value=""> - Seleccione - </option>
                                    <?php

                                    while ($d = mysqli_fetch_array($consulta_producto)) { //array recorre dat
                                    ?>
                                    <option value="<?php echo $d['codigo'] ?>"

                                                               data-nombre="<?php echo $d['codigo'] ?>"
                                                               data-nombre2="<?php echo $d['unidades_disponibles'] ?>"
                                                               data-nombre1="<?php echo $d['precio_unitario'] ?>"
                                                               
                                    >
                                            <?php echo $d['nombre'] ?>

                                        </option>


                                    <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">Elija un codigo  producto.</div>`;
                                    <?php
                                    while ($cant = mysqli_fetch_array($consulta_U_producto)) { //array recorre dat
                                    ?>

                                        cell3.innerHTML = `<input  max="<?= $cant['unidades_disponibles'] ?>" name="cantidad[]"  required class="form-control mr-sm-2 col-sm-3 col-md-12" type="number" min="0"  list="cantidades">
                                <datalist id="cantidades">

                                    <option value="10">

                                    <option value="100">

                                    <option value="1000">

                                    <option value="10000">

                                </datalist> <div class="invalid-feedback"> Debe elegir una menor cantidad  existente </div>`;;
                                    <?php } ?>

                                    cell4.innerHTML = `<input  disabled name="unidades_disponibles[]"   class="form-control mr-sm-2 col-sm-3 col-md-12" type="number">
                                 <div class="invalid-feedback"> Debe elegir una cantidad </div>`;;
                                    cell5.innerHTML = `<input name="precio_unitario[]" disabled required class="form-control mr-sm-2  col-sm-3 col-md-12" type="number"  min="0" max="1000000">
                            
                            <div class="invalid-feedback"> Debe elegir un precio </div>`;


                                }



                                function eliminarFila() {
                                    var rowCount = myTable.rows.length;
                                    if (rowCount <= 1) {
                                        alert('No se puede eliminar el encabezado');
                                    } else {
                                        myTable.deleteRow(rowCount - 1);
                                    }

                                }



                                //  AUTOCOMPLETADO 
                                function cambioOpciones() {
                                    //el evento siempre esta disponible en la función
                                    //event.target -> elemento que disparó el evento ( select name)
                                    let sel = event.target;
                                    // Definir valor inicial
                                    let value = '';
                                    // Si se seleccionó una opción
                                    if (event.target.value) {
                                        // Tomar nombre desde data-nombre de la opción seleccionada
                                        value = sel.options[sel.selectedIndex].dataset.nombre;
                                    }
                                    // Obtener fila a la que pertenece el select
                                    let tr = sel.closest('tr');

                                    // Obtener campo desde TR, por atributo name y asignar valor
                                    tr.querySelector('[name="nombre[]"]').value = value;

                                }



                                function cambioOpciones1() {
                                    //el evento siempre esta disponible en la función
                                    //event.target -> elemento que disparó el evento ( select name)
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
                                    tr.querySelector('[name="precio_unitario[]"]').value = value;
                                }

                                function cambioOpciones2() {
                                    //el evento siempre esta disponible en la función
                                    //event.target -> elemento que disparó el evento ( select name)
                                    let sel = event.target;
                                    // Definir valor inicial
                                    let value = '';
                                    // Si se seleccionó una opción
                                    if (event.target.value) {
                                        // Tomar nombre desde data-nombre de la opción seleccionada
                                        value = sel.options[sel.selectedIndex].dataset.nombre2;
                                    }
                                    // Obtener fila a la que pertenece el select
                                    let tr = sel.closest('tr');

                                    // Obtener campo desde TR, por atributo name y asignar valor
                                    tr.querySelector('[name="unidades_disponibles[]"]').value = value;






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
            <div class="col-12">
                <!-- lista de facturas de ventas -->
                <table class="table table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Número</th>
                            <th>Producto</th>
                            <th>Cliente </th>
                            <th>Fecha</th>
                            <th>Forma de pago</th>
                            <th>Precio Total</th>
                        </tr>
                    </thead>
                    <?php

                    include "../includes/conexion.php";
                    // consulta para traer todos los datos
                    $seleccionar = $conexion->query("SELECT fv.numero , CONCAT(c.nombres , ' ' , c.apellidos ) as 'cliente' ,
fp.nombre as 'formapago' , pt.nombre as 'producto', pt.unidades_disponibles as 'cantidad',
fv.fecha , (fvpt.cantidad * pt.precio) as 'preciototal'
FROM tblfacturaventa as fv
INNER JOIN tblfacturventaproducto as fvpt ON fv.numero = fvpt.factura_venta
INNER JOIN tbl_cliente  as c ON fv.cliente = c.documento
INNER JOIN tblformapago  as fp ON fv.forma_pago = fp.codigo
inner join tblproductoterminado as pt on fvpt.producto = pt.codigo
ORDER BY fv.numero ASC");

                    while ($datos = $seleccionar->fetch_assoc()) {
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
                    } //se cierra ciclo while
                    include "../includes/desconexion.php";
                    ?>
                </table>
            </div>
        </div>
    </div>


</body>

</html>