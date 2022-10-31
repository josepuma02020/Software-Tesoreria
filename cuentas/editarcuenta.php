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
    $cuenta = $_POST['cuenta'];
    $descripcion = $_POST['descripcion'];
    $clasificacion = $_POST['clasificacion'];

    echo $consulta = "UPDATE `cuentas` SET `descripcion`='$descripcion',`clasificacion`='$clasificacion' WHERE `idcuenta`='$cuenta'";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
}
