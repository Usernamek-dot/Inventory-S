<?php
include "../includes/conexion.php";

$documento = $_POST["documento"];
$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$correo = $_POST["correo"];
$telefono = $_POST["telefono"];
$direccion = $_POST["direccion"];
$clave = $_POST["clave"];
$municipio = $_POST["municipio"];

$guardar = "INSERT INTO tblusuario(documento,nombres,apellidos,correo,telefono,direccion,clave,municipio)
VALUES ('$documento','$nombres','$apellidos','$correo','$telefono','$direccion','$clave','$municipio')";

if ($conexion->query($guardar) === true) {

    echo '<script type="text/javascript">
	alert("Datos insertados con exito !");
	window.location.href="login.php";
	</script>';
} else {
    echo '<script type="text/javascript">
	alert("Algo falló! Volver a intentar.");
	window.location.href="registrarse.php";
	</script>';

    /* echo "Error: {$conexion->error}";*/
}

include "../includes/desconexion.php";
