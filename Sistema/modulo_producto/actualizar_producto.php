<?php {
//   inicializar variables de sesion
    session_start();
    error_reporting(0);

    // si no es correcto no deja entrar a la pagina
    if (empty($_SESSION['rol'])) {
        header('location: ../ingreso/login.php');
    }
}

require "../includes/conexion.php";
// traer codigo
$codigo = $_REQUEST['codigo'];

// consultas de select
$consulta_categoria =  mysqli_query($conexion, "SELECT codigo , nombre  FROM tblcategoria");
$consulta_u_medida =  mysqli_query($conexion, "SELECT codigo , nombre  FROM tblunidadmedida");

?>
<html>

<head>
    <meta charset="utf-8">
    <link rel="icon" href="../img/logo_prov_pestaña.png" />
    <title> Productos</title>
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

<!-- script para recordar campos requeridos -->
<script type="text/javascript">
    alert("Recuerde actualizar la unidad de medida y la categoria de nuevo.");
    </script>


    <header class="d-flex justify-content-between">
        <div class="d-flex justify-content-start  mb-3 ">
            <?php include "../includes/btnVolver.php"; ?>
        </div>
        <h1 class="titulo display-4 "> ACTUALIZAR PRODUCTO </h1>
    </header>
    <div class="row  padre d-flex justify-content-between">
        <?php
        // crear consulta y recorrerla
        $seleccionar = $conexion->query("SELECT c.nombre as 'categoria',um.nombre as 'unidad_medida',pt.codigo,pt.nombre,pt.unidades_disponibles,pt.fecha_vencimiento,pt.fecha_creacion,pt.precio FROM tblproductoterminado as pt INNER JOIN tblunidadmedida as um ON pt.unidad_medida = um.codigo INNER JOIN tblcategoria as c ON pt.categoria = c.codigo WHERE pt.codigo=" . $codigo);
        

        while ($datos = $seleccionar->fetch_assoc()) {

        ?>
            <div class="   hijo ">
                <div class="col-12 ">

                <!-- formulario -->
                    <form action="update_producto.php" method="post">
                        <div class="form-group row">
                            <label class="col-md-12 col-lg-12  col-form-label ">Código:</label><br>
                            <input type="text" name="codigo" readonly class="form-control col-md-12  col-lg-8 rounded " value="<?php echo $codigo ?>">
                        </div>
                        <div class="form-group row">
                            <label class="col-md-12 col-lg-12  col-form-label ">Nombre:</label><br>
                            <input type="text" name="nombre" class="form-control col-md-12  col-lg-8 rounded  " value="<?php echo $datos['nombre'] ?>">
                        </div>
                        <div class="form-group row">
                            <label class="col-md-12 col-lg-12  col-form-label ">Fecha creación:</label><br>
                            <input type="date" name="fecha_creacion" class="form-control col-md-12  col-lg-8 rounded " value="<?php echo $datos['fecha_creacion'] ?>">
                        </div>
                        <div class="form-group row">
                            <label class="col-md-12 col-lg-12  col-form-label ">Fecha de vencimiento:</label><br>
                            <input type="date" name="fecha_vencimiento" class="form-control col-md-12  col-lg-8 rounded  " value="<?php echo $datos['fecha_vencimiento'] ?>">
                        </div>
                        <div class="form-group row">
                            <label class="col-md-12 col-lg-12  col-form-label ">Unidades disponibles:</label><br>
                            <input readonly type="number" name="unidades_disponibles" class="form-control col-md-12  col-lg-8 rounded " value="<?php echo $datos['unidades_disponibles'] ?>">
                        </div>


                        <div class="form-group row">
                            <label class="col-md-12 col-lg-12  col-form-label" for="categoria">Categoria : </label><br><br>
                            <select required name="categoria" id="categoria" class="form-control col-md-12  col-lg-8 rounded ">
                                <option value="<?php echo $datos['categoria'] ?>"><?php echo $datos['categoria'] ?></option>



                                <?php
                                while ($dato = mysqli_fetch_array($consulta_categoria)) { //array recorre datos
                                ?>
                                    <option value="<?php echo $dato['codigo'] ?>"> <?php echo $dato['nombre'] ?> </option>
                                <?php } ?>

                            </select>
                        </div>



                        <div class="form-group row">
                            <label class="col-md-12 col-lg-12  col-form-label" for="unidad_medida">Unidad de medida : </label><br><br>
                            <select required name="unidad_medida" id="unidad_medida" class="form-control col-md-12  col-lg-8 rounded ">
                                <option value="<?php echo $datos['unidad_medida'] ?>"><?php echo $datos['unidad_medida'] ?></option>
                                <?php

                                while ($dato = mysqli_fetch_array($consulta_u_medida)) { //array recorre datos
                                ?>
                                    <option value="<?php echo $dato['codigo'] ?>"> <?php echo $dato['nombre'] ?> </option>
                                <?php } ?>

                            </select>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-12 col-lg-12  col-form-label">Precio del producto:</label><br>
                            <input  value="<?php echo $datos['precio'] ?>" type="number" name="precio" id="precio" class="form-control col-md-12  col-lg-8 rounded  " list="precios">
                            <!-- sugerencias de opciones -->
                            <datalist id="precios">

                                <option value="1000">

                                <option value="10000">

                                <option value="10000">

                                <option value="100000">

                            </datalist>
                            <div class="invalid-feedback"> Debe elegir un precios </div>`;
                        </div>

                        <div class="form-group inline row justify-content-center">
                            <input type="submit" value="Actualizar producto" id="boton" class="btn btn-primary col-11  rounded-pill"><br> <br>
                        </div>

                    </form>
                </div>
            </div>
            <!-- div de la imagen -->
            <div class="img hijo col-lg-6 col-sm-12 col-md-6 ">
                <img class="img-fluid  " src="../img/modulo producto.png ">
            <?php }  ?>
            </div>
    </div>

</body>

</html>