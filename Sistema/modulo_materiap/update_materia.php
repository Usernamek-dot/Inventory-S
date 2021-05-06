<?php 
include ("../includes/conexion.php");

// no mostrar errores en lal ui
error_reporting(0);

// inicializar variables
$codigo =$_POST["codigo"];
$nombre = $_POST["nombre"];
$unidad_medida = $_POST["unidad_medida"];
$unidades_disponibles = $_POST["unidades_disponibles"];
$fecha_vencimiento = $_POST["fecha_vencimiento"];



//llamar procedimiento 
$proc= $conexion->prepare(" CALL sp_ActualizarMateriaPrima('$codigo','$nombre','$unidad_medida','$unidades_disponibles','$fecha_vencimiento')");
//ejecutar procedimiento
$up = $proc->execute();



// validar con alertas
if ($up) {
	echo'<script type="text/javascript">
	alert("Actualización realizada");
	window.location.href="inventario_materia.php";   
	</script>';
}
else{
	echo'<script type="text/javascript">
	alert("hubo un error. Actualize la unidad de medida");
	window.location.href="inventario_materia.php";   
	</script>';
}


 ?>