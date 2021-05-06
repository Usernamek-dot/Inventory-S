
<?php

/*-----------------------------------------creación de varible que se conecta a la base de datos-------------------------------------*/ 

$servername="localhost";
$username="root";
$password="";
$db="inventario";

$conexion = new mysqli($servername,$username,$password,$db);



/*------------------------------------------comprobando la conexion------------------------------------------------------------------*/


if ($conexion->connect_error) {
  die("Connection failed: " . $conexion->connect_error);

}



?>