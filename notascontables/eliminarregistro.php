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
    $id = $_POST['id'];
    $consulta = "DELETE FROM `registrosdenota` WHERE idregistro = '$id'";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
