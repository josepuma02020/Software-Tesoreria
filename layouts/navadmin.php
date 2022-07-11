<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/nav/desktop.css">
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
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">Creación de Notas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="revisionnotas.php">Revisión de Notas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Configuración</a>
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