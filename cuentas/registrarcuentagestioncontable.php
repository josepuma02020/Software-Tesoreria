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
    $concepto = $_POST['concepto'];
    $tipo = $_POST['tipo'];

    echo $consulta = "INSERT INTO `cuentas`(`idcuenta`, `descripcion`, `idproceso`, `concepto`, `tipo`) 
    VALUES ('$cuenta','$descripcion','$_SESSION[idproceso]','$concepto','$tipo')";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
}
