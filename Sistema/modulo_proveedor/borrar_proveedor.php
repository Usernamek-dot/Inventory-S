 <?php
	include("../includes/conexion.php");
	// traer pk nit
	$nit = $_REQUEST['nit'];


	// Sí funcionó el procedimiento

	$proc = $conexion->prepare(" CALL sp_EliminarProveedor('$nit')");

	// ejecutar
	$del = $proc->execute();

	// validar
	if ($del) {
		echo '<script type="text/javascript">
	alert("Se eliminará el provedor");
	window.location.href="registro_proveedor.php";   
	</script>';
	} else {
		echo "<script> alert('El registro no pudo ser eliminado, porque se está utilizando en otro registro'); 	location.href='registro_proveedor.php'; </script>";
	}



	?>