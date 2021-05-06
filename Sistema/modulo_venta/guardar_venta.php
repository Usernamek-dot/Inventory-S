<?php
    error_reporting(0);
    include "../includes/conexion.php";

    //llamar funcion
    include "algoritmo.php";

    $cliente = $_POST["cliente"];
    $fecha = $_POST["fecha"];
    $forma_pago = $_POST["forma_pago"];

    // Los siguientes son arreglos, todos con la misma cantidad de elementos
    $producto = $_POST["codigo"];
    $cantidad = $_POST["cantidad"];
    $unidades_disponibles = $_POST["unidades_disponibles"];





    $guardar_venta = "INSERT INTO tblfacturaventa(numero,cliente,fecha,forma_pago)
VALUES (NULL,'$cliente','$fecha','$forma_pago')";



    //sacar el id A_I que se insertó en la anterior consulta

    if (mysqli_query($conexion, $guardar_venta)) {
        $ultimo_id = mysqli_insert_id($conexion);
    } else {
        echo "La inserción no se realizó";
    }



    // Haces un ciclo para recorrer uno de los campos y usar el mismo índice para los otros:
    foreach ($producto as $index => $prod) {
        // Los elementos de arreglo deben encerrarse entre llaves
        $guardar_venta_producto = "INSERT INTO tblfacturventaproducto (factura_venta, producto, cantidad)
        VALUES ('$ultimo_id', '$prod', '{$cantidad[$index]}')";
        // Aquí ejecutas la consulta para insertar este producto
        $resultado_productos = $conexion->query($guardar_venta_producto);


        $c = $cantidad[$index];

        descuentaCantidad($prod,  $c);
    }






    if ($guardar_venta && $resultado_productos) {
        echo '<script type="text/javascript">
	alert("Factura Creada!");
	window.location.href="registrar_venta.php";
	</script>';
        
    } else {
        echo '<script type="text/javascript">
    alert("Algo falló! por favor revisa los datos.");
    window.location.href="registrar_venta.php";
    </script>';

          //echo "Error: {$conexion->error}";
    }
    include "../includes/desconexion.php";
