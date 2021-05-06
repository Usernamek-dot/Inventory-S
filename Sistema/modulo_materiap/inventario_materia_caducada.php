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
    <meta charset="utf-8">
    <title> Entradas | Materia prima</title>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <!---libreria jquery--->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" href="../img/logo_prov_pestaña.png">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/css/estilos/materia_prima.css">
    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>

</head>
<header class="d-flex justify-content-between">
    <div class="d-flex justify-content-start  mb-3 ">
        <?php include "../includes/btnVolver.php"; ?>
    </div>
    <center>
        <h3 class="titulo display-4 ">INVENTARIO DE MATERIA PRIMA CADUCADA </h3>
    </center>
    <form action="buscar.php" method="post" class="form-inline my-2 my-lg-0 ">
        <input class="form-control mr-sm-2" type="text" placeholder="Buscar" name="busqueda" id="busqueda" aria-label="Search" data-placement="bottom" data-toggle="tooltip" title="Busque por el código o el nombre de la materia prima">
        <input type="submit" value="Buscar" class="btn-search form-control mr-sm-2">
    </form>

    <!-- <a href="algoritmo.php" class="mb-3 btn btn-light rounded" data-toggle="tooltip" data-placement="top" 
    title="Disminuir materia prima vencida"><i class="fas fa-virus-slash"></i><a> -->
</header>

<body>
    <br><br><br>
    <div class="row d-flex justify-content-center table-responsive">
        <table class="table table-hover" id="IDlista">
            <thead class="thead-light">

                <th>Código</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Unidad de medida</th>
                <th>Fecha de vencimiento</th>
                <th>Eliminar</th>

                <?php

//fechas mal

                include "../includes/conexion.php";
                $seleccionar = $conexion->query("SELECT mp.codigo as'codigo',mp.nombre as 'nombre',
                    mp.unidades_disponibles as 'cantidad', mp.fecha_vencimiento,
                    um.nombre as 'unidad_medida' 
                     FROM tblmateriaprima as mp INNER JOIN tblunidadmedida as um 
                     ON mp.unidad_medida=um.codigo 
                     where mp.fecha_vencimiento < NOW() 
                      ");
                while ($datos = $seleccionar->fetch_assoc()) {
                ?>
            <tbody>
                <tr>
                    <td data-label="Código" ><?php echo $datos['codigo'] ?></td>
                    <td data-label="Nombre"><?php echo $datos['nombre'] ?></td>

                    <td data-label="Cantidad"><?php echo $datos['cantidad'] ?></td>

                    <td data-label="Unidad Medida"><?php echo $datos['unidad_medida'] ?></td>
                    <td data-label="Fecha de Vecimiento"><?php echo $datos['fecha_vencimiento'] ?></td>
                    <td><a href="borrar_materia_caducada.php?codigo=<?php echo $datos['codigo'] ?>">ELIMINAR</a></td>
                </tr>
            </tbody>
        <?php }   //se cierra ciclo while 
        ?>
        </table>
        <script src="../bootstrap/js/materia.js"></script>
    </div>
</body>




</html>

<?php

include("../includes/desconexion.php");

?>