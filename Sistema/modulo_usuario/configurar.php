<?php

// FORMULARIO ROL

require_once '../includes/conexion.php';

$documento = $_REQUEST['documento'];  

$rol= $_POST["tipousuario"];


$guardar = $conexion -> query("UPDATE tblusuario SET tipo_usuario='$rol' WHERE documento='$documento' ");


if ( $guardar) {
	
	echo'<script type="text/javascript"> 
	alert("Rol asignado correctamente !");
	window.location.href="usuario.php";   
    </script>'; 

}else {
	echo'<script type="text/javascript"> 
	alert("Algo falló! Volver a intentar.");
	window.location.href="usuario.php";   
	</script>'; 
	/****echo "Error: {$conexion->error}"; */	
}

include ("../includes/desconexion.php");

?>