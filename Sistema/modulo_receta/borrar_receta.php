<?php
include "../includes/conexion.php";

$codigo = $_REQUEST['codigo'];

//llamar procedimiento 
$proc = $conexion->prepare(" CALL sp_EliminarReceta('$codigo')");

//ejecutar procedimiento
$del = $proc->execute();


if ($del) {
    echo '<script type="text/javascript">
	alert("Se eliminará la receta");
	window.location.href="registrar_receta.php";
	</script>';
} else {
    echo "<script> alert('La receta no se pudo eliminar ya que esta en uso');
  location.href='registrar_receta.php'; </script>";
    // echo "Error: {$conexion->error}";
}
