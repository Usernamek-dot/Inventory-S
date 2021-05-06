<?php
include ("../includes/conexion.php"); //traer conexion

//capturar datos
$documento = $_POST["documento"];
$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$telefono = $_POST["telefono"]; 
$correo = $_POST["correo"];
$direccion = $_POST["direccion"];
$municipio = $_POST["municipio"];

//insertar datos en tabla
$guardar = "INSERT INTO tbl_cliente(documento,nombres,apellidos,telefono,correo,direccion,municipio)  VALUES ('$documento','$nombres','$apellidos','$telefono','$correo','$direccion','$municipio')";


// validacion
if ($conexion->query($guardar) === TRUE) {
	echo'<script type="text/javascript">
	alert("Cliente creado!");
	window.location.href="registro_cliente.php";   
	</script>';

}else {
'<script type="text/javascript">
	alert("Ocurrió un error, verifica los datos..");
	window.location.href="registro_cliente.php";   
	</script>';}
include("../includes/desconexion.php");
?>