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
    include_once('../conexion/conexion.php');
    include_once('../notascontables/clasenotas.php');

    $obj = new notascontables();
    echo json_encode($obj->obtenerdatoscuenta($_POST['cuenta']));
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
