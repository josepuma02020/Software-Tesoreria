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
    var_dump($_FILES);
    $iddoc = $_GET['iddoc'];
    $extension = pathinfo($_FILES['soporte']['full_path'], PATHINFO_EXTENSION);
    move_uploaded_file($_FILES['soporte']['tmp_name'], './soportes/' . $iddoc . '.' . $extension);
    // $consulta = "INSERT INTO `procesos`(`idproceso`, `idequipo`, `proceso`) 
    //  VALUES ('','$equipo','$proceso')";
    // echo $query = mysqli_query($link, $consulta) or die($consulta);
}
