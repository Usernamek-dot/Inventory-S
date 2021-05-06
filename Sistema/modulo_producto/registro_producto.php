<?php {
    //   inicializar variables de sesion
    session_start();
    error_reporting(0);

    // si no es correcto no deja entrar a la pagina
    if (empty($_SESSION['rol'])) {
        header('location: ../ingreso/login.php');
    }
}


include("../includes/conexion.php");

// consultas de select

$consulta_categoria =  mysqli_query($conexion, "SELECT codigo , nombre  FROM tblcategoria");
$consulta_u_medida =  mysqli_query($conexion, "SELECT codigo , nombre  FROM tblunidadmedida");
$consulta_precio_pr_ter =  mysqli_query($conexion, "SELECT codigo , precio  FROM tblproductoterminado");
?>

<html>

<head>
    <meta charset="utf-8">
    <link rel="icon" href="../img/logo_prov_pestaña.png" />
    <title> Registrar | Producto Terminado</title>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <!---libreria jquery--->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/css/estilos/producto.css">
    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>

</head>

<body>
    <!-- encabezado -->

    <header class="d-flex justify-content-between">
        <div class="d-flex justify-content-start  mb-3 ">
            <?php include "../includes/btnVolver.php"; ?>
        </div>
        <h1 class="titulo display-4 "> REGISTRAR PRODUCTO TERMINADO</h1>
        <!-- formulario de buscar -->
        <form action="buscar_producto.php" method="post" class="form-inline my-2 my-lg-0 ">
            <input class="form-control mr-sm-2" type="text" placeholder="Buscar" name="busqueda" id="busqueda" aria-label="Search" ata-placement="bottom" data-toggle="tooltip" title="Busque por el código o el nombre del producto">
            <input type="submit" value="Buscar" class="btn-search form-control mr-sm-2">
        </form>
    </header>


    <div class=" row  padre d-flex justify-content-between col-md-12 ">
        <div class=" hijo col-md-12 col-lg-6 col-sm-12">
            <!-- formulario -->
            <form action="guardar_producto.php" method="post" name="formulario" class="needs-validation" novalidate onsubmit="return (e);">
                <div class="form-group row">
                    <label class="col-md-12 col-lg-12  col-form-label">Código:</label><br>
                    <input type="text" name="codigo" id="codigo" class="form-control col-md-12  col-lg-8 rounded " autofocus maxlength="50" minlegth="2" required>
                    <div class="invalid-feedback">
                        Digite un Código.
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 col-lg-12  col-form-label">Nombre:</label><br>
                    <input type="text" name="nombre" id="nombre" class="form-control col-md-12  col-lg-8 rounded " maxlength="50" minlegth="2" required>
                    <div class="invalid-feedback">
                        Digite un Nombre.
                    </div>
                </div>


                <!-------------PONER FECHA ACTUAL  validacion fecha----------->
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
                        document.getElementById('fecha_creacion').value = anio + "-" + mes + "-" + dia;
                    }
                </script>



                <div class="form-group row">
                    <label class="col-md-12 col-lg-12  col-form-label ">Fecha creación:</label><br>
                    <input class="form-control col-md-12  col-lg-8 rounded  " type="date" name="fecha" id="fecha_creacion" value="" readonly required>


                </div>

                <div class="form-group row">
                    <label class="col-md-12 col-lg-12  col-form-label">Fecha de vencimiento:</label><br>
                    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control col-md-12  col-lg-8 rounded" value="<?php echo date("Y-m-d"); ?>" min="<?php echo date("Y-m-d"); ?>" max="2025-01-01">
                    <div class="invalid-feedback">
                        Elija una Fecha de expiración.
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 col-lg-12  col-form-label" for="categoria">Categoría: </label><br>
                    <select name="categoria" id="categoria" class="form-control col-md-12  col-lg-8 rounded " required>
                        <option value="" disabled selected> - Seleccione - </option>
                        <?php
                        while ($datos = mysqli_fetch_array($consulta_categoria)) { //array recorre datos

                        ?>
                            <option value=" <?php echo $datos['codigo'] ?> "> <?php echo $datos['nombre'] ?> </option>
                            <!--me muestra los datos-->
                        <?php  } ?>

                    </select>
                    <div class="invalid-feedback">
                        Elija una categoría.
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 col-lg-12  col-form-label">Unidades disponibles:</label><br>
                    <input type="number" name="unidades_disponibles" id="unidades_disponibles" for="unidades_disponibles" class="form-control col-md-12  col-lg-8 rounded  " maxlength="12" minlegth="2" required>
                    <div class="invalid-feedback">
                        Digite las unidades disponibles.
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-12 col-lg-12  col-form-label" for="unidad_medida">Unidad de medida:</label><br>
                    <select name="unidad_medida" id="unidad_medida" class="form-control col-md-12  col-lg-8 rounded " required>
                        <option value="" disabled selected> - Seleccione - </option>
                        <?php
                        while ($datos = mysqli_fetch_array($consulta_u_medida)) { //array recorre datos

                        ?>
                            <option value=" <?php echo $datos['codigo'] ?> "> <?php echo $datos['nombre'] ?> </option>
                            <!--me muestra los datos-->
                        <?php  } ?>

                    </select>
                    <div class="invalid-feedback">
                        Elija la unidad de medida.
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-12 col-lg-12  col-form-label">Precio del producto:</label><br>
                    <input type="number" name="precio" id="precio" class="form-control col-md-12  col-lg-8 rounded  " list="precios" required="">
                    <!-- sugerencias de opciones -->

                    <datalist id="precios">

                        <option value="1000">

                        <option value="10000">

                        <option value="10000">

                        <option value="100000">

                    </datalist>
                    <div class="invalid-feedback"> Debe digitar un precio.</div>
                </div>
                <div class="form-group inline row justify-content-center">
                    <input type="submit" value="Registrar producto" id="boton" class="btn btn-primary col-11  rounded-pill"><br> <br>
                </div>

            </form>

        </div>
        <!-- imagen -->
        <div class=" img hijo col-lg-6 col-sm-12 col-md-6">
            <img class="img-fluid  " src="../img/modulo producto.png ">
        </div>
    </div>

    <!-- archivo de validacion -->
    <script src="../bootstrap/js/validar_venta_compra.js"></script>


    <!-- lista de productos -->
    <div class="container-fluid">

        <center>
            <h3 class="h3 mb-3 font-weight-normal display-4  "> Inventario de producto terminado </h3>
        </center>

        <div class="row d-flex justify-content-center">
            <div class="col-12">
                <table class="table table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Fecha de creación</th>
                            <th>Fecha de vencimiento</th>
                            <th>Categoría</th>
                            <th>Unidades disponibles</th>
                            <th>Unidad de medida</th>
                            <th>Precio del producto</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <?php

                    include "../includes/conexion.php";
                    $seleccionar = $conexion->query("SELECT c.nombre as 'categoria', um.nombre as 'unidad_medida',pt.codigo,pt.nombre,pt.unidades_disponibles,pt.fecha_vencimiento,pt.fecha_creacion,pt.precio FROM tblproductoterminado as pt INNER JOIN tblunidadmedida as um ON pt.unidad_medida = um.codigo INNER JOIN tblcategoria as c ON pt.categoria = c.codigo where pt.fecha_vencimiento > NOW()");
                    while ($datos = $seleccionar->fetch_assoc()) {   ?>


                        <tbody>
                            <tr>
                                <td data-label="Código"><?php echo $datos['codigo'] ?></td>
                                <td data-label="Nombre"><?php echo $datos['nombre'] ?></td>
                                <td data-label="Feha de creación"><?php echo $datos['fecha_creacion'] ?></td>
                                <td data-label="Fecha de vencimiento"><?php echo $datos['fecha_vencimiento'] ?></td>
                                <td data-label="Categoría"><?php echo $datos['categoria']  ?></td>
                                <td data-label="Unidades disponibles"><?php echo $datos['unidades_disponibles'] ?></td>
                                <td data-label="Unidad medida"><?php echo $datos['unidad_medida']  ?></td>
                                <td data-label="Precio"><?php echo $datos['precio']  ?></td>

                                <td><a href="actualizar_producto.php?codigo=<?php echo $datos['codigo'] ?>">ACTUALIZAR</a></td>
                                <td><a href="borrar_producto.php?codigo=<?php echo $datos['codigo'] ?>">ELIMINAR</a></td>
                            </tr>

                        </tbody>
                    <?php

                    }    //se cierra ciclo while

                    ?>

                </table>
            </div>
        </div>
    </div>
</body>

</html>

<?php

include("../includes/desconexion.php");

?>