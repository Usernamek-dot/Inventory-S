 <?php
	include "../includes/conexion.php";

	// traer codigo
	$codigo = $_REQUEST['codigo'];


	// llamar procedimiento

	$proc = $conexion->prepare(" CALL sp_EliminarProduccion('$codigo')");

	// ejecutarlo
	$del = $proc->execute();


	// validar

	if ($del) {
		echo '<script type="text/javascript">
	alert("Se eliminará la orden de producción");
	window.location.href="registrar_produccion.php";
	</script>';
	} else {
		echo "<script> alert('La orden de producción no se eliminó, volver a intentar');
   				  location.href='registrar_produccion.php'; </script>";
	}

	?>