<?php

session_start(); //sesión iniciada

//desactivar errores
//error_reporting(0); 

$varSesion = $_SESSION["user"];

if( $varSesion == null  || $varSesion = ''){
    echo " No puede cerrar sesión ";
    die(); //que la acción muera aqui.
}


session_destroy(); //sesión destruida

header("location:login.php");


?>