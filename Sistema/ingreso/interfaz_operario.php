<?php {  // codigo de sesiones
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
    <!-----logo---->
    <link rel="shortcut icon" href="../img/logo_prov_pestaña.png" type="image/x-icon">

    <title>
        Interfaz | Operario
    </title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/css/estilos/home.css">

    <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>

    <!--Archivos de javascript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!---google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light col-12">
        <a class="navbar-brand text-left navbar" href="interfaz_superadmin.php">
            <h6><img class="logo" src="../img/logo_prov_pestaña.png"></h6>
            <a>

                <!-- ICONO DE MENU -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- menu -->

                <div class="collapse navbar-collapse  d-flex justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../modulo_cliente/registro_cliente.php">Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../modulo_venta/registrar_venta.php">Ventas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../modulo_compra/registro_compra.php">Compras</a>

                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Inventarios
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a href="../modulo_producto/registro_producto.php" class="dropdown-item">Producto Terminado</a>
                                <a href="../modulo_producto/producto_caducado.php" class="dropdown-item">Producto Terminado Caducado</a>
                            </div>
                        </li>
                    </ul>
                    <div class="btn ">
                        <a href="cerrar_sesion.php" class=" btn btn-outline-primary my-2 my-sm-0 "> CERRAR SESIÓN</a>

                    </div>

                </div>

    </nav <br><br>
    <!-- menu de reportes -->

    <div class="container">


        <div class="alert alert-dark alert-dismissible fade show" role="alert">
            Revise cantidad de productos que hay en cada <a href="../modulo_producto/rpCategoriaProducto.php" class="alert-link"> Categoria </a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            Reporte de facturas de
            <a href="../modulo_venta/rpNumeroVentas.php" class="alert-link">venta </a>
            por producto <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <!-- plantillas -->

    <?php include('../includes/contenido.php'); ?>
    <?php include('../includes/footer.php'); ?>

</body>


</html>