<?php 
include ("../includes/conexion.php");

$codigo =$_REQUEST['codigo'];
$proc = $conexion->prepare(" CALL sp_EliminarMateriaPrima('$codigo')");
$del = $proc->execute();
if ($del) 

{
	echo'<script type="text/javascript">
	alert("Se eliminará la existencia");
	window.location.href="inventario_materia_caducada.php";   
	</script>';
}

else{
echo '<script type="text/javascript">
	alert("La materia no pudo ser eliminada, porque se utilizó.");
	window.location.href="inventario_materia_caducada.php";   
	</script>';
}



 ?>