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
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $proceso = $_POST['proceso'];

    $consulta = "INSERT INTO `usuarios`(`idusuario`, `nombre`, `correo`, `usuario`, `clave`, `rol`, `activo`, `ultingreso`, `idproceso`) 
    VALUES ('','$nombre','$correo',' $usuario','$clave ',' $rol','0',NULL,'$proceso')";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
}
