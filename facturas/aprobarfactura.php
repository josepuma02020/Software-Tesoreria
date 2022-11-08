<?php
session_start();
if (time() - $_SESSION['tiempo'] > 500) {
    //session_destroy();
    /* Aquí redireccionas a la url especifica */
    session_destroy();
    header('Location: ' . "index.php?m=5");
    //die();
} else {
    $_SESSION['tiempo'] = time();
}
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    date_default_timezone_set('America/Bogota');
    $iddocumento = $_POST['iddocumento'];
    $fecha_actual = date("Y-m-d");
    $hora = date('h:i a');
    $consulta = "UPDATE `facturas` SET `idrevisador`='$_SESSION[idusuario]',`fecharevision`='$fecha_actual',`horarevision`='$hora'  
        WHERE iddoc = '$iddocumento'";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
}
