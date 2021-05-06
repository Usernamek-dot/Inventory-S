<?php

// TRAER ROL PARA MOSTRAR EN FORMULARIO CONFIGURAR
require_once '../includes/conexion.php'; //libreria de conexion a la base

$usuario_doc = filter_input(INPUT_POST, 'usuario_doc'); //obtenemos el parametro que viene de ajax

if ($usuario_doc != '') { //verificamos nuevamente que sea una opcion valida

    if (!$conexion) {
        die("<br/>Sin conexión.");

    }

    /*Obtenemos el rol del usuario*/
    $sql = "SELECT
        tu.id, tu.nombre
    from
        tblusuario as u
            inner join
        tbltipousuario as tu ON u.tipo_usuario = tu.id
     where u.documento = " . $usuario_doc;

    $query = mysqli_query($conexion, $sql);
    $filas = mysqli_fetch_all($query, MYSQLI_ASSOC);
    mysqli_close($conexion);

    /***consultamos todos los roles  */

    $c_rol = mysqli_query($conexion, "SELECT * FROM tbltipousuario ");
}

?>

<?php foreach ($filas as $op): //creamos las opciones a partir de los datos obtenidos ?>
	    					<option disabled selected value="<?=$op['id']?>"><?=$op['nombre']?></option>
	                                        <?php endforeach;?>
                                    <option value="1" > Super Administrador </option>
                                    <option value="2" > Administrador </option>
                                    <option value="3"> Operario</option>




