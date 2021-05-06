<?php
include("../includes/conexion.php");
?>

<html>

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <!-----logo---->
    <link rel="shortcut icon" href="../img/logo_prov_pestaña.png" type="image/x-icon">
    <script src="../bootstrap/js/jquery-3.5.1.min.js"></script>

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/css/estilos/login.css">
    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>


</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Iniciar Sesión</h5>
                        <form class="form-signin" action="validar_login.php" method="post">
                            <div class="form-label-group">
                                <input type="text" name="documento" id="documento" class="form-control" placeholder="Documento de identidad" required autofocus>
                                <label for="documento">Documento de identidad</label>
                            </div>
                            <div class="form-label-group">
                                <input placeholder="Clave" name="clave" id="clave" type="password" Class="form-control"  required>
                                <label for="clave">  Clave  </label>
                                <input type="checkbox"  for="clave" onclick="mostrarClave()"  style="height: 12px; width: 12px; " >  Mostrar  Clave

                            </div>


                            <!-- ------------- JQUERY SCRIPT PARA VIZUALIZAR CONTRASEÑA----------------- -->
                            <script>
                                function mostrarClave() {
                                    var tipo = document.getElementById("clave");
                                    if (tipo.type == "password") {
                                        tipo.type = "text";
                                    } else {
                                        tipo.type = "password";
                                    }
                                }
                            </script>
                            <div class="form-label-group">
                                <select name="rol" id="rol" class="form-control " required>
                                    <option value="" disabled selected> Tipo de usuario </option>
                                    <option value="1"> Super administrador </option>
                                    <option value="2"> Administrador </option>
                                    <option value="3"> Operario</option>
                                </select>

                            </div>

                            <hr class="my-4">
                            <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Ingresar</button>
                            <a href="registrarse.php" class="btn btn-lg btn-google btn-block text-uppercase" type="submit"><i class="fas fa-sign-in-alt"></i> Registrarse</a>
                            <a href="../index.html" class="btn btn-lg btn-facebook btn-block text-uppercase" type="submit"><i class="fas fa-home"></i> Página Principal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
include("../includes/desconexion.php");
?>