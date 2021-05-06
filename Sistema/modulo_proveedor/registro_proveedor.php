    <?php
    require_once('../includes/conexion.php');

    /*Inicio obtenemos los datos del primer select*/
    $sql = "select * from tbldepartamento";
    $query = mysqli_query($conexion, $sql);
    $filas = mysqli_fetch_all($query, MYSQLI_ASSOC);
    mysqli_close($conexion);
    /* Fin Inicio obtenemos los datos del primer select*/

    ?>

    <html>

    <head>
        <meta charset="utf-8">
        <link rel="icon" href="../img/logo_prov_pestaña.png" />
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <!---libreria jquery--->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title> Proveedor | Registrar </title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../bootstrap/css/estilos/proveedor.css">
        <script src="../bootstrap/js/popper.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../bootstrap/js/jquery-3.5.1.min.js"></script>
        <script src="../bootstrap/js/validar_proveedor.js"></script>
        <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>

    </head>

    <body>
        <header class="d-flex justify-content-between   col-md-12 col-sm-12 col-lg-12">

            <div class=" justify-content-start  mb-3 ">

                <?php include "../includes/btnVolver.php"; ?>

            </div>

            <center>
                <h1 class=" titulo display-4">REGISTRAR PROVEEDOR</h1>
            </center>
            <!-- formulario de buscar -->
            <form action="buscar_proveedor.php" method="post" class="form-inline my-2 my-lg-0 ">
                <input class="form-control mr-sm-2" type="text" placeholder="Buscar " name="busqueda" id="busqueda" aria-label="Search" ata-placement="bottom" data-toggle="tooltip" title="Busque por el nit , el nombre o el apellido del proveedor.">
                <input type="submit" value="Buscar" class="btn-search form-control mr-sm-2">
            </form>

        </header>



        <div class="padre row justify-content-between">

            <!-- imagen -->
            <div class="row img hijo">

                <img class="img-fluid " src="../img/proveedor.png ">
            </div>

            <div class=" row  hijo ">
                <div class="col-12 ">

                    <!-- formulario -->
                    <form action="guardar_proveedor.php" method="post" name="formulario" class="needs-validation" novalidate>

                        <div class="form-group row">
                            <label class="col-lg-4 col-md-12  col-form-label ">Nit : </label><br><br>
                            <input type="text" name="nit" id="nit" class="form-control col-md-12  col-lg-8 rounded " autofocus maxlength="10" minlegth="2" required>
                            <div class="invalid-feedback">
                                Digite el Número de identificación tributaria.
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-12  col-form-label  ">Nombre del proveedor : </label><br><br>
                            <input type="text" name="nombre" id="nombre" class="form-control col-md-12  col-lg-8 rounded " maxlength="50" minlegth="9" required>
                            <div class="invalid-feedback">
                                Digite el nombre del proveedor.
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-12  col-form-label  ">Apellido del proveedor:</label><br><br>
                            <input type="text" name="apellido" id="apellido" class="form-control col-md-12  col-lg-8 rounded " maxlength="60" minlegth="5">
                            <div class="invalid-feedback">
                                Digite el apellido si lo tiene.
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-12  col-form-label  ">Número de teléfono: </label><br><br>
                            <input type="text" name="telefono" id="telefono" class="form-control col-md-12  col-lg-8 rounded " maxlength="20" minlegth="2" required>
                            <div class="invalid-feedback">
                                Digite el Número de teléfono.
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-12  col-form-label  ">Correo : </label><br><br>
                            <input type="email" name="correo" id="correo" class="form-control col-md-12  col-lg-8 rounded " maxlength="70" minlegth="10" required>
                            <div class="invalid-feedback">
                                Digite el Correo Electrónico.
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-12  col-form-label  ">Dirección : </label><br><br>
                            <input type="text" name="direccion" id="direccion" class="form-control col-md-12  col-lg-8 rounded " maxlength="45" minlegth="2" required>
                            <div class="invalid-feedback">
                                Digite la dirección.
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-12  col-form-label  " for="depatamento"> Departamento: </label><br>
                            <select name="departamento" id="tbl_departamento" class="form-control col-md-12  col-lg-8 rounded " required>
                                <option value="" disabled selected>- Seleccione </option>
                                <?php foreach ($filas as $op) : //llenar las opciones del primer select 
                                ?>
                                    <option value="<?= $op['codigo'] ?>"> <?= $op['nombre'] ?> </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Elija el departamento.
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-md-12  col-form-label  " for="municipio">Municipio: </label><br>
                            <select name="municipio" id="tbl_municipio" disabled="" class="form-control col-md-12  col-lg-8 rounded " required>

                                <option value="" disabled selected>- Seleccione </option>

                            </select>
                            <div class="invalid-feedback">
                                Elija el municipio.
                            </div>
                        </div>
                        <div class="form-group inline row justify-content-center">

                            <input type="submit" value="REGISTRAR PROVEEDOR" id="boton" class="btn btn-primary col-6 rounded-pill">
                        </div>
                    </form>


                </div>


            </div>

        </div>

        <!-- codigo de select dependientes depart. municipio -->
        <script type="text/javascript">
            $(document).ready(function() {
                var tbl_municipio = $('#tbl_municipio');

                //Ejecutar accion al cambiar de opcion en el select de las bandas
                $('#tbl_departamento').change(function() {
                    var departamento_codigo = $(this).val(); //obtener el id seleccionado

                    if (departamento_codigo !== '') { //verificar haber seleccionado una opcion valida

                        /*Inicio de llamada ajax*/
                        $.ajax({
                            data: {
                                departamento_codigo: departamento_codigo
                            }, //variables o parametros a enviar, formato => nombre_de_variable:contenido
                            dataType: 'html', //tipo de datos que esperamos de regreso
                            type: 'POST', //mandar variables como post o get
                            url: '../includes/traer_municipios.php' //url que recibe las variables
                        }).done(function(data) { //metodo que se ejecuta cuando ajax ha completado su ejecucion             

                            tbl_municipio.html(data); //establecemos el contenido html de discos con la informacion que regresa ajax             
                            tbl_municipio.prop('disabled', false); //habilitar el select
                        });
                        /*fin de llamada ajax*/

                    } else { //en caso de seleccionar una opcion no valida
                        tbl_municipio.val(''); //seleccionar la opcion "- Seleccione -", osea como reiniciar la opcion del select
                        tbl_municipio.prop('disabled', true); //deshabilitar el select
                    }
                });

            });
        </script>
        <div class="container-fluid">

            <center>
                <h3 class="h3 mb-3 font-weight-normal display-4  ">Lista de Proveedores Registrados </h3>
            </center>

            <div class="row d-flex justify-content-center">
                <div class="col-12">

                    <!-- lista de proveedores -->
                    <table class="table table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Nit</th>
                                <th>Nombre </th>
                                <th>Apellidos</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Correo </th>
                                <th>Municipio</th>
                                <th>Actualizar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <?php

                        include "../includes/conexion.php";
                        // consulta de datos
                        $seleccionar = $conexion->query("SELECT
                                                    p.nit,
                                                    p.nombre as 'nombre',
                                                    p.apellido as 'apellido',
                                                    p.direccion,
                                                    p.telefono,
                                                    p.correo,
                                                    m.nombre as 'municipio'
                                                    FROM tblproveedor as p 
                                                    INNER JOIN tblmunicipio as m ON p.municipio = m.codigo");
                        while ($datos = $seleccionar->fetch_assoc()) {
                        ?>
                            <tbody>
                                <tr>
                                    <td data-label="Nit"><?php echo $datos['nit'] ?></td>
                                    <td data-label="Nombre"><?php echo $datos['nombre'] ?></td>
                                    <td data-label="Apellidos"><?php echo $datos['apellido'] ?></td>
                                    <td data-label="Dirección"><?php echo $datos['direccion'] ?></td>
                                    <td data-label="Teléfono"><?php echo $datos['telefono'] ?></td>
                                    <td data-label="Correo"><?php echo $datos['correo'] ?></td>
                                    <td data-label="Municipio"><?php echo $datos["municipio"]; ?></td>
                                    <td><a href="actualizar_proveedor.php?nit=<?php echo $datos['nit'] ?>">ACTUALIZAR</a></td>
                                    <td><a href="borrar_proveedor.php?nit=<?php echo $datos['nit'] ?>">ELIMINAR</a></td>
                                </tr>
                            </tbody>
                        <?php
                        }
                        include "../includes/desconexion.php";
                        ?>

                    </table>
                    <!-- validacion de formulario -->
                    <script src="../bootstrap/js/validar_venta_compra.js"></script>
                </div>
            </div>
        </div>
    </body>

    </html>