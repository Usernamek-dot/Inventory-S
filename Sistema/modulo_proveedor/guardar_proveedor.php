<?php
include ("../includes/conexion.php");
// inicializar variables
$nit = $_POST["nit"];
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$direccion = $_POST["direccion"];
$telefono = $_POST["telefono"];
$correo = $_POST["correo"];   
$municipio = $_POST["municipio"];

// Sí funcionó el procedimiento

$proc = $conexion->prepare(" CALL sp_InsertarProveedor('$nit','$nombre','$apellido','$direccion','$telefono','$correo','$municipio')");
// ejecutar procedimiento
$del = $proc->execute();


// validar
if ($del === TRUE) {

	echo'<script type="text/javascript">
	alert("Proveedor registrado!");
	window.location.href="registro_proveedor.php";   
	</script>';

		}else{
				echo "Error  <br> <br> ".$guardar."<br><br>".$conexion_error;
}

include ("../includes/desconexion.php");
