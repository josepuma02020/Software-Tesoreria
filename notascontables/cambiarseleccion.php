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

    $consultaestadoactual = "select seleccion from notascontables WHERE idnota = '$id'";
    $queryestado = mysqli_query($link, $consultaestadoactual) or die($consultaestadoactual);
    $filaestado = mysqli_fetch_array($queryestado);

    if ($filaestado['seleccion'] == 1) {
        $consulta = "UPDATE `notascontables` SET `seleccion`=0 
        WHERE idnota = '$id'";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    } else {
        $consulta = "UPDATE `notascontables` SET `seleccion`=1
        WHERE idnota = '$id'";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }
}
