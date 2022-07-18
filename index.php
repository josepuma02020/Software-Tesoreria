<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="./css/bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/index/desktop.css">
    <link rel="stylesheet" type="text/css" href="librerias/alertify/css/alertify.css" />
    <SCRIPT src="./librerias/alertify/alertify.js"></script>
    <title>Notas de Pagos</title>
</head>

<body>
    <header>
        <?php
        if (isset($_GET['m'])) {
            $m = $_GET['m'];
            switch ($m) {
                case 1:
        ?>
                    <script>
                        alertify.alert('Atencion!!', 'El usuario se encuentra Inactivo', function() {
                            alertify.success('Ok');
                        });
                    </script>
                <?php
                    break;
                case 2:
                ?>
                    <script>
                        alertify.alert('Atencion!!', 'Usuario o clave de ingreso incorrecto', function() {
                            alertify.success('Ok');
                        });
                    </script>
                <?php
                    break;
                case 3:
                ?>
                    <script>
                        alertify.alert('Atencion!!', 'Favor iniciar sesión', function() {
                            alertify.success('Ok');
                        });
                    </script>
                <?php
                    break;
                case 4:
                ?>
                    <script>
                        alertify.alert('Atencion!!', 'El sistema se encuentra cerrado', function() {
                            alertify.success('Ok');
                        });
                    </script>
                <?php
                    break;
                case 5:
                ?>
                    <script>
                        alertify.alert('Atencion!!', 'Sesión cerrada correctamente', function() {
                            alertify.success('Ok');
                        });
                    </script>
        <?php
                    break;
            }
        }
        ?>
    </header>
    <main class="container">
        <h2>Bienvenido a Notas de Pagos</h2>
        <div>
            <form action="./usuarios/login.php" method="post">
                <div class="form-group centrado">
                    <label for="user">Usuario:</label>
                    <input type="text" class="form-control" id="user" name="user" required>
                </div>
                <div class="form-group centrado">
                    <label for="password">Clave:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group centrado">
                    <button class="btn btn-primary" type="submit">Iniciar Sesión </button>
                </div>
            </form>
        </div>
    </main>
    <footer>

        <img class="logo" src="./img/logo.png" alt="Logo ESSA">

    </footer>
    <script src="./css/bootstrap/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
</body>

</html>