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
        switch ($rol) {
            case '1':
                $menu = "./layouts/navadmin.php";
                break;
            case 2:
                $menu = "./layouts/navverificador.php";
                break;
            case 3:
                $menu = "./layouts/navverificador.php";
                break;
        }
        //autenticacion
        if (password_verify($clave1, $clave2)) {
            echo 1;
            $_SESSION['idusuario'] = $arreglo['idusuario'];
            $_SESSION['usuario'] = $usuario;
            $_SESSION['rol'] = $rol;
            $_SESSION['menu'] = $menu;
            $_SESSION['nombre'] = $arreglo['nombre'];
            $_SESSION['activo'] = $arreglo['activo'];
            $_SESSION['idproceso'] = $arreglo['idproceso'];
            $_SESSION['tiempo'] = time();
            $consultaactconex = "update usuarios set ultingreso = '$fecha' where idusuario = $_SESSION[idusuario] ";
            $query = mysqli_query($link, $consultaactconex) or die($consultaactconex);
            header('Location: ' . "../informes.php");
        } else {
            echo 'no';
            header('Location: ' . "../index.php?m=2");
        }
    }
}
