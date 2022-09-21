<?php
session_start();
if (time() - $_SESSION['tiempo'] > 500) {
    //session_destroy();
    /* Aquí redireccionas a la url especifica */
    session_destroy();
    header('Location: ' . "index.php?m=6");
    //die();
} else {
    $_SESSION['tiempo'] = time();
}
if ($_SESSION['usuario'] && $_SESSION['rol'] == 1) {
    include_once('conexion/conexion.php');
    setlocale(LC_ALL, "es_CO");
    date_default_timezone_set('America/Bogota');
    $consultagenerales = "select * from  general";
    $querygeneral = mysqli_query($link, $consultagenerales) or die($consultagenerales);
    $filasgeneral = mysqli_fetch_array($querygeneral)
?>
    <HTML>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./css/bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="./librerias/alertify/css/alertify.css" />
        <link rel="stylesheet" type="text/css" href="./librerias/alertify/css/themes/default.css" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css" />
        <link type="text/css" href="./librerias/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel=" Stylesheet" />
        <link rel="stylesheet" href="./css/configuracion/desktop.css">
        <SCRIPT lang="javascript" type="text/javascript" src="./configuracion/configuracion.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <title>Configuración general</title>
    </head>

    <body>
        <header>
            <?php
            include_once($_SESSION['menu']);
            ?>
        </header>
        <main style="max-width:90% ;" class=" container container-md">
            <div class="tabla-registros">
                <div class="titulo-tabla">
                    <h2>Configuración general</h2>
                </div>
                <section class="parametros">
                    <div class="form-group mediano">
                        <label for="hasta">Salario mínimo:</label>
                        <input value="<?php echo '$' . number_format($filasgeneral['salariominimo']) ?>" style="text-align:center" class="form-control " id="salmin" name="salmin" type="text">
                    </div>
                    <button id="guardar" class="btn btn-primary boton-parametro">
                        <b> Guardar </b>
                    </button>
                </section>
            </div>
        </main>
        <footer>
        </footer>
    </body>

    </HTML>
<?php
} else {
    header('Location: ' . "usuarios/cerrarsesion.php");
}
?>
<script type=" text/javascript" src="librerias/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript" src="librerias/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#guardar').click(function() {
            a = 0;
            salmin = $('#salmin').val();
            if (isNaN(salmin) || salmin < 100000) {
                a = 1;
                alertify.alert('ATENCION!!', 'El valor del salario minimo de ser mayor a 100.000', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                guardar(salmin);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }
        });
    });
</script>