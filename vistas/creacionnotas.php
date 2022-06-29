<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/notas/desktop.css">
    <title>Notas Contables</title>
    <?php
    include('../NotasdePago/conexion/conexion.php');
    ?>
</head>

<body>
    <header>
        <form action="" method="post">
            <div class="form-row">
                <div class="form-group mediano">
                    <label for="tipo">Tipo de Documento</label>
                    <select id="tipo" class="form-control col-md-8 ">
                        <?php
                        $consultausuarios = "select * from tiposdocumento";
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
            </div>
        </form>
    </header>
    <main>

    </main>
    <footer>

    </footer>
</body>

</html>