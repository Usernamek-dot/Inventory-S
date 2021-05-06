<?php
include ("../includes/conexion.php");

$fecha = $_POST["fecha"];
$producto = $_POST["producto"];
$usuario = $_POST["usuario"];
$descripcion = $_POST["descripcion"];

//arreglos
$materia = $_POST["materia"];
$cantidad = $_POST["cantidad"];

   
//encabezado
$guardar_receta = "INSERT INTO tblreceta(fecha,producto,usuario,descripcion) 
VALUES ('$fecha','$producto','$usuario','$descripcion')";

//sacar el id A_I que se insertó en la anterior consulta

if (mysqli_query($conexion, $guardar_receta)) {
    $ultimo_id = mysqli_insert_id($conexion);

} else {
    echo "La inserción no se realizó";
}

$up_estadoProducto = $conexion -> query("UPDATE tblproductoterminado  SET estado='1' WHERE codigo='$producto' ");





// un ciclo para recorrer uno de los campos y usar el mismo índice para los otros:
foreach($materia as $index => $m) {


	//tabla compuesta
	// Los elementos de arreglo deben encerrarse entre llaves	
	$guardar_materia_receta = "INSERT INTO 
	tblmateriaprimareceta(materia_prima,receta,cantidad) 
	VALUES ('{$materia[$index]}','$ultimo_id','{$cantidad[$index]}')";
    // ejecutar consulta
	$resultado_materia_receta = $conexion->query( $guardar_materia_receta);


 
}




if ( $guardar_receta && $resultado_materia_receta ) {
	echo'<script type="text/javascript"> 
	alert("Receta  Creada!");
	window.location.href="registrar_receta.php";   
	</script>';
	// echo  "si";

}else {
	echo'<script type="text/javascript"> 
	alert("Hubo un error , volver a intentar!(Revise que los ingredientes de su receta no esten repetidos.)");
	window.location.href="registrar_receta.php";   
	</script>'; 
	// echo "Error: {$conexion->error}";
}

include ("../includes/desconexion.php");
?>	