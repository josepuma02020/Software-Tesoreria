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
    $id = $_POST['iddoc'];
    $archivo = $_POST['archivo'];

    echo unlink('./' . $id . '/' . $archivo);
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
