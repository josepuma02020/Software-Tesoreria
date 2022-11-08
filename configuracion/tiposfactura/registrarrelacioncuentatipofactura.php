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
    include('../../conexion/conexion.php');
    date_default_timezone_set('America/Bogota');
    $tipo = $_POST['tipo'];
    $cuenta = $_POST['cuenta'];
    $consulta = "INSERT INTO `cuentastipofactura`(`id`, `idtipofactura`, `idcuenta`) VALUES ('','$tipo','$cuenta')";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
}
