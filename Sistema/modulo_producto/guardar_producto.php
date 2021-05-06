<?php
include ("../includes/conexion.php");

// inicializar variables
$codigo =$_POST["codigo"];
$nombre = $_POST["nombre"];
$fecha_creacion = $_POST["fecha"];
$fecha_vencimiento = $_POST["fecha_vencimiento"];
$categoria = $_POST["categoria"];
$unidades_disponibles = $_POST["unidades_disponibles"];
$unidad_medida = $_POST["unidad_medida"];
$precio = $_POST["precio"];


// query de insertar
$guardar = "INSERT INTO tblproductoterminado(codigo,nombre,fecha_creacion,fecha_vencimiento,categoria,unidades_disponibles,unidad_medida,precio) VALUES ('$codigo','$nombre','$fecha_creacion','$fecha_vencimiento','$categoria','$unidades_disponibles','$unidad_medida','$precio')";
// validar
if ($conexion->query($guardar) === TRUE) {
	echo'<script type="text/javascript">
	alert("Producto creado!");
	window.location.href="registro_producto.php";   
	</script>';

}else {
	echo'<script type="text/javascript">
	alert("Hubo un error! Intente nuevamente, recuerde que el codigo solo debe ser numerico.");
	window.location.href="registro_producto.php";   
	</script>';
}



include ("../includes/desconexion.php");
?>	