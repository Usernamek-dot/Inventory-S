<?php {
    session_start();
    error_reporting(0);

    if (empty($_SESSION['rol'])) {
        header('location: ../ingreso/login.php');
    }
}

include "../includes/conexion.php";
$consulta_materia = mysqli_query($conexion, "SELECT  materia.unidades_disponibles as 'unidades_disponibles' ,  materia.codigo as 'codigo' , materia.nombre as 'nombre' FROM tblmateriaprima as materia where fecha_vencimiento > NOW()");
$consulta_producto = mysqli_query($conexion, "SELECT codigo, nombre , estado FROM tblproductoterminado WHERE estado = 0");
$consulta_usuario = mysqli_query($conexion, "SELECT documento ,  CONCAT (nombres, ' ' , apellidos ) as 'nombre' FROM tblusuario");



?>
<html>

<head>
    <link rel="icon" href="../img/logo_prov_pestaña.png" />
    <title>Registrar | Receta </title>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <!---libreria jquery--->
    <meta charset="utf-8">
    <!-- LINK MEDIA QUERYS importante ! -->
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/css/estilos/receta.css">
    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../bootstrap/js/jquery-3.5.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>
    <script src="../bootstrap/js/validar_venta_compra.js"></script>


</head>

<body>

    <?php
    echo '<script type="text/javascript">
    alert("Recuerde NO registrar un ingrediente dos veces en la lista de ingredientes. Cada ingrediente que registre en la lista debe ser diferente, de  lo contrario la receta no se registrará propiamente.");
    </script>';
    ?>

    <header class="d-flex justify-content-between ">
        <div class="d-flex justify-content-start  mb-3">
            <?php include "../includes/btnVolver.php"; ?>
        </div>
        <h1 class="titulo display-4 "> CREAR RECETA </h1>
        <form action="buscar.php" method="post" class="  form-inline my-2 my-lg-0 ">
            <input class="form-control mr-sm-2" type="text" placeholder="Buscar" name="busqueda" id="busqueda" aria-label="Search" ata-placement="bottom" data-toggle="tooltip" title="Busque por el número , empleado o el nombre del producto">
            <input type="submit" value="Buscar" class="btn-search form-control mr-sm-2">
        </form>
    </header>

    <!------------FORMULARIO------------->
    <div class="container-fluid">
        <form method="post" action="guardar.php " class="col-12 needs-validation" novalidate name="formulario">
            <!---ENCABEZADO --->
            <div class="row border encabezado">
                <div class="col-12  col-sm-12  col-md-12 col-lg-3 ">
                    <input type="submit" class="btn btn-primary button" value="CREAR RECETA" id="boton">
                </div>

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

                <div class="col-12  col-sm-12  col-md-12 col-lg-3">
                    <div class="form-group row ">
                        <label class=" col-lg-6 col-sm-12 col-md-12  "> Fecha:</label>
                        <input required class="form-control mr-sm-2 col-lg-6 col-md-12 " type="date" name="fecha" id="fechaActual" value="" readonly>

                    </div>
                </div>

                <div class="col-12  col-sm-12  col-md-12 col-lg-3">
                    <div class="form-group row ">
                        <label class=" col-lg-6 col-sm-12  col-md-12"> Producto:</label>
                        <select required name="producto" class="col-md-12 col-lg-6 form-control mr-sm-2 ">
                            <option disabled selected value=""> - Seleccione - </option>
                            <?php
                            while ($datos = mysqli_fetch_array($consulta_producto)) { //array recorre datos 
                            ?>
                                <option value="<?php echo $datos['codigo'] ?>"> <?php echo $datos['nombre'] ?> </option>

                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">
                            Elija un producto.
                        </div>
                    </div>
                </div>
                <div class="col-12  col-sm-12  col-md-12 col-lg-3">
                    <div class="form-group row ">
                        <label class=" col-lg-6 col-sm-12  "> Empleado:</label>
                        <select required name="usuario" class=" col-md-12 col-lg-6 form-control mr-sm-2 ">
                            <option disabled selected value=""> - Seleccione - </option>
                            <?php
                            while ($datos = mysqli_fetch_array($consulta_usuario)) { //array recorre datos
                            ?>
                                <option value="<?php echo $datos['documento'] ?>"> <?php echo $datos['nombre'] ?> </option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">
                            Elija un empleado.
                        </div>
                    </div>
                </div>
                <!---BOTONES Y TITULO--->
                <h1 class="titulo display-4 d-flex justify-content-center"> Ingredientes </h1>

                <div class="container-fluid d-flex justify-content-between">

                    <div class="row">
                        <div class="boton">
                            <button type="button" class=" button btn btn-primary rounded-pill " onclick="agregarFila()" data-placement="top" data-toggle="tooltip" title="pulse aquí para agregar una fila a la tabla ingredientes"> Agregar fila</button>

                        </div>

                        <div class="boton">
                            <button type="button" class="button  btn btn-primary rounded-pill " data-placement="bottom" data-toggle="tooltip" title="pulse aquí para eliminar una fila a la tabla ingredientes" onclick="eliminarFila()"> Eliminar fila</button>

                        </div>
                    </div>
                </div>



                <!---TABLA--->

                <div class="container-fluid row">

                    <div class="col-lg-9  col-fluid">
                        <table class="table">
                            <thead class="thead-light ">
                                <tr>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                    <th>Unidades disponibles</th>

                                </tr>
                            </thead>
                            <tbody>



                                <!-- script donde sea crean filas apartir del boton agregarFila -->
                                <script>
                                    var myTable = document.querySelector("table");

                                                                        function agregarFila() {

                                    var row = myTable.insertRow(myTable.rows.length);
                                    var cell1 = row.insertCell(0);
                                    var cell2 = row.insertCell(1);
                                    var cell3 = row.insertCell(2);
                                    var cell4 = row.insertCell(3);



                                    cell1.innerHTML = `<input required type="text"  name="nombre[]"  class="form-control mr-sm-2 " disabled >`;
                                    cell2.innerHTML = `<select required  class="col-12 form-control mr-sm-2 "
                                            name="materia[]" id='opciones' onchange="cambioOpciones1(), cambioOpciones()" >
                                    <option disabled selected value=""> - Seleccione - </option>
                                    <?php
                                    while ($d = mysqli_fetch_array($consulta_materia)) {  //array recorre dat
                                    ?>

                                    <option value="<?php echo $d['codigo'] ?>"

                                    data-nombre1="<?php echo $d['unidades_disponibles'] ?>"
                                                            data-nombre="<?php echo $d['codigo'] ?>"
                                                            
                                                    
                                                            
                                    > <?php echo $d['nombre'] ?></option>

                                    <?php  } ?>
                                    </select>
                                    <div class="invalid-feedback">Elija un ingrediente. </div>`;



                                        cell3.innerHTML = `<input required  class="form-control mr-sm-2 col-12" type="number" placeholder="Ingrese cantidad"   id="cantidad" name="cantidad[]">   <div class="invalid-feedback">Escriba una cantidad.</div>`;;

                                    cell4.innerHTML = `<input  disabled name="unidades_disponibles[]"   class="form-control mr-sm-2 col-sm-3 col-md-12" type="number">
                                    <div class="invalid-feedback"> Debe elegir una cantidad </div>`;;


                                    }


                                    function eliminarFila() {
                                        var rowCount = myTable.rows.length;
                                        if (rowCount <= 2) {
                                            alert('No se puede eliminar el encabezado , debe haber al menos un ingrediente para crear la receta');
                                        } else {
                                            myTable.deleteRow(rowCount - 2);
                                        }

                                    }
                                    //  AUTOCOMPLETADO DE NOMBRE
                                    function cambioOpciones() {
                                        //el evento siempre esta disponible en la función
                                        //event.target -> elemento que disparó el evento ( select name= materia)
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
                                        tr.querySelector('[name="nombre[]"]').value = value;

                                    }

                                    function cambioOpciones1() {
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
                    <div class="col-lg-3 col-md-12 col-fluid">
                        <div class="input-group mb-3">
                            <!---- clase para que el icono este pegado al input------>
                            <div class="input-group-prepend">
                                <i class="fas fa-pencil-ruler input-group-text"></i>
                            </div>
                            <textarea required class="form-control" placeholder="Descripción" name="descripcion" cols="30" rows="10"></textarea>
                            <div class="invalid-feedback">
                                Escriba una descripcion.
                            </div>
                        </div>
                    </div>

                </div>
        </form>
    </div>


    </div>

    <!-------------------LISTA------------->

    <div class="container-fluid">
        <center>
            <h1 class="titulo display-4"> Lista de Recetas</h1>
        </center>

        <div class="row d-flex justify-content-center">
            <div class="col-12">
                <table class="table table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Número</th>
                            <th>Fecha </th>
                            <th>Empleado</th>
                            <th>Producto</th>
                            <th>Actualizar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <?php




                    $seleccionar = $conexion->query("SELECT
                r.codigo as 'codigo',
                r.fecha,
                CONCAT(u.nombres,' ',u.apellidos) as 'nombre',
                p.nombre as 'producto' 
                FROM
                tblreceta as r INNER JOIN tblusuario as u ON r.usuario=u.documento
                 INNER JOIN tblproductoterminado as p on r.producto = p.codigo ");
                    while ($datos = $seleccionar->fetch_assoc()) {
                    ?>
                        <tbody>
                            <tr>
                                <td> <?php echo $datos['codigo']; ?> </td>
                                <td> <?php echo $datos['fecha']; ?> </td>
                                <td> <?php echo $datos['nombre']; ?> </td>
                                <td> <?php echo $datos['producto']; ?> </td>


                                <td><a href="actualizar.php?codigo=<?php echo $datos['codigo'] ?>">ACTUALIZAR</a></td>
                                <td><a href="borrar_receta.php?codigo=<?php echo $datos['codigo'] ?>">ELIMINAR</a></td>
                            </tr>
                        </tbody>
                    <?php
                    }  //se cierra ciclo while
                    include "../includes/desconexion.php";
                    ?>
                </table>
            </div>
        </div>
    </div>


    </div>
    <!-- <script src="../bootstrap/js/validar_receta.js"></script> -->

</body>

</html>