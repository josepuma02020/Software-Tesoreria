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
if ($_SESSION['usuario'] && $_SESSION['rol'] == 1) {
    include_once('conexion/conexion.php');
    setlocale(LC_ALL, "es_CO");
    date_default_timezone_set('America/Bogota');



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
        <SCRIPT lang="javascript" type="text/javascript" src="./usuarios/usuarios.js"></script>
        <SCRIPT src="librerias/alertify/alertify.js"></script>
        <title>Usuarios</title>
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
                    <h2>Usuarios</h2>
                </div>
                <section class="parametros">
                    <span class="btn btn-primary boton-parametro" data-toggle="modal" data-target="#nuevacuenta">
                        <b> Nuevo usuario</b>
                    </span>
                </section>
                <div class="modal fade" id="nuevacuenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Registrar nuevo usuario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <div class="form-row formulario">
                                        <div class="form-group mediano-grande">
                                            <label for="desde"><b>Nombre:</b></label>
                                            <input style="text-align:center" class=" form-control " id="nombren" name="nombren" type="text">
                                        </div>
                                        <div class="form-group mediano-grande">
                                            <label for="hasta">Correo:</label>
                                            <input style="text-align:center" class="form-control " id="correon" name="correon" type="email">
                                        </div>
                                    </div>
                                    <div class="form-row formulario">
                                        <div class="form-group mediano-grande">
                                            <label for="desde">Rol:</label>
                                            <select class="form-control col-md-8 " name="roln" id="roln">
                                                <option value="0">Seleccionar</option>
                                                <option value="1">Administrador</option>
                                                <option value="2">Verificador de Notas</option>
                                                <option value="0">Registrador de Notas</option>
                                            </select>
                                        </div>
                                        <div class="form-group mediano-grande">
                                            <label for="hasta">Usuario:</label>
                                            <input value="" autocomplete="off" style="text-align:center" class="form-control " id="usuarion" name="usuarion" type="text">
                                        </div>
                                    </div>
                                    <div class="form-row formulario">
                                        <div class="form-group mediano-grande">
                                            <label for="desde">Clave:</label>
                                            <input style="text-align:center" class=" form-control " id="claven" name="claven" type="password">
                                        </div>
                                        <div class="form-group mediano-grande">
                                            <label for="hasta">Confirmar Clave:</label>
                                            <input style="text-align:center" class="form-control " id="confirmarclaven" name="confirmarclaven" type="password">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" id="registrar" class="btn btn-primary">Registrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="registrosnotas" class="table table-striped  table-responsive-lg usuarios ">
                    <thead>
                        <tr>
                            <th> Nombre</th>
                            <th> Usuario </th>
                            <th> Rol </th>
                            <th> Correo </th>
                            <th> Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $consultatipos = "select * from usuarios";
                        $query = mysqli_query($link, $consultatipos) or die($consultatipos);
                        while ($filas = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td> <?php echo $filas['nombre'] ?> </td>
                                <td> <?php echo $filas['usuario'] ?> </td>
                                <td> <?php
                                        switch ($filas['rol']) {
                                            case 1:
                                                echo 'Administrador';
                                                break;
                                            case 2:
                                                echo 'Verificador';
                                                break;
                                            case 3:
                                                echo 'Registrador';
                                                break;
                                            case 4:
                                                echo 'Inactivo';
                                                break;
                                        }

                                        ?> </td>
                                <td> <?php echo $filas['correo'] ?> </td>
                                <td>
                                    <button onclick="datosusuario('<?php echo $filas['idusuario'] ?>')" type="button" title="Editar tipo de documento" id="detalles" class="btn btn-primary" data-toggle="modal" data-target="#editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Registrar nuevo usuario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <div class="form-row formulario">
                                        <div class="form-group mediano-grande">
                                            <label for="desde"><b>Nombre:</b></label>
                                            <input style="text-align:center" class=" form-control " id="idu" name="idu" type="hidden">
                                            <input style="text-align:center" class=" form-control " id="nombreu" name="nombreu" type="text">
                                        </div>
                                        <div class="form-group mediano-grande">
                                            <label for="hasta">Correo:</label>
                                            <input style="text-align:center" class="form-control " id="correou" name="correou" type="email">
                                        </div>
                                    </div>
                                    <div class="form-row formulario">
                                        <div class="form-group mediano-grande">
                                            <label for="hasta">Usuario:</label>
                                            <input style="text-align:center" class="form-control " id="usuariou" name="usuariou" type="text">
                                        </div>
                                        <div class="form-group mediano-grande">
                                            <label for="desde">Ult.Conexion:</label>
                                            <input disabled style="text-align:center" class=" form-control " id="ultconexion" name="ultconexion" type="text">
                                        </div>

                                    </div>
                                    <div class="form-row formulario">
                                        <div class="form-group mediano-grande">
                                            <label for="hasta">Rol actual:</label>
                                            <input disabled style="text-align:center" class="form-control " id="rola" name="rola" type="text">
                                        </div>
                                        <div class="form-group mediano-grande">
                                            <label for="desde">Nuevo rol:</label>
                                            <select class="form-control col-md-8 " name="rolu" id="rolu">
                                                <option value="0">Seleccionar</option>
                                                <option value="1">Administrador</option>
                                                <option value="2">Verificador de Notas</option>
                                                <option value="3">Registrador de Notas</option>
                                                <option style="background-color: yellow ;" value="4">Inactivo</option>s
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-row formulario">
                                        <div class="form-group mediano-grande">
                                            <label for="desde">Nueva clave:</label>
                                            <input autocomplete="off" style="text-align:center" class=" form-control " id="claveu" name="claveu" type="password">
                                        </div>
                                        <div class="form-group mediano-grande">
                                            <label for="hasta">Confirmar Clave:</label>
                                            <input style="text-align:center" class="form-control " id="confirmarclaveu" name="confirmarclaveu" type="password">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" id="guardar" class="btn btn-primary">Editar</button>
                            </div>
                        </div>
                    </div>
                </div>
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
        $('#registrar').click(function() {
            a = 0;
            confirmarclave = $('#confirmarclaven').val();
            nombre = $('#nombren').val();
            correo = $('#correon').val();
            rol = $('#roln').val();
            usuario = $('#usuarion').val();
            clave = $('#claven').val();
            if (clave != confirmarclave) {
                a = 1;
                alertify.alert('ATENCION!!', 'Las claves no coinciden. ', function() {
                    alertify.success('Ok');
                });
            }
            if (nombre == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de nombre. ', function() {
                    alertify.success('Ok');
                });
            }
            if (correo == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de correo. ', function() {
                    alertify.success('Ok');
                });
            }
            if (rol == 0) {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor escoger un rol para el nuevo usuario. ', function() {
                    alertify.success('Ok');
                });
            }
            if (usuario == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de usuario. ', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                registrarusuario(nombre, correo, rol, usuario, clave);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }

        });
        $('#guardar').click(function() {
            confirmarclave = $('#confirmarclaveu').val();
            nombre = $('#nombreu').val();
            correo = $('#correou').val();
            rol = $('#rolu').val();
            usuario = $('#usuariou').val();
            clave = $('#claveu').val();
            id = $('#idu').val();
            a = 0;
            if (clave != confirmarclave) {
                a = 1;
                alertify.alert('ATENCION!!', 'Las claves no coinciden. ', function() {
                    alertify.success('Ok');
                });
            }
            if (nombre == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de nombre. ', function() {
                    alertify.success('Ok');
                });
            }
            if (correo == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de correo. ', function() {
                    alertify.success('Ok');
                });
            }
            if (usuario == '') {
                a = 1;
                alertify.alert('ATENCION!!', 'Favor llenar el campo de usuario. ', function() {
                    alertify.success('Ok');
                });
            }
            if (a == 0) {
                editarusuario(id, correo, rol, usuario, clave);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }

        });
        $('#eliminar').click(function() {

            id = $('#id').val();
            eliminartipo(id);
            setTimeout(function() {
                window.location.reload();
            }, 1000);

        });
    });
</script>