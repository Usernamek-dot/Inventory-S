<?php
include "../includes/conexion.php";

$numero = $_REQUEST['numero'];


//llamar procedimiento 
$proc = $conexion->prepare(" CALL sp_EliminarFacturacompra('$numero')");

//ejecutar procedimiento
$del = $proc->execute();

if ($del) {
	echo '<script type="text/javascript">
	alert("Se eliminará la factura");
	window.location.href="registro_compra.php";
	</script>';
} else {
	echo "<script> alert('Esta factura no puede ser eliminada.');
      		location.href='registro_compra.php'; </script>";
	// echo "Error: {$conexion->error}";
}
