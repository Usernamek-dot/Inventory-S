<?php


// CODIGO PARA TRAER EL ROL
require_once '../includes/conexion.php';

/*Inicio obtenemos los datos del primer select*/
$sql = "select documento , tipo_usuario from tblusuario";
$query = mysqli_query($conexion, $sql);
$filas = mysqli_fetch_all($query, MYSQLI_ASSOC);
mysqli_close($conexion);
/* Fin Inicio obtenemos los datos del primer select*/
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

  </head>
  <body>
<div class="form-group row" >   
  <label class="col-lg-6 col-form-label"> Documento: </label><br><br>
    <select id="tblusuario" name="documento" class="col-lg-6 "  >
      <option  disabled selected>- Seleccione -</option>
      <?php foreach ($filas as $op): //llenar las opciones del primer select ?>
														 <option value="<?=$op['documento']?>"> <?=$op['documento']?> </option>
														<?php endforeach;?>
    </select>
</div>

<div class="form-group row" >   
    <label class="col-lg-6  col-form-label " for="rol">Tipo de usuario: </label><br> 
       <select id="tbltipousuario" name="tipousuario" disabled="" class="col-lg-6 " >
      <option disabled selected >- Seleccione -</option>
    <?php foreach ($filas as $op): //llenar las opciones del primer select ?>
														 <option value="<?=$op['id']?>"> <?=$op['nombre']?> </option>
														<?php endforeach;?>
    </select>
</div>

<input type="submit" value="CONFIGURAR USUARIO" id="boton" class="btn btn-primary col-lg-6 rounded-pill">

   

     <!-- Iniciamos el segmento de codigo javascript -->
    <script type="text/javascript">
      $(document).ready(function(){
        var tbltipousuario = $('#tbltipousuario');

        //Ejecutar accion al cambiar de opcion en el select de las bandas
        $('#tblusuario').change(function(){
          var usuario_doc= $(this).val(); //obtener el id seleccionado

          if(usuario_doc !== ''){ //verificar haber seleccionado una opcion valida

            /*Inicio de llamada ajax*/
            $.ajax({
              data: { usuario_doc : usuario_doc }, //variables o parametros a enviar, formato => nombre_de_variable:contenido
              dataType: 'html', //tipo de datos que esperamos de regreso
              type: 'POST', //mandar variables como post o get
              url: 'traer_rol.php' //url que recibe las variables
            }).done(function(data){ //metodo que se ejecuta cuando ajax ha completado su ejecucion
              if(data != '') {
                tbltipousuario.html(data); //establecemos el contenido html de discos con la informacion que regresa ajax
              }
              tbltipousuario.prop('disabled', false); //habilitar el select
            }); 
            /*fin de llamada ajax*/

          }else{ //en caso de seleccionar una opcion no valida
            tbltipousuario.val(''); //seleccionar la opcion "- Seleccione -", osea como reiniciar la opcion del select
            tbltipousuario.val('');
            tbltipousuario.prop('disabled', true); //deshabilitar el select
          }
        });


        //mostrar una leyenda con el disco seleccionado
        $('#tbltipousuario').change(function(){
          $('#tbltipousuario_sel').html($(this).val() + ' - ' + $('#tbltipousuario option:selected').text());
        });

      });
    </script>
  </body>
</html>
