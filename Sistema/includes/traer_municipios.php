<?php

// ARCHIVO DE SELECT DEPENDIENTE DE LOS MUNICIPIOS

require_once ('conexion.php'); //libreria de conexion a la base

$departamento_codigo = filter_input(INPUT_POST, 'departamento_codigo'); //obtenemos el parametro que viene de ajax

if($departamento_codigo != ''){ //verificamos nuevamente que sea una opcion valida
  
 
  if(!$conexion){
    die("<br/>Sin conexión.");

  }

  /*Obtenemos los discos de la departamento seleccionada*/
  $sql = "select codigo, nombre from tblmunicipio where tbl_departamentos_codigo = ".$departamento_codigo;
  $query = mysqli_query($conexion, $sql);
  $filas = mysqli_fetch_all($query, MYSQLI_ASSOC); 
  mysqli_close($conexion);
}

/* el combo dependiente */
?>
 
     </div>    
     <option value="">- Seleccione -</option>
    <?php foreach($filas as $op): //creamos las opciones a partir de los datos obtenidos ?>
    <option value="<?= $op['codigo'] ?>"><?= $op['nombre'] ?></option>
    <?php endforeach; ?>
