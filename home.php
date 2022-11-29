<?php
session_start();
if (time() - $_SESSION['tiempo'] > 500000000000) {
    //session_destroy();
    /* Aquí redireccionas a la url especifica */
    session_destroy();
    header('Location: ' . "index.php?m=6");
    //die();
} else {
    $_SESSION['tiempo'] = time();
}
if ($_SESSION['usuario']) {
    include_once('conexion/conexion.php');
    date_default_timezone_set('America/Bogota');
    setlocale(LC_ALL, "es_CO");
    $fecha_actual = date("Y-m-j");
    $ano = date('Y');
    $mes = date('m');
    $dia = date('d');
    if (isset($_GET['n'])) {
        $n = $_GET['n'];
    } else {
        $n = 0;
    }
    if (isset($_GET['desde'])) {
        $desde = $_GET['desde'];
    } else {
        $desde = date("Y-m-01");
    }
    if (isset($_GET['hasta'])) {
        $hasta = $_GET['hasta'];
    } else {
        $hasta = date("Y-m-d");
    }
    $fechahoyval = date("Y") . '-' . date("m") . '-' . date("j");
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./css/bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/home/desktop.css">
        <title>Home</title>
    </head>

    <body>
        <header>
            <?php
            include_once($_SESSION['menu']) ?>
        </header>
        <main>


            <?php
            switch ($n) {
                case 1:
                    include('./vistas/notascontables.php');
                    break;
                case 4:
                    include('./vistas/notascontablesgestioncontable.php');
                    break;
                case 'f':
                    include('./vistas/registrarfactura.php');
                    break;
                case 5:
                    include('./vistas/registrarnotaadjunto.php');
                    break;
                default:
            ?>
                    <section class="seccion-menu">
                        <h4>Registro de notas contables</h4>
                        <hr>
                        <div class="opciones">
                            <button class="opcion">
                                Nota contable por cuentas.
                            </button>
                            <button class="opcion">
                                Nota contable por conceptos.
                            </button>
                            <button class="opcion">
                                Nota contable por adjuntos.
                            </button>
                        </div>
                    </section>
                    <section class="seccion-menu">
                        <h4>Registro de consignaciones</h4>
                        <hr>
                        <div class="opciones">
                            <button class="opcion">
                                Registrar Consignación.
                            </button>
                        </div>
                    </section>
            <?php
                    break;
            }

            ?>
        </main>
    </body>

    </html>
    <script>

    </script>
<?php

}
?>