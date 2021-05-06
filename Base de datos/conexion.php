
<?php

/*-----------------------------------------creación de varible que se conecta a la base de datos-------------------------------------*/ 

$servername="mysql.adsisena.net";
$username="userdb_adsisena";
$password="Adsisena2020";
$db="db_inventoryadsi";

$conexion = new mysqli($servername,$username,$password,$db);



/*------------------------------------------comprobando la conexion------------------------------------------------------------------*/


if ($conexion->connect_error) {
  die("Connection failed: " . $conexion->connect_error);

}



?>