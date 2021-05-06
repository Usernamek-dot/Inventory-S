<?php
require "../includes/conexion.php";
///include "../ingreso/guardar.php";

$nit = $_REQUEST["nit"];
$seleccionar = $conexion -> query("SELECT p.nit,p.nombre,p.apellido,p.correo,p.telefono,p.direccion,m.nombre as 'municipio'
FROM
tblproveedor as p
inner join
tblmunicipio as m ON p.municipio = m.codigo WHERE p.nit=".$nit);
if ($datos= $seleccionar -> fetch_assoc()) {
}
//$municipio = $conexion->query("SELECT * from tblmunicipio");

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
	      <title>Proveedor | Actualizar </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <link rel="icon" href="../img/logo_prov_pestaña.png" />
	      <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script> <!---libreria jquery--->
        <meta charset="utf-8">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../bootstrap/css/estilos/proveedor.css">
        <script src="../bootstrap/js/popper.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../bootstrap/js/jquery-3.5.1.min.js"></script>
        <script src="../bootstrap/js/validar_venta_compra.js"></script>

        <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>
      </head>
    <body>
    <?php
        echo '<script type="text/javascript">
    alert("Recuerde actualizar el departamento y municipio de nuevo.");
    </script>';
        ?>
	         <header class="d-flex justify-content-between">
                <div class="justify-content-start  mb-3 ">

                  <?php include "../includes/btnVolver.php";?>
                </div>
                <h1 class="titulo display-4  "> ACTUALIZAR PROVEEDOR </h1>
           </header>  
             
     

              <div class="padre row d-flex justify-content-between">

                       
                    <div class="hijo">
       
                          <form action="update_proveedor.php" method="post" class="needs-validation" novalidate>

                                <div class="form-group row" > 
                                    <label class="col-lg-4 col-md-12  col-form-label ">Nit:</label><br>
                	                  <input type="text" readonly name="nit" class="form-control col-md-12  col-lg-8 rounded " value="<?php echo $datos['nit'] ?>"><br><br>
                                </div>
                                <div class="form-group row" > 
                	                   <label class="col-lg-4 col-md-12  col-form-label ">Nombre :</label><br>
                	                   <input type="text" name="nombre" class="form-control col-md-12  col-lg-8 rounded " value="<?php echo $datos['nombre'] ?>"><br><br>
                                </div>
                	              <div class="form-group row" > 
                	                   <label class="col-lg-4 col-md-12  col-form-label "class="col-lg-4 col-md-12  col-form-label ">Apellido:</label><br>
                	                   <input type="text" name="apellido" class="form-control col-md-12  col-lg-8 rounded " value="<?php echo $datos['apellido'] ?>"><br><br>
                                </div>
                	              <div class="form-group row" > 
                	                   <label class="col-lg-4 col-md-12  col-form-label ">Dirección:</label><br>
                	                   <input type="text" name="direccion" class="form-control col-md-12  col-lg-8 rounded " value="<?php echo $datos['direccion'] ?>"><br><br>
                                </div>
                	              <div class="form-group row" > 
                	                   <label class="col-lg-4 col-md-12  col-form-label ">Teléfono:</label><br>
                	                   <input type="text" name="telefono" class="form-control col-md-12  col-lg-8 rounded " value="<?php echo $datos['telefono'] ?>"><br><br>
                                </div>
                                <div class="form-group row" > 
                                     <label class="col-lg-4 col-md-12  col-form-label ">Correo:</label><br>
                	                   <input type="email" name="correo" class="form-control col-md-12  col-lg-8 rounded " value="<?php echo $datos['correo'] ?>"><br><br>
                                </div>
                	              <div class="form-group row" >
                                              <label class="col-lg-4 col-md-12  col-form-label " for="depatamento"> Departamento: </label><br>
                                              <select class="form-control col-md-12  col-lg-8 rounded " name="depatamento" id="tbl_departamento"  class="col-8">
                                                        <option value="" disabled> - Seleccione - </option>
                                                        <?php foreach ($filas as $op): //llenar las opciones del primer select ?>
                                                        <option value="<?=$op['codigo']?>"> <?=$op['nombre']?> </option>
                                                        <?php endforeach;?>
                                              </select>
                                </div>
                                <div class="form-group row" >
                                            <label class="col-4 col-form-label " for="municipio">Municipio: </label><br>
                                            <select class="form-control col-md-12  col-lg-8 rounded " name="municipio" id="tbl_municipio"  disabled="" class="col-8">
                                                        <option value="<?php echo $datos['municipio'] ?>"><?php echo $datos['municipio'] ?></option>
                                                        <option value="<?php echo $datos['municipio'] ?>"><?php echo $datos['municipio'] ?></option>
                                            </select>
                                </div>
                                                   <!-- Iniciamos el segmento de codigo javascript -->
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                        var tbl_municipio = $('#tbl_municipio');

                                       //Ejecutar accion al cambiar de opcion en el select de las bandas
                                        $('#tbl_departamento').change(function(){
                                        var departamento_codigo= $(this).val(); //obtener el id seleccionado

                                        if(departamento_codigo !== ''){ //verificar haber seleccionado una opcion valida

                                        /*Inicio de llamada ajax*/
                                        $.ajax({
                                          data: { departamento_codigo : departamento_codigo }, //variables o parametros a enviar, formato => nombre_de_variable:contenido
                                          dataType: 'html', //tipo de datos que esperamos de regreso
                                          type: 'POST', //mandar variables como post o get
                                          url: '../includes/traer_municipios.php' //url que recibe las variables
                                        }).done(function(data){ //metodo que se ejecuta cuando ajax ha completado su ejecucion

                                          tbl_municipio.html(data); //establecemos el contenido html de discos con la informacion que regresa ajax
                                          tbl_municipio.prop('disabled', false); //habilitar el select
                                        });
                                        /*fin de llamada ajax*/

                                        }else{ //en caso de seleccionar una opcion no valida
                                        tbl_municipio.val(''); //seleccionar la opcion "- Seleccione -", osea como reiniciar la opcion del select
                                        tbl_municipio.prop('disabled', true); //deshabilitar el select
                                        }
                                        });

                                        });
                                    </script>

                                  <div class="row justify-content-center">

                                        <button type="submit" class="btn btn-primary col-6  rounded-pill"> ACTUALIZAR </button>
                                  </div>
                          </form>
                    </div>
                       <div class="hijo">

                              <img class="img-fluid" src="../img/proveedor.png">

                          </div>  
              </div>



    </body>
</html>