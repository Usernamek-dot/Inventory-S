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
	alert("Se eliminará el producto");
	window.location.href="registro_producto.php";   
	</script>';
}

else{
echo "<script> alert('El producto no pudo ser eliminado, porque se está usando.'); 	location.href='registro_producto.php'; </script>";
}



 ?>