<?php
include "../includes/conexion.php";


// inicializar vairables
$fecha = $_POST["fecha"];
$usuario = $_POST["usuario"];
//arreglos 
$cod_receta = $_POST["receta"];
$cantidad = $_POST["cantidad"];




$guardar_produccion = "INSERT INTO tblproduccion(codigo,fecha,usuario)
VALUES (NULL,'$fecha','$usuario')";

//sacar el id A_I que se insertó en la anterior consulta

if (mysqli_query($conexion, $guardar_produccion)) {
    $ultimo_id = mysqli_insert_id($conexion);
} else {
    echo "La inserción no se realizó";
}

//foreach para recorrer y guardar los arreglos
foreach ($cod_receta as $index => $cod) {


    $guardar_produccion_receta = "INSERT INTO
                             tblproduccionreceta(cod_produccion,cod_receta,cantidad)
                                 VALUES ('$ultimo_id','$cod','{$cantidad[$index]}')";

    $resultado_produccion_receta = $conexion->query($guardar_produccion_receta);
}


// validar variaables
if ($guardar_produccion && $resultado_produccion_receta) {

    echo '<script type="text/javascript">
	alert("La orden de producción ha sido creada!");
	window.location.href="registrar_produccion.php";
	</script>';
} else {

    echo '<script type="text/javascript">
                    alert("Hubo un error, intentar de nuevo");
                    window.location.href="registrar_produccion.php";
                    </script>';
}

include "../includes/desconexion.php";
