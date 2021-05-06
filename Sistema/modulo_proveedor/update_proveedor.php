<?php
include("../includes/conexion.php");

// inicializar variables
$nit = $_POST["nit"];
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$direccion = $_POST["direccion"];
$telefono = $_POST["telefono"];
$correo = $_POST["correo"];
$municipio = $_POST["municipio"];

//llamar procedimiento 
$proc = $conexion->prepare(" CALL sp_ActualizarProveedor('$nit', '$nombre','$apellido',
'$direccion','$telefono','$correo','$municipio')");

//ejecutar procedimiento
$up = $proc->execute();

if ($up) {
	echo '<script type="text/javascript">
    alert("Actualización realizada");
    window.location.href="registro_proveedor.php";   
    </script>';
} else {
	echo'<script type="text/javascript">
	alert("Debe actualizar el municipio. Si todavía habita en el mismo municipio pongalo nuevamente junto con el departameento correspondiente");
	window.location.href="registro_proveedor.php";   
	</script>';


}
