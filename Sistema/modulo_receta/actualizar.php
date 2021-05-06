<?php {
    session_start();
    error_reporting(0);

    if (empty($_SESSION['rol'])) {
        header('location: ../ingreso/login.php');
    }
}

require "../includes/conexion.php";

$codigo = $_REQUEST['codigo'];


//CONSULTAS PARA TRAER DATOS DE LA BD
$consulta_producto =  mysqli_query($conexion, "SELECT codigo , nombre FROM tblproductoterminado");
$consulta_usuario =  mysqli_query($conexion, "SELECT documento , CONCAT (nombres, ' ' , apellidos ) as 'nombre' FROM tblusuario");

//CONSULTA PARA TRAER LOS DATOS DE LA RECETA 

$seleccionar = $conexion->query("SELECT
r.codigo as codigo,
r.fecha ,
r.descripcion as descripcion,
CONCAT(u.nombres,' ',u.apellidos) as usuario,
p.nombre as producto
FROM
tblreceta as r INNER JOIN tblusuario as u ON r.usuario=u.documento
 INNER JOIN tblproductoterminado as p on r.producto = p.codigo
--   INNER JOIN tblmateriaprima as m on 
WHERE r.codigo=" . $codigo);


if ($datos = $seleccionar->fetch_assoc()) {
}



?>

<!DOCTYPE html>
<html>

<head>
    <title> Producción | Actualizar receta </title>
    <link rel="icon" href="../img/logo_prov_pestaña.png" />
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>
    <!-- LINK MEDIA QUERYS importante ! -->
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <!---libreria jquery--->
    <meta charset="utf-8">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/css/estilos/proveedor.css">

    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../bootstrap/js/jquery-3.5.1.min.js"></script>

</head>

<body>

    <?php
    echo '<script type="text/javascript">
	alert("Debe actualizar el campo producto y el campo empleado .");
	</script>';
    ?>

    <header class="d-flex justify-content-between">
        <div class="d-flex justify-content-start  mb-3 ">
            <!--------BOTON VOLVER  CON SESIONES----->
            <?php include "../includes/btnVolver.php"; ?>
        </div>
        <h1 class="titulo display-4"> ACTUALIZAR RECETA </h1>
    </header>

    <div class="padre row d-flex justify-content-between">


        <div class="hijo">

            <form action="update.php" method="post">
                <!-- traer el codigo autoincremental -->
                <input type="hidden" name="codigo" value="<?php echo $datos['codigo'] ?>">


                <div class="form-group row">
                    <label class=" col-lg-6 col-sm-12 "> Fecha:</label>
                    <input value="<?php echo $datos['fecha'] ?>" class="form-control mr-sm-2 col-lg-12 " type="date" name="fecha">
                </div>
                <div class="form-group row">
                    <label class=" col-lg-6 col-sm-12 "> Empleado:</label>
                    <select name="usuario" class="col-lg-12 form-control mr-sm-2 ">
                        <option disabled selected value="<?php echo $datos['usuario'] ?>"> <?php echo $datos['usuario'] ?> </option>
                        <?php
                        while ($dato = mysqli_fetch_array($consulta_usuario)) { //array recorre datos
                        ?>
                            <option value="<?php echo $dato['documento'] ?>"> <?php echo $dato['nombre'] ?> </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group row">
                    <label class=" col-lg-6 col-sm-12 "> Producto:</label>
                    <select name="producto" class="col-lg-12 form-control mr-sm-2 ">
                        <option disabled selected value="<?php echo $datos['producto'] ?>"> <?php echo $datos['producto'] ?> </option>
                        <?php
                        while ($dato = mysqli_fetch_array($consulta_producto)) { //array recorre datos
                        ?>
                            <option value="<?php echo $dato['codigo'] ?>"> <?php echo $dato['nombre'] ?> </option>
                        <?php } ?>
                    </select>
                </div>
                <label> Descripcion de la receta :</label>

                <div class="form-group row">
                    <div class="input-group mb-3">
                        <!---- clase para que el icono este pegado al input------>
                        <div class="input-group-prepend">
                            <i class="fas fa-pencil-ruler input-group-text"></i>
                        </div>
                        <textarea type="text" class="form-control" name="descripcion" cols="30" rows="10">
                        <?php echo $datos['descripcion'] ?>
                        </textarea>
                    </div>
                </div>

                <div class="row justify-content-center">

                    <button type="submit" class="btn btn-primary col-6  rounded-pill"> ACTUALIZAR RECETA</button>
                </div>
            </form>
        </div>
        <div class="hijo">

            <img class="img-fluid" src="../img/proveedor.png">

        </div>
    </div>



</body>

</html>