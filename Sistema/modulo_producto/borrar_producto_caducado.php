<?php 
include ("../includes/conexion.php");
// traer codigo
$codigo =$_REQUEST['codigo'];
// llamar procedimiento

$proc = $conexion->prepare(" CALL sp_EliminarProducto('$codigo')");
// ejecutarlo

$del = $proc->execute();
// validar

if ($del) 

{
	echo'<script type="text/javascript">
	alert("Se eliminará el producto ");
	window.location.href="producto_caducado.php";   
	</script>';
}

else{
echo '<script type="text/javascript">
	alert("El producto no puede ser eliminado  porque se está usando.");
	window.location.href="producto_caducado.php";   
	</script>';
}



 ?>