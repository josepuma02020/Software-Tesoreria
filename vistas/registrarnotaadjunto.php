<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css" />
    <link rel="stylesheet" type="text/css" href="librerias/alertify/css/themes/default.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css" />
    <link type="text/css" href="./librerias/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel=" Stylesheet" />
    <link rel="stylesheet" href="./css/facturas/desktop.css">
    <SCRIPT lang="javascript" type="text/javascript" src="./facturas/facturas.js"></script>
    <SCRIPT src="librerias/alertify/alertify.js"></script>
    <title>Notas Contables</title>
    <?php
    include('./conexion/conexion.php');
    $fecha_actual = date("Y-m-j");
    $ano = date('Y');
    $mes = date('m');
    $dia = date('d');
    $hora = date('h:i a');
    //autocompletar cliente
    $consulta = "select descripcion from cuentas where clasificacion = '1' order by descripcion";
    $queryt = mysqli_query($link, $consulta) or die($consulta);
    $productos[] = array();
    while ($arreglocuentas = mysqli_fetch_row($queryt)) {
        $cuentas[] = $arreglocuentas[0];
    }
    array_shift($cuentas);
    $relleno = json_encode($cuentas);
    //consulta idnota
    if (isset($_GET['id'])) {
        $idnota = $_GET['id'];
        $soporte = 'si';
        $consultanotacreada = "select * from notascontables where idnota = '$idnota'";
        $querynotacreada = mysqli_query($link, $consultanotacreada) or die($consultanotacreada);
        $filanotacreada = mysqli_fetch_array($querynotacreada);
        if (isset($filanotacreada)) {
            $creado = 1;
        } else {
            $creado = 0;
        }
    } else {
        $consultaconsecutivo = "select iddoc  from facturas where fecharegistro = '$fecha_actual'";
        $queryconsecutivo = mysqli_query($link, $consultaconsecutivo) or die($consultaconsecutivo);
        $filaconsecutivo = mysqli_fetch_array($queryconsecutivo);
        if (isset($filaconsecutivo)) {
            $consecutivo = substr($filaconsecutivo['iddoc'], 8, 10);
            $consecutivo++;
        } else {
            $consecutivo = 1;
        }
        $idnota = $ano . $mes . $dia . $consecutivo;
        $creado = 0;
    }
    //consulta datos notas
    $consultadatosnota = "SELECT a.*,b.nombre'nombrecreador',b.usuario'usariocreador',c.nombre'nombrerevisador',d.descripcion'descripcioncuenta' FROM `facturas` a inner join usuarios b on a.idcreador = b.idusuario left join usuarios c on a.idrevisador=c.idusuario INNER JOIN cuentas d on d.idcuenta=a.idcuenta  where `iddoc` =  $idnota";
    $querydatosnota = mysqli_query($link, $consultadatosnota) or die($consultadatosnota);
    $filadatosnota = mysqli_fetch_array($querydatosnota);
    if (isset($filadatosnota)) {
        $soporte = 'si';
        $usuario = $filadatosnota['nombrecreador'];
        $idusuario = $filadatosnota['usariocreador'];
        if ($filadatosnota['idrevisador'] == 0) {
            $nombrerevisa = '';
            $fecharevision = '';
            $horarevision = '';
        } else {
            $nombrerevisa = $filadatosnota['nombrerevisador'];
        }
        $banco = $nombrerevisa = $filadatosnota['descripcioncuenta'];
        $tipofactura = 0;
        $ri = $filadatosnota['ri'];
        $an = $filadatosnota['tercero'];
        $batch = '';
        $valor = $filadatosnota['valor'];
        $horaregistro = $filadatosnota['horaregistro'];
        $fecha = $filadatosnota['fecharegistro'];
        $comentario = '';
        $extension = $filadatosnota['extensionarchivo'];
    } else {
        $soporte = 'no';
        $extension = '';
        $idusuario = $_SESSION['idusuario'];
        $usuario = $_SESSION['nombre'];
        $tipofactura = 0;
        $batch = '';
        $ri = '';
        $an = '';
        $valor = '';
        $nombrerevisa = '';
        $fecharevision = '';
        $horarevision = '';
        $fecha = $fecha_actual;
        $comentario = '';
        $banco = '';
    }
    ?>
</head>

<body>
    <header>
        <?php
        $des = '';
        if ($creado == 1) {
            if ((($_SESSION['idusuario'] == $idusuario && $filadatosnota['revision'] == 0) || ($filadatosnota['tipo'] == $_SESSION['idproceso'] && $filadatosnota['revision'] == 0 && $_SESSION['idusuario'] == $idusuario))) {
                $des = '';
            } else {
                $des = 'disabled';
            }
        } else {
            if ($_SESSION['creacion'] == 1) {
                $des = '';
            } else {
                $des = 'disabled';
            }
        }
        ?>
        <?php
        if ($batch != '') {
            $estado = 'disabled';
        } else {
            $estado = '';
        }
        ?>
        <div class="form-row formulario">
            <div class="form-group pequeno">
                <label for="iddocumento">ID.Documento:</label>
                <input value="<?php echo $creado  ?>" style="text-align:center" class="form-control " id="creado" name="creado" type="hidden" disabled>
                <input <?php echo $estado ?> value="<?php echo $idnota  ?>" style="text-align:center" class="form-control " id="iddoc" name="iddoc" type="text" disabled>
            </div>
            <div class="form-group mediano ">
                <label for="comment">Creado por:</label>
                <input <?php echo $des; ?> value=" <?php echo $usuario . ' : ' . $fecha . ' ' . $hora; ?>" style="text-align:center" class="form-control " id="revision" name="revision" type="text" disabled>
            </div>
            <div class="form-group mediano ">
                <label for="comment">Revisado por:</label>
                <input <?php echo $des; ?> value=" <?php echo $nombrerevisa . ' : ' . $fecharevision . ' ' . $horarevision; ?>" style="text-align:center" class="form-control " id="revision" name="revision" type="text" disabled>
            </div>
            <div class="form-group mediano ">
                <label for="comment">Autorizado por:</label>
                <input <?php echo $des; ?> value=" <?php echo $nombrerevisa . ' : ' . $fecharevision . ' ' . $horarevision; ?>" style="text-align:center" class="form-control " id="revision" name="revision" type="text" disabled>
            </div>

        </div>
        <div class="form-row formulario">
            <div class="form-group mediano-pequeno">
                <label for="type">Tipo de factura</label>
                <select <?php echo $estado ?> style="text-align: center;" id="tipofactura" class="form-control col-md-8 ">
                    <?php
                    $selected = '';
                    $consultausuarios = "select * from tiposfactura order by tipofactura";
                    $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                    ?> <option value="0">Seleccionar</option>
                    <?php
                    while ($filas1 = mysqli_fetch_array($query)) {
                        if ($filas1['idtipo'] == $tipodocumento) {
                            $selected = 'selected';
                        }
                    ?>
                        <option <?php echo $selected ?> value="<?php echo $filas1['idtipo'] ?>"><?php echo   $filas1['tipofactura'] ?></option>
                    <?php
                        $selected = '';
                    }
                    ?>
                </select>
            </div>
            <input <?php echo $estado ?> style="text-align:center" class="form-control " id="valido" name="valido" type="hidden">
            <div class="form-group mediano-pequeno">
                <label for="type">Banco</label>
                <input value="<?php echo $banco; ?>" <?php echo $estado ?> style="text-align:center" class="form-control " id="cuenta" name="cuenta" type="text">
            </div>
            <div class="form-group mediano-pequeno">
                <label for="fechafactura">Fecha factura:</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="fechafactura" value="<?php echo $fecha ?>" name="fechafactura" type="date">
            </div>
            <div class="form-group mediano-pequeno">
                <label for="valor">Valor:</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control number " id="valor" value="<?php echo $valor ?>" name="valor" type="text">
            </div>

            <div class="form-group pequeno">
                <label for="ri">RI:</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="ri" value="<?php echo $ri ?>" name="ri" type="number">
            </div>
            <div class="form-group pequeno">
                <label for="an">AN8:</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="an" value="<?php echo $an ?>" name="an" type="number">
            </div>


            <div class="form-row formulario">
                <div class="form-group grande ">
                    <label for="comment">Comentario:</label>
                    <input <?php echo $des; ?> <?php echo $estado ?> value="<?php echo $comentario ?>" style="text-align:center" class="form-control " id="comentario" name="comentario" type="text">
                </div>
                <div class="form-group mediano">
                    <label for="soporte">Soporte:</label>
                    <input multiple style="text-align:center" accept="image/gif,image/jpg,img/jpeg,image/png,.pdf" class="form-control " id="soporte" name="soporte" type="file">
                </div>
                <div class="form-group pequeno ">
                    <label for="comment"></label>
                    <button title="Enviar nota contable a revisión." id="registrarfactura" name="registrarfactura" class="btn btn-primary boton">Registrar factura </button>
                </div>
            </div>
        </div>
    </header>
    <main class=" container container-md tabla-registros ">
        <table class="table table-striped  table-responsive-lg ">
            <thead>
                <tr>
                    <th> Archivo </th>
                    <th> Acciones </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $consultacuentas = "select * from cuentas where idproceso = 4";
                $querycuentas = mysqli_query($link, $consultacuentas) or die($consultacuentas);
                while ($filascuentas = mysqli_fetch_array($querycuentas)) {
                ?>
                    <tr>
                        <td> <?php echo $filascuentas['concepto'] ?> </td>

                        <td>
                            <SCRIPT lang="javascript" type="text/javascript" src="./cuentas/cuentas.js"></script>

                            <button onclick="datoscuenta('<?php echo $filascuentas['idcuenta'] ?>','<?php echo $filascuentas['descripcion'] ?>')" type="button" title="Eliminar cuenta" id="delete" class="btn btn-danger" data-toggle="modal" data-target="#eliminar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </main>
    <footer>
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
        const number = document.querySelector('.number');

        function formatNumber(n) {
            n = String(n).replace(/\D/g, "");
            return n === '' ? n : Number(n).toLocaleString();
        }
        number.addEventListener('keyup', (e) => {
            const element = e.target;
            const value = element.value;
            element.value = formatNumber(value);

        });
        $('#registrarfactura').click(function() {
            a = 0;
            iddoc = $('#iddoc').val();
            valor = $('#valor').val();
            user = $('#user').val();
            tipo = $('#tipofactura').val();
            cuenta = $('#cuenta').val();
            fechafactura = $('#fechafactura').val();
            soporte = $('#soporte').val();
            ri = $('#ri').val();
            an = $('#an').val();
            valido = $('#valido').val();
            comentario = $('#comentario').val();
            inputcuenta = document.getElementById("cuenta");
            inputan = document.getElementById("an");
            if (ri == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Debe el # de la RI', function() {
                    alertify.success('Ok');
                });
            }
            if (valido == 'no') {
                a = 1;
                alertify.alert('ATENCION!!', 'Revisar campo de Banco y de AN8', function() {
                    alertify.success('Ok');
                });
            }
            if (an == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Debe ingresar el #AN8.', function() {
                    alertify.success('Ok');
                });
            }
            if (fechafactura == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Debe ingresar la fecha de la factura.', function() {
                    alertify.success('Ok');
                });
            }
            if (valor == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Debe ingresar el valor de la factura.', function() {
                    alertify.success('Ok');
                });
            }
            if (cuenta == 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'Seleccionar el banco donde se realizo el pago', function() {
                    alertify.success('Ok');
                });
            }
            if (tipo == 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'Debe seleccionar el tipo de factura.', function() {
                    alertify.success('Ok');
                });
            }
            if (soporte == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Debe subir soporte de la factura.', function() {
                    alertify.success('Ok');
                });
            } else {
                filesize = $('#soporte')[0].files[0].size;
                if (filesize > 55000000000000) {
                    a = 1;
                    alertify.alert('ATENCION!!', 'El soporte es demasiado pesado. ', function() {
                        alertify.success('Ok');
                    });
                }
            }
            if (a == 0) {
                registrarfactura(iddoc, valor, user, tipo, fechafactura, ri, an, cuenta, comentario);
                soporte = $('#soporte').prop('files')[0];
                datosForm = new FormData;
                datosForm.append("soporte", soporte);
                ruta = 'facturas/subirsoporte.php?iddoc=' + iddoc;
                $.ajax({
                    type: "POST",
                    url: ruta,
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: datosForm,
                    success: function(r) {
                        if (r == 1) {
                            console.log(r);
                            debugger;
                        } else {
                            console.log(r);
                            debugger;
                        }
                    }
                });
                setTimeout(function() {
                    window.location.href = "./home.php?id=" + iddoc + "&n=f"
                }, 1000);
            }

        });
        $('#cuenta').change(function() {
            cuenta = $('#cuenta').val();
            verificarbanco(cuenta);
        });
        $('#an').change(function() {
            an = $('#an').val();
            verificaran(an);
        });
        $('#aprobar').click(function() {
            a = 0;
            iddocumento = $('#iddocumento').val();
            totalhaber = $('#totalhaber').val();
            alertify.confirm('Aprobación de nota contable', 'Esta seguro que desea aprobar esta nota contable con valor de $' + totalhaber, function() {
                aprobarnota(iddocumento);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
                alertify.success('Operación exitosa. ');
            }, function() {

            }).set('labels', {
                ok: 'Continuar',
                cancel: 'Cancelar'
            });
        });
        $('#confirmardesaprobar').click(function() {
            a = 0;
            iddocumento = $('#iddocumento').val();
            comentariodesaprobacion = $('#comentariodesaprobacion').val();
            noaprobarnota(iddocumento, comentariodesaprobacion);
            setTimeout(function() {
                window.location.reload();
            }, 1000);
        });
        $('#revision').click(function() {
            a = 0;
            iddocumento = $('#iddocumento').val();
            alertify.confirm('Envio a revisión', 'Esta seguro de enviar esta nota contable para revisión?', function() {
                revision(iddocumento);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
                alertify.success('Operación exitosa. ');
            }, function() {

            }).set('labels', {
                ok: 'Continuar',
                cancel: 'Cancelar'
            });
        });
        $('#lm').change(function() {
            lm = $('#lm').val();
            if (lm.length > 0) {
                $('#tipolm').val("A");
            } else {
                $('#tipolm').val("");
            }
        });
        $('#cuenta').change(function() {
            // $.ajax({
            //     type: "POST",
            //     url: "notascontables/obtenerdescripcion.php",
            //     data: "cuenta=" + $('#cuenta').val(),
            //     success: function(r) {
            //         dato = jQuery.parseJSON(r);
            //         console.log(r)
            //         $('#descripcion').val(dato['descripcion']);

            //     }
            // });

        });
        disponible = (<?php echo $relleno ?>);
        $("#cuenta").autocomplete({
            source: disponible,
            lookup: disponible,
            minLength: 3
        });
        $("#cuenta").autocomplete("option", "appendTo", ".eventInsForm");

    });
</script>