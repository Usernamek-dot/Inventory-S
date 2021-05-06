<?php
require_once "../includes/conexion.php";

$numero = $_REQUEST['numero'];


//llamar procedimiento 
$proc = $conexion->prepare(" CALL sp_EliminarFacturaventa('$numero')");

//ejecutar procedimiento
$del = $proc->execute();


if ($del) {
    echo '<script type="text/javascript">
	alert("Se eliminará la factura");
	window.location.href="registrar_venta.php";
	</script>';
} else {
// echo "<script> alert('La factura no pudo ser eliminada');
// location.href='registrar_venta.php'; </script>";
 
    echo "Error: {$conexion->error}";
}
