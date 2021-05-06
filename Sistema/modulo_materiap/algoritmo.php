<?php

function MateriaVencida($codigo, $unidades_disponibles)
{

	// traer conexion
	include("../includes/conexion.php");

	// traer unidades 
	$sql = "SELECT unidades_disponibles  From tblmateriaprima where year(fecha_vencimiento) < year(now())";
	// ejecutar query
	$result = mysqli_query($conexion, $sql);

	$unidades_disponibles1 = mysqli_fetch_row($result)[0];
	// restar unidades a unidades existentes
	$cantidadNueva = abs($unidades_disponibles - $unidades_disponibles1);
	// actualizar datos
	$sql = "UPDATE tblmateriaprima set unidades_disponibles = '$cantidadNueva' where codigo = '$codigo'";

	mysqli_query($conexion, $sql);
}
