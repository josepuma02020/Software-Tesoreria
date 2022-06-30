<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/notas/desktop.css">
    <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css" />
    <link rel="stylesheet" type="text/css" href="librerias/alertify/css/themes/default.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css" />
    <link type="text/css" href="./librerias/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel=" Stylesheet" />
    <SCRIPT src="librerias/alertify/alertify.js"></script>

    <title>Notas Contables</title>
    <?php
    include('../NotasdePago/conexion/conexion.php');

    //autocompletar cliente
    $consulta = "SELECT `idcuenta`  FROM `cuentas` ";
    $queryt = mysqli_query($link, $consulta) or die($consulta);
    $productos[] = array();
    while ($arregloproductos = mysqli_fetch_row($queryt)) {
        $productos[] = $arregloproductos[0];
    }
    array_shift($productos);
    $relleno = json_encode($productos);
    ?>
</head>

<body>
    <header>
        <form action="" method="post">
            <div class="form-row formulario">
                <div class="form-group mediano">
                    <label for="user">Usuario:</label>
                    <input style="text-align:center" class="form-control " id="user" name="user" type="text" disabled value="<?php echo $_SESSION['nombre']; ?>">
                </div>
                <div class="form-group mediano">
                    <label for="type">Tipo de Documento</label>
                    <select id="type" class="form-control col-md-8 ">
                        <?php
                        $consultausuarios = "select * from tiposdocumento order by documento";
                        $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                        ?> <option value="0"></option>
                        <?php
                        while ($filas1 = mysqli_fetch_array($query)) {
                        ?>
                            <option value="<?php echo $filas1['idtipo'] ?>"><?php echo $filas1['documento'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group mediano">
                    <label for="type">Clasificación de Documento</label>
                    <select id="type" class="form-control col-md-8 ">
                        <?php
                        $consultausuarios = "select * from clasificacionesnotas order by clasificacion";
                        $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                        ?> <option value="0"></option>
                        <?php
                        while ($filas1 = mysqli_fetch_array($query)) {
                        ?>
                            <option value="<?php echo $filas1['idclasificacion'] ?>"><?php echo $filas1['clasificacion'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mediano">
                    <label for="batch">Batch:</label>
                    <input style="text-align:center" class="form-control " id="batch" name="batch" type="number">
                </div>
            </div>
            <div class="form-row formulario">
                <div class="form-group completo ">
                    <label for="comment">Comentario:</label>
                    <input style="text-align:center" class="form-control " id="comment" name="comment" type="text">
                </div>
            </div>
        </form>
    </header>
    <main class="tabla-registros">
        <table id="registrosnotas" class="table table-striped  table-responsive-lg">
            <thead>
                <th>Fecha</th>
                <th>Cuenta</th>
                <th>Descripción</th>
                <th>Debe</th>
                <th>Haber</th>
                <th>Importe</th>
                <th>T.LM</th>
                <th>LM</th>
                <th>AN8</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                <form action="#" method="POST" class="form-registros">
                    <tr>
                        <td>
                            <input class="form-control" type="date" required id="date" name="date">
                        </td>
                        <td style="width: 13%;">
                            <input class=" form-control" type="text" required id="cuenta" name="cuenta">
                        </td>
                        <td style="width: 15% ;">
                            <input class="form-control" type="text" required id="descripcion" name="descripcion" disabled>
                        </td>
                        <td style="width:8%">
                            <input style="text-align:center" value="0" min="0" class="form-control" type="number" required id="debe" name="debe">
                        </td>
                        <td style="width:8%">
                            <input style="text-align:center" value="0" min="0" class="form-control" type="number" required id="haber" name="haber">
                        </td>
                        <td style="width:10%">
                            <input style="text-align:center" class="form-control" type="number" required id="importe" name="importe" disabled>
                        </td>
                        <td>
                            <input class="form-control" type="text" required id="tipolm" name="tipolm" disabled>
                        </td>
                        <td style="width:10%">
                            <input class="form-control" type="text" required id="lm" name="lm" required>
                        </td>
                        <td style="width:10%">
                            <input class="form-control" type="text" required id="an" name="an" required>
                        </td>
                        <td style="width: 8%;">
                            <SCRIPT lang="javascript" type="text/javascript" src="  "></script>
                            <button onclick="" type="button" id="registrar" class="btn btn-primary" data-toggle="modal" data-target="#editar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                                    <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z" />
                                    <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z" />
                                </svg>
                            </button>
                            <!-- <button onclick="" type="button" id="eeeee" class="btn btn-danger" data-toggle="modal" data-target="#eliminar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
                                    <path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z" />
                                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                                </svg>
                            </button> -->
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>
    </main>
    <footer>
        <div class="form-row formulario">
            <div class="form-group mediano ">
                <label for="comment">Total Debe:</label>
                <input style="text-align:center" class="form-control " id="totaldebe" name="totaldebe" type="text" value="0" disabled>
            </div>
            <div class="form-group mediano ">
                <label for="comment">Total Haber:</label>
                <input style="text-align:center" class="form-control " id="totalhaber" name="totalhaber" type="text" value="0" disabled>
            </div>
            <div class="form-group mediano ">
                <label for="comment">Total Importe:</label>
                <input style="text-align:center" class="form-control " id="totalimporte" name="totalimporte" type="text" value="0" disabled>
            </div>
        </div>
        <button id="save" name="save" class="btn btn-primary">Guardar</button>
        <button id="cancel" name="cancel" class="btn btn-secondary">Cancelar</button>
        <button id="delete" name="delete" class="btn btn-danger">Eliminar</button>
    </footer>
</body>

</html>
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
        $('#debe').change(function() {
            debe = $('#debe').val();
            haber = $('#haber').val();
            importe = debe - haber;
            $('#importe').val(importe);
        });
        $('#haber').change(function() {
            debe = $('#debe').val();
            haber = $('#haber').val();
            importe = debe - haber;
            $('#importe').val(importe);
        });
        $('#registrar').click(function() {
            a = 0;
            cuenta = $('#cuenta').val();
            debe = $('#debe').val();
            haber = $('#haber').val();
            lm = $('#lm').val();
            an = $('#an').val();
            dias = $('#diasref').val();
            valorprestamo = $('#valoru').val();
            comentario = $('#comentariou').val();
            if (debe <= 0 && haber <= 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'Debe llenar el campo de Debe o Haber(Los dos no pueden registrarse en valor menor o igual a cero). ', function() {
                    alertify.success('Ok');
                });
            }
            if (cuenta == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'El campo de Cuenta se encuentra vacío', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                //editarprestamo(dias, valor, ruta, id, comentario);
                window.location.reload();
            }
        })


        disponible = (<?php echo $relleno ?>);
        console.log(disponible);
        $("#cuenta").autocomplete({
            source: disponible,
            lookup: disponible,
            minLength: 4
        });
        $("#cuenta").autocomplete("option", "appendTo", ".eventInsForm");
    });
</script>