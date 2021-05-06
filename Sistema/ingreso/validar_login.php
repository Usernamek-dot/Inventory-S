<?php
        session_start(); // Esta debe ser siempre la primera instrucción
        include ("../includes/conexion.php");

        // Limpiar variables de sesión
        $_SESSION["user"] = '';
        $_SESSION["rol"] = 0;

        //funcion de seguridad
        $usuario = mysqli_real_escape_string($conexion, $_POST["documento"]) ;
        //funcon md5 contraseña encriptada
        $clave = mysqli_real_escape_string($conexion, $_POST["clave"]) ;
        // También se debe escapar este dato
        $rol = mysqli_real_escape_string($conexion, $_POST["rol"]);

        
        $consulta = " SELECT * FROM tblusuario WHERE documento = '$usuario' 
        and  clave = '$clave'  and tipo_usuario = '$rol' " ;
        $resultado = mysqli_query($conexion , $consulta);
        $datos = mysqli_fetch_assoc($resultado);
        
        //-----------verificar los roles y las interfazes---------------
        // $datos será falso si el usuario no existe
        // o arreglo asociativo si el usuario fue encontrado
        if($datos){
            // Los datos son correctos, ahora sí se pueden crear las variables de sesión
            $_SESSION["user"] = $usuario;
            $_SESSION["rol"] = $rol;

            if($rol == 1){
                header("location:interfaz_superadmin.php");
            } elseif($rol == 2){
                header("location:interfaz_admin.php");
            } elseif($rol == 3){
                header("location:interfaz_operario.php");
            } else {
                // Limpiar variables de sesión
                $_SESSION["user"] = '';
                $_SESSION["rol"] = 0;
                echo "No existe su rol ";
            }
        } else {
            echo'<script type="text/javascript">
            alert("Datos incorrectos");
            window.location.href="login.php";   
            </script>';
        }
        ?>