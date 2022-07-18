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
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];
    $usuario = $_POST['usuario'];
    echo $clave = $_POST['clave'];

    if ($clave != '') {
        $claveh = password_hash($clave, PASSWORD_DEFAULT);
        $consulta = "UPDATE `usuarios` SET `clave`='$claveh' WHERE  idusuario = '$id'";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }
    if ($rol != 0) {
        echo   $consulta = "UPDATE `usuarios` SET `rol`='$rol' WHERE  idusuario = '$id'";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }

    $consulta = "UPDATE `usuarios` SET `nombre`='$nombre',`correo`='$correo',`usuario`='$usuario' WHERE  idusuario = '$id'";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
}
