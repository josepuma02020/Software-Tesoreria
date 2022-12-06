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
    //autocompletar cuenta
    $consulta = "SELECT  `nombre` FROM `listaan` order by nombre";
    $queryt = mysqli_query($link, $consulta) or die($consulta);
    $funcionarios[] = array();
    while ($arreglofuncionarios = mysqli_fetch_row($queryt)) {
        $funcionarios[] = $arreglofuncionarios[0];
    }
    array_shift($funcionarios);
    $relleno = json_encode($funcionarios);
    //consulta idnota
    if (isset($_GET['id'])) {
        $iddoc = $_GET['id'];
        $consultafactura = "select * from facturas where iddoc = '$iddoc'";
        $queryfactura = mysqli_query($link, $consultafactura) or die($consultafactura);
        $filafactura = mysqli_fetch_array($queryfactura);
        if (isset($filafactura)) {
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
        $iddoc = $ano . $mes . $dia . $consecutivo;
        $creado = 0;
    }

    //consulta area
    $consultaarea = "SELECT c.area,c.codarea,c.codclasificacion FROM procesos a inner join equipos b on b.idequipo=a.idequipo INNER join areas c on c.idarea=b.idarea where idproceso = $_SESSION[idproceso]";
    $queryarea = mysqli_query($link, $consultaarea) or die($consultaarea);
    $filaarea = mysqli_fetch_array($queryarea);
    $codarea = $filaarea['codarea'];
    $area  = $filaarea['area'];
    //consulta datos notas
    $consultadatosnota = "SELECT a.*,b.nombre'nombrecreador',b.usuario'usariocreador',c.nombre'nombrerevisador',d.descripcion'descripcioncuenta',g.area'areacreador' FROM `facturas` a inner join usuarios b on a.idcreador = b.idusuario left join usuarios c on a.idrevisador=c.idusuario INNER JOIN cuentas d on d.idcuenta=a.idcuenta inner join procesos e on e.idproceso=b.idproceso inner join equipos f on f.idequipo=e.idequipo inner JOIN areas g on g.idarea=f.idarea  where `iddoc` =  '$iddoc'";
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
            $fecharevision = $filadatosnota['fecharevision'] . ': ';
            $horarevision = $filadatosnota['horarevision'];
        }
        $banco = $filadatosnota['descripcioncuenta'];
        $tipofactura = 0;
        $ri = $filadatosnota['ri'];
        $an = $filadatosnota['tercero'];
        $batch = '';
        $areacreador = ' - ' . $filadatosnota['areacreador'];
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
        $areacreador = '';
        $ri = '';
        $an = '';
        $valor = '';
        $nombrerevisa = '';
        $fecharevision = '';
        $horarevision = '';
        $fecha = $fecha_actual;
        $comentario = '';
        $cuenta = '';
    }
    ?>
</head>

<body>
    <header>
        <?php
        if ($creado == 1) {
            $estado = 'disabled';
        } else {
            $estado = '';
        }
        ?>
        <div class="form-row formulario">
            <div class="form-group mediano-pequeno">
                <label for="user">Nro.Transacción</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="iddoc" name="iddoc" type="text" disabled value="<?php echo $iddoc; ?>">
            </div>
            <div class="form-group mediano">
                <label for="user">Revisado por</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="user" name="user" type="text" disabled value="<?php echo $nombrerevisa; ?>">
            </div>
            <div class="form-group mediano-pequeno">
                <label for="user"> Fecha revisión</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="user" name="user" type="text" disabled value="<?php echo  $fecharevision . $horarevision; ?>">
            </div>
        </div>
        <div class="form-row formulario tabla-registros">
            <h5 class="subtitulo-formulario">Información del empleado</h5>
            <div class="form-group mediano-pequeno">
                <label for="user">Nombre</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="user" name="user" type="text" disabled value="<?php echo $usuario . $areacreador; ?>">
            </div>
            <div class="form-group mediano-grande">
                <label for="user">Correo</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="user" name="user" type="text" disabled value="<?php echo $_SESSION['correo']; ?>">
            </div>
            <div class="form-group pequeno">
                <label for="user"> Dependencia</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="user" name="user" type="text" disabled value="<?php echo  $codarea; ?>">
            </div>
            <div class="form-group mediano">
                <label for="user"> Nombre dependencia</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="user" name="user" type="text" disabled value="<?php echo  $area; ?>">
            </div>

        </div>
        <div class="form-row formulario">

        </div>
        <div class="form-row formulario tabla-registros">
            <h5 class="subtitulo-formulario">Registro de pago realizado por consignación o transferencia</h5>
            <div class="form-group mediano-pequeno">
                <label for="type">Concepto de pago *</label>
                <select <?php echo $estado ?> style="text-align: center;" id="tipofactura" class="form-control col-md-8 ">
                    <?php
                    $selected = '';
                    $consultatiposfactura = "select * from tiposfactura order by tipofactura";
                    $query = mysqli_query($link, $consultatiposfactura) or die($consultatiposfactura);
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
            <div class="form-group pequeno">
                <label for="user">Cód. OW - AN8 *</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="an" value="<?php echo $an ?>" name="an" type="number">
            </div>

            <div class="form-group mediano-pequeno">
                <label for="fechafactura">Fecha de pago *</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="fechafactura" value="<?php echo $fecha ?>" name="fechafactura" type="date">
            </div>
            <div class="form-group mediano-pequeno">
                <label for="user">Valor consignación *</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control number " id="valor" value="<?php echo $valor ?>" name="valor" type="text">
            </div>
            <input style="text-align:center" class="form-control " id="valido" name="valido" type="hidden">
            <div class="form-group mediano-pequeno">
                <label for="type">Entidad bancaria*</label>
                <select disabled style="text-align: center;" id="cuenta" class="form-control col-md-8 ">s
                </select>
                <select style="text-align: center;display:none" id="cuentari" class="form-control col-md-8 ">
                    <?php
                    $selected = '';
                    $consultausuarios = "SELECT a.*,b.descripcion FROM `cuentastipofactura` a inner join cuentas b on b.idcuenta=a.idcuenta WHERE idtipofactura = 6";
                    $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                    ?> <option value="0">Seleccionar</option>
                    <?php
                    while ($filas1 = mysqli_fetch_array($query)) {
                        if ($filas1['idcuenta'] == $cuenta) {
                            $selected = 'selected';
                        }
                    ?>
                        <option <?php echo $selected ?> value="<?php echo $filas1['idcuenta'] ?>"><?php echo   $filas1['descripcion'] ?></option>
                    <?php
                        $selected = '';
                    }
                    ?>
                </select>
                <select style="text-align: center;display:none" id="cuentaauxiliosalimentacion" class="form-control col-md-8 ">
                    <?php
                    $selected = '';
                    $consultausuarios = "SELECT a.*,b.descripcion FROM `cuentastipofactura` a inner join cuentas b on b.idcuenta=a.idcuenta WHERE idtipofactura = 4";
                    $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                    ?> <option value="0">Seleccionar</option>
                    <?php
                    while ($filas1 = mysqli_fetch_array($query)) {
                        if ($filas1['idcuenta'] == $cuenta) {
                            $selected = 'selected';
                        }
                    ?>
                        <option <?php echo $selected ?> value="<?php echo $filas1['idcuenta'] ?>"><?php echo   $filas1['descripcion'] ?></option>
                    <?php
                        $selected = '';
                    }
                    ?>
                </select>
                <select style="text-align: center;display:none" id="cuentacontribucion" class="form-control col-md-8 ">
                    <?php
                    $selected = '';
                    $consultausuarios = "SELECT a.*,b.descripcion FROM `cuentastipofactura` a inner join cuentas b on b.idcuenta=a.idcuenta WHERE idtipofactura = 2";
                    $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                    ?> <option value="0">Seleccionar</option>
                    <?php
                    while ($filas1 = mysqli_fetch_array($query)) {
                        if ($filas1['idcuenta'] == $cuenta) {
                            $selected = 'selected';
                        }
                    ?>
                        <option <?php echo $selected ?> value="<?php echo $filas1['idcuenta'] ?>"><?php echo   $filas1['descripcion'] ?></option>
                    <?php
                        $selected = '';
                    }
                    ?>
                </select>
                <select style="text-align: center;display:none" id="cuentadevolucionviaticos" class="form-control col-md-8 ">
                    <?php
                    $selected = '';
                    $consultausuarios = "SELECT a.*,b.descripcion FROM `cuentastipofactura` a inner join cuentas b on b.idcuenta=a.idcuenta WHERE idtipofactura = 3";
                    $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                    ?> <option value="0">Seleccionar</option>
                    <?php
                    while ($filas1 = mysqli_fetch_array($query)) {
                        if ($filas1['idcuenta'] == $cuenta) {
                            $selected = 'selected';
                        }
                    ?>
                        <option <?php echo $selected ?> value="<?php echo $filas1['idcuenta'] ?>"><?php echo   $filas1['descripcion'] ?></option>
                    <?php
                        $selected = '';
                    }
                    ?>
                </select>
                <select style="text-align: center;display:none" id="cuentaprestamo" class="form-control col-md-8 ">
                    <?php
                    $selected = '';
                    $consultausuarios = "SELECT a.*,b.descripcion FROM `cuentastipofactura` a inner join cuentas b on b.idcuenta=a.idcuenta WHERE idtipofactura = 5";
                    $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                    ?> <option value="0">Seleccionar</option>
                    <?php
                    while ($filas1 = mysqli_fetch_array($query)) {
                        if ($filas1['idcuenta'] == $cuenta) {
                            $selected = 'selected';
                        }
                    ?>
                        <option <?php echo $selected ?> value="<?php echo $filas1['idcuenta'] ?>"><?php echo   $filas1['descripcion'] ?></option>
                    <?php
                        $selected = '';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group pequeno">
                <label for="user">Nro. RI</label>
                <input <?php echo $estado ?> style="text-align:center" class="form-control " id="ri" value="<?php echo $ri ?>" name="ri" type="number">
            </div>
            <div style="text-align: left;" class="form-row formulario checkfuncionario">
                <label for="user">Registrar pago a nombre de otro funcionario </label>
                <input <?php echo $estado ?> class="form-check-input " id="relfuncionario" name="relfuncionario" type="checkbox">
            </div>
            <div style="text-align: left;display:none" id="llenarfuncionario" class="form-row formulario checkfuncionario">
                <div class="form-group mediano-grande">
                    <label for="user">Nombre</label>
                    <input <?php echo $estado ?> style="text-align:center" class="form-control " id="funcionario" name="funcionario" type="text">
                </div>
            </div>
        </div>
        <div class="form-row formulario tabla-registros">
            <h5 class="subtitulo-formulario">Evidencia de consignación</h5>
            <div class="form-group mediano-grande">
                <input <?php echo $estado ?> style="text-align:center" accept="image/gif,image/jpg,img/jpeg,image/png,.pdf" class="form-control " id="soporte" name="soporte" type="file">
            </div>

            <div class="form-group mediano-grande ">
                <label for="comment">Observaciones adicionales</label>
                <input <?php echo $estado ?> value="<?php echo $comentario ?>" style="text-align:center" class="form-control " id="comentario" name="comentario" type="text">
            </div>

            <div class="form-group pequeno ">
                <?php
                if ($creado == 1) {
                    if ($nombrerevisa == '') {
                ?>
                        <button style="width: max-content ;" title="Enviar nota contable a revisión." id="revisarfactura" name="revisarfactura" class="btn btn-success ">Validar</button>
                    <?php
                    }
                } else {
                    ?>
                    <button style="width: max-content ;" title="Enviar nota contable a revisión." id="registrarfactura" name="registrarfactura" class="btn btn-primary ">Continuar</button>
                <?php
                }
                ?>
            </div>
            <?php
            if ($soporte == 'si') {
                switch ($extension) {
                    case 'pdf':
            ?>
                        <hr>
                        <embed src="facturas/soportes/<?php echo $iddoc . '.' . $extension ?>" width="80%" height=" 800px" type="application/pdf">
                    <?php
                        break;
                    case 'png':
                    ?>
                        <hr>
                        <embed src="facturas/soportes/<?php echo $iddoc . '.' . $extension ?>" width="80%" height=" 800px" type="image/png">
                    <?php
                        break;
                    case 'jpeg':
                    ?>
                        <hr>
                        <embed src="facturas/soportes/<?php echo $iddoc . '.' . $extension ?>" width="80%" height=" 800px" type="image/jpeg">
                    <?php
                        break;
                    case 'jpg':
                    ?>
                        <hr>
                        <embed src="facturas/soportes/<?php echo $iddoc . '.' . $extension ?>" width="80%" height=" 800px" type="image/jpg">
                    <?php
                        break;
                    case 'gif':
                    ?>
                        <hr>
                        <embed src="facturas/soportes/<?php echo $iddoc . '.' . $extension ?>" width="80%" height=" 800px" type="image/gif">
                <?php
                        break;
                }
                ?>

            <?php
            }
            ?>
        </div>
    </header>
    <main>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="librerias/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript" src="librerias/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#funcionario').change(function() {
            funcionario = $('#funcionario').val();
            codigofuncionario(funcionario);
        });

        const number = document.querySelector('.number');
        disponible = (<?php echo $relleno ?>);
        $("#funcionario").autocomplete({
            source: disponible,
            lookup: disponible,
            minLength: 3
        });

        function formatNumber(n) {
            n = String(n).replace(/\D/g, "");
            return n === '' ? n : Number(n).toLocaleString();
        }
        number.addEventListener('keyup', (e) => {
            const element = e.target;
            const value = element.value;
            element.value = formatNumber(value);

        });
        $('#relfuncionario').change(function() {
            check = $('#relfuncionario').is(":checked");
            if (check == true) {
                document.getElementById('llenarfuncionario').style.display = 'block';
                document.getElementById('an').disabled = true;
            } else {
                document.getElementById('llenarfuncionario').style.display = 'none';
                document.getElementById('an').disabled = false;
            }

            //verificaran(an);
        });
        $('#revisarfactura').click(function() {
            a = 0;
            iddocumento = $('#iddoc').val();
            alertify.confirm('Validación de factura', 'Esta seguro que desea validar esta consignación?.', function() {
                aprobarfactura(iddocumento);
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
        $('#registrarfactura').click(function() {

            a = 0;
            iddoc = $('#iddoc').val();
            valor = $('#valor').val();
            user = $('#user').val();
            tipo = $('#tipofactura').val();
            fechafactura = $('#fechafactura').val();
            soporte = $('#soporte').val();
            ri = $('#ri').val();
            an = $('#an').val();
            valido = $('#valido').val();
            comentario = $('#comentario').val();
            inputcuenta = document.getElementById("cuenta");
            inputan = document.getElementById("an");
            console.log($('#cuentacontribucion').val());
            switch (tipo) {
                case '2':
                    cuenta = $('#cuentacontribucion').val();
                    break;
                case '3':
                    cuenta = $('#cuentadevolucionviaticos').val();
                    break;
                case '4':
                    cuenta = $('#cuentaauxiliosalimentacion').val();
                    break;
                case '5':
                    cuenta = $('#cuentaprestamo').val();
                    break;
                case '6':
                    cuenta = $('#cuentari').val();
                    break;
            }
            console.log('tipo:' + tipo + ' cuenta:' + cuenta);
            debugger;
            if (tipo == 6) {
                if (ri == '') {
                    a = 1;
                    alertify.alert('ATENCION!!', 'Debe el # de la RI', function() {
                        alertify.success('Ok');
                    });
                }
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
                alertify.confirm('Envio a revisión', 'Esta seguro de enviar esta nota contable para revisión?', function() {
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
                    alertify.success('Operación exitosa. ');
                }, function() {

                }).set('labels', {
                    ok: 'Continuar',
                    cancel: 'Cancelar'
                });

            }

        });
        $('#an').change(function() {
            an = $('#an').val();
            verificaran(an);
        });
        $('#tipofactura').change(function() {
            tipo = $('#tipofactura').val();
            if (tipo != 6) {
                document.getElementById('ri').disabled = true;
            } else {
                document.getElementById('ri').disabled = false;
            }
            switch (tipo) {
                case '0':
                    document.getElementById('cuentaprestamo').disabled = true;
                    document.getElementById('cuentadevolucionviaticos').disabled = true;
                    document.getElementById('cuentacontribucion').disabled = true;
                    document.getElementById('cuentaauxiliosalimentacion').disabled = true;
                    document.getElementById('cuenta').disabled = true;
                    document.getElementById('cuentari').disabled = true;
                    break;
                case '6':
                    document.getElementById('cuentari').style.display = 'block';
                    document.getElementById('cuenta').style.display = 'none';
                    document.getElementById('cuentaauxiliosalimentacion').style.display = 'none';
                    document.getElementById('cuentacontribucion').style.display = 'none';
                    document.getElementById('cuentadevolucionviaticos').style.display = 'none';
                    document.getElementById('cuentaprestamo').style.display = 'none';
                    break;
                case '4':
                    document.getElementById('cuentaauxiliosalimentacion').style.display = 'block';
                    document.getElementById('cuenta').style.display = 'none';
                    document.getElementById('cuentari').style.display = 'none';
                    document.getElementById('cuentacontribucion').style.display = 'none';
                    document.getElementById('cuentadevolucionviaticos').style.display = 'none';
                    document.getElementById('cuentaprestamo').style.display = 'none';
                    break;
                case '2':
                    document.getElementById('cuentacontribucion').style.display = 'block';
                    document.getElementById('cuenta').style.display = 'none';
                    document.getElementById('cuentari').style.display = 'none';
                    document.getElementById('cuentaauxiliosalimentacion').style.display = 'none';
                    document.getElementById('cuentadevolucionviaticos').style.display = 'none';
                    document.getElementById('cuentaprestamo').style.display = 'none';
                    break;
                case '3':
                    document.getElementById('cuentadevolucionviaticos').style.display = 'block';
                    document.getElementById('cuentacontribucion').style.display = 'none';
                    document.getElementById('cuenta').style.display = 'none';
                    document.getElementById('cuentari').style.display = 'none';
                    document.getElementById('cuentaauxiliosalimentacion').style.display = 'none';
                    document.getElementById('cuentaprestamo').style.display = 'none';
                    break;
                case '5':
                    document.getElementById('cuentaprestamo').style.display = 'block';
                    document.getElementById('cuentadevolucionviaticos').style.display = 'none';
                    document.getElementById('cuentacontribucion').style.display = 'none';
                    document.getElementById('cuenta').style.display = 'none';
                    document.getElementById('cuentari').style.display = 'none';
                    document.getElementById('cuentaauxiliosalimentacion').style.display = 'none';
                    break;
            }
        });
        $('#cuenta').change(function() {
            cuenta = $('#cuenta').val();
            verificarbanco(cuenta);
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
    });
</script>