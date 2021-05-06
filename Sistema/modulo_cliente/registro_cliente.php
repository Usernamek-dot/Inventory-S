<?php
{ 
    session_start();
    error_reporting(0);
 
    if(empty($_SESSION['rol']))
    {
        header('location: ../ingreso/login.php');
    }
 
}

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
  <title> Registrar | Cliente</title>
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <!---libreria jquery--->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bootstrap/css/estilos/proveedor.css">
  <script src="../bootstrap/js/popper.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>



</head>

<body>
  <header class="d-flex justify-content-between">
    <div class="d-flex justify-content-start  mb-3 ">
     <?php include "../includes/btnVolver.php"; ?>
    </div>
    <center>
      <h1 class=" titulo display-4">REGISTRAR CLIENTE</h1>
    </center>
    <form action="buscar_cliente.php" method="post" class="form-inline my-2 my-lg-0 ">
      <input class="form-control mr-sm-2" type="text" placeholder="Buscar" ata-placement="bottom" data-toggle="tooltip" 
     title="Busque por el documento , los nombres o los apellidos del cliente " name="busqueda" id="busqueda" aria-label="Search">
      <input type="submit" value="Buscar" class="btn-search form-control mr-sm-2">
    </form>
  </header>


  <div class=" row  padre d-flex justify-content-between">

    <div class=" img hijo col-lg-6 col-sm-12 col-md-6 ">
      <img class="img-fluid" src="../img/cliente.png ">
    </div>
    <div class=" hijo">

      <div class="col-md-12 col-lg-12 ">
        <form action="guardar_cliente.php" method="post" name="formulario" class="needs-validation" novalidate onsubmit="return (e);" >
          <div class="form-group row">
            <label class="col-md-12 col-lg-12  col-form-label "> Documento de Identidad: </label><br>
            <input type="text" name="documento" id="documento" class="form-control col-md-12  col-lg-8 rounded " maxlength="12" minlegth="2"  autofocus ata-placement="bottom" data-toggle="tooltip" title="Busque por el documento o nombre " required> <br> <br>
             <div class="invalid-feedback">
                                Digite un Documento.
                            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-12 col-lg-12  col-form-label ">Nombres : </label><br><br>
            <input type="text" name="nombres" id="nombres" class="form-control col-md-12  col-lg-8 rounded " maxlength="50" minlegth="2" required> <br> <br>
            <div class="invalid-feedback">
                                Digite uno o dos Nombres.
                            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-12 col-lg-12  col-form-label ">Apellidos: </label><br><br>
            <input type="text" name="apellidos" id="apellidos" class="form-control col-md-12  col-lg-8 rounded " maxlength="60" minlegth="2"required > <br> <br>
            <div class="invalid-feedback">
                                Digite sus Apellidos.
                            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-12 col-lg-12  col-form-label "> Telefono : </label><br><br>
            <input type="text" name="telefono" id="telefono" class="form-control col-md-12  col-lg-8 rounded" maxlength="60" minlegth="2" required > <br> <br>
            <div class="invalid-feedback">
                                Digite un Teléfono.
                            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-12 col-lg-12  col-form-label">Correo: </label><br><br>
            <input type="email" name="correo" id="correo" class="form-control col-md-12  col-lg-8 rounded " maxlength="30" minlegth="2" required> <br> <br>
            <div class="invalid-feedback">
                                Digite un Correo Electrónico.
                            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-12 col-lg-12  col-form-label"> Dirección: </label><br><br>
            <input type="text" name="direccion" id="direccion" class="form-control col-md-12  col-lg-8 rounded" maxlength="45" minlegth="2" required> <br> <br>
            <div class="invalid-feedback">
                                Digite una Dirección.
                            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-12 col-lg-12  col-form-label" for="depatamento"> Departamento: </label><br>
            <select name="departamento" id="tbl_departamento" class="form-control col-md-12  col-lg-8 rounded" required>
              <option value=""> - Seleccione - </option>
              <?php foreach ($filas as $op) : //llenar las opciones del primer select 
              ?>
                <option value="<?= $op['codigo'] ?>"> <?= $op['nombre'] ?> </option>
              <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                                Elija un Departamento.
                            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-12 col-lg-12  col-form-label" for="municipio">Municipio: </label><br>
            <select name="municipio" id="tbl_municipio" disabled="" class="form-control col-md-12  col-lg-8 rounded" required>
              <option value=""> - Seleccione - </option>
            </select>
            <div class="invalid-feedback">
                                Elija un Municipio.
                            </div>
          </div>
          <div class="form-group inline row justify-content-center">
            <input type="submit" value="REGISTRAR CLIENTE" id="boton" class="btn btn-primary col-11  rounded-pill"><br>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Iniciamos el segmento de codigo javascript -->
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
     <script src="../bootstrap/js/validar_venta_compra.js"></script>
   <!--  <script src="../bootstrap/js/validar_cliente.js"></script> -->
  <!----------------------------  LISTA CLIENTE------------------------------------------------------->

  <div class="container-fluid">
    <center>
      <h1 class="titulo display-4"> Lista de Clientes Registrado</sh1>
    </center>

    <div class="row d-flex justify-content-center">
      <div class="col-12">
        <table class="table table-hover">
          <thead class="table-primary">
            <tr>
              <th>Documento </th>
              <th>Nombres</th>
              <th>Apellidos</th>
              <th>Telefono </th>
              <th>Correo</th>
              <th>Dirección</th>
              <th>Municipio</th>
              <th>Actualizar</th>
              <th>Eliminar</th>
            </tr>
          </thead>
          <?php

          include "../includes/conexion.php";

          $seleccionar = $conexion->query("SELECT
cl.documento,
cl.nombres as 'nombres',
cl.apellidos as 'apellidos',
cl.correo,
cl.telefono,
cl.direccion,
m.nombre as 'municipio'
FROM
tbl_cliente as cl
inner join
tblmunicipio as m ON cl.municipio = m.codigo");
          while ($datos = $seleccionar->fetch_assoc()) {
          ?>
            <tbody>
              <tr>
                <td data-label="Documento"><?php echo $datos['documento'] ?></td>
                <td data-label="Nombres"><?php echo $datos['nombres'] ?></td>
                <td data-label="Apellidos"><?php echo $datos['apellidos'] ?></td>
                <td data-label="Teléfono"><?php echo $datos['telefono'] ?></td>
                <td data-label="Correo"><?php echo $datos['correo'] ?></td>
                <td data-label="Dirección"><?php echo $datos['direccion'] ?></td>
                <td data-label="Municipio"><?php echo $datos['municipio'] ?></td>

                <td><a href="actualizar_cliente.php?documento=<?php echo $datos['documento'] ?>">ACTUALIZAR</a></td>
                <td><a href="borrar_cliente.php?documento=<?php echo $datos['documento'] ?>">ELIMINAR</a></td>
              </tr>

            </tbody>
          <?php
          }   //se cierra ciclo while
          include "../includes/desconexion.php";
          ?>
        </table>
      </div>
    </div>
</body>

</html>