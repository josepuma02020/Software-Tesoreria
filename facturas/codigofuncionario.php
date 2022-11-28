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
    $funcionario = $_POST['funcionario'];
    $consultafuncionario = "select * from listaan where nombre = '$funcionario'";
    $query = mysqli_query($link, $consultafuncionario) or die($consultafuncionario);
    $filafuncionario = mysqli_fetch_array($query);
    echo $resultado = $filafuncionario['idan'];
}
