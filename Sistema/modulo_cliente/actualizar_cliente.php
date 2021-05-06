<?php {
  session_start();
  error_reporting(0);

  if (empty($_SESSION['rol'])) {
    header('location: ../ingreso/login.php');
  }
}
include("../includes/conexion.php");

$documento = $_REQUEST["documento"];
// $_REQUEST Un array asociativo que por defecto contiene el contenido de $_GET, $_POST y $_COOKIE

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
tblmunicipio as m ON cl.municipio = m.codigo where cl.documento = " . $documento);
if ($datos = $seleccionar->fetch_assoc()) {
}

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
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link rel="icon" href="../img/logo_prov_pestaña.png" />
  <title> Actualizar | Cliente</title>
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <!---libreria jquery--->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bootstrap/css/estilos/proveedor.css">
  <script src="../bootstrap/js/popper.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>


</head>

<body>
<?php
        echo '<script type="text/javascript">
    alert("Recuerde actualizar el departamento y municipio de nuevo.");
    </script>';
        ?>
  <header class="d-flex justify-content-between">
    <div class="col-6">
      <?php include "../includes/btnVolver.php"; ?>
    </div>
    <div class="col-6">
      <h3 class=" display-4 titulo"> ACTUALIZAR CLIENTE</h3>
    </div>
  </header>
  <div class=" row  padre d-flex justify-content-between">

    <div class=" img hijo col-lg-6 col-sm-12 col-md-6 ">
      <img class="img-fluid  " src="../img/portada.png ">
    </div>
    <div class=" hijo">
      <div class="col-12 ">
        <form action="update_cliente.php" method="post" name="formulario" onsubmit="return (e);">
          <div class="form-group row">
            <label class="col-md-12 col-lg-12  col-form-label"> Documento de Identidad: </label><br>
            <input type="text" readonly placeholder="Documento de Identidad" name="documento" class="form-control col-md-12  col-lg-8 rounded " value="<?php echo $datos['documento'] ?>"> <br> <br>
          </div>
          <div class="form-group row">
            <label class="col-md-12 col-lg-12  col-form-label">Nombres : </label><br><br>
            <input type="text" placeholder="Nombres" name="nombres" class="form-control col-md-12  col-lg-8 rounded " value="<?php echo $datos['nombres'] ?>"> <br> <br>
          </div>
          <div class="form-group row">
            <label class="col-md-12 col-lg-12  col-form-label">Apellidos: </label><br><br>
            <input type="text" placeholder="Apellidos" name="apellidos" class="form-control col-md-12  col-lg-8 rounded " value="<?php echo $datos['apellidos'] ?>"> <br> <br>
          </div>
          <div class="form-group row">
            <label class="col-md-12 col-lg-12  col-form-label"> Telefono : </label><br><br>
            <input type="text" placeholder="Telefono " name="telefono" class="form-control col-md-12  col-lg-8 rounded " value="<?php echo $datos['telefono'] ?>"> <br> <br>
          </div>
          <div class="form-group row">
            <label class="col-md-12 col-lg-12  col-form-label">Correo: </label><br><br>
            <input type="email" name="correo" class="form-control col-md-12  col-lg-8 rounded " value="<?php echo $datos['correo'] ?>"><br> <br>
          </div>
          <div class="form-group row">
            <label class="col-md-12 col-lg-12  col-form-label"> Dirección: </label><br><br>
            <input type="text" name="direccion" class="form-control col-md-12  col-lg-8 rounded " value="<?php echo $datos['direccion'] ?>"> <br> <br>
          </div>
          <div class="form-group row">
            <label class="col-md-12 col-lg-12  col-form-label" for="depatamento"> Departamento: </label><br>
            <select name="depatamento" id="tbl_departamento" class="form-control col-md-12  col-lg-8 rounded">
              <option value="" disabled> - Seleccione - </option>
              <?php foreach ($filas as $op) : //llenar las opciones del primer select 
              ?>
                <option value="<?= $op['codigo'] ?>"> <?= $op['nombre'] ?> </option>
              <?php endforeach; ?>
            </select>
          </div>



          <div class="form-group row">
            <label class="col-md-12 col-lg-12  col-form-label" for="municipio">Municipio: </label><br>
            <select name="municipio" id="tbl_municipio" disabled="" class="form-control col-md-12  col-lg-8 rounded">
              <option value="<?php echo $datos['municipio'] ?>"><?php echo $datos['municipio'] ?></option>

            </select>
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

          <div class="form-group inline row justify-content-center">
            <input type="submit" value="Actualizar cliente" id="boton" class="btn btn-primary col-11  rounded-pill"><br>
          </div>
        </form>
      </div>
    </div>

</body>

</html>