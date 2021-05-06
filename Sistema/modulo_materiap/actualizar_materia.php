<?php 
{ 
    session_start();
    error_reporting(0);
 
    if(empty($_SESSION['rol']))
    {
        header('location: ../ingreso/login.php');
    }
 
}
include ("../includes/conexion.php");
$codigo = $_REQUEST['codigo'];  
// $_REQUEST Un array asociativo que por defecto contiene el contenido de $_GET, $_POST y $_COOKIE
$seleccionar = $conexion -> query("SELECT mp.codigo as'codigo',mp.nombre as 'nombre',
                    mp.unidades_disponibles as 'unidades_disponibles',mp.fecha_vencimiento,
                    um.nombre as 'unidad_medida' 
                     FROM tblmateriaprima as mp INNER JOIN tblunidadmedida as um 
                     ON mp.unidad_medida=um.codigo WHERE mp.codigo=".$codigo);
if ($datos= $seleccionar -> fetch_assoc()) {
}
  $consulta_u_medida =  mysqli_query($conexion, "SELECT codigo , nombre  FROM tblunidadmedida"); 
 ?>
 <!DOCTYPE html>
<html>

     <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
         <title> Actualizar | Materia prima</title>
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script> <!---libreria jquery--->   
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../bootstrap/css/estilos/materia_prima.css">
         <link rel="icon" href="../img/logo_prov_pestaña.png" />
        <script src="../bootstrap/js/popper.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>          
        <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
           <script src="https://kit.fontawesome.com/fa9adf4dd2.js" crossorigin="anonymous"></script>
    </head>
</head>
<body>
<header class="d-flex justify-content-between">
      <div class="d-flex justify-content-start  mb-3 ">
              <?php include "../includes/btnVolver.php"; ?>
            </div>
      <center>
      <h3 class=" font-weight-normal  display-4 ">ACTUALIZAR MATERIA PRIMA </h3>
        </center>
    </header>   
        <div class=" row padre d-flex justify-content-between">
            
                    <div class=" img hijo col-lg-6 col-sm-12 col-md-6 ">
                        <img class="img-fluid " src="../img/materia.png " >
                    </div> 
                            
                    <div class="hijo">
                        <div class="col-12 ">
                                <form action="update_materia.php" method="post"   name ="formulario" onsubmit="return (e);">
                                        <div class="form-group row" >
                                        <label class="col-md-12 col-lg-12  col-form-label">Código : </label><br><br>
                                        <input type="text" placeholder="Codigo" readonly name="codigo"  class="form-control col-md-12  col-lg-8 rounded" value="<?php echo $codigo ?>"> 
                                        </div>
                                        <div class="form-group row" >
                                        <label class="col-md-12 col-lg-12  col-form-label">Nombre : </label><br><br>
                                        <input type="text" placeholder="Nombre de la materia prima" name="nombre" id="nombre" class="form-control col-md-12  col-lg-8 rounded" value="<?php echo $datos['nombre'] ?>"> 
                                        </div>
                                        <div class="form-group row" >
                                        <label class="col-md-12 col-lg-12  col-form-label">Unidades disponibles:</label><br><br>
                                        <input type="text" placeholder="Unidad disponibles" name="unidades_disponibles" id="unidades_disponibles" value="<?php echo $datos['unidades_disponibles'] ?>" class="form-control col-md-12  col-lg-8 rounded"   > 
                                        </div>
                                        <div class="form-group row" >
                                        <label class="col-md-12 col-lg-12  col-form-label">Fecha de vencimiento: </label><br><br>
                                        <input type="date" placeholder="Fecha de vencimiento" name="fecha_vencimiento"  class="form-control col-md-12  col-lg-8 rounded" value="<?php echo $datos['fecha_vencimiento'] ?>"> 
                                        </div>
                                        <div class="form-group row" >
                                        <label class="col-md-12 col-lg-12  col-form-label" >Unidad de medida : </label><br><br>
                                         <select name="unidad_medida"   id="unidad_medida" class="form-control col-md-12  col-lg-8 rounded">
                                            <option value="<?php echo $datos['unidad_medida'] ?>"><?php echo $datos['unidad_medida'] ?></option>
                                            <?php
                                        while ($datos = mysqli_fetch_array($consulta_u_medida)) { //array recorre datos
                                        ?>
                                        <option value="<?php echo $datos['codigo'] ?>" > <?php echo $datos['nombre'] ?>  </option>
                                        <?php }?>
        
                                        </select>
                                        </div>
                                      
                                        
                                       
                                        <div class="form-group inline row justify-content-center">
                                        <input type="submit" value="Actualizar existencia" id="boton" class="btn btn-primary col-11  rounded-pill">
                                        </div>
                                    </form>
                    
                        </div>
                </div>      
        </div>

</body>        
</html>