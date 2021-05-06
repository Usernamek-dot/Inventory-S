<?php

// INDEX
{ 
  session_start();
  error_reporting(0);

  if(empty($_SESSION['rol']))
  {
      header('location: ../ingreso/login.php');
  }

}


?>
<html>

<head>
  
  <title> Configurar usuario</title>
  <!-- LINK MEDIA QUERYS importante ! -->
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta charset="utf-8">
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  
  <!---libreria jquery--->
  <link rel="icon" href="../img/logo_prov_pestaña.png">
  
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <script src="botones.js" type="text/javascript"></script>
  <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bootstrap/css/estilos/usuario.css">
  <script src="../bootstrap/js/popper.min.js"></script>

</head>

<body>

  <header class="d-flex justify-content-between ">
    <div class="d-flex justify-content-start  mb-3 ">
    <?php include "../includes/btnVolver.php"; ?>
    </div>
    <h1 class="titulo display-4   "> CONFIGURAR INFORMACIÓN DE USUARIO </h1>
    <form action="buscar_usuario.php" method="post" class=" form-inline my-2 my-lg-0 ">
      <input class="  form-control mr-sm-12" type="text" placeholder="Buscar usuario" name="busqueda" id="busqueda" aria-label="Search" ata-placement="bottom" data-toggle="tooltip" title="Busque por el documento,nombre, apellidos  o rol del usuario">
      <input type="submit" value="Buscar" class="  btn-search form-control mr-sm-12">
    </form>
    </header>


  <div class="padre d-flex justify-content-center row ">
    <div class=" hijo ">
      <div class="col-12 col-md-12 ">
        <form action="configurar.php" method="post" name="formulario" onsubmit="return (e);">
          <?php include "usuario_rol.php"; ?>
        </form>
      </div>
    </div>

    <div class=" img hijo">
      <img class="img-fluid" src="../img/user.png ">
    </div>
  </div>

  <div class="container-fluid">
  <center>
    <h1 class="titulo display-4"> Lista de Usuarios </h1>
  </center>

   <div class="row d-flex justify-content-center ">
    <div class="col-12">
      <table class="table table-hover">

        <thead class="table-primary">
          <tr>
            <th>Documento</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Correo </th>
            <th>Telefono</th>
            <th>Dirección</th>
            <th>Perfil</th>
            <th>Municipio </th>
            <!-- <th>Estado </th> -->
            <th>Actualizar</th>
          </tr>
        </thead>
        <?php

        include "../includes/conexion.php";

        $seleccionar = $conexion->query("SELECT
u.documento,
u.nombres as 'nombre',
u.apellidos as 'apellido',
u.correo,
u.telefono,
u.direccion,
u.clave,
tp.nombre as 'rol',
m.nombre as 'municipio',
u.estado as 'estado'
FROM
tblusuario as u
    left JOIN
tbltipousuario as tp ON u.tipo_usuario = tp.id
inner join
tblmunicipio as m ON u.municipio = m.codigo

");
        while ($datos = $seleccionar->fetch_assoc()) {
        ?>
          <tbody>
            <tr>
              <td data-label="Documento"> <?php echo $datos["documento"]; ?> </td>
              <td data-label="Nombre"> <?php echo $datos["nombre"]; ?> </td>
              <td data-label="Apellido"> <?php echo $datos["apellido"]; ?> </td>
              <td data-label="Correo">  <div class="limitetd"> <?php echo $datos["correo"]; ?>...</div></td>
              <td data-label="Teléfono"> <?php echo $datos["telefono"]; ?> </td>
              <td data-label="Dirección"> <div class="limitetd"> <?php echo $datos["direccion"]; ?>...</div></td>
              <td data-label="Perfil"><?php echo $datos["rol"]; ?></td>
              <td data-label="Municipio"><?php echo $datos["municipio"]; ?></td>
              <!--------BOTONES PARA USUARIO.AJAX.PHP----------->

               <!-- <?php

              if ($datos['estado'] != 0) { //si estado = 1
                echo '<td><button type="button" class="btn btn-danger btnprueba btn-xs btnActivar" 
                        documento=' . $datos["estado"] . ' estado="1" >Inactivo</button></td>';
              } else { //si estado = 0
                echo '<td><button type="button" class="btn btn-success btnprueba btn-xs btnActivar" 
                  documento=' . $datos["estado"] . ' estado="0" >Activo</button></td>';
              } ?> 

                            <?php if($datos['estado']!=0){
                  echo'<td><button type="button"  id="btnActivar" class="btn btn-danger btnprueba btn-xs " 
                  documento='.$datos["estado"].'  estado="0">Inactivo</button></td>';
              }else{
                echo'<td><button type="button" id="btnActivar" class="btn btn-success btnprueba btn-xs " 
                documento='.$datos["estado"].' estado="1" >Activo</button></td>';
                if($datos['estado']!=0){ echo''; }else{ echo''; } if($datos['estado']!=0){ echo''; }else{ echo''; } 
              }?> -->



              <td><a href="actualizar.php?documento=<?php echo $datos['documento'] ?>">ACTUALIZAR</a></td>
            </tr>

          </tbody>
        <?php
          } //se cierra ciclo while
       
        include "../includes/desconexion.php";
        ?>
      </table>
    </div>
  </div>

</html>