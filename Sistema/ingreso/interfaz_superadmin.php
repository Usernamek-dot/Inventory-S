<?php {
    // codigo de sesiones
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
        Interfaz | Superadministrador
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


    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="../Project/style.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>





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
                <div class="collapse navbar-collapse  d-flex justify-content-end " id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto menu1">
                        <li class="nav-item">
                            <a class="nav-link  " href="../modulo_usuario/usuario.php">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../modulo_cliente/registro_cliente.php">Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../modulo_venta/registrar_venta.php">Ventas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../modulo_compra/registro_compra.php">Compras</a>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../modulo_proveedor/registro_proveedor.php">Proveedores</a>

                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Inventarios
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a href="../modulo_materiap/inventario_materia.php" class="dropdown-item">Materia Prima</a>
                                <a href="../modulo_materiap/inventario_materia_caducada.php" class="dropdown-item">Materia Prima Caducada</a>
                                <a href="../modulo_producto/registro_producto.php" class="dropdown-item">Producto Terminado</a>
                                <a href="../modulo_producto/producto_caducado.php" class="dropdown-item">Producto Terminado Caducado</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Producción
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="../modulo_receta/registrar_receta.php">Recetas</a>
                                <a class="dropdown-item" href="../modulo_produccion/registrar_produccion.php">Ordenes de Producción</a>
                            </div>
                        </li>

                    </ul>
                    <div class="btn ">
                        <a href="cerrar_sesion.php" class=" btn btn-outline-primary my-2 my-sm-0 "> CERRAR SESIÓN</a>
                    </div>
                    <div class="contenedor">
                        <div class="boton">
                            <label for="btn_menu" class="navbar-btn btn btn-outline-primary my-2 my-sm-0" id="sidebarCollapse2">Reportes</label>
                        </div>
                    </div>


                </div>


    </nav>



    <!-- menu de reportes -->

    <input type="checkbox" id="btn_menu">

    <div class="wrapper">
        Sidebar Holder
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3 class="tituloDeReporte">Reportes</h3>
                <label for="btn_menu" class="btnCerrar"> <i class="fas fa-window-close"></i></label>
            </div>

            <ul class="list-unstyled components">

                <li>
                    <a href="../modulo_materiap/inventario_materia_caducada.php">Existencias Caducadas</a>

                </li>
                <li>
                    <a href="../modulo_usuario/rpUsuariossinrol.php"> Usuarios Sin Perfil </a>
                </li>
                <li>
                    <a href="../modulo_receta/rpRecetasUsadas.php"> Recetas en Producción </a>
                </li>

                <li>
                    <a href="../modulo_producto/rpCategoriaProducto.php"> Productos Según categoría </a>
                </li>
                <li>
                    <a href="../modulo_venta/rpNumeroVentas.php">Productos Vendidos </a>
                </li>
            </ul>


        </nav>


    </div>



    <!-- plantillas -->

    <?php include('../includes/contenido.php'); ?>
    <?php include('../includes/footer.php'); ?>