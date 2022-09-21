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
    $desde = $_POST['desde'];
    $hasta = $_POST['hasta'];
    $batch = $_POST['batch'];

    $consultanotas = "select idnota from notascontables where seleccion=0 and fecha between '$desde' and '$hasta'";
    $querynotas = mysqli_query($link, $consultanotas) or die($consultanotas);
    while ($filasnotas = mysqli_fetch_array($querynotas)) {
        $consulta = "UPDATE `notascontables` SET `batch`= '$batch',idverificador = '$_SESSION[idusuario]',seleccion = 1
        WHERE idnota = '$filasnotas[idnota]'";
        $query = mysqli_query($link, $consulta) or die($consulta);
    }
}
