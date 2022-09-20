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
    $nombre = $_POST['nombre'];

    echo $consulta = "INSERT INTO `listaan`(`idan`, `nombre`) VALUES ('$id','$nombre')";
    $query = mysqli_query($link, $consulta) or die($consulta);
}
