<?php
include ("../includes/conexion.php");

$proveedor = $_POST["proveedor"];
$forma_pago = $_POST["forma_pago"];
$fecha = $_POST["fecha"];
$numeroFactura = $_POST["numeroFactura"];

// arreglos

$codigo= $_POST["codigo"];
$nombre= $_POST["nombre"];
$unidad_medida=	 $_POST["unidad_medida"]; 
$fecha_vencimiento= $_POST["fecha_vencimiento"];
$unidades_disponibles = $_POST["cantidad"];
$precio_unitario = $_POST["precio_unitario"]; 

//encabezado

 
$guardar_compra = "INSERT INTO tblfacturacompra(numero,proveedorFactura,proveedor,forma_pago,fecha) 
VALUES (NULL,'$numeroFactura','$proveedor','$forma_pago','$fecha')";

//sacar el id A_I que se insertó en la anterior consulta

if (mysqli_query($conexion,$guardar_compra)) {
    $ultimo_id = mysqli_insert_id($conexion);

        } else {
            echo "La inserción no se realizó";
}

// ejecutar consulta
$resultado_compra = $conexion->query( $guardar_compra );

// Haces un ciclo para recorrer uno de los campos y usar el mismo índice para los otros:
foreach($codigo as $index => $cod) {


	//materia prima
	// Los elementos de arreglo deben encerrarse entre llaves	
	$guardar_materia_prima = "INSERT INTO 
	tblmateriaprima(codigo,nombre,unidad_medida,unidades_disponibles,fecha_vencimiento) 
	VALUES('$cod','{$nombre[$index]}','{$unidad_medida[$index]}',
	'{$unidades_disponibles[$index]}',
	'{$fecha_vencimiento[$index]}')";
	$resultado_materia= $conexion->query($guardar_materia_prima);

	//tabla puente
	// Los elementos de arreglo deben encerrarse entre llaves		
	$guardar_compra_materia = "INSERT INTO 
	tblfacturacompramateriaprima(materia_prima,factura_compra,cantidad,precio_unitario)
	VALUES ('$cod' ,' $ultimo_id','{$unidades_disponibles[$index]}', '{$precio_unitario[$index]}')";
    // ejecutar consulta
	$resultado_compra_materia= $conexion->query($guardar_compra_materia);

}



if (  $resultado_compra  && $resultado_materia && $resultado_compra_materia ) {
	
	echo'<script type="text/javascript"> 
	alert("Factura Creada!");
	window.location.href="registro_compra.php";   
	</script>';

	}else {
		// echo'<script type="text/javascript"> 
		// alert("Algo falló! Volver a intentar.");
		// window.location.href="registro_compra.php";   
		// </script>';
		echo "Error: {$conexion->error}";	
}

include ("../includes/desconexion.php");
?>	
