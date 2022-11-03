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
    $type = $_POST['tiponota'];
    $comentario = $_POST['comentario'];
    $id = $_POST['iddocumento'];
    $fecha_actual = date("Y-m-d");
    $hora = date('h:i a');
    $consultaexistenota = "select * from notascontables where idnota = '$id'";
    $queryexistenota = mysqli_query($link, $consultaexistenota) or die($consultaexistenota);
    $existenota = mysqli_fetch_array($queryexistenota);
    if (isset($existenota)) {
        //existe
        $consultaeditarnota = "UPDATE `notascontables` SET  `idtipodocumento`='$type',`comentario`='$comentario' WHERE idnota=$id";
        echo $query = mysqli_query($link, $consultaeditarnota) or die($consultaeditarnota);
    } else {
        //no existe
        $consultaagregarnota = "INSERT INTO `notascontables`(`idnota`, `idusuario`, `idtipodocumento`, `idclasificacion`, `batch`, `comentario`, `fecha`, `hora`, `seleccion`, `idaprobador`, `tipo`, `idverificador`, `fechabatch`, `horabatch`, `fechaaprobacion`, `horaaprobacion`, `idautoriza`, `fechaautorizacion`, `horaautorizacion`, `revision`) VALUES 
        ('$id','$_SESSION[idusuario]','$type','0','0','$comentario','$fecha_actual','$hora','1','','5','','','','','','','','','')";
        echo $query = mysqli_query($link, $consultaagregarnota) or die($consultaagregarnota);
    }
    // $consulta = "UPDATE `notascontables` SET `idtipodocumento`='$type',
    // `idclasificacion`= '$clasificacion',`batch`='$batch',`comentario`='$comentario',`tipo`='$proceso' WHERE idnota = '$id'";
    // echo $query = mysqli_query($link, $consulta) or die($consulta);
}
