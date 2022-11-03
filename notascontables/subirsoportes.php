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
    // var_dump($_FILES);
    // echo count($_FILES);
    $iddoc = $_GET['iddoc'];

    if (is_dir('./' . $iddoc . '/')) {
    } else {
        mkdir('./' . $iddoc . '/', 0777,);
    }

    foreach ($_FILES as $file) {
        // $extension = pathinfo($file['name']['full_path'], PATHINFO_EXTENSION);
        move_uploaded_file($file['tmp_name'], './' . $iddoc . '/' . $file['name']);
    }
}
