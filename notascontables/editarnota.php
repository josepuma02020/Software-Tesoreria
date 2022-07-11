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
    $type = $_POST['type'];
    $clasificacion = $_POST['clasificacion'];
    $comentario = $_POST['comentario'];
    $batch = $_POST['batch'];
    $usuario = $_POST['usuario'];
    $id = $_POST['id'];

    $consulta = "UPDATE `notascontables` SET `idtipodocumento`='$type',
    `idclasificacion`= '$clasificacion',`batch`='$batch',`comentario`='$comentario' WHERE idnota = '$id'";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
}
