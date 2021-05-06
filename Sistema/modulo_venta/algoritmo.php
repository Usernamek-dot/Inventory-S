<?php

function descuentaCantidad($prod,  $c)
{


    include("../includes/conexion.php"); //llamar conexion

// traer unidades del producto
    $sql = "SELECT unidades_disponibles  From tblproductoterminado where codigo='$prod'"; 
// recorrer query
    $result = mysqli_query($conexion, $sql);


    $cantidad1 = mysqli_fetch_row($result)[0];
// restar  a la cantidad existente la nueva
    $cantidadNueva = abs($c - $cantidad1);
// actualizar
    $sql = "UPDATE tblproductoterminado set unidades_disponibles = '$cantidadNueva' where codigo = '$prod'";

// recorrer query
    mysqli_query($conexion, $sql);

    return $sql;
}
