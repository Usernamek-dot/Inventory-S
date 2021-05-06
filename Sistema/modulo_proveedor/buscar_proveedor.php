<?php
// trae variable conexion
include '../includes/conexion.php';

?>

<html>

<head>
    <title> Proveedor | Buscando...</title>
    <meta charset="utf-8">
    <link rel="icon" href="../img/logo_prov_pestaña.png" />
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <!---libreria jquery--->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/css/estilos/proveedor.css">
    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../bootstrap/js/jquery-3.5.1.min.js"></script>
    <script src="../bootstrap/js/validar_poveedor.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php
    // variable de busqueda
    $busqueda = strtolower($_REQUEST['busqueda']);
    // validar si esta vacia no permitiendo entrar al archivo de buscar
    if (empty($busqueda)) {
        header("location:registro_proveedor.php");
    }

    ?>
    <header class="d-flex justify-content-between">
        <div class="d-flex justify-content-start  mb-3 ">

            <?php include "../includes/btnVolver.php"; ?>
        </div>
        <center>
            <h1 class=" titulo display-4">BUSCANDO PROVEEDOR...</h1>
        </center>
        <!-- formulario buscar -->
        <form action="buscar_proveedor.php" method="post" class="form-inline my-2 my-lg-0 ">
            <input class="form-control mr-sm-2" type="text" placeholder="Buscar" name="busqueda" id="busqueda" value="<?php echo $busqueda; ?>" aria-label="Search" ata-placement="bottom" data-toggle="tooltip" title="Busque por el nit , el nombre o el apellido del proveedor.">
            <input type="submit" value="Buscar" class="btn-search form-control mr-sm-2">
        </form>
    </header>
    <br><br>


    <div class="row d-flex justify-content-center">
        <div class="col-11">
            <!-- lista de busqueda -->
            <table class="table">
                <thead class="table-primary">
                    <tr>
                        <th>Nit</th>
                        <th>Nombre </th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Correo </th>
                        <th>Dirección</th>
                        <th>Municipio</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <?php

                include "../includes/conexion.php";
                // consulta segun la busqueda
                $seleccionar = $conexion->query("SELECT
                                                p.nit,
                                                p.nombre as 'nombre',
                                                p.apellido as 'apellido',
                                                p.direccion,
                                                p.telefono,
                                                p.correo,
                                                m.nombre as 'municipio'
                                                FROM tblproveedor as p 
                                                INNER JOIN tblmunicipio as m ON p.municipio = m.codigo
                                                WHERE p.nit LIKE '%$busqueda%' OR p.nombre LIKE '%$busqueda%' OR p.apellido LIKE '%$busqueda%'");

                // recorrer consulta
                $filas = $seleccionar->fetch_all(MYSQLI_ASSOC);
                // Verificar si hay filas o no
                if (empty($filas)) {
                    echo '<script type="text/javascript">
                                                 alert("No existen datos que coincidan con su busqueda");
                                                    window.location.href="registro_proveedor.php";   
                                                      </script>';
                } else {
                    foreach ($filas as $datos) {
                ?>
                        <tbody>
                            <tr>
                                <td><?php echo $datos['nit'] ?></td>
                                <td><?php echo $datos['nombre'] ?></td>
                                <td><?php echo $datos['apellido'] ?></td>
                                <td><?php echo $datos['direccion'] ?></td>
                                <td><?php echo $datos['telefono'] ?></td>
                                <td><?php echo $datos['correo'] ?></td>
                                <td><?php echo $datos['municipio']; ?></td>

                                <td><a href="actualizar_proveedor.php?nit=<?php echo $datos['nit'] ?>">ACTUALIZAR</a></td>
                                <td><a href="borrar_proveedor.php?nit=<?php echo $datos['nit'] ?>">ELIMINAR</a></td>
                            </tr>
                        </tbody>
                <?php

                    }
                }
                include "../includes/desconexion.php";

                ?>

            </table>
        </div>

    </div>
</body>

</html>