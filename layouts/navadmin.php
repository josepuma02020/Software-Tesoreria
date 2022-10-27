<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/nav/desktop.css">
    <link rel="stylesheet" href="./css/bootstrap/css/bootstrap.css">
    <script src="./css/bootstrap/js/bootstrap.js"></script>
</head>

<body>
    <header>

    </header>
    <main>
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="../NotasdePago/home.php"><img class="logo" src="../NotasdePago/img/logo.png" alt="Logo ESSA"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Notas Contables </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"> Registrar nota &raquo </a>
                                    <ul class="submenu dropdown-menu">
                                        <li><a class="dropdown-item" href="home.php?n=1"> Flujo de caja y Financiación</a></li>
                                        <li><a class="dropdown-item" href="home.php?n=4"> Gestión contable</a></li>
                                        <!-- <li><a class="dropdown-item" href=""> Third level 3 &raquo </a>
                                            <ul class="submenu dropdown-menu">
                                                <li><a class="dropdown-item" href=""> Fourth level 1</a></li>
                                                <li><a class="dropdown-item" href=""> Fourth level 2</a></li>
                                            </ul>
                                        </li> -->
                                    </ul>
                                </li>
                                <li><a class="dropdown-item" href="#"> Revisión de Notas &raquo </a>
                                    <ul class="submenu dropdown-menu">
                                        <li><a class="dropdown-item" href="revisionnotas.php?n=1">Flujo de caja y Financiación</a></li>
                                        <li> <a class="dropdown-item" href="revisionnotas.php?n=4">Gestión contable</a></li>
                                        <!-- <li><a class="dropdown-item" href=""> Third level 3 &raquo </a>
                                            <ul class="submenu dropdown-menu">
                                                <li><a class="dropdown-item" href=""> Fourth level 1</a></li>
                                                <li><a class="dropdown-item" href=""> Fourth level 2</a></li>
                                            </ul>
                                        </li> -->
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item" href="./informes.php">Informes</a>
                                </li>
                                <div class="dropdown-divider"></div>
                                <?php if ($_SESSION['configuracion'] == 1) {
                                ?>
                                    <li><a class="dropdown-item" href="#"> Configuración &raquo </a>
                                        <ul class="submenu dropdown-menu">
                                            <a class="dropdown-item" href="./tiposdocumento.php">Tipos de documento</a>
                                            <a class="dropdown-item" href="./clasificacion.php">Clasificacion de documentos</a>

                                            <!-- <li><a class="dropdown-item" href=""> Third level 3 &raquo </a>
                                            <ul class="submenu dropdown-menu">
                                                <li><a class="dropdown-item" href=""> Fourth level 1</a></li>
                                                <li><a class="dropdown-item" href=""> Fourth level 2</a></li>
                                            </ul>
                                        </li> -->
                                        </ul>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Recaudos</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="dropdown-item" href="home.php?n=f">Registrar factura</a>
                                </li>
                                <div class="dropdown-divider"></div>
                                <?php if ($_SESSION['configuracion'] == 1) {
                                ?>
                                    <li><a class="dropdown-item" href="#"> Configuración &raquo </a>
                                        <ul class="submenu dropdown-menu">
                                            <a class="dropdown-item" href=" ./tiposfactura.php">Tipos de factura</a>

                                            <!-- <li><a class="dropdown-item" href=""> Third level 3 &raquo </a>
                                            <ul class="submenu dropdown-menu">
                                                <li><a class="dropdown-item" href=""> Fourth level 1</a></li>
                                                <li><a class="dropdown-item" href=""> Fourth level 2</a></li>
                                            </ul>
                                        </li> -->
                                        </ul>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Configuración general</a>
                            <ul class="dropdown-menu">
                                <a class="dropdown-item" href="./generales.php">Generales</a>
                                <a class="dropdown-item" href="./cuentas.php">Cuentas</a>
                                <a class="dropdown-item" href="./procesos.php">Procesos</a>
                                <a class="dropdown-item" href="./listaan.php">Lista de AN8</a>
                                <a class="dropdown-item" href="./usuarios.php">Usuarios</a>
                            </ul>
                        </li>
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Notas Contables
                            </a>
                            <div class="dropdown-menu" aria-labelledby="NavCreacionNota">
                                <a class="nav-link dropright-toggle " href="#" id="NavCreacionNota" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Creación
                                </a>
                                <div class="dropdown-menu" aria-labelledby="NavCreacionNota">
                                    <a class="nav-link" href="home.php?n=1">Flujo de caja y Financiación</a>
                                    <a class="nav-link" href="home.php?n=4">Flujo de caja y Financiación</a>
                                </div>
                            </div>
                        </li> -->

                        <li class="nav-item">
                            <a class="nav-link" href="usuarios/cerrarsesion.php">Salir</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="end-nav">
                <h5><?php echo $_SESSION['nombre'];  ?></h5>
            </div>
        </nav>
    </main>
    <footer></footer>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>