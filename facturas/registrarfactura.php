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
    $hora = date('h:i a');
    $fecha_actual = date("Y-m-j");
    $valor = $_POST['valor'];
    $user = $_POST['user'];
    $tipo = $_POST['tipo'];
    $iddoc = $_POST['iddoc'];
    $comentario = $_POST['comentario'];
    $fechafactura = $_POST['fechafactura'];
    $ri = $_POST['ri'];
    $an = $_POST['an'];
    $cuenta = $_POST['cuenta'];
    echo $consulta = "INSERT INTO `facturas`(`iddoc`, `fechafactura`, `valor`, `idcuenta`, `idcreador`, `idrevisador`, `horaregistro`, `fecharegistro`, `idtipofactura`, `ri`, `tercero`, `fecharevision`, `horarevision`, `extensionarchivo`, `comentario`)VALUES 
    ('$iddoc','$fechafactura','$valor','$cuenta',' $_SESSION[idusuario]','','$hora', '$fecha_actual',' $tipo','  $ri','$an','','','','$comentario')";
    echo $query = mysqli_query($link, $consulta) or die($consulta);
}
