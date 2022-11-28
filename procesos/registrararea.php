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
    $codarea = $_POST['codarea'];
    $area = $_POST['area'];
    $compania = $_POST['compania'];
    $consulta = "INSERT INTO `areas`(`idarea`, `area`, `codarea`, `codclasificacion`) VALUES ('','$area','$codarea','$compania')";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
}
