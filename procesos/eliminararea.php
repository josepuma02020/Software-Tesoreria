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
    $id = $_POST['id'];

    $consultaverificacion = "select * from equipos where idarea= '$id'";
    $query = mysqli_query($link, $consultaverificacion) or die($consultaverificacion);
    $filaverificacion = mysqli_fetch_array($query);
    if (isset($filaverificacion)) {
        echo 'No';
    } else {
        $consulta = "DELETE FROM `areas` WHERE `idarea` = '$id'";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }
}
