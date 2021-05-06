<?php 
include ("../includes/conexion.php");

// inicializar variables
$codigo =$_POST["codigo"];
$nombre = $_POST["nombre"];
$fecha_creacion = $_POST["fecha_creacion"];
$fecha_vencimiento = $_POST["fecha_vencimiento"];
$categoria = $_POST["categoria"];
$unidades_disponibles = $_POST["unidades_disponibles"];
$unidad_medida = $_POST["unidad_medida"];
$precio = $_POST["precio"];


//llamar procedimiento 
$proc= $conexion->prepare(" CALL sp_ActualizarProducto('$codigo','$nombre','$fecha_creacion','$fecha_vencimiento','$categoria','$unidades_disponibles','$unidad_medida','$precio')");
//ejecutar procedimiento
$up = $proc->execute();
if ($up) {
	echo'<script type="text/javascript">
	alert("Actualización realizada");
	window.location.href="registro_producto.php";   
	</script>';
}
else{
	//  echo "Error: {$conexion->error}";
	echo'<script type="text/javascript">
	alert("Hubo un error");
	window.location.href="registro_producto.php";   
	</script>';
}

 ?>