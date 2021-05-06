 <?php 
include ("../includes/conexion.php");


$documento = $_POST["documento"];  //documento='$documento',
$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$telefono = $_POST["telefono"];
$correo = $_POST["correo"];
$direccion = $_POST["direccion"];
//CAPTURAR EL CODIGO
$municipio = $_POST["municipio"];
//llamar procedimiento 
$proc= $conexion->prepare("CALL sp_ActualizarCliente('$documento','$nombres','$apellidos','$telefono','$correo','$direccion','$municipio')");
//ejecutar procedimiento
$up = $proc->execute();
/*$up = $conexion -> query("UPDATE tbl_cliente SET nombres='$nombres',
apellidos='$apellidos',telefono='$telefono',correo='$correo',
direccion='$direccion' , municipio='$municipio'  WHERE documento='$documento' ");*/
if ($up) {

	echo'<script type="text/javascript">
	alert("Actualización realizada");
	window.location.href="registro_cliente.php";   
	</script>'; 
	
}
else{
	// echo "Error: {$conexion->error}";
	
	echo'<script type="text/javascript">
	alert("Debe actualizar el municipio");
	window.location.href="registro_cliente.php";   
	</script>'; 
}

 ?>