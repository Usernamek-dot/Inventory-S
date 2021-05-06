<?php 
include ("../includes/conexion.php");

error_reporting(0);
$codigo = $_POST['codigo'];
$fecha = $_POST["fecha"];
$producto = $_POST["producto"];
$usuario = $_POST["usuario"];
$descripcion = $_POST["descripcion"];  


$up_receta = $conexion -> query("UPDATE tblreceta SET fecha='$fecha',producto='$producto',usuario='$usuario',descripcion='$descripcion'  WHERE codigo='$codigo' ");
if ($up_receta ) {
	echo'<script type="text/javascript">
	alert("Actualización realizada");
	window.location.href="registrar_receta.php";   
	</script>';
}
else{
	echo'<script type="text/javascript">
	alert("Hubo un error. Intente nuevamente.");
	window.location.href="registrar_receta.php";   
	</script>';
	// echo "Error: {$conexion->error}";

}
