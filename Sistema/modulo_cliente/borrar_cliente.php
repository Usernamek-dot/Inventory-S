<?php
include("../includes/conexion.php");

$documento = $_REQUEST['documento']; //traer doc
$proc = $conexion->prepare(" CALL sp_EliminarCliente('$documento')");
$del = $proc->execute(); //ejecutar procedimiento

//validar
if ($del) {
	echo '<script type="text/javascript">
	alert("Se eliminará el cliente");
	window.location.href="registro_cliente.php";   
	</script>';
} else {
	echo "<script> alert('El cliente no pudo ser eliminado porque esta en una factura de venta'); 	location.href='registro_cliente.php'; </script>";
}
