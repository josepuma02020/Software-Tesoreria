<?php
session_start();
include('../conexion/conexion.php');
//include('funciones/funciones.php');
date_default_timezone_set('America/Bogota');
$usuario = htmlentities($_POST['user']);
$clave1 = htmlentities($_POST['password']);
echo $consulta = "SELECT * from  usuarios where usuario = '$usuario'";
$query = mysqli_query($link, $consulta) or die($consulta);
$arreglo = mysqli_fetch_array($query);
if ($arreglo['activo'] == 1 and $arreglo['Rol'] != 1) {
    header('Location: ' . "../index.php?m=4");
} else {
    if ($arreglo['rol'] == "4") {
        header('Location: ' . "../index.php?m=1");
    } else {
        $clave2 = $arreglo['clave'];
        $fecha = date("Y" . "-" . "m" . "-" . "d");
        $rol = $arreglo['rol'];
        //autenticacion
        if (password_verify($clave1, $clave2)) {
            $_SESSION['idusuario'] = $arreglo['idusuario'];
            $_SESSION['usuario'] = $usuario;
            $_SESSION['correo'] = $arreglo['correo'];
            $_SESSION['rol'] = $rol;
            $_SESSION['menu'] = "./layouts/navadmin.php";
            $_SESSION['nombre'] = $arreglo['nombre'];
            $_SESSION['activo'] = $arreglo['activo'];
            $_SESSION['idproceso'] = $arreglo['idproceso'];
            $_SESSION['creacion'] = $arreglo['creacion'];
            $_SESSION['verificacion'] = $arreglo['verificacion'];
            $_SESSION['aprobacion'] = $arreglo['aprobacion'];
            $_SESSION['autorizacion'] = $arreglo['autorizacion'];
            $_SESSION['configuracion'] = $arreglo['configuracion'];
            $_SESSION['tiempo'] = time();
            $consultaactconex = "update usuarios set ultingreso = '$fecha' where idusuario = $_SESSION[idusuario] ";
            $query = mysqli_query($link, $consultaactconex) or die($consultaactconex);
            header('Location: ' . "../revisionnotas.php?n=" . $_SESSION['idproceso']);
        } else {
            echo 'no';
            header('Location: ' . "../index.php?m=2");
        }
    }
}
