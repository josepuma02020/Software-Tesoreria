<?php
session_start();
if ($_SESSION['usuario']) {
    include('../conexion/conexion.php');
    date_default_timezone_set('America/Bogota');
    $id = $_POST['id'];
    $consulta = "select cuenta from cuentas where idcuenta = '$id'";
    $query = mysqli_query($link, $consulta) or die($consulta);
    $filas1 = mysqli_fetch_array($query);
    echo $filas1['cuenta'];
} else {
    echo "<script type=''>
        alert('favor iniciar sesion');
        window.location='index.php';
    </script>";
}
