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
    $an = $_POST['an'];
    $consultabanco = "select * from listaan where idan = '$an'";
    $query = mysqli_query($link, $consultabanco) or die($consultabanco);
    echo $resultado = mysqli_num_rows($query);
}
