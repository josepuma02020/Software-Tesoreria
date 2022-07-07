<?php

session_start();
if ($_SESSION['usuario']) {
    include_once('../conexion/conexion.php');
    include_once('../notascontables/clasenotas.php');

    $obj = new notascontables();
    echo json_encode($obj->obtenerdatoscuenta($_POST['cuenta']));
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
