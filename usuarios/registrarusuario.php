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
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $proceso = $_POST['proceso'];
    $nconfiguracion = $_POST['nconfiguracion'];
    $nautorizacion = $_POST['nautorizacion'];
    $naprobacion = $_POST['naprobacion'];
    $nverificacion = $_POST['nverificacion'];
    $ncreacion = $_POST['ncreacion'];
    $claveh = password_hash($clave, PASSWORD_DEFAULT);
    $consulta = "INSERT INTO `usuarios`(`idusuario`, `nombre`, `correo`, `usuario`, `clave`, `rol`, `activo`, `ultingreso`, `idproceso`, `creacion`, `verificacion`, `aprobacion`, `autorizacion`, `configuracion`) 
    VALUES ('','$nombre','$correo','$usuario','$claveh ','$rol','0',NULL,'$proceso','$ncreacion','$nverificacion','$naprobacion','$nautorizacion','$nconfiguracion')";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
}
