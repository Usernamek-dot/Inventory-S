<?php

//codigo de select dependientes
require_once('../includes/conexion.php');

/*Inicio obtenemos los datos del primer select*/
$sql = "select * from tbldepartamento";
$query = mysqli_query($conexion, $sql);
$filas = mysqli_fetch_all($query, MYSQLI_ASSOC);
mysqli_close($conexion);
/* Fin Inicio obtenemos los datos del primer select*/
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <!-----logo---->
  <link rel="shortcut icon" href="../img/logo_prov_pestaña.png" type="image/x-icon">
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <!---libreria jquery--->
  <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bootstrap/css/estilos/registrarse.css">
  <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
  <script src="../bootstrap/js/popper.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>

  <!-- LINK MEDIA QUERYS importante ! -->
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

  <script src="../bootstrap/js/validar_venta_compra.js"></script>



  <title> Registro</title>
</head>

<body>

  <body>

    <header class="d-flex justify-content-center">
      <h1 class="titulo display-4 "> REGISTRARSE </h1>
    </header>

    <div class="padre d-flex justify-content-between row">

      <!-- formulario registro -->
      <div class=" hijo  col-lg-6  col-md-12 col-sm-12">
        <form class="needs-validation" novalidate action="guardar.php" method="post" name="formulario">
          <div class="form-group row">
            <label class=" col-md-6 col-lg-12 col-xl-4 col-sm-12  col-form-label "> Documento de Identidad: </label><br>
            <input type="text" name="documento" id="documento" class=" col-md-6 col-8 col-lg-10  col-sm-12  col-xl-8 " autofocus maxlength="12" minlegth="2" required> <br> <br>
            <div class="invalid-feedback">
              Escriba su documento de identidad.
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-6 col-lg-12  col-xl-4 col-sm-12 col-form-label ">Nombres : </label><br><br>
            <input type="text" name="nombres" id="nombres" class="col-md-6 col-sm-12 col-8 col-lg-10 col-xl-8 " maxlength="50" minlegth="2" required> <br> <br>
            <div class="invalid-feedback">
              Escriba su nombre completo.
            </div>
          </div>
          <div class="form-group row">
            <label class=" col-md-6 col-lg-12  col-xl-4 col-sm-12  col-form-label ">Apellidos: </label><br><br>
            <input type="text" name="apellidos" id="apellidos" class="col-md-6 col-sm-12 col-8 col-lg-10 col-xl-8 " maxlength="60" minlegth="2" required> <br> <br>
            <div class="invalid-feedback">
              Escriba su apellido completo.
            </div>
          </div>
          <div class="form-group row">
            <label class=" col-md-6 col-lg-12  col-xl-4 col-sm-12 col-form-label "> Correo : </label><br><br>
            <input type="email" name="correo" id="correo" class=" col-md-6 col-sm-12 col-8 col-lg-10 col-xl-8 " maxlength="60" minlegth="2" required> <br> <br>
            <div class="invalid-feedback">
              Escriba su correo personal o empresarial.

            </div>
          </div>
          <div class="form-group row">
            <label class=" col-md-6 col-lg-12  col-xl-4 col-sm-12 col-form-label ">Número de teléfono : </label><br><br>
            <input type="text" name="telefono" id="telefono" class="col-md-6 col-sm-12 col-8 col-lg-10 col-xl-8 " maxlength="20" minlegth="2" required> <br> <br>
            <div class="invalid-feedback">
              Escriba un telefono valido.

            </div>
          </div>
          <div class="form-group row">
            <label class=" col-md-6 col-lg-12  col-xl-4 col-sm-12 col-form-label "> Dirección: </label><br><br>
            <input type="text" name="direccion" id="direccion" class=" col-md-6 col-sm-12 col-8 col-lg-10 col-xl-8 " maxlength="45" minlegth="2" required> <br> <br>
            <div class="invalid-feedback">
              Escriba una direccion valida.

            </div>
          </div>
          <div class="form-group row">
            <label class=" col-md-6 col-lg-12  col-xl-4 col-sm-12 col-form-label ">Clave: </label><br><br>
            <input type="password" name="clave" id="clave" class=" col-md-6 col-sm-12 col-8 col-lg-10 col-xl-8 " maxlength="15" minlegth="2" required> <br> <br>
            <div class="invalid-feedback">
              Escriba una clave.
            </div>
          </div>
          <div class="form-group row">
            <label class=" col-md-6 col-lg-12  col-xl-4 col-sm-12 col-form-label " for="depatamento"> Departamento: </label><br>
            <select name="depatamento" id="tbl_departamento" class=" col-md-6 col-sm-12 col-8 col-lg-10 col-xl-8" required>
              <option value=""> - Seleccione - </option>
              <?php foreach ($filas as $op) : //llenar las opciones del primer select 
              ?>
                <option value="<?= $op['codigo'] ?>"> <?= $op['nombre'] ?> </option>
              <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
              Elija un departamento.
            </div>
          </div>


          <div class="form-group row">
            <label class=" col-lg-12 col-md-6  col-xl-4 col-sm-12 col-form-label " for="municipio">Municipio: </label><br>
            <select name="municipio" id="tbl_municipio" disabled="" class=" col-md-6 col-sm-12 col-8 col-lg-10 col-xl-8" required>
              <option value=""> - Seleccione - </option>
            </select>
            <div class="invalid-feedback">
              Elija un municipio.
            </div>
          </div>





          <div class="form-group inline row justify-content-center">
            <input type="submit" value="CREAR USUARIO" id="boton" class="btn btn-primary col-sm-12 col-md-6 col-12 col-lg-10 col-xl-8 rounded-pill"><br>
          </div>

          <div class="form-group inline row justify-content-center">
            <a href="login.php" class="btn btn-primary col-12 col-lg-10 col-xl-8 col-sm-12 col-md-6  rounded-pill"> INICIAR SESION</a>
          </div>



        </form>

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

      <div class="div-img hijo  col-lg-6 col-sm-12 col-md-6 ">
        <img src="../img/user.png" class="img-fluid  ">
      </div>

    </div>

    <!-- <script src="../bootstrap/js/validar_registro.js"></script> -->

  </body>

</html>