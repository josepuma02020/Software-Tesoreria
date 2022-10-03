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
    $clave = $_POST['clave'];
    $proceso = $_POST['proceso'];
    $pcreacion = $_POST['pcreacion'];
    $pverificacion = $_POST['pverificacion'];
    $paprobacion = $_POST['paprobacion'];
    $pautorizacion = $_POST['pautorizacion'];
    $pconfiguracion = $_POST['pconfiguracion'];

    if ($clave != '') {
        $claveh = password_hash($clave, PASSWORD_DEFAULT);
        $consulta = "UPDATE `usuarios` SET `clave`='$claveh' WHERE  idusuario = '$id'";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }
    if ($proceso != 0) {
        echo   $consulta = "UPDATE `usuarios` SET `idproceso`='$proceso' WHERE  idusuario = '$id'";
        echo $query = mysqli_query($link, $consulta) or die($consulta);
    }

    $consulta = "UPDATE `usuarios` SET `nombre`='$nombre',`correo`='$correo',`usuario`='$usuario',`creacion`='$pcreacion',`verificacion`='$pverificacion',`aprobacion`='$paprobacion',`autorizacion`='$pautorizacion',`configuracion`='$pconfiguracion' WHERE  idusuario = '$id'";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
}
