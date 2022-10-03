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
if ($_SESSION['usuario']) {
    include_once('conexion/conexion.php');
    setlocale(LC_ALL, "es_CO");
    date_default_timezone_set('America/Bogota');
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

    //consultanotas
    if (isset($_GET['m'])) {
        $mostrar = $_GET['m'];
    } else {
        $mostrar = 'a';
    }
    $n = $_GET['n'];
    switch ($mostrar) {
        case 't':
            $consultanotas = "SELECT SUM(e.debe)-sum(e.haber) 'importe',a.*,b.nombre,c.documento,d.clasificacion,sum(e.haber)'haber',f.nombre 'naprobador',g.nombre 'nautoriza'  FROM notascontables a  LEFT JOIN usuarios g on g.idusuario=a.idautoriza  left join usuarios f on f.idusuario=a.idaprobador
            INNER JOIN usuarios b on a.idusuario = b.idusuario INNER JOIN tiposdocumento c on c.idtipo=a.idtipodocumento 
            INNER JOIN clasificaciones d on d.idclasificacion=a.idclasificacion left JOIN registrosdenota e on e.idnota=a.idnota where a.fecha between '$desde' and '$hasta' and tipo = $n GROUP by a.idnota;";
            break;
        case 'a':
            $consultanotas = "SELECT SUM(e.debe)-sum(e.haber) 'importe',a.*,b.nombre,c.documento,d.clasificacion,sum(e.haber)'haber',f.nombre 'naprobador' ,g.nombre 'nautoriza' FROM notascontables a  LEFT JOIN usuarios g on g.idusuario=a.idautoriza  left join usuarios f on f.idusuario=a.idaprobador
            INNER JOIN usuarios b on a.idusuario = b.idusuario INNER JOIN tiposdocumento c on c.idtipo=a.idtipodocumento 
            INNER JOIN clasificaciones d on d.idclasificacion=a.idclasificacion left JOIN registrosdenota e on e.idnota=a.idnota where (a.batch is null or a.batch = '' or a.batch='NULL') and a.fecha between '$desde' and '$hasta'  and tipo = $n GROUP by a.idnota;";
            break;
        case 'c':
            $consultanotas = "SELECT SUM(e.debe)-sum(e.haber) 'importe',a.*,b.nombre,c.documento,d.clasificacion,sum(e.haber)'haber',f.nombre 'naprobador' ,g.nombre 'nautoriza' FROM notascontables a  LEFT JOIN usuarios g on g.idusuario=a.idautoriza  left join usuarios f on f.idusuario=a.idaprobador
            INNER JOIN usuarios b on a.idusuario = b.idusuario   INNER JOIN tiposdocumento c on c.idtipo=a.idtipodocumento 
            INNER JOIN clasificaciones d on d.idclasificacion=a.idclasificacion left JOIN registrosdenota e on e.idnota=a.idnota where a.batch > 0  and a.fecha between '$desde' and '$hasta'  and tipo = $n GROUP by a.idnota;";
            break;
    }
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
        <link rel="stylesheet" href="./css/revisionnotas/desktop.css">
        <SCRIPT lang="javascript" type="text/javascript" src="notascontables/notascontables.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <title>Revisión de notas</title>
    </head>

    <body>
        <header>
            <?php
            include_once($_SESSION['menu']);
            ?>

        </header>
        <main style="max-width:90% ;" class=" container container-md">
            <div class="tabla-registros">
                <section class="titulo-pagina">
                    <h2>Notas Registradas</h2>
                </section>
                <form action="" method="post">
                    <div class="form-row formulario">
                        <div class="form-group mediano">
                            <label for="desde">Desde:</label>
                            <input value="<?php echo $n ?>" style="text-align:center" class="form-control " id="tipon" name="tipon" type="hidden">
                            <input value="<?php echo $desde ?>" style="text-align:center" class=" form-control " id="desde" name="desde" type="date">
                        </div>
                        <div class="form-group mediano">
                            <label for="hasta">Hasta:</label>
                            <input value="<?php echo $hasta ?>" style="text-align:center" class="form-control " id="hasta" name="hasta" type="date" value="<?php  ?>">
                        </div>
                        <div class="form-group pequeno">
                            <label for="mostrar">Mostrar</label>
                            <select style="text-align: center;" id="mostrar" class="form-control col-md-8 ">
                                <?php
                                switch ($mostrar) {
                                    case 't':
                                ?>
                                        <option value="t" selected>Todo</option>
                                        <option value="c">Cerradas</option>
                                        <option value="a">Abiertas</option>
                                    <?php break;
                                    case 'a':
                                    ?>
                                        <option value="t">Todo</option>
                                        <option value="c">Cerradas</option>
                                        <option value="a" selected>Abiertas</option>
                                    <?php break;
                                    case 'c':
                                    ?>
                                        <option value="t">Todo</option>
                                        <option value="c" selected>Cerradas</option>
                                        <option value="a">Abiertas</option>
                                <?php break;
                                }
                                ?>
                            </select>
                        </div>
                        <button title="Buscar" type="button" id="buscar" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </button>
                        <?php if ($_SESSION['verificacion'] == 1 && ($_GET['n'] == $_SESSION['idproceso'])) {
                        ?>
                            <div class="form-group mediano">
                                <label for="batch">Batch:</label>
                                <input value="<?php echo $hasta ?>" min=0 style="text-align:center" class="form-control " id="batch" name="batch" type="number" value="<?php  ?>">
                            </div>
                            <button title="Verificar Batch" type="button" id="verificar" class="btn btn-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                    <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z" />
                                </svg>
                            </button>
                        <?php
                        } ?>

                    </div>
                </form>
                <table id="registrosnotas" class="table table-striped  table-responsive-lg revision-notas ">
                    <THEAD>
                        <tr>
                            <th> Sel. </th>
                            <th style="width: 10% ;"> Creacion </th>
                            <th> Aprobación </th>
                            <th> Autorización </th>
                            <th> Usuario </th>
                            <th> Tipo </th>
                            <th> Clasificación </th>
                            <th> Total importe </th>
                            <th> Batch </th>
                            <th> Comentario </th>
                        </tr>
                    </THEAD>
                    <TBODY>
                        <?php
                        $query = mysqli_query($link, $consultanotas) or die($consultanotas);
                        while ($filas1 = mysqli_fetch_array($query)) {
                            $estado = '';
                            if ($filas1['batch'] == 0) {
                                $batch = '';
                            } else {
                                $batch = $filas1['batch'];
                            }
                            $consultaterceros = "select * from registrosdenota where idnota = $filas1[idnota] and haber > 0";
                            $queryterceros = mysqli_query($link, $consultaterceros) or die($consultaterceros);
                            $importemenos = 0;
                            while ($filasterceros = mysqli_fetch_array($queryterceros)) {
                                $consultaveran = "select idan from listaan where idan = $filasterceros[an]";
                                $queryveran = mysqli_query($link, $consultaveran) or die($consultaveran);
                                if (mysqli_num_rows($queryveran) == 0) {
                                    $color =  '#FC9999';
                                    $importemenos = $importemenos + $filasterceros['haber'];
                                    $estado = 'disabled';
                                }
                                $consultaveran = "select idcuenta from cuentas where idcuenta = '$filasterceros[idcuenta]'";
                                $queryveran = mysqli_query($link, $consultaveran) or die($consultaveran);
                                if (mysqli_num_rows($queryveran) == 0) {
                                    $color =  '#FC9999';
                                    $importemenos = $importemenos + $filasterceros['haber'];
                                    $estado = 'disabled';
                                }
                            }
                            $totalimporte = $filas1['importe'];
                            switch ($_GET['n']) {
                                case 1:
                                    $importe = $filas1['importe'];
                                    break;
                                case 4:
                                    $consultaimporte = "select SUM(debe) 'importe' from registrosdenota where idcuenta > 0 and idnota = '$filas1[idnota]'";
                                    $queryimporte = mysqli_query($link, $consultaimporte) or die($consultaimporte);
                                    $filaimporte = mysqli_fetch_array($queryimporte);
                                    $importe = $filaimporte['importe'] - $importemenos;
                                    break;
                            }
                            $consultaminimo = "SELECT * FROM `general`";
                            $queryminimo = mysqli_query($link, $consultaminimo) or die($consultaminimo);
                            $filaminimo = mysqli_fetch_array($queryminimo);
                            $coloraprobador =  '';
                            $colorautorizador =  '';
                            $estado = '';
                            if (($importe >    $filaminimo['salariominimo'] * 500)) {
                                $a = 0;
                                if ($filas1['idaprobador'] == 0) {

                                    $coloraprobador =  '#FC9999';
                                    $a++;
                                }
                                if ($filas1['idautoriza'] == 0) {
                                    $colorautorizador =  '#FC9999';
                                    $a++;
                                }
                                if ($a > 0) {
                                    $estado = 'disabled';
                                }
                            }
                        ?>

                            <TR style="background-color: <?php echo $color ?> ;">
                                <TD>
                                    <?php
                                    $estadocheck = 'checked';
                                    if ($filas1['seleccion'] == 1) {
                                        $estadocheck = '';
                                    }
                                    ?>
                                    <input <?php echo $estadocheck . ' ' . $estado; ?> onchange="cambiarseleccionnota(<?php echo $filas1['idnota'] ?>)" id="check" type="checkbox" aria-label="Checkbox for following text input">
                                </TD>
                                <TD><?php echo $filas1['fecha'] . ' ' . $filas1['hora']; ?> </TD>
                                <TD style="background-color: <?php echo $coloraprobador ?> ;">
                                    <?php
                                    if ($filas1['idaprobador'] == 0) {
                                        echo '';
                                    } else {
                                        echo $filas1['naprobador'];
                                    }
                                    ?> </TD>
                                <TD style="background-color: <?php echo $colorautorizador ?> ;">
                                    <?php
                                    if ($filas1['idaprobador'] == 0) {
                                        echo '';
                                    } else {
                                        echo $filas1['nautoriza'];
                                    }
                                    ?> </TD>
                                <TD><?php echo $filas1['nombre']; ?> </TD>
                                <TD><?php echo $filas1['documento']; ?> </TD>
                                <TD><?php echo $filas1['clasificacion']; ?> </TD>
                                <TD> <a href="home.php?id=<?php echo "$filas1[idnota]" ?>&n=<?php echo $filas1['tipo'] ?>"> <?php echo number_format($importe); ?></a> </TD>
                                <TD><?php echo $batch; ?> </TD>
                                <TD style="width:20% ;"><?php echo $filas1['comentario']; ?> </TD>

                            </TR>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </main>
        <footer>
        </footer>
    </body>

    </HTML>
<?php
} else {
    // header('Location: ' . "usuarios/cerrarsesion.php");
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        tabla = $('#registrosnotas').DataTable({
            language: {
                url: '../vendor/datatables/es-ar.json',
                lengthMenu: "Mostrar _MENU_ Registros",
                loadingRecords: "Cargando...",
                search: "Buscar:",
                info: "",
                //info: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
                infoEmpty: "No se encontraron registros",
                zeroRecords: "Sin Resultados",
                paginate: {
                    first: "Primera pagina",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Ultima"
                },
            }
        });
    });
</script>
<script type="text/javascript" src="librerias/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript" src="librerias/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#verificar').click(function() {
            a = 0;
            desde = $('#desde').val();
            console.log(desde);
            hasta = $('#hasta').val();
            batch = $('#batch').val();
            if (batch == '' || batch <= 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'Para verificar notas contables debe digitalizar el campo de Batch. ', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                alertify.confirm('Confirmación', 'Esta seguro que desea registrar este batch?', function() {
                    verificar(desde, hasta, batch);
                    alertify.success('Registrado Correctamente');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }, function() {
                    alertify.error('Registro cancelado');
                });

            }

        });
        $('#buscar').click(function() {
            a = 0;

            desde = $('#desde').val();
            tipon = $('#tipon').val();
            hasta = $('#hasta').val();
            mostrar = $('#mostrar').val();
            location.href = `revisionnotas.php?desde=${desde}&hasta=${hasta}&m=${mostrar}&n=${tipon}`;
        });
        $('#detalles').click(function() {
            a = 0;
            desde = $('#desde').val();
            hasta = $('#hasta').val();
            location.href = `prestamoscerrados.php?desde=${desde}&hasta=${hasta}`;
        });
    });
</script>