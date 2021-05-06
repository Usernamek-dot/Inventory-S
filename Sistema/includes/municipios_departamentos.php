<?php

// ARCHIVO DE SELECT DEPENDIENTE DE LOS DEPARTAMENTOS
require_once('conexion.php');

/*Inicio obtenemos los datos del primer select*/
$sql = "select * from tbl_departamento";
$query = mysqli_query($conexion, $sql);
$filas = mysqli_fetch_all($query, MYSQLI_ASSOC); 
mysqli_close($conexion);
/* Fin Inicio obtenemos los datos del primer select*/
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Select Ajax</title>

  <!-- Inicia Librerias necesarias js-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Termina librerias necesarias js-->

  </head>
  <body>
    <label>departamentos</label>
    <select id="tbl_departamento">
      <option value="">- Seleccione -</option>
      <?php foreach ($filas as $op): //llenar las opciones del primer select ?>
      <option value="<?= $op['codigo'] ?>"> <?= $op['nombre'] ?> </option>  
      <?php endforeach; ?>
    </select>

    <br/><br/>
    <label>municipios</label>
    <select id="tbl_municipio" disabled="">
      <option value="">- Seleccione -</option>
    </select>

    <br/><br/>
    
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
              url: 'traer_municipios.php' //url que recibe las variables
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


        $('#tbl_municipio').change(function(){
          $('#municipio_sel').html($(this).val() + ' - ' + $('#tbl_municipio option:selected').text());
        });

      });
    </script>    
  </body>
</html>