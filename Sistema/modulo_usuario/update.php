<?php 
error_reporting(0);
include ("../includes/conexion.php");

$documento = $_POST["documento"];
$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$telefono = $_POST["telefono"];
$correo = $_POST["correo"];
$direccion = $_POST["direccion"];
$municipio = $_POST["municipio"];
$clave = $_POST["clave"];


//llamar procedimiento 
$proc = $conexion->prepare(" CALL sp_ActualizarUsuario('$documento','$nombres','$apellidos','$correo',
'$telefono','$direccion','$clave','$municipio')");

//ejecutar procedimiento
$reesult = $proc->execute();





if ($reesult ) {

	echo'<script type="text/javascript">
	alert("Actualizacion realizada");
	window.location.href="usuario.php";   
	</script>';
}
else{
// 	echo "Error: {$conexion->error}";
	
	echo'<script type="text/javascript">
	alert("Actualize todos los campos , en especial el municipio.");
	window.location.href="usuario.php";   
	</script>';
}

 ?>