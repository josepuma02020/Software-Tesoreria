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
    $iddocumento = $_POST['iddocumento'];
    $fecha_actual = date("Y-m-d");
    $hora = date('h:i a');
    $consulta = "UPDATE `notascontables` SET `idaprobador`= '$_SESSION[idusuario]',fechaaprobacion = '$fecha_actual',`horaaprobacion`= '$hora'
        WHERE idnota = '$iddocumento'";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
}
