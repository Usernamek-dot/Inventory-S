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
  <link rel="icon" href="../img/logo_prov_pestaña.png" />
  <title>Reporte Usuarios Sin Perfil</title>
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <!---libreria jquery--->
  <!-- LINK MEDIA QUERYS importante ! -->
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

  <meta charset="utf-8">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bootstrap/css/estilos/compra.css">
  <script src="../bootstrap/js/popper.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <script src="../bootstrap/js/jquery-3.5.1.min.js"></script>
  <script src="../bootstrap/js/validar_compra.js"></script>
  <script src="../bootstrap/js/botones.js"></script>
  <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>

</head>

<body>


  <header class="d-flex justify-content-between">
    <div class="d-flex justify-content-start  mb-3 ">
      <?php include "../includes/btnVolver.php"; ?>

      <a href='../modulo_usuario/usuario.php' class='btn btn-light rounded btn_usuario'><i class="fas fa-users"></i></a>
    </div>

    <h1 class="titulo display-4"> Informe de los usuarios en espera de perfil </h1>

  </header>
  <br> <br>

  <div class="row d-flex justify-content-center">
    <div class="col-11">

      <table class="table table-hover">
        <thead  class="table-primary">
                <tr>
                    <th scope="col">Documento </th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Correo Electrónico </th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Dirección </th>
                    <th scope="col">Perfil </th>
                    <th scope="col">Municipio</th>
                    <th scope="col">Actualizar</th>
                    
                </tr>
        </thead>
                <?php

            include "../includes/conexion.php";

            $seleccionar = $conexion->query(" CALL RP_usuariossinrol() ");

            foreach ($seleccionar as $op) : //creamos las opciones a partir de los datos obtenidos 


            ?>
                <tbody>
                        <tr>
                        <td data-label="Documento "> <?php echo $op['documento']; ?> </td>
                        <td data-label="Usuario"> <?php echo $op['usuario']; ?> </td>
                        <td data-label="Correo Electrónico  "> <?php echo $op['correo']; ?> </td>
                        <td data-label="Teléfono"> <?php echo $op['telefono']; ?> </td>
                        <td data-label="Dirección "> <?php echo $op['direccion']; ?> </td>
                        <td data-label="Perfil "> <?php echo $op['rol']; ?> </td>
                        <td data-label="Municipio"> <?php echo $op['municipio']; ?> </td>
                        <td><a href="actualizar.php?documento=<?php echo $op['documento'] ?>">ACTUALIZAR</a></td>



                        </tr>
                </tbody>
            <?php
            endforeach;
            include "../includes/desconexion.php";
            ?>
      </table>
    </div>
  
    </div>
  





</body>

</html>